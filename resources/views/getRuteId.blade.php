@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12"> --}}
    <div class="card">
        <div class="card-header">Search Data by Route ID</div>
        <div class="card-body">
            <form class="form-inline" method="POST" action="{{ route('getRuteId') }}">
                @csrf
                <div class="form-group mx-sm-3 mb-2">
                    <label for="rute_id" class="sr-only">Route ID</label>
                    <input type="text" name="rute_id" class="form-control" id="rute_id" placeholder="Enter Route ID"
                        value="{{ old('rute_id', $rute_id ?? '') }}">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
            <br>
            @if (isset($data))
                <h3>Hasil Pencarian:</h3>
                <p>Rute : <span class="font-weight-bold">{{ $data->rute }}</span></p>
                <p>Hari : <span class="font-weight-bold">{{ $data->hari }}</span></p>
                <p>Distributor : <span class="font-weight-bold">{{ $data->d->nama_distributor }}
                        ({{ $data->d->id_distributor }})</span>
                </p>
                <p>Wilayah : <span class="font-weight-bold">{{ $data->w->nama_wilayah }}
                        ({{ $data->w->id_wilayah }})</span></p>
                <p>Nama Salesman : <span class="font-weight-bold">{{ $data->salesman }}</span></p>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered ">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>id</th>
                                <th>rute_id</th>
                                <th>rute_detail_id</th>
                                <th>survey_pasar_id</th>
                                <th>Kode Customer</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
                                <th>Nama Pasar</th>
                                <th>Nama Pemilik</th>
                                <th>id_pasar_mrd</th>
                                <th>nama_pasar_mrd</th>
                                <th>id_pasar_mrdo</th>
                                <th>nama_pasar_mp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->mrdo as $mrdo)
                                @foreach ($mrdo->mco as $mco)
                                    <tr>
                                        <td>{{ $mrdo->id }}</td>
                                        <td>{{ $mrdo->rute_id }}</td>
                                        <td>{{ $mrdo->rute_detail_id }}</td>
                                        <td>{{ $mrdo->survey_pasar_id }}</td>
                                        <td>{{ $mco->kode_customer }}</td>
                                        <td>{{ $mrdo->nama_toko }}</td>
                                        <td>{{ $mrdo->alamat }}</td>
                                        <td>{{ $mrdo->nama_pasar }}</td>
                                        <td>{{ $mrdo->nama_pemilik }}</td>
                                        <td>{{ $mrdo->mrd->id_pasar }}</td>
                                        <td>{{ $mrdo->mrd->nama_pasar }}</td>
                                        <td>{{ $mrdo->id_pasar }}</td>
                                        <td>{{ $mrdo->mp->nama_pasar }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h3>Hasil Pencarian:</h3>
                <p>Tidak Ditemukan</p>
            @endif
        </div>
        {{-- </div>
            </div>
        </div> --}}
    </div>
@endsection
