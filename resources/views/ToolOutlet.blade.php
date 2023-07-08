@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card">
        <div class="card-header">Pindah Outlet</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('ToolOutlet.getDataByRuteId') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_awal" name="salesman_awal"
                                id="salesman_awal" required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                                oninput="setCustomValidity('')">
                                <option value="{{ old('salesman_awal', $salesman_awal ?? '') }}">
                                    {{ old('salesman_awal', $salesman_awal ?? '') }}
                                </option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute_awal" name="rute_id_awal"
                                id="rute_id_awal" oninvalid="this.setCustomValidity('Harap Pilih Rute')"
                                oninput="setCustomValidity('')">
                                <option value="{{ old('rute_id_awal', $rute_id_awal ?? '') }}">
                                    {{ old('rute_awal', $rute_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="rute_awal" name="rute_awal"
                                value="{{ old('rute_awal', $rute_awal ?? '') }}">
                        </div>
                    </div>
                    <div class="col-lg-1 text-center my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span><i
                                    class="bi bi-search"></i></span></button>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_akhir" name="salesman_akhir"
                                id="salesman_akhir">
                            </select>
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute_akhir" name="rute_id_akhir"
                                id="rute_id_akhir"></select>
                        </div>
                    </div>
                    <div class="col-lg-3 text-center my-auto">
                        <button type="button" class="btn btn-warning btn-sm" id="btnPindah">Pindah <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                        <button type="button" class="btn btn-info btn-sm" id="btnPindahPasar">Pindah Pasar <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                        <button type="button" class="btn btn-success btn-sm" id="btnPindahLokasi">Pindah Lokasi <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                    </div>

                    @if (!isset($data))
                        @php
                            $data = collect();
                        @endphp
                        <div class="row py-3"></div>
                    @else
                        <div class="row py-3">
                            <div class="col-lg-12">
                                <p class="d-inline-block pe-3">Distributor : <span class="fw-bold"
                                        id="nama-distributor">{{ $data->first()->d->nama_distributor ?? '' }}
                                        ({{ $data->first()->d->id_distributor ?? '' }})</span>
                                </p>
                                <p class="d-inline-block pe-3">Wilayah : <span class="fw-bold"
                                        id="nama_wilayah">{{ $data->first()->w->nama_wilayah ?? '' }}
                                        ({{ $data->first()->w->id_wilayah ?? '' }})</span>
                                </p>
                                <p class="d-inline-block pe-3">Nama Salesman : <span class="fw-bold"
                                        id="nama-salesman">{{ $data->first()->salesman ?? '' }}
                                        ({{ $data->first()->kr->id_salesman_mss ?? '' }})</span>
                                </p>
                                <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                            class="bi bi-journal-text"></i></span></button>
                                <button type="button" class="btn btn-warning btn-sm btnKandidat">Kandidat <span> <i
                                            class="bi bi-journal-text"></i></span></button>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-sm table-dark table-striped table-bordered align-middle myTable" id="myTable">
                    <thead class="text-center">
                        <th>no</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>id mrdo</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer <button type="button" class="btn btn-sm btn-secondary"
                                id="salinKode">Salin</button></th>
                        <th>Nama Toko <button type="button" class="btn btn-sm btn-secondary"
                                id="salinNamaToko">Salin</button></th>
                        <th>Alamat</th>
                        <th>id mco</th>
                        <th>id pasar mrd</th>
                        <th>nama pasar mrd</th>
                        <th>nama pasar mp</th>
                        <th>Tipe Outlet</th>
                        <th class="text-center" id="action">Action</th>
                        <th class="text-center">
                            <input type="checkbox" class="btn-check check-all" id="check-all" autocomplete="off">
                            <label class="btn btn-sm btn-outline-success" for="check-all">All</label>
                        </th>
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
                                    <tr class="warnaBaris" data-id="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                        data-id_pasar_awal="{{ $mrdo->id_pasar }}"
                                        data-rute_id_awal="{{ $mrdo->rute_id }}"
                                        data-id_survey_pasar="{{ $mrdo->survey_pasar_id }}"
                                        data-rute_detail_id="{{ $mrdo->rute_detail_id }}">
                                        <td></td>
                                        <td class="rute">{{ $mr->rute }}</td>
                                        <td class="hari">{{ $mr->hari }}</td>
                                        <td class="rute_id">{{ $mrdo->rute_id }}</td>
                                        <td class="id_mrdo">{{ $mrdo->id }}</td>
                                        <td class="survey_pasar_id">{{ $mrdo->survey_pasar_id }}</td>
                                        <td class="text-primary fw-bold kode_customer">{{ $mco->kode_customer }}</td>
                                        <td class="nama_toko">{{ $mrdo->nama_toko }}</td>
                                        <td class="alamat" id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                        <td class="id_mco">{{ $mco->id }}</td>
                                        <td class="id_pasar">{{ $mrdo->mrd->id_pasar ?? '' }}</td>
                                        <td class="nama_pasar">{{ $mrdo->mrd->nama_pasar ?? '' }}</td>
                                        <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                        <td class="tipe_outlet">{{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                            - {{ $mco->sp->location_type ?? '' }} - {{ $mco->sp->source_type ?? '' }}
                                        </td>
                                        <td>
                                            <div class="row px-2 py-1">
                                                <div class="col-6 px-0">
                                                    <button type="button"
                                                        class="btn btn-sm p-1 btn-warning btnEdit w-100">Edit</button>
                                                </div>
                                                <div class="col-6 px-0">
                                                    <button type="button"
                                                        class="btn btn-sm p-1 btn-info w-100 btnSetRetail"
                                                        data-row-index="{{ $no }}"
                                                        data-id_mrdo="{{ $mrdo->id }}"
                                                        data-id_mco="{{ $mco->id }}"
                                                        data-set={{ null }}>Retail</button>
                                                </div>
                                                <div class="col-6 px-0">
                                                    <button type="button"
                                                        class="btn btn-sm p-1 btn-success w-100 btnSetGrosir"
                                                        data-row-index="{{ $no }}"
                                                        data-id_mrdo="{{ $mrdo->id }}"
                                                        data-id_mco="{{ $mco->id }}"
                                                        data-set="TPOUT_WHSL">Grosir</button>
                                                </div>
                                                <div class="col-6 px-0">
                                                    <button type="button" class="btn btn-sm p-1 btn-light w-100 bypassQR"
                                                        data-survey_pasar_id="{{ $mco->sp->id }}">QR</button>
                                                </div>
                                                {{-- <div class="col-6 px-0">
                                                    <button type="button"
                                                        class="btn btn-sm p-1 btn-danger w-100 btnHapus">Hapus</button>
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="btn-check check" id="check{{ $no }}"
                                                autocomplete="off">
                                            <label class="btn btn-sm btn-outline-success"
                                                for="check{{ $no }}">Pilih</label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Order -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Data Order</h5>
                    <input type='date' class='form-control form-control-sm date' id='tgl_transaksi'
                        name='tgl_transaksi' value='<?= date('Y-m-d') ?>'>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-dark  table-striped table-bordered TableOrder">
                            <thead class="text-center">
                                <th>no</th>
                                <th>id</th>
                                <th>wilayah</th>
                                <th>no_order</th>
                                <th>nama_salesman</th>
                                <th>nama_toko</th>
                                <th>id_survey_pasar</th>
                                <th>status</th>
                                <th>total_rp</th>
                                <th>total_qty</th>
                                <th>total_transaksi</th>
                                <th>tgl_transaksi</th>
                                <th>document</th>
                                <th>closed_order</th>
                                <th>platform</th>
                                <th>id_qr_outlet</th>
                                <th>kode_customer</th>
                            </thead>
                            <tbody id="bodyTabelOrder">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kandidat -->
    <div class="modal fade" id="KandidatModal" tabindex="-1" role="dialog" aria-labelledby="KandidatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="KandidatModalLabel">Data Kandidat</h5>
                    <input type='date' class='form-control form-control-sm date' id='tgl_visit' name='tgl_visit'
                        value='<?= date('Y-m-d') ?>'>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-dark table-striped table-bordered TableKandidat w-100">
                            <thead class="text-center">
                                <th>No</th>
                                <th>Distributor</th>
                                <th>Wilayah</th>
                                <th>id_salesman</th>
                                <th>Salesman</th>
                                <th>Nama Toko</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Kode Customer</th>
                                <th>Tgl Visit</th>
                                <th>Lama Visit</th>
                                <th>Jam Masuk</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Alamat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAlamat">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <label for="nama_toko-baru">Nama Toko</label>
                            <input type="text" autocomplete="off" class="form-control modal-input"
                                id="nama_toko-baru" name="nama_toko-baru">
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="alamat-baru">Alamat</label>
                            <input type="text" autocomplete="off" class="form-control modal-input" id="alamat-baru"
                                name="alamat-baru">
                        </div>
                        <div class="form-group">
                            <label for="kode_customer-baru">Kode Customer</label>
                            <input type="text" autocomplete="off" class="form-control modal-input"
                                id="kode_customer-baru" name="kode_customer-baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEdit">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pindah Pasar -->
    <div class="modal fade" id="PindahPasarModal" tabindex="-1" role="dialog" aria-labelledby="PindahPasarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="PindahPasarModalLabel">Pindah Pasar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Pasar</span>
                            <select class="form-select form-select-sm select2-pasar_akhir w-100" id="pasar_akhir">
                            </select>
                        </div>
                        <input type="hidden" id="id_pasar_akhir" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="savePindahPasar">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pindah Lokasi -->
    <div class="modal fade" id="PindahLokasiModal" tabindex="-1" role="dialog"
        aria-labelledby="PindahLokasiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="PindahLokasiModalLabel">Pindah Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Lokasi</span>
                            <select class="form-select form-select-sm w-100" id="lokasi">
                                <option value="Mainroad">Mainroad</option>
                                <option value="Pasar">Pasar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="savePindahLokasi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- TOAST SALIN KODE --}}
    <div class="toast-container position-fixed top-0 end-0 p-5">
        <div class="toast align-items-center text-bg-success border-0" id="toastSalin" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Data berhasil disalin
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.select2-salesman_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getSalesman') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page ||
                                1, // Menambahkan parameter 'page' saat melakukan permintaan ke server
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1; // Menyimpan nilai halaman saat ini

                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more // Mengambil nilai 'more' dari respons server
                            }
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
                $('.select2-rute_awal').val(null).trigger('change');
            });

            $('.select2-rute_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getRute') }}",
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
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getSalesman') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page ||
                                1, // Menambahkan parameter 'page' saat melakukan permintaan ke server
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1; // Menyimpan nilai halaman saat ini

                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more // Mengambil nilai 'more' dari respons server
                            }
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
                $('.select2-rute_akhir').val(null).trigger('change');
            });

            $('.select2-rute_akhir').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getRute') }}",
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

            // SELECT2 PASAR
            $('.select2-pasar_akhir').select2({
                dropdownParent: $('#PindahPasarModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getPasar') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page ||
                                1, // Menambahkan parameter 'page' saat melakukan permintaan ke server
                            id_wilayah: $('#nama_wilayah').text().match(/\((.*?)\)/)[1],
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1; // Menyimpan nilai halaman saat ini

                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more // Mengambil nilai 'more' dari respons server
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih Pasar',
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.id_pasar).addClass('pull-right').append($('<b>').text(
                        ' - ' + data.text)).addClass('pull-right').append($('<b>').text(
                        ' - ' + data.nama_wilayah));
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#id_pasar_akhir').val(data.id_pasar);
            });

            var table = $('.myTable').DataTable({
                "dom": "<'row'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-3 filter-NamaToko'><'col-sm-12 col-md-3 filter-jenis_outlet'B><'col-sm-12 col-md-2 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                buttons: [{
                    extend: 'copy',
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#id_salesman')
                        .text(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }, 'csv', {
                    extend: 'excel',
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#id_salesman')
                        .text(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }, 'pdf', 'print'],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 14, 15],
                    "className": 'no-export'
                }],
                "order": [
                    [1, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-50">
                        <option value="">Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-jenis_outlet')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            if (val === '') {
                                table.columns(6).search('').draw();
                            } else if (val ===
                                'KANDIDAT') {
                                table.columns(6).search('^(0|null|)$', true, false).draw();
                            } else if (val === 'RO') {
                                table.columns(6).search('^(?!0|!|!null).+$', true, false).draw();
                            }
                        });

                    // FILTER SURVEY_PASAR
                    $(`<textarea id="filterSurveyPasar" class="form-control" rows="2" placeholder="Filter Survey Pasar"></textarea>`)
                        .appendTo('.filter-survey_pasar')
                        .on('input', function() {
                            var filterSurveyPasar = $(this).val().trim().split('\n').map(function(
                                item) {
                                return '^' + item.trim() + '$';
                            }).join('|');

                            table.column(5).search(filterSurveyPasar, true, false).draw();
                        });

                    // FILTER KODE CUSTOMER
                    $(`<textarea id="filterKodeCustomer" class="form-control" rows="2" placeholder="Filter Kode Customer"></textarea>`)
                        .appendTo('.filter-KodeCustomer')
                        .on('input', function() {
                            var filterKodeCustomer = $(this).val().trim().split('\n').map(function(
                                item) {
                                return '^' + item.trim() + '$';
                            }).join('|');

                            table.column(6).search(filterKodeCustomer, true, false).draw();
                        });

                    // FILTER NAMA TOKO
                    $(`<textarea id="filterNamaToko" class="form-control" rows="2" placeholder="Filter Nama Toko"></textarea>`)
                        .appendTo('.filter-NamaToko')
                        .on('input', function() {
                            var filterNamaToko = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            }).join('|');

                            table.column(7).search(filterNamaToko, true, false).draw();
                        });
                }
            });
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $('#salinKode').click(function() {
                // Mengambil data kolom dengan filter yang aktif
                var filteredData = table.column(6, {
                    search: 'applied'
                }).data().toArray();

                var textToCopy = filteredData.join('\n');
                var tempInput = document.createElement('textarea');
                tempInput.value = textToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                var toast = $('#toastSalin');
                toast.show();
                setTimeout(function() {
                    toast.hide();
                }, 2000);
            });
            $('#salinNamaToko').click(function() {
                // Mengambil data kolom dengan filter yang aktif
                var filteredData = table.column(7, {
                    search: 'applied'
                }).data().toArray();

                var textToCopy = filteredData.join('\n');
                var tempInput = document.createElement('textarea');
                tempInput.value = textToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                var toast = $('#toastSalin');
                toast.show();
                setTimeout(function() {
                    toast.hide();
                }, 2000);
            });

            $('.check-all').click(function() {
                $('.check').prop('checked', this.checked);
            });

            $('.check').click(function() {
                if ($('.check:checked').length == $('.check').length) {
                    $('.check-all').prop('checked', true);
                } else {
                    $('.check-all').prop('checked', false);
                }
            });

            var TableOrder;
            $(document).on('click', ".btnOrder", function() {
                if (!TableOrder) {
                    TableOrder = $('.TableOrder').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f >> " +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data ' + $('#salesman_awal').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data ' + $('#salesman_awal').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'pdf', 'print'],
                        ajax: {
                            url: "{{ route('ToolOutlet.getOrder') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#nama-salesman').text().match(/\((.*?)\)/)[
                                    1];
                                d.tgl_transaksi = $('#tgl_transaksi')
                                    .val(); // ambil nilai input field id_transaksi
                            },
                        },
                        order: [
                            [11, 'asc'],
                            [2, 'asc'],
                            [4, 'asc']
                        ],
                        columnDefs: [{
                            targets: [1, 6, 12, 13, 15, 14],
                            className: 'no-export' // kelas no-export
                        }],
                        columns: [{
                                "title": "no",
                                "orderable": false,
                                "searchable": false,
                                "width": "30px",
                                "className": "dt-center",
                                'render': function(data, type, full, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'nama_wilayah',
                                name: 'nama_wilayah'
                            },
                            {
                                data: 'no_order',
                                name: 'no_order'
                            },
                            {
                                data: 'nama_salesman',
                                name: 'nama_salesman',
                                className: 'text-primary'
                            },
                            {
                                data: 'nama_toko',
                                name: 'nama_toko'
                            },
                            {
                                data: 'id_survey_pasar',
                                name: 'id_survey_pasar'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'total_rp',
                                name: 'total_rp'
                            },
                            {
                                data: 'total_qty',
                                name: 'total_qty'
                            },
                            {
                                data: 'total_transaksi',
                                name: 'total_transaksi'
                            },
                            {
                                data: 'tgl_transaksi',
                                name: 'tgl_transaksi',
                                className: 'text-success fw-bold'
                            },
                            {
                                data: 'document',
                                name: 'document'
                            },
                            {
                                data: 'closed_order',
                                name: 'closed_order'
                            },
                            {
                                data: 'platform',
                                name: 'platform'
                            },
                            {
                                data: 'id_qr_outlet',
                                name: 'id_qr_outlet'
                            },
                            {
                                data: 'kode_customer',
                                name: 'kode_customer'
                            },
                        ],
                    });
                } else {
                    TableOrder.draw();
                }
                $('#orderModal').modal('show');
            });
            $(document).on('change', "#tgl_transaksi", function() {
                TableOrder.draw();
            });

            // TABLE KANDIDAT
            var TableKandidat;
            $(document).on('click', ".btnKandidat", function() {
                if (!TableKandidat) {
                    TableKandidat = $('.TableKandidat').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f >> " +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data ' + $('#salesman_awal').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data ' + $('#salesman_awal').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'pdf', 'print'],
                        ajax: {
                            url: "{{ route('ToolOutlet.getKandidat') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#nama-salesman').text().match(/\((.*?)\)/)[
                                    1];
                                d.tgl_visit = $('#tgl_visit')
                                    .val(); // ambil nilai input field id_visit
                            },
                        },
                        order: [
                            [11, 'asc'],
                        ],
                        columnDefs: [{
                            targets: 11,
                            render: function(data, type, row, meta) {
                                return data
                                // return moment(data).tz("Asia/Jakarta").format("YYYY-MM-DD HH:mm:ss");
                            }
                        }],
                        columns: [{
                                "title": "no",
                                "orderable": false,
                                "searchable": false,
                                "width": "30px",
                                "className": "dt-center",
                                'render': function(data, type, full, meta) {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'nama_distributor',
                                name: 'nama_distributor'
                            },
                            {
                                data: 'nama_wilayah',
                                name: 'nama_wilayah'
                            },
                            {
                                data: 'id_salesman',
                                name: 'id_salesman'
                            },
                            {
                                data: 'nama_salesman',
                                name: 'nama_salesman'
                            },
                            {
                                data: 'nama_toko',
                                name: 'nama_toko'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'reason',
                                name: 'reason'
                            },
                            {
                                data: 'kode_customer',
                                name: 'kode_customer'
                            },
                            {
                                data: 'tgl_visit',
                                name: 'tgl_visit'
                            },
                            {
                                data: 'lama_visit',
                                name: 'lama_visit'
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at'
                            }
                        ],
                    });
                } else {
                    TableKandidat.draw();
                }
                $('#KandidatModal').modal('show');
            });
            $(document).on('change', "#tgl_visit", function() {
                TableKandidat.draw();
            });

            // // PINDAH RUTE
            // $('#btnPindah').click(function(e) {
            //     e.preventDefault();

            //     var selectedRows = [];

            //     var rute_id_akhir = $('#rute_id_akhir').val();
            //     $('.check:checked').each(function() {
            //         var id = $(this).closest('tr').data('id');
            //         var id_pasar_awal = $(this).closest('tr').data('id_pasar_awal');
            //         var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
            //         selectedRows.push({
            //             id: id,
            //             id_pasar_awal: id_pasar_awal,
            //             rute_id_akhir: rute_id_akhir,
            //             id_survey_pasar: id_survey_pasar
            //         });
            //     });
            //     // console.log(selectedRows);
            //     $.ajax({
            //         type: 'post',
            //         url: "{{ route('ToolOutlet.pindah') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             detail: selectedRows
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             // console.log(response.message);
            //             $('#successModal #message').text(response.message);
            //             $('#successModal').modal('show');
            //             setTimeout(function() {
            //                 $('#successModal').modal('hide');
            //                 location.reload();
            //             }, 3000);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //             $('#errorModal #message').text(xhr.responseJSON.message);
            //             $('#errorModal').modal('show');
            //         },
            //         complete: function() {
            //             $('.loading-overlay').hide();
            //         }
            //     });
            // });

            // // PINDAH PASAR
            // $('#savePindahPasar').click(function(e) {
            //     e.preventDefault();

            //     var selectedRows = [];

            //     $('.check:checked').each(function() {
            //         var id = $(this).closest('tr').data('id');
            //         var id_mco = $(this).closest('tr').data('id_mco');
            //         var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
            //         var rute_id_awal = $(this).closest('tr').data('rute_id_awal');
            //         var id_pasar_akhir = $('#id_pasar_akhir').val();
            //         selectedRows.push({
            //             id: id,
            //             id_mco: id_mco,
            //             id_survey_pasar: id_survey_pasar,
            //             id_pasar_akhir: id_pasar_akhir,
            //             rute_id_awal: rute_id_awal
            //         });
            //     });
            //     // console.log(selectedRows);
            //     $.ajax({
            //         type: 'post',
            //         url: "{{ route('ToolOutlet.pindahPasar') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             detail: selectedRows
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             // console.log(response.message);
            //             $('#successModal #message').text(response.message);
            //             $('#successModal').modal('show');
            //             $('#id_pasar_akhir').val(null);
            //             setTimeout(function() {
            //                 $('#successModal').modal('hide');
            //                 location.reload();
            //             }, 3000);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //             $('#errorModal #message').text(xhr.responseJSON.message);
            //             $('#errorModal').modal('show');
            //         },
            //         complete: function() {
            //             $('.loading-overlay').hide();
            //         }
            //     });
            // });

            // PINDAH RUTE
            $('#btnPindah').click(function(e) {
                e.preventDefault();


                var salesman_awal = $('#salesman_awal').val();
                var salesman_akhir = $('#salesman_akhir').val();
                var hari = $('#rute_id_akhir').text().split(' ')[0];
                var rute = $('#rute_id_akhir').val();
                var selectedRows = [];

                if (rute === '' || rute == null) {
                    $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
                    $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }

                $('.check:checked').each(function(index) {
                    var id_mrdo = $(this).closest('tr').find('.id_mrdo').text();
                    var rute_id = $(this).closest('tr').find('.rute_id').text();
                    var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                    var id_pasar = $(this).closest('tr').find('.id_pasar').text();
                    var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                    var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                    var wilayah = $('#nama_wilayah').text().replace(
                        /\s*\([^)]*\)$/, '');
                    var location_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                        ' - ')[1];
                    var toko = $(this).closest('tr').find('.nama_toko').text();

                    var dataObject = {};
                    dataObject['id_mrdo'] = id_mrdo;
                    dataObject['rute_id'] = rute_id;
                    dataObject['rute_detail_id'] = rute_detail_id;
                    dataObject['id_pasar'] = id_pasar;
                    dataObject['survey_pasar_id'] = id_survey_pasar;
                    dataObject['kode_customer'] = kode_customer;
                    dataObject['wilayah'] = wilayah;
                    dataObject['salesman'] = salesman_awal;
                    dataObject['location_type'] = location_type;
                    dataObject['toko'] = toko;

                    selectedRows.push(dataObject);
                });

                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/outletkandidat/pindahoutlet",
                    dataType: 'json',
                    encode: true,
                    data: {
                        salesman: salesman_akhir,
                        hari: hari,
                        rute: rute,
                        data_all: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            $('#successModal').modal('show');
                            setTimeout(function() {
                                $('#successModal').modal('hide');
                                location.reload();
                            }, 3000);
                        } else {
                            $('#errorModal #message').text(response.message);
                            $('#errorModal').modal('show');
                        }
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

            // PINDAH PASAR
            $(document).on('click', "#btnPindahPasar", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahPasarModal').modal('show');

                $('#savePindahPasar').click(function(e) {
                    e.preventDefault();

                    var selectedRows = [];
                    var valid = true;
                    $('.check:checked').each(function(index) {
                        var id_wilayah = $('#nama_wilayah').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                        var id_qr_outlet = $(this).closest('tr').find('.id_mco').text();
                        var mrdo_id = $(this).closest('tr').find('.id_mrdo').text();
                        var id = $(this).closest('tr').find('.rute_id').text();
                        var rute = $(this).closest('tr').find('.rute').text();
                        var hari = $(this).closest('tr').find('.hari').text();
                        var nama_toko = $(this).closest('tr').find('.nama_toko').text();
                        var alamat = $(this).closest('tr').find('.alamat').text();
                        var kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        var nama_wilayah = $('#nama_wilayah').text().replace(
                            /\s*\([^)]*\)$/, '');
                        var salesman = $('#salesman_awal').val();
                        var id_pasar = $(this).closest('tr').find('.id_pasar').text();
                        var location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split(
                                ' - ')[1].trim();
                        var source_type = $(this).closest('tr').find('.tipe_outlet').text()
                            .split(
                                ' - ')[2].trim();
                        if (source_type == 'MAS') {
                            alert("Source Type MAS : " + nama_toko + " - " + kode_customer);
                            valid = false;
                            $('#PindahPasarModal').modal('hide');
                            return false;
                        }
                        console.log(source_type);
                        var id_pasar_akhir = $('#id_pasar_akhir').val();

                        var dataObject = {};
                        dataObject['id_wilayah'] = id_wilayah;
                        dataObject['survey_pasar_id'] = id_survey_pasar;
                        dataObject['id_qr_outlet'] = id_qr_outlet;
                        dataObject['mrdo_id'] = mrdo_id;
                        dataObject['id'] = id;
                        dataObject['rute'] = rute;
                        dataObject['hari'] = hari;
                        dataObject['nama_toko'] = nama_toko;
                        dataObject['kode_customer'] = kode_customer;
                        dataObject['nama_wilayah'] = nama_wilayah;
                        dataObject['salesman'] = salesman;
                        dataObject['id_pasar'] = id_pasar;
                        dataObject['location_type'] = location_type;

                        var data = [];
                        data.push(kode_customer);
                        data.push(nama_toko);
                        data.push(alamat);
                        data.push(location_type);
                        data.push(id_pasar_akhir);
                        data[5] = dataObject;
                        selectedRows.push(data);
                    });

                    if (valid) {
                        $.ajax({
                            type: 'post',
                            url: "http://10.11.1.37/api/tool/outletkandidat/saveeditcustomer",
                            dataType: 'json',
                            encode: true,
                            data: {
                                data: selectedRows
                            },
                            beforeSend: function() {
                                $('.loading-overlay').show();
                            },
                            success: function(response) {
                                $('#successModal #message').text(response.message);
                                $('#successModal').modal('show');
                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    location.reload();
                                }, 3000);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                $('#errorModal #message').text(xhr.responseJSON
                                    .message);
                                $('#errorModal').modal('show');
                            },
                            complete: function() {
                                $('.loading-overlay').hide();
                            }
                        });
                    }
                });
            });

            // PINDAH LOKASI
            $(document).on('click', "#btnPindahLokasi", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahLokasiModal').modal('show');

                $('#savePindahLokasi').click(function(e) {
                    e.preventDefault();

                    var selectedRows = [];
                    var valid = true;
                    $('.check:checked').each(function(index) {
                        var id_wilayah = $('#nama_wilayah').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                        var id_qr_outlet = $(this).closest('tr').find('.id_mco').text();
                        var mrdo_id = $(this).closest('tr').find('.id_mrdo').text();
                        var id = $(this).closest('tr').find('.rute_id').text();
                        var rute = $(this).closest('tr').find('.rute').text();
                        var hari = $(this).closest('tr').find('.hari').text();
                        var nama_toko = $(this).closest('tr').find('.nama_toko').text();
                        var alamat = $(this).closest('tr').find('.alamat').text();
                        var kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        var nama_wilayah = $('#nama_wilayah').text().replace(
                            /\s*\([^)]*\)$/, '');
                        var salesman = $('#salesman_awal').val();
                        var id_pasar = $(this).closest('tr').find('.id_pasar').text();
                        var location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split(
                                ' - ')[1];
                        var source_type = $(this).closest('tr').find('.tipe_outlet').text()
                            .split(
                                ' - ')[2].trim();
                        if (source_type == 'MAS') {
                            alert("Source Type MAS : " + nama_toko + " - " + kode_customer);
                            valid = false;
                            $('#PindahLokasiModal').modal('hide');
                            return false;
                        }

                        var lokasi = $('#lokasi').val();

                        var dataObject = {};
                        dataObject['id_wilayah'] = id_wilayah;
                        dataObject['survey_pasar_id'] = id_survey_pasar;
                        dataObject['id_qr_outlet'] = id_qr_outlet;
                        dataObject['mrdo_id'] = mrdo_id;
                        dataObject['id'] = id;
                        dataObject['rute'] = rute;
                        dataObject['hari'] = hari;
                        dataObject['nama_toko'] = nama_toko;
                        dataObject['kode_customer'] = kode_customer;
                        dataObject['nama_wilayah'] = nama_wilayah;
                        dataObject['salesman'] = salesman;
                        dataObject['id_pasar'] = id_pasar;
                        dataObject['location_type'] = location_type;

                        var data = [];
                        data.push(kode_customer);
                        data.push(nama_toko);
                        data.push(alamat);
                        data.push(lokasi);
                        data.push(id_pasar);
                        data[5] = dataObject;
                        selectedRows.push(data);
                    });

                    if (valid) {
                        $.ajax({
                            type: 'post',
                            url: "http://10.11.1.37/api/tool/outletkandidat/saveeditcustomer",
                            dataType: 'json',
                            encode: true,
                            data: {
                                data: selectedRows
                            },
                            beforeSend: function() {
                                $('.loading-overlay').show();
                            },
                            success: function(response) {
                                $('#successModal #message').text(response.message);
                                $('#successModal').modal('show');
                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    location.reload();
                                }, 3000);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                $('#errorModal #message').text(xhr.responseJSON
                                    .message);
                                $('#errorModal').modal('show');
                            },
                            complete: function() {
                                $('.loading-overlay').hide();
                            }
                        });
                    }
                });
            });

            // EDIT OUTLET
            $(document).on('click', ".btnEdit", function() {
                var nama_toko = $(this).closest('tr').find('.nama_toko').text();
                var alamat = $(this).closest('tr').find('.alamat').text();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();

                $('#alamat-baru').val(alamat);
                $('#nama_toko-baru').val(nama_toko);
                $('#kode_customer-baru').val(kode_customer);
                // var index = $(".btnEdit").index(this);
                // $('#index-edit').val();

                // Tampilkan modal edit
                $('#editModal').modal('show');

                var selectedRows = [];
                var valid = true;

                var id_wilayah = $('#nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
                var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                var id_qr_outlet = $(this).closest('tr').find('.id_mco').text();
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text();
                var id = $(this).closest('tr').find('.rute_id').text();
                var rute = $(this).closest('tr').find('.rute').text();
                var hari = $(this).closest('tr').find('.hari').text();
                var nama_toko = $(this).closest('tr').find('.nama_toko').text();
                var alamat = $(this).closest('tr').find('.alamat').text();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var nama_wilayah = $('#nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $('#salesman_awal').val();
                var id_pasar = $(this).closest('tr').find('.id_pasar').text();
                var location_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                    ' - ')[1].trim();
                var source_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                    ' - ')[2].trim();

                var dataObject = {};
                dataObject['id_wilayah'] = id_wilayah;
                dataObject['survey_pasar_id'] = id_survey_pasar;
                dataObject['id_qr_outlet'] = id_qr_outlet;
                dataObject['mrdo_id'] = mrdo_id;
                dataObject['id'] = id;
                dataObject['rute'] = rute;
                dataObject['hari'] = hari;
                dataObject['nama_toko'] = nama_toko;
                dataObject['kode_customer'] = kode_customer;
                dataObject['nama_wilayah'] = nama_wilayah;
                dataObject['salesman'] = salesman;
                dataObject['id_pasar'] = id_pasar;
                dataObject['location_type'] = location_type;

                console.log(dataObject);

                $('#saveEdit').click(function(e) {
                    e.preventDefault();
                    var nama_toko_akhir = $('#nama_toko-baru').val();
                    var alamat_akhir = $('#alamat-baru').val();
                    var kode_customer_akhir = $('#kode_customer-baru').val();

                    var data = [];
                    data.push(kode_customer_akhir);
                    data.push(nama_toko_akhir);
                    data.push(alamat_akhir);
                    data.push(location_type);
                    data.push(id_pasar);
                    data[5] = dataObject;
                    selectedRows.push(data);

                    $.ajax({
                        type: 'post',
                        url: "http://10.11.1.37/api/tool/outletkandidat/saveeditcustomer",
                        dataType: 'json',
                        encode: true,
                        data: {
                            data: selectedRows
                        },
                        beforeSend: function() {
                            $('.loading-overlay').show();
                        },
                        success: function(response) {
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

            // SET RETAIL
            $(document).on('click', '.btnSetRetail, .btnSetGrosir', function() {
                var id_mrdo = $(this).data('id_mrdo');
                var id_mco = $(this).data('id_mco');
                var set = $(this).data('set');
                var tipe_outlet = $(this).closest('tr').find('.tipe_outlet');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolOutlet.setOutlet') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        id_mrdo: id_mrdo,
                        id_mco: id_mco,
                        set: set
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        var tipe_outlet_all = tipe_outlet.text().trim();
                        var tipe_outlet_parts = tipe_outlet_all.split(' - ');
                        tipe_outlet_parts[0] = response.tipe_outlet ?? "RETAIL";
                        var tipe_outlet_modified = tipe_outlet_parts.join(' - ');
                        tipe_outlet.html(tipe_outlet_modified);
                        $('.modal-input').val('');
                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            // // HAPUS
            // $(document).on('click', '.btnHapus', function() {
            //     var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
            //     var id_depo = $('#nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
            //     var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();

            //     $.ajax({
            //         type: 'POST',
            //         url: "http://10.11.1.37/api/tool/rute/hapusOutlet",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             mrdo_id: mrdo_id,
            //             id_depo: id_depo,
            //             kode_customer: kode_customer,
            //             tipe: ''
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             $('#successModal').modal('show');
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //             $('#errorModal').modal('show');
            //         },
            //         complete: function() {
            //             $('.loading-overlay').hide();
            //         }
            //     });
            // });

            // CEK RUTE AKTIF
            var nama_sales = $('#salesman_awal').val();
            if (nama_sales !== '') {
                var iddepo = $('#nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/rute/getData",
                    dataType: 'json',
                    encode: true,
                    data: {
                        nama_sales: nama_sales,
                        iddepo: iddepo
                    },
                    success: function(response) {
                        $('.warnaBaris').each(function() {
                            var ruteId = $(this).find('.rute_id').text();
                            var rute = $(this).find('.rute');
                            if (ruteId == response.rute_hari_ini) {
                                rute.addClass('text-success fw-bolder');
                            }
                        });
                    },
                    error: function(xhr, status, error) {},
                    complete: function() {}
                });
            }
        });
    </script>
@endsection
