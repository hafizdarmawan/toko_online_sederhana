@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">
        <a href="{{ route('home') }}" class="btn btn-secondary mb-2"> <i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3>CheckOut Barang</h3>
                @php
                    if(!empty($pesanan)):
                @endphp
                <p class="float-right">{{ $pesanan->tanggal }}</p>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $totalSemua = 0;
                            @endphp
                            @foreach ($pesanan_detail as $p_detail)
                            <tr>
                                <td>{{  $no++ }}</td>
                                <td>{{ $p_detail->barang->nama_barang }}</td>
                                <td>{{ $p_detail->jumlah_barang }}</td>
                                <td>Rp.{{ number_format($p_detail->barang->harga) }}</td>
                                <td>Rp.{{ number_format($p_detail->jumlah_harga) }}</td>
                                <td>
                                    <form action="{{ route('checkout-delete',$p_detail->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button  type="submit"  class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>                                
                            @php
                                $totalSemua += $p_detail->jumlah_harga
                            @endphp
                            @endforeach
                            <tr>
                                <td colspan="4"><b class="text-center">Total</b></td>
                                <td>Rp. {{ number_format( $totalSemua) }}</td>
                                <td>
                                    <a href="{{ route('checkout-konfirmasi') }}" class="btn btn-primary">Check Out</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @php
                    endif
                @endphp
            </div>
            <table class="table table-bordered">
            </table>
        </div>
    </div>
</div>
@endsection
