@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-3">
        <img src="{{ url('images/logo.png') }}" alt="" style="width: 500px">
    </div>
    <div class="row justify-content-center">
        @foreach ($barangs as $barang)
        <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ url('uploads')}}/{{ $barang->gambar }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                        <p class="card-text">{{ $barang->keterangan }}</p> <br>
                        <strong>Stok</strong>  {{ $barang->stok }} <br>
                        <strong>Harga</strong> Rp.{{ number_format($barang->harga) }} <br>
                        <a href="{{ route('pesan',$barang->id) }}" class="btn btn-primary">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
