<?php

namespace App\Http\Controllers;
use App\Barang;
use App\Pesanan;
use App\PesananDetail;
use Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
     $barang = Barang::where('id',$id)->first();
     return view('pesan.index',compact('barang'));
    }

    public function pesan(Request $request,$id){
      $barang = Barang::where('id',$id)->first();
      if($barang->stok < $request->jumlah_pesan){
          return redirect()->route('pesan',$id)->with('pesan','Barang Melebihi Stok');
      }

      $cek_pesanan = Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
       if(empty($cek_pesanan)){ 
    //   simpan ke database pesanan
        $pesanan = new Pesanan;
        $pesanan->user_id               = Auth::user()->id;
        $pesanan->tanggal               = Carbon::now();
        $pesanan->status                = 0;
        $pesanan->jumlah_total_harga    = 0;
        $pesanan->save();
       }
        $pesanan_baru = Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();

       $cek_pesanan_detail = PesananDetail::where('barang_id',$id)
       ->where('pesanan_id',$pesanan_baru->id)->first();

       if(empty($cek_pesanan_detail)){
            //  simpan pesanan detail
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->barang_id      = $id;
            $pesanan_detail->pesanan_id     = $pesanan_baru->id;
            $pesanan_detail->jumlah_barang  = $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga   = $barang->harga * $request->jumlah_pesan;
            $pesanan_detail->save();
       }else{
            $pesanan_detail = PesananDetail::where('barang_id',$id)->where('pesanan_id',$pesanan_baru->id)->first();
            $pesanan_detail->barang_id = $id;
            $pesanan_detail->pesanan_id = $pesanan_baru->id;
            $pesanan_detail->jumlah_barang = $pesanan_detail->jumlah_barang+$request->jumlah_pesan;
            $harga_baru = $barang->harga + $pesanan_detail->jumlah_barang;
            $pesanan_detail->jumlah_harga = $barang->harga + $harga_baru;
            $pesanan_detail->update();
       } 

        $pesanan = Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
        $pesanan->jumlah_total_harga = $pesanan->jumlah_harga+$barang->harga*$request->jumlah_pesan;
        $pesanan->update();

        Alert::success('Success Message', 'Optional Title');
        return redirect()->route('home');
  }


  public function checkout(){
    $pesanan = Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
    if(!empty($pesanan)){
        $pesanan_detail = PesananDetail::where('pesanan_id',$pesanan->id)->get();
    }else{
        $pesanan_detail = '';
    }
    return view('pesan.checkout',compact('pesanan_detail','pesanan'));
  }

  public function delete($id){
      $pesanan_detail = PesananDetail::where('id',$id)->first();
      $pesanan = Pesanan::where('id',$pesanan_detail->pesanan_id)->first();
      $pesanan->jumlah_total_harga = $pesanan->jumlah_total_harga - $pesanan_detail->jumlah_barang;
      $pesanan->update();

      $pesanan_detail->delete();

      Alert::success('Success Message', 'Optional Title');
      return redirect()->route('checkout-barang');
  }


  public function konfirmasi(){
      $pesanan = Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();

      $pesanan_detail = PesananDetail::where('pesanan_id',$pesanan->id)->get();
      foreach($pesanan_detail as $ps_detail){
          $barang = Barang::where('id',$ps_detail->barang_id)->first();
          $barang->stok = $barang->stok - $ps_detail->jumlah_barang;
          $barang->update();
      }
       $pesanan->status = 1;
       $pesanan->update();

      Alert::success('Pesanan Sucess Checkout','Success');
      return redirect('home');
  }

}
