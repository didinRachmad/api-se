@extends('layouts.app')
@section('content')
    <style>
        .select2-results__option {
            font-size: 8pt;
        }

        .select2-search__field {
            height: 25px;
            font-size: 8pt;
        }

        p {
            margin: 0;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 0 5px;
        }

        .select2-container .select2-selection--single {
            height: 100%;
        }

        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header">Pindah Outlet</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('PindahOutlet.getDataByRuteId') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-control w-100 select2-salesman_awal" name="salesman_awal" id="salesman_awal"
                                required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                                oninput="setCustomValidity('')">
                                <option value="{{ old('salesman_awal', $salesman_awal ?? '') }}">
                                    {{ old('salesman_awal', $salesman_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" name="id_salesman_awal" id="id_salesman_awal"
                                value="{{ old('id_salesman_awal', $id_salesman_awal ?? '') }}">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-control w-100 select2-rute" name="rute_id_awal" id="rute_id_awal"
                                oninvalid="this.setCustomValidity('Harap Pilih Rute')" oninput="setCustomValidity('')">
                                <option value="{{ old('rute_id_awal', $rute_id_awal ?? '') }}">
                                    {{ old('rute_awal', $rute_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="rute_awal" name="rute_awal"
                                value="{{ old('rute_awal', $rute_awal ?? '') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 text-center my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span><i
                                    class="bi bi-search"></i></span></button>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-control w-100 select2-salesman_akhir" name="salesman_akhir"
                                id="salesman_akhir" oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                                oninput="setCustomValidity('')">
                            </select>
                            <input type="hidden" name="id_salesman_akhir" id="id_salesman_akhir">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-control w-100 select2-rute-akhir" name="rute_id_akhir" id="rute_id_akhir"
                                oninvalid="this.setCustomValidity('Harap Pilih Rute')" oninput="setCustomValidity('')">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center my-auto">
                        <button type="button" class="btn btn-warning btn-sm" id="btnGanti">Pindah <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                    </div>

                    @if (!isset($data))
                        @php
                            $data = collect();
                        @endphp
                    @endif
                    {{-- <h3>Hasil Pencarian:</h3> --}}
                    <div class="row pt-3">
                        <div class="col-lg-12">
                            <p class="d-inline-block pe-3">Distributor : <span class="fw-bold"
                                    id="nama-distributor">{{ $data->first()->d->nama_distributor ?? '' }}({{ $data->first()->d->id_distributor ?? '' }})</span>
                            </p>
                            <p class="d-inline-block pe-3">Wilayah : <span class="fw-bold"
                                    id="nama-wilayah">{{ $data->first()->w->nama_wilayah ?? '' }}({{ $data->first()->w->id_wilayah ?? '' }})</span>
                            </p>
                            <p class="d-inline-block pe-3">Nama Salesman : <span class="fw-bold"
                                    id="nama-salesman">{{ $data->first()->salesman ?? '' }}</span>
                            </p>
                            <p class="d-inline-block pe-3">Rute : <span class="fw-bold"
                                    id="nama-salesman">{{ $data->first()->rute ?? '' }}</span>
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered align-middle myTable" id="myTable">
                            <thead class="table-dark text-center">
                                <th>no</th>
                                <th>rute</th>
                                <th>hari</th>
                                <th>rute id</th>
                                <th>rute detail id</th>
                                <th>survey pasar id</th>
                                <th>Kode Customer</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
                                <th>id pasar mrd</th>
                                <th>nama pasar mrd</th>
                                <th>id pasar mrdo</th>
                                <th>nama pasar mp</th>
                                <th>Tipe Outlet</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($data as $mr)
                                    @foreach ($mr->mrdo as $mrdo)
                                        @foreach ($mrdo->mco as $mco)
                                            @php
                                                $no += 1;
                                            @endphp
                                            <tr data-id="{{ $mrdo->id }}" data-rute_id_awal="{{ $mrdo->rute_id }}"
                                                data-id_pasar_awal="{{ $mrdo->id_pasar }}">
                                                <td>{{ $no }}</td>
                                                <td class="text-success">{{ $mr->rute }}</td>
                                                <td>{{ $mr->hari }}</td>
                                                <td>{{ $mrdo->rute_id }}</td>
                                                <td>{{ $mrdo->rute_detail_id }}</td>
                                                <td>{{ $mrdo->survey_pasar_id }}</td>
                                                <td class="text-primary fw-bold" id="kode{{ $no }}">
                                                    {{ $mco->kode_customer }}
                                                    <input type="hidden" class="form-control" value="{{ $mco->id }}">
                                                </td>
                                                <td>{{ $mrdo->nama_toko }}</td>
                                                <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                                <td>{{ $mrdo->mrd->id_pasar }}</td>
                                                <td>{{ $mrdo->mrd->nama_pasar }}</td>
                                                <td>{{ $mrdo->id_pasar }}</td>
                                                <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                                <td id="tipe_outlet{{ $no }}">
                                                    {{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="btn-check check"
                                                        id="check{{ $no }}" autocomplete="off"
                                                        value="{{ $mrdo->rute_id }}">
                                                    <label class="btn btn-outline-success"
                                                        for="check{{ $no }}">Pilih</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2-salesman_awal').select2({
                ajax: {
                    url: "{{ route('PindahOutlet.getSalesman') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih salesman',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text).addClass('pull-right').append($('<b>').text(
                        ' - ' +
                        data.nama_wilayah));
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                // mengubah value dari id_salesman_awal
                $('#id_salesman_awal').val(data.id_salesman);
            });

            $('.select2-rute').select2({
                ajax: {
                    url: "{{ route('PindahOutlet.getRute') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('#salesman_awal').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih Rute',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text);
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                // mengubah value dari id_salesman_awal
                $('#rute_awal').val(data.text);
            });


            $('.select2-salesman_akhir').select2({
                ajax: {
                    url: "{{ route('PindahOutlet.getSalesman') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih salesman',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text).addClass('pull-right').append($('<b>').text(
                        ' - ' +
                        data.nama_wilayah));
                }
            })

            $('.select2-rute-akhir').select2({
                ajax: {
                    url: "{{ route('PindahOutlet.getRute') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('#salesman_akhir').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih Rute',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text);
                }
            });

            $('.myTable').DataTable({
                "dom": "<'row'<'col-sm-12 col-md-6 btn_upload'><'col-sm-12 col-md-6 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                "order": [
                    [2, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
            });

            $('#btnGanti').click(function(e) {
                e.preventDefault();

                var selectedRows = [];

                var rute_id_akhir = $('#rute_id_akhir').val();
                $('.check:checked').each(function() {
                    var id = $(this).closest('tr').data('id');
                    var rute_id_awal = $(this).closest('tr').data('rute_id_awal');
                    var id_pasar_awal = $(this).closest('tr').data('id_pasar_awal');
                    selectedRows.push({
                        id: id,
                        rute_id_awal: rute_id_awal,
                        id_pasar_awal: id_pasar_awal,
                        rute_id_akhir: rute_id_akhir
                    });
                });
                console.log(selectedRows);
                $.ajax({
                    type: 'post',
                    url: "{{ route('PindahOutlet.pindah') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        console.log(response.message);
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#errorModal #message').text(xhr.responseJSON.message);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });
        });
    </script>
@endsection
