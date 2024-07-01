@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }

        /* .action {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                min-width: 80px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */
    </style>
    <div class="card">
        {{-- <div class="card-header">Search Data by Kode Customer</div> --}}
        <div class="card-body card-body-custom mt-3">
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
                    <div class="col-lg-1">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                    </div>
                    <div class="col-lg-7">
                        <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                        {{-- <button type="button" class="btn btn-danger btn-sm hapusKhusus">Hapus Khusus <span> <i
                                    class="bi bi-journal-text"></i></span></button> --}}
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
                <table class="table table-sm table-light table-striped align-middle  myTable">
                    <thead class="text-center">
                        <th id="filter-wilayah">Wilayah</th>
                        <th id="filter-salesman">Salesman</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>mrdo id</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer</th>
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>id mco</th>
                        <th>id pasar mrd</th>
                        <th>nama pasar mrd</th>
                        <th>nama pasar mp</th>
                        <th>Tipe Outlet</th>
                        <th>QR</th>
                        <th class="action">Action</th>
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
                                <tr class="warnaBaris" data-id="{{ $mrdo->id }}"
                                    data-rute_detail_id="{{ $mrdo->rute_detail_id }}"
                                    data-id_distributor="{{ $mrdo->mr->d->id_distributor ?? '' }}"
                                    data-nama_distributor="{{ $mrdo->mr->d->nama_distributor ?? '' }}"
                                    data-rute_detail_id="{{ $mrdo->rute_detail_id }}">
                                    <td class="nama_wilayah">
                                        {{ $mrdo->mr?->w?->nama_wilayah }} ({{ $mrdo->mr?->w?->id_wilayah }})
                                    </td>
                                    <td class="salesman">
                                        {{ $mrdo->mr?->salesman }} ({{ $mrdo->mr?->kr?->id_salesman_mss ?? '' }})
                                    </td>
                                    <td class="rute">{{ $mrdo->mr?->rute }}</td>
                                    <td class="hari">{{ $mrdo->mr?->hari }}</td>
                                    <td class="rute_id" id="rute_id{{ $no }}">{{ $mrdo->rute_id }}</td>
                                    <td class="id_mrdo">{{ $mrdo->id }}</td>
                                    <td class="id_survey_pasar">{{ $mco->sp->id }}</td>
                                    <td class="text-primary fw-bold kode_customer">
                                        {{ $mco->kode_customer }}</td>
                                    <td class="nama_toko">{{ $mrdo->nama_toko }}</td>
                                    <td class="alamat">{{ $mrdo->alamat }}</td>
                                    <td class="id_mco">{{ $mco->id }}</td>
                                    <td class="id_pasar">{{ $mrdo->mrd?->id_pasar }}</td>
                                    <td>{{ $mrdo->mrd?->nama_pasar }}</td>
                                    <td class="nama_pasar">{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                    <td class="tipe_outlet">
                                        {{ $mrdo->tipe_outlet ?? 'RETAIL' }} - {{ $mco->sp->location_type ?? '' }} -
                                        {{ $mco->sp->source_type ?? '' }}
                                    </td>
                                    <td class="barcode text-center">-</td>
                                    <td>
                                        <div class="row px-2 py-1 text-center justify-content-center">
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-secondary btn-block w-100 btnPindah">Pindah
                                                    Rute</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-dark btn-block w-100 btnPindahPasar"
                                                    data-id_mrdo="{{ $mrdo->id }}">Pindah Pasar</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-info btn-block w-100 btnSetRetail"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                                    data-set={{ null }}>Retail</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-success btn-block w-100 btnSetGrosir"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                                    data-set="TPOUT_WHSL">Grosir</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-warning btn-block w-100 btnEdit">Edit</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <div class="btn-group btn-block w-100">
                                                    <button class="btn btn-danger btn-sm btn-block w-100 dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Hapus
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item btnHapus" href="#">Biasa</a></li>
                                                        <li><a class="dropdown-item btnHapus" href="#">Permanent</a>
                                                        </li>
                                                    </ul>
                                                </div>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-light  table-striped  TableOrder">
                            <thead class="text-center">
                                <th>no</th>
                                <th>id</th>
                                <th id="filter-wilayah-Order">wilayah</th>
                                <th>no order</th>
                                <th id="filter-salesman-Order">salesman</th>
                                <th>kode customer</th>
                                <th>nama toko</th>
                                <th>id survey pasar</th>
                                <th>status</th>
                                <th>total rp</th>
                                <th>total qty</th>
                                <th>total transaksi</th>
                                <th>tgl transaksi</th>
                                <th>document</th>
                                <th>platform</th>
                                <th>tipe outlet</th>
                                <th>tipe order</th>
                                <th>id qr outlet</th>
                                <th>exported</th>
                                <th>is call</th>
                            </thead>
                            <tbody id="bodyTabelOrder">
                            </tbody>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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

    <!-- Modal Pindah Outlet -->
    <div class="modal fade" id="PindahRuteModal" tabindex="-1" role="dialog" aria-labelledby="PindahRuteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="PindahRuteModalLabel">Pindah Outlet</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_akhir w-100" id="salesman_akhir">
                            </select>
                        </div>
                    </div>
                    <!-- Kolom input field untuk alamat yang akan diupdate -->
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute-akhir w-100"
                                id="rute_id_akhir"></select>
                            <input type="hidden" id="id_wilayah_akhir">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="savePindahRute">Simpan</button>
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
                        <input type="hidden" id="nama_pasar_akhir" readonly>
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

    <!-- Modal Hapus -->
    <div class="modal fade" id="HapusModal" tabindex="-1" role="dialog" aria-labelledby="HapusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-body text-center">
                    <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex; font-size: 8px;">
                        <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span>
                            <span class="swal2-x-mark-line-right"></span></span>
                    </div>
                    <b>Informasi</b><br>
                    <label>Tidak dapat dihapus, terdapat transaksi berikut :</label><br>
                    <table class="table table-sm table-light  table-striped  tableOrderHapus">
                        <tbody id="detailOrderHapus">
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" autocomplete="off" class="form-control modal-input" id="keterangan"
                            name="keterangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-danger" id="saveHapus">Hapus</button>
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
                minLength: 4
            });

            // SELECT2 PASAR
            $('.select2-pasar_akhir').select2({
                dropdownParent: $('#PindahPasarModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('KodeCustomer.getPasar') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page ||
                                1, // Menambahkan parameter 'page' saat melakukan permintaan ke server
                            // id_wilayah: $('#nama_wilayah').text().match(/\((.*?)\)/)[1],
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
                $('#nama_pasar_akhir').val(data.text);
            });

            var table = $('.myTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f>>" +
                    "<'row'<'col-sm-12 table-responsive'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // scrollY: 260,
                buttons: [
                    'copy', 'csv', {
                        extend: 'excel',
                        title: 'Data - ' + $('#kode_customer').val(),
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    }, 'pdf', 'print'
                ],
                columnDefs: [{
                    targets: [15],
                    className: 'no-export' // kelas no-export
                }],
                "lengthMenu": [10, 25, 50, 75, 100, 500],
                "pageLength": 500,
                "order": [
                    [2, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
                "initComplete": function(settings, json) {
                    var wilayahList = this.api().column(0).data().unique().sort();
                    var wilayahSelect = $(
                            '<select class="w-100"><option value="">All</option></select>')
                        .appendTo('#filter-wilayah')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            table.column(0).search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    wilayahList.each(function(d, j) {
                        wilayahSelect.append('<option value="' + d + '">' + d + '</option>');
                    });

                    var salesmanList = this.api().column(1).data().unique().sort();
                    var salesmanSelect = $(
                            '<select class="w-100"><option value="">All</option></select>')
                        .appendTo('#filter-salesman')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    salesmanList.each(function(d, j) {
                        salesmanSelect.append('<option value="' + d + '">' + d + '</option>');
                    });
                }
            });

            // MODAL ORDER
            var tableOrder;
            $(document).on('click', ".btnOrder", function() {
                if (!tableOrder) {
                    tableOrder = $('.TableOrder').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f >> " +
                            "<'row'<'col-sm-12 table-responsive'tr>>" +
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
                        }, {
                            extend: 'pdf',
                            title: 'Data - ' + $('#kode_customer').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            },
                            customize: function(doc) {
                                doc.pageOrientation =
                                    'landscape'; // Set orientasi landscape
                                doc.pageSize =
                                    'LEGAL'; // Set ukuran halaman 
                            }
                        }, 'print'],
                        ajax: {
                            url: "{{ route('KodeCustomer.getOrder') }}",
                            type: 'POST',
                            data: function(d) {
                                d.kode_customer = $('#kode_customer').val();
                            },
                        },
                        order: [
                            [2, 'asc'],
                            [12, 'asc'],
                            [4, 'asc']
                        ],
                        columnDefs: [{
                            targets: [1, 13, 17],
                            className: 'no-export'
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
                                className: 'text-info'
                            },
                            {
                                data: 'kode_customer',
                                name: 'kode_customer',
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
                                data: 'platform',
                                name: 'platform'
                            },
                            {
                                data: 'tipe_outlet',
                                name: 'tipe_outlet'
                            },
                            {
                                data: 'tipe_order',
                                name: 'tipe_order'
                            },
                            {
                                data: 'id_qr_outlet',
                                name: 'id_qr_outlet'
                            },
                            {
                                data: 'is_exported',
                                name: 'is_exported',
                                render: function(data, type, full, meta) {
                                    if (data === 1) {
                                        return '<i class="bi bi-check-square-fill text-success">1</i>';
                                    } else {
                                        return '<i class="bi bi-x-square-fill text-danger">0</i>';
                                    }
                                }
                            },
                            {
                                data: 'is_call',
                                name: 'is_call',
                                render: function(data, type, full, meta) {
                                    if (data === 1) {
                                        return '<i class="bi bi-check-square-fill text-success">1</i>';
                                    } else {
                                        return '<i class="bi bi-x-square-fill text-danger">0</i>';
                                    }
                                }
                            },
                        ],
                        "initComplete": function(settings, json) {
                            var salesmanOrderList = tableOrder.column('nama_salesman:name')
                                .data()
                                .unique()
                                .sort();
                            var selectSalesmanOrder = $(
                                    '<select class="w-100"><option value=""></option></select>')
                                .appendTo('#filter-salesman-Order')
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    tableOrder.column('nama_salesman:name').search(val ?
                                        '^' +
                                        val +
                                        '$' : '',
                                        true, false).draw();
                                });
                            salesmanOrderList.each(function(d, j) {
                                selectSalesmanOrder.append('<option value="' + d +
                                    '">' + d +
                                    '</option>')
                            });

                            var wilayahOrderList = tableOrder.column('nama_wilayah:name').data()
                                .unique()
                                .sort();
                            var selectWilayahOrder = $(
                                    '<select class="w-100"><option value=""></option></select>')
                                .appendTo('#filter-wilayah-Order')
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    tableOrder.column('nama_wilayah:name').search(val ?
                                        '^' +
                                        val +
                                        '$' : '',
                                        true, false).draw();
                                });
                            wilayahOrderList.each(function(d, j) {
                                selectWilayahOrder.append('<option value="' + d + '">' +
                                    d +
                                    '</option>')
                            });
                        }
                    });
                } else {
                    tableOrder.draw();
                }
                $('#orderModal').modal('show');
            });

            // // EDIT OUTLET
            // $(document).on('click', ".btnEdit", function() {
            //     var nama_toko = $(this).closest('tr').find('.nama_toko').text().trim();
            //     var alamat = $(this).closest('tr').find('.alamat').text().trim();
            //     var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
            //     var id_salesman = $(this).closest('tr').find('.salesman').text().match(
            //         /\(([^()]+)\)[^(]*$/)[1].trim();

            //     $('#alamat-baru').val(alamat);
            //     $('#nama_toko-baru').val(nama_toko);
            //     $('#kode_customer-baru').val(kode_customer);
            //     // var index = $(".btnEdit").index(this);

            //     // Tampilkan modal edit
            //     $('#editModal').modal('show');

            //     var survey_pasar_id = $(this).closest('tr').find('.id_survey_pasar').text().trim();
            //     var id_mco = $(this).closest('tr').find('.id_mco').text().trim();

            //     $('#saveEdit').click(function(e) {
            //         e.preventDefault();
            //         // Ambil nilai kolom input field
            //         var nama_tokoBaru = $('#nama_toko-baru').val();
            //         var alamatBaru = $('#alamat-baru').val();
            //         var kode_customerBaru = $('#kode_customer-baru').val();

            //         // Lakukan update pada data di database
            //         $.ajax({
            //             type: 'post',
            //             url: "{{ route('KodeCustomer.editOutlet') }}",
            //             dataType: 'json',
            //             encode: true,
            //             data: {
            //                 survey_pasar_id: survey_pasar_id,
            //                 id_mco: id_mco,
            //                 nama_toko: nama_tokoBaru,
            //                 alamat: alamatBaru,
            //                 kode_customer: kode_customerBaru,
            //                 id_salesman: id_salesman,
            //             },
            //             beforeSend: function() {
            //                 $('.loading-overlay').show();
            //             },
            //             success: function(response) {
            //                 $('#successModal #message').text(response.message);
            //                 $('#successModal').modal('show');
            //                 setTimeout(function() {
            //                     $('#successModal').modal('hide');
            //                     location.reload();
            //                 }, 1000);
            //             },
            //             error: function(xhr, status, error) {
            //                 // console.error(error);
            //                 $('#errorModal #message').text(xhr.responseJSON.message);
            //                 $('#errorModal').modal('show');
            //             },
            //             complete: function() {
            //                 $('.loading-overlay').hide();
            //             }
            //         });
            //     });
            // });

            // // PINDAH OUTLET
            // $('.btnPindah').click(function(e) {
            //     e.preventDefault();
            //     $('#PindahRuteModal').modal('show');

            //     var id = $(this).closest('tr').find('.id_mrdo').text().trim();
            //     var id_pasar_awal = $(this).closest('tr').find('.id_pasar').text().trim();
            //     var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text()
            //         .trim();

            //     $(document).on('click', '#savePindahRute', function() {

            //         var rute_id_akhir = $('#rute_id_akhir').val();

            //         if (rute_id_akhir === '' || rute_id_akhir == null) {
            //             $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
            //             $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
            //             return;
            //         }

            //         $.ajax({
            //             type: 'POST',
            //             url: "{{ route('KodeCustomer.pindah') }}",
            //             dataType: 'json',
            //             encode: true,
            //             data: {
            //                 id: id,
            //                 id_pasar_awal: id_pasar_awal,
            //                 rute_id_akhir: rute_id_akhir,
            //                 id_survey_pasar: id_survey_pasar
            //             },
            //             beforeSend: function() {
            //                 $('.loading-overlay').show();
            //             },
            //             success: function(response) {
            //                 $('#PindahRuteModal').modal('hide');
            //                 $('#successModal #message').text(response.message);
            //                 
            //                 $('#successModal').modal('show');
            //                 setTimeout(function() {
            //                     $('#successModal').modal('hide');
            //                     location.reload();
            //                 }, 1000);
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error(error);
            //                 $('#errorModal #message').text(xhr.responseJSON.message);
            //                 $('#errorModal').modal('show');
            //             },
            //             complete: function() {
            //                 $('.loading-overlay').hide();
            //             }
            //         });
            //     });
            // });

            $('.select2-salesman_akhir').select2({
                dropdownParent: $('#PindahRuteModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('KodeCustomer.getSalesman') }}",
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
                        '-' +
                        data.nama_wilayah));
                }
            }).on('select2:select', function(e) {
                $('.select2-rute-akhir').val(null).trigger('change');
            });

            $('.select2-rute-akhir').select2({
                dropdownParent: $('#PindahRuteModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('KodeCustomer.getRute') }}",
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
                searchable: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text);
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#id_wilayah_akhir').val(data.id_wilayah);
            });

            // EDIT OUTLET
            $(document).on('click', ".btnEdit", function() {
                var nama_toko = $(this).closest('tr').find('.nama_toko').text().trim();
                var alamat = $(this).closest('tr').find('.alamat').text().trim();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();

                $('#alamat-baru').val(alamat);
                $('#nama_toko-baru').val(nama_toko);
                $('#kode_customer-baru').val(kode_customer);
                // var index = $(".btnEdit").index(this);

                // Tampilkan modal edit
                $('#editModal').modal('show');

                var selectedRows = [];

                var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1].trim();
                var id_distributor = $(this).closest('tr').data('id_distributor');
                var nama_distributor = $(this).closest('tr').data('nama_distributor');
                var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
                var id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                var id = $(this).closest('tr').find('.rute_id').text().trim();
                var rute = $(this).closest('tr').find('.rute').text().trim();
                var hari = $(this).closest('tr').find('.hari').text().trim();
                var nama_toko = $(this).closest('tr').find('.nama_toko').text().trim();
                var alamat = $(this).closest('tr').find('.alamat').text().trim();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var nama_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $(this).closest('tr').find('.salesman').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                var nama_pasar = $(this).closest('tr').find('.nama_pasar').text().trim();
                var location_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[1]
                    .trim();
                var source_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                    '-')[2].trim();

                var dataObject = {};
                dataObject['id_wilayah'] = id_wilayah;
                dataObject['survey_pasar_id'] = id_survey_pasar;
                dataObject['id_qr_outlet'] = id_qr_outlet;
                dataObject['mrdo_id'] = mrdo_id;
                dataObject['rute_detail_id'] = rute_detail_id;
                dataObject['id'] = id;
                dataObject['rute'] = rute;
                dataObject['hari'] = hari;
                dataObject['id_distributor'] = id_distributor;
                dataObject['nama_distributor'] = nama_distributor;
                dataObject['nama_toko'] = nama_toko;
                dataObject['kode_customer'] = kode_customer;
                dataObject['nama_wilayah'] = nama_wilayah;
                dataObject['nama_pasar'] = nama_pasar;
                dataObject['salesman'] = salesman;
                dataObject['id_pasar'] = id_pasar;
                dataObject['location_type'] = location_type;

                $('#saveEdit').off('click');
                $('#saveEdit').click(function(e) {
                    e.preventDefault();
                    var nama_toko_baru = $('#nama_toko-baru').val();
                    var alamat_baru = $('#alamat-baru').val();
                    var kode_customer_baru = $('#kode_customer-baru').val();

                    var data = [];
                    data.push(kode_customer_baru);
                    data.push(nama_toko_baru);
                    data.push(alamat_baru);
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
                            }, 1000);
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

            // PINDAH OUTLET
            $(document).on('click', ".btnPindah", function(e) {
                e.preventDefault();

                $('#PindahRuteModal').modal('show');

                var selectedRows = [];
                var id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                var rute_id = $(this).closest('tr').find('.rute_id').text().trim();
                var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                var id_wilayah = $('#id_wilayah_akhir').val();
                var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $(this).closest('tr').find('.salesman').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var location_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                    '-')[1].trim();
                var toko = $(this).closest('tr').find('.nama_toko').text().trim();

                var dataObject = {};
                dataObject['id_mrdo'] = id_mrdo;
                dataObject['rute_id'] = rute_id;
                dataObject['rute_detail_id'] = rute_detail_id;
                dataObject['id_wilayah'] = id_wilayah;
                dataObject['id_pasar'] = id_pasar;
                dataObject['survey_pasar_id'] = id_survey_pasar;
                dataObject['kode_customer'] = kode_customer;
                dataObject['wilayah'] = wilayah;
                dataObject['salesman'] = salesman;
                dataObject['location_type'] = location_type;
                dataObject['toko'] = toko;

                selectedRows.push(dataObject);

                $('#savePindahRute').off('click');
                $('#savePindahRute').click(function(e) {
                    e.preventDefault();

                    var salesman_akhir = $('#salesman_akhir').val();
                    var hari = $('#rute_id_akhir').text().split(' ')[0].trim();
                    var rute = $('#rute_id_akhir').val();

                    if (rute === '' || rute == null) {
                        $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
                        $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
                        return;
                    }

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
                                }, 1000);
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
            });

            // PINDAH PASAR
            $(document).on('click', ".btnPindahPasar", function() {
                // Tampilkan modal edit
                $('#PindahPasarModal').modal('show');

                var valid = true;

                var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1].trim();
                var id_distributor = $(this).closest('tr').data('id_distributor');
                var nama_distributor = $(this).closest('tr').data('nama_distributor');
                var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
                var id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                var id = $(this).closest('tr').find('.rute_id').text().trim();
                var rute = $(this).closest('tr').find('.rute').text().trim();
                var hari = $(this).closest('tr').find('.hari').text().trim();
                var nama_toko = $(this).closest('tr').find('.nama_toko').text().trim();
                var alamat = $(this).closest('tr').find('.alamat').text().trim();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var nama_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $(this).closest('tr').find('.salesman').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                var nama_pasar = $(this).closest('tr').find('.nama_pasar').text().trim();
                var location_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[1]
                    .trim();
                var pasar = $(this).closest('tr').find('.tipe_outlet').text()
                    .split('-')[1].trim().toUpperCase();
                if (pasar == 'PASAR') {
                    // alert("LOKASI PASAR : " + nama_toko + " - " + kode_customer);
                    valid = false;
                }

                var dataObject = {};
                dataObject['id_wilayah'] = id_wilayah;
                dataObject['survey_pasar_id'] = id_survey_pasar;
                dataObject['id_qr_outlet'] = id_qr_outlet;
                dataObject['mrdo_id'] = mrdo_id;
                dataObject['rute_detail_id'] = rute_detail_id;
                dataObject['id'] = id;
                dataObject['rute'] = rute;
                dataObject['hari'] = hari;
                dataObject['id_distributor'] = id_distributor;
                dataObject['nama_distributor'] = nama_distributor;
                dataObject['nama_toko'] = nama_toko;
                dataObject['kode_customer'] = kode_customer;
                dataObject['nama_pasar'] = nama_pasar;
                dataObject['nama_wilayah'] = nama_wilayah;
                dataObject['salesman'] = salesman;
                dataObject['id_pasar'] = id_pasar;
                dataObject['location_type'] = location_type;

                $('#savePindahPasar').off('click').on('click', function(e) {
                    e.preventDefault();
                    var id_pasar_akhir = $('#pasar_akhir').val();
                    var nama_pasar_akhir = $('#nama_pasar_akhir').val();

                    var selectedRows = [];

                    var data = [];
                    data.push(kode_customer);
                    // data.push(String(kode_customer).padStart(6, '0'));
                    data.push(nama_toko);
                    data.push(alamat);
                    data.push(location_type);
                    // data.push(id_pasar);
                    data.push(id_pasar_akhir);
                    data[5] = dataObject;
                    selectedRows.push(data);

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
                                $('#PindahPasarModal').modal('hide');
                                $('#successModal').modal('show');

                                var rowData = table.row(
                                    '[data-id="' + mrdo_id +
                                    '"]').data();

                                rowData[11] = id_pasar_akhir;
                                rowData[12] = nama_pasar_akhir;
                                rowData[13] = nama_pasar_akhir;

                                table.row('[data-id="' +
                                    mrdo_id + '"]').data(
                                    rowData).draw();

                                $('#nama_pasar_akhir').val("");
                                $('#pasar_akhir').val(null).trigger(
                                    'change.select2');

                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    $('#PindahPasarModal').modal('hide');
                                    // location.reload();
                                }, 1000);
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
                    } else {
                        $('#errorModal #message').text("Outlet lokasinya PASAR");
                        $('#errorModal').modal('show');
                        $('#PindahPasarModal').modal('hide');
                    }
                });
            });

            // // SET RETAIL / GROSIR
            // $(document).on('click', '.btnSetRetail, .btnSetGrosir', function() {
            //     var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
            //     var id_mco = $(this).data('id_mco');
            //     var set = $(this).data('set');

            //     $.ajax({
            //         type: 'POST',
            //         url: "{{ route('ToolOutlet.setOutlet') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             // _token: "{{ csrf_token() }}",
            //             id_mrdo: id_mrdo,
            //             id_mco: id_mco,
            //             set: set
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             var tipe_outlet_all = tipe_outlet.text().trim();
            //             var tipe_outlet_parts = tipe_outlet_all.split('-');
            //             tipe_outlet_parts[0] = response.tipe_outlet ?? "RETAIL";
            //             var tipe_outlet_modified = tipe_outlet_parts.join(' - ');
            //             tipe_outlet.html(tipe_outlet_modified);
            //             $('.modal-input').val('');
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

            // SET RETAIL
            $(document).on('click', ".btnSetRetail", function() {
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var iddepo = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1].trim();
                var tipe_outlet = $(this).closest('tr').find('.tipe_outlet');

                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/rute/setRetail",
                    dataType: 'json',
                    encode: true,
                    data: {
                        mrdo_id: mrdo_id,
                        iddepo: iddepo
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            var tipe_outlet_all = tipe_outlet.text().trim();
                            var tipe_outlet_parts = tipe_outlet_all.split('-');
                            tipe_outlet_parts[0] = "RETAIL";
                            var tipe_outlet_modified = tipe_outlet_parts.join('-');
                            // tipe_outlet.html(tipe_outlet_modified);

                            var rowData = table.row(
                                '[data-id="' + mrdo_id +
                                '"]').data();

                            rowData[14] = tipe_outlet_modified;

                            table.row('[data-id="' +
                                mrdo_id + '"]').data(
                                rowData).draw();

                            $('#successModal').modal('show');
                        } else {
                            $('#errorModal #message').text(response.message);
                            $('#errorModal').modal('show');
                        }
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

            // SET GROSIR
            $(document).on('click', ".btnSetGrosir", function() {
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var iddepo = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1].trim();
                var tipe_outlet = $(this).closest('tr').find('.tipe_outlet');

                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/rute/setGrosir",
                    dataType: 'json',
                    encode: true,
                    data: {
                        mrdo_id: mrdo_id,
                        iddepo: iddepo
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            var tipe_outlet_all = tipe_outlet.text().trim();
                            var tipe_outlet_parts = tipe_outlet_all.split('-');
                            tipe_outlet_parts[0] = "TPOUT_WHSL";
                            var tipe_outlet_modified = tipe_outlet_parts.join('-');
                            // tipe_outlet.html(tipe_outlet_modified);

                            var rowData = table.row(
                                '[data-id="' + mrdo_id +
                                '"]').data();

                            rowData[14] = tipe_outlet_modified;

                            table.row('[data-id="' +
                                mrdo_id + '"]').data(
                                rowData).draw();

                            $('#successModal').modal('show');
                        } else {
                            $('#errorModal #message').text(response.message);
                            $('#errorModal').modal('show');
                        }
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

            // HAPUS OUTLET
            $(document).on('click', ".btnHapus", function() {
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var iddepo = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1].trim();
                var id_distributor = $(this).closest('tr').data('id_distributor');
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var tipe = $(this).text().trim().toLowerCase();

                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/rute/hapusOutlet",
                    dataType: 'json',
                    encode: true,
                    data: {
                        mrdo_id: mrdo_id,
                        iddepo: iddepo,
                        kode_customer: kode_customer,
                        tipe: tipe,
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
                            }, 1000);
                        } else {
                            var html = "";
                            for (var i = 0; i < response.data.length; i++) {
                                var data = response.data[i];
                                if (data.id_distributor_mss == id_distributor) {
                                    html += "<tr>";
                                    html += "<td>" + data.no_order + "</td>";
                                    html += "<td>" + data.nama_salesman + "</td>";
                                    html += "<td>" + data.kode_customer + "</td>";
                                    html += "<td>" + data.tgl_transaksi + "</td>";
                                    html += "<td>" + data.nama_toko + "</td>";
                                    html += "<td>" + data.total_rp + "</td>";
                                    html += "</tr>";
                                }
                            }
                            $('#detailOrderHapus').html(html);
                            $('#HapusModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });

                // SAVE HAPUS OUTLET
                $('#saveHapus').off('click').on('click', function(e) {
                    e.preventDefault();
                    var keterangan = $('#keterangan').val();

                    $.ajax({
                        type: 'POST',
                        url: "http://10.11.1.37/api/tool/rute/hapusOutlet",
                        dataType: 'json',
                        encode: true,
                        data: {
                            mrdo_id: mrdo_id,
                            iddepo: iddepo,
                            kode_customer: kode_customer,
                            keterangan: keterangan,
                            tipe: tipe,
                        },
                        beforeSend: function() {
                            $('.loading-overlay').show();
                        },
                        success: function(response) {
                            if (response.is_valid) {
                                $('#successModal').modal('show');
                                $('#HapusModal').modal('hide');
                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    location.reload();
                                }, 1000);
                            } else {
                                $('#errorModal #message').text(response.message);
                                $('#errorModal').modal('show');
                            }
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
            });

            // BYPASS QR
            $(document).on('click', '.btnBarcode', function() {
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var dataToEncrypt = [{
                    id: $(this).data('id_qr')
                }];
                var jsonData = JSON.stringify(dataToEncrypt);
                var encryptedData = btoa(jsonData);

                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/outletkandidat/bypassqr",
                    dataType: 'json',
                    encode: true,
                    data: {
                        survey_pasar: encryptedData
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#successModal').modal('show');

                        var rowData = table.row(
                            '[data-id="' + mrdo_id +
                            '"]').data();

                        rowData[15] = 'SUDAH BYPASS';

                        table.row('[data-id="' +
                            mrdo_id + '"]').data(
                            rowData).draw();

                        setTimeout(function() {
                            $('#successModal').modal('hide');
                        }, 1000);
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

            cek_rute_aktif();
            // CEK RUTE AKTIF
            function cek_rute_aktif() {
                var kode_customer = [];
                kode_customer.push($('#kode_customer').val());

                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/outletkandidat/getData",
                    dataType: 'json',
                    encode: true,
                    data: {
                        salesman: "",
                        depo: "",
                        pasar: "",
                        type: "",
                        hari: "",
                        periodik: "",
                        kode_customer: kode_customer
                    },
                    success: function(response) {
                        const dataRuteID = {};
                        const dataBarcode = {};
                        $.each(response.data, function(index, item) {
                            const id = item.id;
                            const mrdo_id = item.mrdo_id;
                            if (!dataRuteID[id] && item.rute_hari_ini == 1) {
                                dataRuteID[id] = id;
                            }
                            if (!dataBarcode[mrdo_id] && item.verifikasi_qr) {
                                if (item.verifikasi_qr.flag_qr) {
                                    if (item.pengajuan_by_pass[0]) {
                                        dataBarcode[mrdo_id] = item.pengajuan_by_pass[0].id;
                                    } else {
                                        dataBarcode[mrdo_id] = "Belum Isi QR Bermasalah";
                                    }
                                } else {
                                    dataBarcode[mrdo_id] = "SUDAH BYPASS";
                                }
                            }
                        });
                        $('.warnaBaris').each(function() {
                            var ruteId = $(this).find('.rute_id').text().trim();
                            var mrdo_id = $(this).find('.id_mrdo').text().trim();
                            var nama_wilayah = $(this).find('.nama_wilayah');
                            var nama_salesman = $(this).find('.salesman');
                            var rute = $(this).find('.rute');
                            var hari = $(this).find('.hari');
                            // Mencocokkan ruteId dengan dataRuteID
                            if (dataRuteID[ruteId]) {
                                nama_wilayah.addClass('text-success fw-bolder shadow-sm');
                                nama_salesman.addClass('text-success fw-bolder shadow-sm');
                                rute.addClass('text-success fw-bolder shadow-sm');
                                hari.addClass('text-success fw-bolder shadow-sm');
                            } else {
                                nama_wilayah.removeClass(
                                    'text-success fw-bolder shadow-sm');
                                nama_salesman.removeClass(
                                    'text-success fw-bolder shadow-sm');
                                rute.removeClass('text-success fw-bolder shadow-sm');
                                hari.removeClass('text-success fw-bolder shadow-sm');
                            }
                            if (dataBarcode[mrdo_id]) {
                                if (dataBarcode[mrdo_id] == "SUDAH BYPASS") {
                                    var rowData = table.row('[data-id="' + mrdo_id + '"]')
                                        .data();
                                    rowData[15] = dataBarcode[mrdo_id];
                                    table.row('[data-id="' + mrdo_id + '"]').data(rowData)
                                        .draw();
                                } else if (dataBarcode[mrdo_id] == "Belum Isi QR Bermasalah") {
                                    var rowData = table.row('[data-id="' + mrdo_id + '"]')
                                        .data();
                                    rowData[15] = dataBarcode[mrdo_id];
                                    table.row('[data-id="' + mrdo_id + '"]').data(rowData)
                                        .draw();
                                } else {
                                    var rowData = table.row('[data-id="' + mrdo_id + '"]')
                                        .data();
                                    rowData[15] =
                                        '<button type="button" class="btn btn-sm p-1 btn-danger btn-block w-100 btnBarcode" data-id_qr="' +
                                        dataBarcode[mrdo_id] + '">QR</button>';
                                    table.row('[data-id="' + mrdo_id + '"]').data(rowData)
                                        .draw();
                                }
                            }

                        });
                    },
                    error: function(xhr, status, error) {},
                    complete: function() {}
                });
            }

            // $('.hapusKhusus').on('click', function(e) {
            //     e.preventDefault();
            //     var data = [{
            //             mrdo_id: 2053558,
            //             kode_customer: 'YUMN0001'
            //         },
            //         {
            //             mrdo_id: 2053576,
            //             kode_customer: 'PURN0003'
            //         }
            //     ]

            //     data.forEach((item, index, array) => {
            //         console.log(item.mrdo_id + " - " + item.kode_customer);
            //         $.ajax({
            //             type: 'POST',
            //             url: "http://10.11.1.37/api/tool/rute/hapusOutlet",
            //             dataType: 'json',
            //             encode: true,
            //             data: {
            //                 mrdo_id: item.mrdo_id,
            //                 iddepo: 28,
            //                 kode_customer: item.kode_customer,
            //                 keterangan: "TUTUP PERMANEN",
            //                 tipe: "permanent",
            //             },
            //             // beforeSend: function() {
            //             //     $('.loading-overlay').show();
            //             // },
            //             success: function(response) {
            //                 if (response.is_valid) {
            //                     console.log("berhasil : " + item.kode_customer);
            //                     //     $('#successModal').modal('show');
            //                     //     $('#HapusModal').modal('hide');
            //                     //     setTimeout(function() {
            //                     //         $('#successModal').modal('hide');
            //                     //         location.reload();
            //                     //     }, 1000);
            //                     // } else {
            //                     //     $('#errorModal #message').text(response.message);
            //                     //     $('#errorModal').modal('show');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 // console.error(error);
            //                 // $('#errorModal').modal('show');
            //             },
            //             // complete: function() {
            //             //     $('.loading-overlay').hide();
            //             // }
            //         });
            //         if (index === data.length - 1) {
            //             console.log("Ini adalah elemen terakhir.");
            //             $('#successModal').modal('show');
            //         }
            //     });
            // });
        });
    </script>
@endsection
