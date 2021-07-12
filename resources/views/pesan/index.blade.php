@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">
        <a href="{{ route('home') }}" class="btn btn-secondary mb-2"> <i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $barang->nama_barang }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ url('uploads') }}/{{ $barang->gambar }}" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h3>Barang: {{ $barang->nama_barang }}</h3>
                            <table style="font-size: 18px" class="table">
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>Rp. {{ number_format($barang->harga) }}</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td>{{ $barang->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td>:</td>
                                    <td>{{ $barang->stok }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Pesan</td>
                                    <td>
                                        <form action="{{ route('pesan-barang',$barang->id) }}" method="POST">
                                          @csrf
                                          <input type="number" class="form-control m-2" min="1" name="jumlah_pesan" required>
                                          <button type="submit" class="btn btn-primary text-center">Masukan Keranjang</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div>
@endsection
