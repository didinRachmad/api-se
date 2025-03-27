@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">Search Data by Route ID</div> --}}
        <div class="card-body card-body-custom mt-3">
            <form class="form" method="POST" action="{{ route('RuteId.getDataByRuteId') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman w-100" name="salesman" id="salesman"
                                required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                                oninput="setCustomValidity('')">
                                <option value="{{ old('salesman', $salesman ?? '') }}">
                                    {{ old('salesman', $salesman ?? '') }}</option>
                            </select>
                        </div>
                        <input type="hidden" name="id_salesman" id="id_salesman"
                            value="{{ old('id_salesman', $id_salesman ?? '') }}">
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute w-100" name="rute_id" id="rute_id">
                                <option value="{{ old('rute_id', $rute_id ?? '') }}">
                                    {{ old('rute', $rute ?? '') }}</option>
                            </select>
                        </div>
                        <input type="hidden" id="rute" name="rute" value="{{ old('rute', $rute ?? '') }}">
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-info btnOrder">Order <span>
                                <i class="bi bi-journal-text"></i></span></button>
                        <button type="button"
                            class="btn btn-sm rounded-3 shadow-sm btn-outline-warning btnKandidat">Kandidat <span>
                                <i class="bi bi-journal-text"></i></span></button>
                    </div>
                    {{-- </div> --}}

                    @if (!isset($data))
                        @php
                            $data = collect();
                        @endphp
                    @endif
                    {{-- <h3>Hasil Pencarian:</h3> --}}
                    {{-- <div class="row pt-3"> --}}
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
                    </div>
                </div>
            </form>
            <div class="table-responsive pt-3">
                <table class="table table-sm table-light table-striped  align-middle myTable">
                    <thead class="text-center">
                        <th>no</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>rute detail id</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer <button type="button"
                                class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-secondary" id="salinKode"><i
                                    class="bi bi-clipboard-fill"></i></button></th>
                        <th>Nama Toko <button type="button"
                                class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-secondary" id="salinNamaToko"><i
                                    class="bi bi-clipboard-fill"></i></button></th>
                        <th>Alamat</th>
                        <th>id mco</th>
                        <th>id pasar mrd</th>
                        <th>nama pasar mrd</th>
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
                                @php
                                    $no += 1;
                                @endphp
                                <tr class="warnaBaris">
                                    <td></td>
                                    <td class="rute">{{ $mr->rute }}</td>
                                    <td>{{ $mr->hari }}</td>
                                    <td class="rute_id">{{ $mrdo->rute_id }}</td>
                                    <td>{{ $mrdo->rute_detail_id }}</td>
                                    <td>{{ $mrdo->survey_pasar_id }}</td>
                                    <td class="text-primary fw-bold" id="kode{{ $no }}">
                                        {{ $mrdo->mco->kode_customer }}
                                        {{-- <input type="hidden" class="form-control" value="{{ $mrdo->mco->id }}"> --}}
                                    </td>
                                    <td id="nama_toko{{ $no }}">{{ $mrdo->nama_toko }}</td>
                                    <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                    <td>{{ $mrdo->mco->id }}</td>
                                    <td>{{ $mrdo->mrd->id_pasar }}</td>
                                    <td>{{ $mrdo->mrd->nama_pasar }}</td>
                                    <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                    <td id="tipe_outlet{{ $no }}">{{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                    </td>
                                    <td>
                                        <div class="row px-2 py-1">
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-warning btnEditAlamat w-100"
                                                    data-row-index="{{ $no }}"
                                                    data-alamat-awal="{{ $mrdo->alamat }}"
                                                    data-survey_pasar_id="{{ $mrdo->survey_pasar_id }}"
                                                    data-id_mco="{{ $mrdo->mco->id }}">Edit</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-primary btnEditKode w-100"
                                                    data-row-index="{{ $no }}"
                                                    data-kode-awal="{{ $mrdo->mco->kode_customer }}"
                                                    data-id_mco="{{ $mrdo->mco->id }}"
                                                    data-survey_pasar_id="{{ $mrdo->survey_pasar_id }}">Kode</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-secondary btnPindahPasar w-100"
                                                    data-id="{{ $mrdo->id }}" data-id_mco="{{ $mrdo->mco->id }}"
                                                    data-id_pasar_awal="{{ $mrdo->id_pasar }}"
                                                    data-rute_id_awal="{{ $mrdo->rute_id }}"
                                                    data-id_survey_pasar="{{ $mrdo->survey_pasar_id }}">Pasar</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-info w-100 btnSetRetail"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mrdo->mco->id }}"
                                                    data-set={{ null }}>Retail</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-success w-100 btnSetGrosir"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}"
                                                    data-id_mco="{{ $mrdo->mco->id }}"
                                                    data-set="TPOUT_WHSL">Grosir</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-light w-100 bypassQR"
                                                    data-survey_pasar_id="{{ $mrdo->mco->sp->id }}">QR</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-light  table-striped  TableOrder">
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-light table-striped  TableKandidat w-100">
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

    <!-- Modal Edit Alamat -->
    <div class="modal fade" id="editAlamatModal" tabindex="-1" role="dialog" aria-labelledby="editAlamatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlamatModalLabel">Edit Alamat</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAlamat">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <input type="hidden" id="index-ALAMAT" name="index-ALAMAT" readonly>
                            <input type="hidden" id="survey_pasar_id-ALAMAT" name="survey_pasar_id-ALAMAT" readonly>
                            <input type="hidden" id="id_mco-ALAMAT" name="id_mco-ALAMAT" readonly>
                            <label for="alamat-baru">Nama Toko</label>
                            <input type="text" class="form-control modal-input" id="nama_toko-baru"
                                name="nama_toko-baru">
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="alamat-baru">Alamat</label>
                            <input type="text" class="form-control modal-input" id="alamat-baru" name="alamat-baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="saveEditAlamat">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kode Customer -->
    <div class="modal fade" id="editKodeModal" tabindex="-1" role="dialog" aria-labelledby="editKodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKodeModalLabel">Edit Kode Customer</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editKode">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <input type="hidden" id="index-KODE" name="index-KODE" readonly>
                            <input type="hidden" id="id_mco-KODE" name="id_mco-KODE" readonly>
                            <input type="hidden" id="survey_pasar_id-KODE" name="survey_pasar_id-KODE" readonly>
                            <label for="kode-awal">Kode Customer Awal</label>
                            <input type="text" class="form-control modal-input" id="kode-awal" name="kode-awal"
                                readonly>
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="kode-baru">Kode Customer Baru</label>
                            <input type="text" class="form-control modal-input" id="kode-baru" name="kode-baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="saveEditKode">Simpan</button>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Pasar</span>
                            <select class="form-select form-select-sm select2-pasar_akhir w-100" id="pasar_akhir">
                            </select>
                        </div>
                        <input type="hidden" id="id_mrdo-PASAR" readonly>
                        <input type="hidden" id="id_mco-PASAR" readonly>
                        <input type="hidden" id="survey_pasar_id-PASAR" readonly>
                        <input type="hidden" id="rute_id-PASAR" readonly>
                        <input type="hidden" id="id_pasar-PASAR" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="savePindahPasar">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- TOAST SALIN KODE --}}
    <div class="toast-container position-fixed top-0 end-0 p-5">
        <div class="toast align-items-center text-bg-success border-0" id="toastSalinKode" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Data berhasil disalin
                </div>
                <button type="button" class="btn-close bg-danger btn-close bg-danger-white me-2 m-auto"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var id_salesman = '';
            $('.select2-salesman').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('RuteId.getSalesman') }}",
                    dataType: 'json',
                    delay: 250,
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
                var data = e.params.data;
                // mengubah value dari id_salesman
                $('#id_salesman').val(data.id_salesman);
                $('.select2-rute').val(null).trigger('change');
            });

            $('.select2-rute').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('RuteId.getRute') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('#salesman').val()
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
                // mengubah value dari id_salesman
                $('#rute').val(data.text);
            });

            // SELECT2 PASAR
            $('.select2-pasar_akhir').select2({
                dropdownParent: $('#PindahPasarModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('RuteId.getPasar') }}",
                    dataType: 'json',
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
                $('#id_pasar-PASAR').val(data.id_pasar);
            });

            var table = $('.myTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-2 filter-kode_customer'><'col-sm-12 col-md-6 text-right 'f>>" +
                    "<'row py-2'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // "scrollY": "calc(100vh - 180px)",
                // "scrollCollapse": true,
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
                columnDefs: [{
                    targets: [4, 5, 6, 10, 11, 12, 14],
                    className: 'no-export' // kelas no-export
                }],
                // "lengthMenu": [
                //     [10, 25, 50, 100, -1],
                //     [10, 25, 50, 100, "All"]
                // ],
                // "pageLength": -1,
                "columnDefs": [{
                        "targets": [6],
                        "createdCell": function(td, cellData, rowData, rowIndex, colIndex) {
                            $(td).addClass('editable');
                        }
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }
                ],
                "paging": false,
                "order": [
                    [1, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
                // createdRow: function(row, data, rowIdx) {
                //     // Tambahkan nomor dinamis ke kolom pertama
                //     $('td', row).eq(0).html(rowIdx + 1);
                // },
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-50">
                        <option value="">Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-kode_customer')
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

            $('#salinKode').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
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

                var toast = $('#toastSalinKode');
                toast.show();
                setTimeout(function() {
                    toast.hide();
                }, 2000);
            });

            $('#salinNamaToko').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
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

                var toast = $('#toastSalinKode');
                toast.show();
                setTimeout(function() {
                    toast.hide();
                }, 2000);
            });

            var TableOrder;
            $(document).on('click', ".btnOrder", function() {
                if (!TableOrder) {
                    TableOrder = $('.TableOrder').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f >> " +
                            "<'row py-2'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data ' + $('#nama-salesman').text() + " - " + $(
                                    '#nama-distributor')
                                .text() + " - " +
                                $('#nama_wilayah').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data ' + $('#nama-salesman').text() + " - " + $(
                                    '#nama-distributor')
                                .text() + " - " +
                                $('#nama_wilayah').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'pdf', 'print'],
                        ajax: {
                            url: "{{ route('RuteId.getOrder') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#id_salesman')
                                    .val(); // ambil nilai input field id_salesman
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
                            "<'row py-2'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data ' + $('#nama-salesman').text() + " - " + $(
                                    '#nama-distributor')
                                .text() + " - " +
                                $('#nama_wilayah').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data ' + $('#nama-salesman').text() + " - " + $(
                                    '#nama-distributor')
                                .text() + " - " +
                                $('#nama_wilayah').text(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'pdf', 'print'],
                        ajax: {
                            url: "{{ route('RuteId.getKandidat') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#id_salesman')
                                    .val(); // ambil nilai input field id_salesman
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

            // INIT EDIT ALAMAT
            $(document).on('click', ".btnEditAlamat", function() {
                var index = $(this).data('row-index');
                var survey_pasar_id = $(this).data('survey_pasar_id');
                var id_mco = $(this).data('id_mco');
                var alamat = $('#alamat' + index).text().trim();
                var nama_toko = $('#nama_toko' + index).text().trim();

                $('#index-ALAMAT').val(index);
                $('#survey_pasar_id-ALAMAT').val(survey_pasar_id);
                $('#id_mco-ALAMAT').val(id_mco);
                $('#alamat-baru').val(alamat);
                $('#nama_toko-baru').val(nama_toko);

                // Tampilkan modal edit
                $('#editAlamatModal').modal('show');
            });

            // INIT EDIT KODE
            $(document).on('click', ".btnEditKode", function() {
                var index = $(this).data('row-index');
                var id_mco = $(this).data('id_mco');
                var survey_pasar_id = $(this).data('survey_pasar_id');
                var kodeAwal = $('#kode' + index).text().trim();

                $('#index-KODE').val(index);
                $('#id_mco-KODE').val(id_mco);
                $('#survey_pasar_id-KODE').val(survey_pasar_id);
                $('#kode-awal').val(kodeAwal);

                // Tampilkan modal edit
                $('#editKodeModal').modal('show');
            });

            // INIT EDIT PASAR
            $(document).on('click', ".btnPindahPasar", function() {
                var id = $(this).data('id');
                var id_mco = $(this).data('id_mco');
                var id_survey_pasar = $(this).data('id_survey_pasar');
                var rute_id_awal = $(this).data('rute_id_awal');
                var id_pasar_akhir = $('#id_pasar_akhir').val();

                $('#id_mrdo-PASAR').val(id);
                $('#id_mco-PASAR').val(id_mco);
                $('#survey_pasar_id-PASAR').val(id_survey_pasar);
                $('#rute_id-PASAR').val(rute_id_awal);
                $('#id_pasar-PASAR').val(id_pasar_akhir);

                // Tampilkan modal edit
                $('#PindahPasarModal').modal('show');
            });

            // EDIT ALAMAT
            $(document).on('click', "#saveEditAlamat", function() {
                // Ambil nilai kolom input field
                var survey_pasar_id = $('#survey_pasar_id-ALAMAT').val();
                var id_mco = $('#id_mco-ALAMAT').val();
                var nama_tokoBaru = $('#nama_toko-baru').val();
                var alamatBaru = $('#alamat-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var index = $('#index-ALAMAT').val();

                if (alamatBaru === '' || alamatBaru == null) {
                    $('#alamat-baru').get(0).setCustomValidity('Harap isi Alamat');
                    $('#alamat-baru').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }
                if (nama_tokoBaru === '' || nama_tokoBaru == null) {
                    $('#nama_toko-baru').get(0).setCustomValidity('Harap isi Nama Toko');
                    $('#nama_toko-baru').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }

                // Lakukan update pada data di database
                $.ajax({
                    type: 'post',
                    url: "{{ route('RuteId.updateAlamat') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        survey_pasar_id: survey_pasar_id,
                        id_mco: id_mco,
                        nama_toko: nama_tokoBaru,
                        alamat: alamatBaru,
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#alamat' + index).text(response.alamat);
                        $('#nama_toko' + index).text(response.nama_toko);
                        $('#editAlamatModal').modal('hide');
                        $('.modal-input').val('');
                        $('#successModal').modal('show');
                        $('#alamat-baru').val('');
                        $('#nama_toko-baru').val('');
                    },
                    error: function(xhr, status, error) {
                        // console.error(error);
                        $('#errorModal #message').text(xhr.responseJSON.message);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            // EDIT KODE
            $(document).on('click', '#saveEditKode', function() {
                var id_mco = $('#id_mco-KODE').val();
                var survey_pasar_id = $('#survey_pasar_id-KODE').val();
                var kodeBaru = $('#kode-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var index = $('#index-KODE').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('RuteId.updateKode') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        id_mco: id_mco,
                        survey_pasar_id: survey_pasar_id,
                        kodeBaru: kodeBaru
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#kode' + index).text(response.kode_customer);
                        $('#editKodeModal').modal('hide');
                        $('.modal-input').val('');
                        $('#successModal').modal('show');
                        $('#kode-baru').val('');
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

            // SET RETAIL
            $(document).on('click', '.btnSetRetail, .btnSetGrosir', function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var id_mco = $(this).data('id_mco');
                var set = $(this).data('set');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('RuteId.setOutlet') }}",
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
                        $('#tipe_outlet' + index).text(response.tipe_outlet ??
                            "RETAIL");

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

            // PINDAH PASAR
            $('#savePindahPasar').click(function(e) {
                e.preventDefault();

                var selectedRows = [];

                var id_mrdo = $('#id_mrdo-PASAR').val();
                var id_mco = $('#id_mco-PASAR').val();
                var id_survey_pasar = $('#survey_pasar_id-PASAR').val();
                var rute_id_awal = $('#rute_id-PASAR').val();
                var id_pasar_akhir = $('#id_pasar-PASAR').val();
                selectedRows.push({
                    id: id_mrdo,
                    id_mco: id_mco,
                    id_survey_pasar: id_survey_pasar,
                    id_pasar_akhir: id_pasar_akhir,
                    rute_id_awal: rute_id_awal
                });

                $.ajax({
                    type: 'post',
                    url: "{{ route('RuteId.pindahPasar') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
                        $('#id_pasar_akhir').val(null);
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            location.reload();
                        }, 2000);
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

            // BYPASS QR
            $(document).on('click', '.bypassQR', function() {
                var survey_pasar_id = $(this).data('survey_pasar_id');

                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/outletkandidat/bypassqr",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        survey_pasar: survey_pasar_id
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
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

            // CEK RUTE AKTIF
            var nama_sales = $('#salesman').val();
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

        });
    </script>
@endsection
