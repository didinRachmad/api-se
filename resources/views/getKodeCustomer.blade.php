@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">Search Data by Kode Customer</div>
                    <div class="card-body">
                        <form class="form-inline" method="POST" action="{{ route('getKodeCustomer') }}">
                            @csrf
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="kode_customer" class="sr-only">Kode Customer</label>
                                <input type="text" name="kode_customer" class="form-control" id="kode_customer"
                                    placeholder="Enter Kode Customer"
                                    value="{{ old('kode_customer', $kode_customer ?? '') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
                        <br>
                        @if (isset($data))
                            <h3>Hasil Pencarian:</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode Customer</th>
                                        <th>Nama Toko</th>
                                        <th>Alamat</th>
                                        <th>Nama Pasar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $d['kode_customer'] }}</td>
                                            <td>{{ $d['mrdo']->nama_toko }}</td>
                                            <td>{{ $d['mrdo']->alamat }}</td>
                                            <td>{{ $d['mrdo']['mrd']->nama_pasar }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h3>Hasil Pencarian:</h3>
                            <p>Tidak Ditemukan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
