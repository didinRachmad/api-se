@extends('layouts.app')
@section('content')

    <style>
        .card-body-custom {
            padding: 5px;
            /* ukuran padding yang lebih kecil */
            font-size: 12px;
            /* ukuran font yang lebih kecil */
        }

        .myTable {
            font-size: 12px;
            padding: 5px;
        }

        /* CSS untuk mengatur tampilan Select2 */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057;
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }

        p {
            margin: 0;
        }
    </style>

    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12"> --}}
    <div class="card">
        <div class="card-header">Search Data by Route ID</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('getRuteId') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <label for="salesman" class="sr-only">Salesman</label>
                        <select class="form-control select2-salesman w-100" name="salesman" id="salesman"
                            onchange="tes(this.value)">
                            <option value="{{ old('salesman', $salesman ?? '') }}">
                                {{ old('salesman', $salesman ?? '') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="rute_id" class="sr-only">Rute</label>
                        <select class="form-control select2-rute w-100" name="rute_id" id="rute_id">
                            <option value="{{ old('rute_id', $rute_id ?? '') }}">
                                {{ old('rute', $rute ?? '') }}</option>
                        </select>
                        <input type="hidden" id="select2-rute-rute" name="rute">
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </div>
                </div>
            </form>
            @if (isset($data))
                <h3>Hasil Pencarian:</h3>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="d-inline-block px-3">Rute : <span class="font-weight-bold">{{ $data->rute }}</span></p>
                        <p class="d-inline-block px-3">Hari : <span class="font-weight-bold">{{ $data->hari }}</span></p>
                        <p class="d-inline-block px-3">Distributor : <span
                                class="font-weight-bold">{{ $data->d->nama_distributor }}
                                ({{ $data->d->id_distributor }})</span>
                        </p>
                        <p class="d-inline-block px-3">Wilayah : <span class="font-weight-bold">{{ $data->w->nama_wilayah }}
                                ({{ $data->w->id_wilayah }})</span></p>
                        <p class="d-inline-block px-3">Nama Salesman : <span
                                class="font-weight-bold">{{ $data->salesman }}</span>
                        </p>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered myTable">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>id</th>
                                <th>rute_id</th>
                                <th>rute_detail_id</th>
                                <th>survey_pasar_id</th>
                                <th class="bg-secondary">Kode Customer</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
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
                                        <td class="bg-secondary text-white">{{ $mco->kode_customer }}</td>
                                        <td>{{ $mrdo->nama_toko }}</td>
                                        <td>{{ $mrdo->alamat }}</td>
                                        <td>{{ $mrdo->nama_pemilik }}</td>
                                        <td>{{ $mrdo->mrd->id_pasar }}</td>
                                        <td>{{ $mrdo->mrd->nama_pasar }}</td>
                                        <td>{{ $mrdo->id_pasar }}</td>
                                        <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
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

<script>
    function tes(value) {
        console.log(value);
    }
</script>
