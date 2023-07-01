@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 120px;
        }
    </style>
    <div class="card">
        <div class="card-header">Search Data by Kode Customer</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('KodeCustomer.getDataByKodeCustomer') }}">
                @csrf
                <div class="row align-items-top">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text">Kode Customer</span>
                            <input type="search" autocomplete="off" name="kode_customer"
                                class="form-control form-control-sm" id="kode_customer" placeholder="Kode Customer"
                                value="{{ old('kode_customer', $kode_customer ?? '') }}" required
                                oninvalid="this.setCustomValidity('Harap isi kode customer')"
                                oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                        <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text">Id Survey Pasar</span>
                            <input type="search" autocomplete="off" name="id_survey_pasar"
                                class="form-control form-control-sm" id="id_survey_pasar" placeholder="id survey pasar"
                                value="{{ old('id_survey_pasar', $id_survey_pasar ?? '') }}">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-sm btn-success updateDataar">Update Dataar</button>
                    </div> --}}
                </div>
            </form>

            @if (!isset($data))
                @php
                    $data = collect();
                @endphp
            @endif
            <div class="table-responsive">
                <table class="table table-sm table-dark table-striped align-middle table-bordered myTable">
                    <thead class="text-center">
                        <th>Wilayah</th>
                        <th>Salesman</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>rute detail id</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer</th>
                        <th>Nama Toko</th>
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
                        @foreach ($data as $mco)
                            @foreach ($mco->mrdo as $mrdo)
                                @php
                                    $no += 1;
                                @endphp
                                <tr class="warnaBaris">
                                    <td class="nama_wilayah">
                                        {{ $mrdo->mr?->w?->nama_wilayah . ' (' . $mrdo->mr?->w?->id_wilayah . ') ' }}
                                    </td>
                                    <td class="salesman">{{ $mrdo->mr?->salesman }}
                                        ({{ $mrdo->mr?->kr?->id_salesman_mss ?? '' }})
                                    </td>
                                    <td class="rute">{{ $mrdo->mr?->rute }}</td>
                                    <td>{{ $mrdo->mr?->hari }}</td>
                                    <td class="rute_id" id="rute_id{{ $no }}">{{ $mrdo->rute_id }}</td>
                                    <td>{{ $mrdo->rute_detail_id }}</td>
                                    <td>{{ $mco->sp->id }}</td>
                                    <td class="text-primary fw-bold" id="kode{{ $no }}">
                                        {{ $mco->kode_customer }}</td>
                                    <td id="nama_toko{{ $no }}">{{ $mrdo->nama_toko }}</td>
                                    <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                    <td>{{ $mco->id }}</td>
                                    <td id="id_pasar_mrd{{ $no }}">{{ $mrdo->mrd?->id_pasar }}</td>
                                    <td>{{ $mrdo->mrd?->nama_pasar }}</td>
                                    <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                    <td id="tipe_outlet{{ $no }}">{{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                    </td>
                                    <td>
                                        <div class="row px-2 py-1">
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-warning editAlamat w-100"
                                                    data-row-index="{{ $no }}"
                                                    data-alamat-awal="{{ $mrdo->alamat }}"
                                                    data-survey_pasar_id="{{ $mco->sp->id }}"
                                                    data-id_mco="{{ $mco->id }}">Edit</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-primary btnEditKode w-100"
                                                    data-row-index="{{ $no }}"
                                                    data-kode-awal="{{ $mco->kode_customer }}"
                                                    data-id_mco="{{ $mco->id }}"
                                                    data-survey_pasar_id="{{ $mco->sp->id }}">Kode</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-secondary w-100 pindahOutlet"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}"
                                                    data-id_survey_pasar="{{ $mco->sp->id }}">Pindah</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-info w-100 setRetail"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                                    data-set={{ null }}>Retail</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-success w-100 setGrosir"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                                    data-set="TPOUT_WHSL">Grosir</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-light w-100 bypassQR"
                                                    data-survey_pasar_id="{{ $mco->sp->id }}">QR</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-dark  table-striped table-bordered TableOrder">
                            <thead class="text-center">
                                <th>no</th>
                                <th>id</th>
                                <th id="filter-wilayah">wilayah</th>
                                <th>no order</th>
                                <th id="filter-salesman">salesman</th>
                                <th>nama_toko</th>
                                <th>id_survey_pasar</th>
                                <th>status</th>
                                <th>total_rp</th>
                                <th>total_qty</th>
                                <th>total_transaksi</th>
                                <th>tgl transaksi</th>
                                <th>document</th>
                                <th>closed_order</th>
                                <th>platform</th>
                                <th>id_qr_outlet</th>
                                <th>kode customer</th>
                            </thead>
                            <tbody id="bodyTabelOrder">
                            </tbody>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditAlamat">Simpan</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditKode">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pindah Outlet -->
    <div class="modal fade" id="PindahOutletModal" tabindex="-1" role="dialog"
        aria-labelledby="PindahOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="PindahOutletModalLabel">Pindah Outlet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="id_mrdo-PINDAH" readonly>
                        <input type="hidden" id="id_pasar_awal-PINDAH" readonly>
                        <input type="hidden" id="id_survey_pasar-PINDAH" readonly>
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_akhir w-100"
                                id="salesman_akhir-PINDAH">
                            </select>
                        </div>
                    </div>
                    <!-- Kolom input field untuk alamat yang akan diupdate -->
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute-akhir w-100"
                                id="rute_id_akhir-PINDAH"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="savePindahOutlet">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#kode_customer').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('KodeCustomer.autocomplete') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 3
            });

            $('.myTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // scrollY: 260,
                buttons: [
                    'copy', 'csv', {
                        extend: 'excel',
                        title: 'Data ' + $('#nama-salesman').text() + " - " + $('#nama-distributor')
                            .text() + " - " +
                            $('#nama-wilayah').text(),
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    }, 'pdf', 'print'
                ],
                columnDefs: [{
                    targets: [4, 5, 6, 10, 11, 12, 14],
                    className: 'no-export' // kelas no-export
                }],
                "lengthMenu": [10, 25, 50, 75, 100, 500],
                "pageLength": 500,
                "order": [
                    [2, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
            });

            // MODAL ORDER
            var table;
            $(document).on('click', ".btnOrder", function() {
                if (!table) {
                    table = $('.TableOrder').DataTable({
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
                            title: 'Data - ' + $('#kode_customer').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data - ' + $('#kode_customer').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'pdf', 'print'],
                        ajax: {
                            url: "{{ route('KodeCustomer.getOrder') }}",
                            type: 'POST',
                            data: function(d) {
                                d.kode_customer = $('#kode_customer').val();
                            },
                        },
                        order: [
                            [11, 'asc'],
                            [2, 'asc'],
                            [4, 'asc']
                        ],
                        columnDefs: [{
                            targets: [1, 6, 12, 13, 15, 14], // kolom pertama
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
                        "initComplete": function(settings, json) {
                            var salesmanList = table.column('nama_salesman:name').data()
                                .unique()
                                .sort();
                            var select = $('<select><option value=""></option></select>')
                                .appendTo('#filter-salesman')
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    table.column('nama_salesman:name').search(val ? '^' +
                                        val +
                                        '$' : '',
                                        true, false).draw();
                                });
                            salesmanList.each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });

                            var wilayahList = table.column('nama_wilayah:name').data().unique()
                                .sort();
                            var select = $('<select><option value=""></option></select>')
                                .appendTo('#filter-wilayah')
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    table.column('nama_wilayah:name').search(val ? '^' +
                                        val +
                                        '$' : '',
                                        true, false).draw();
                                });
                            wilayahList.each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        }
                    });
                } else {
                    table.draw();
                }
                $('#orderModal').modal('show');
            });

            // INIT EDIT ALAMAT
            $(document).on('click', ".editAlamat", function() {
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

            // INIT PINDAH OUTLET
            $(document).on('click', ".pindahOutlet", function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var id_survey_pasar = $(this).data('id_survey_pasar');
                var rute_id = $('#rute_id' + index).text().trim();
                var id_pasar_awal = $('#id_pasar_mrd' + index).text().trim();

                $('#id_mrdo-PINDAH').val(id_mrdo);
                $('#id_pasar_awal-PINDAH').val(id_pasar_awal);
                $('#id_survey_pasar-PINDAH').val(id_survey_pasar);

                // Tampilkan modal edit
                $('#PindahOutletModal').modal('show');
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
                    url: "{{ route('KodeCustomer.updateAlamat') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
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
                    url: "{{ route('KodeCustomer.updateKode') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
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

            $('.select2-salesman_akhir').select2({
                dropdownParent: $('#PindahOutletModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('PindahOutlet.getSalesman') }}",
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
                $('.select2-rute-akhir').val(null).trigger('change');
            });

            $('.select2-rute-akhir').select2({
                dropdownParent: $('#PindahOutletModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('PindahOutlet.getRute') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('#salesman_akhir-PINDAH').val()
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
                searchable: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text);
                }
            });

            // PINDAH OUTLET
            $(document).on('click', '#savePindahOutlet', function() {
                var id = $('#id_mrdo-PINDAH').val();
                var id_pasar_awal = $('#id_pasar_awal-PINDAH').val();
                var rute_id_akhir = $('#rute_id_akhir-PINDAH').val();
                var id_survey_pasar = $('#id_survey_pasar-PINDAH').val();

                if (rute_id_akhir === '' || rute_id_akhir == null) {
                    $('#rute_id_akhir-PINDAH').get(0).setCustomValidity('Harap isi Rute tujuan');
                    $('#rute_id_akhir-PINDAH').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('KodeCustomer.pindah') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        id: id,
                        id_pasar_awal: id_pasar_awal,
                        rute_id_akhir: rute_id_akhir,
                        id_survey_pasar: id_survey_pasar
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        // console.log(response.message);
                        $('#PindahOutletModal').modal('hide');
                        $('#successModal #message').text(response.message);
                        $('.modal-input').val('');
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

            // SET RETAIL/GROSIR
            $(document).on('click', '.setRetail, .setGrosir', function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var id_mco = $(this).data('id_mco');
                var set = $(this).data('set');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('KodeCustomer.setOutlet') }}",
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
                        $('#tipe_outlet' + index).text(response.tipe_outlet ?? "RETAIL");

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

            // UPDATE DATAAR
            $(document).on('click', '.updateDataar', function() {
                var id_survey_pasar = $('#id_survey_pasar').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('KodeCustomer.updateDataar') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        id_survey_pasar: id_survey_pasar
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
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

            // CEK RUTE AKTIF
            $('.warnaBaris').each(function() {
                var ruteId = $(this).find('.rute_id').text();
                var rute = $(this).find('.rute');

                // console.log(ruteId);
                // console.log(rute);

                var nama_sales = $(this).find('.salesman').text().replace(/\s*\([^)]*\)\s*$/, '').trim();
                var iddepo = $(this).find('.nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
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
                        if (ruteId == response.rute_hari_ini) {
                            rute.addClass('text-success fw-bolder');
                        }
                    },
                    error: function(xhr, status, error) {},
                    complete: function() {}
                });
            });

        });
    </script>
@endsection
