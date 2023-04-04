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
    </style>

    <div class="card shadow-sm">
        <div class="card-header">Search Data by Kode Customer</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('KodeCustomer.getDataByKodeCustomer') }}">
                @csrf
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <input type="search" name="kode_customer" class="form-control form-control-sm" id="kode_customer"
                            placeholder="Kode Customer" value="{{ old('kode_customer', $kode_customer ?? '') }}" required
                            oninvalid="this.setCustomValidity('Harap isi kode customer')" oninput="setCustomValidity('')">
                    </div>
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                        <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                    </div>
                </div>
            </form>

            @if (!isset($data))
                @php
                    $data = collect();
                @endphp
            @endif
            {{-- <h3>Hasil Pencarian:</h3> --}}
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered myTable">
                    <thead class="table-dark text-center">
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
                        @foreach ($data as $mco)
                            @foreach ($mco->mrdo as $mrdo)
                                @php
                                    $no += 1;
                                @endphp
                                <tr>
                                    <td>{{ $mrdo->mr?->w?->nama_wilayah . ' (' . $mrdo->mr?->w?->id_wilayah . ') ' }}
                                    </td>
                                    <td>{{ $mrdo->mr?->salesman }}</td>
                                    <td class="text-success">{{ $mrdo->mr?->rute }}</td>
                                    <td>{{ $mrdo->mr?->hari }}</td>
                                    <td>{{ $mrdo->rute_id }}</td>
                                    <td>{{ $mrdo->rute_detail_id }}</td>
                                    <td>{{ $mrdo->survey_pasar_id }}</td>
                                    <td class="text-primary fw-bold" id="kode{{ $no }}">
                                        {{ $mco->kode_customer }}</td>
                                    <td>{{ $mrdo->nama_toko }}</td>
                                    <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                    <td>{{ $mrdo->mrd?->id_pasar }}</td>
                                    <td>{{ $mrdo->mrd?->nama_pasar }}</td>
                                    <td>{{ $mrdo->id_pasar }}</td>
                                    <td>{{ $mrdo->mp->nama_pasar ?? ('' ?? '') }}</td>
                                    <td id="tipe_outlet{{ $no }}">{{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning editAlamat w-100"
                                            data-row-index="{{ $no }}" data-alamat-awal="{{ $mrdo->alamat }}"
                                            data-id_mrdo="{{ $mrdo->id }}">Alamat</button>
                                        <button type="button" class="btn btn-sm btn-primary editKode w-100"
                                            data-row-index="{{ $no }}"
                                            data-kode-awal="{{ $mco->kode_customer }}"
                                            data-id_mco="{{ $mco->id }}">Kode</button>
                                        <button type="button" class="btn btn-sm btn-info w-100" id="setRetail"
                                            data-row-index="{{ $no }}" data-id_mrdo="{{ $mrdo->id }}"
                                            data-id_mco="{{ $mco->id }}" data-set={{ null }}>Retail</button>
                                        <button type="button" class="btn btn-sm btn-success w-100" id="setGrosir"
                                            data-row-index="{{ $no }}" data-id_mrdo="{{ $mrdo->id }}"
                                            data-id_mco="{{ $mco->id }}" data-set="TPOUT_WHSL">Grosir</button>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Data Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered TableOrder">
                            <thead class="table-dark text-center">
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
            <div class="modal-content">
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
                            <input type="hidden" id="id_mrdo-ALAMAT" name="id_mrdo-ALAMAT" readonly>
                            <label for="alamat-awal">Alamat Awal</label>
                            <input type="text" class="form-control" id="alamat-awal" name="alamat-awal" readonly>
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="alamat-baru">Alamat Baru</label>
                            <input type="text" class="form-control" id="alamat-baru" name="alamat-baru">
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
            <div class="modal-content">
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
                            <label for="kode-awal">Kode Customer Awal</label>
                            <input type="text" class="form-control" id="kode-awal" name="kode-awal" readonly>
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="kode-baru">Kode Customer Baru</label>
                            <input type="text" class="form-control" id="kode-baru" name="kode-baru">
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

    <script>
        $(document).ready(function() {
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

            var table = $('.TableOrder').DataTable({
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
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#nama-distributor')
                        .text() + " - " +
                        $('#nama-wilayah').text(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }, 'csv', {
                    extend: 'excel',
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#nama-distributor')
                        .text() + " - " +
                        $('#nama-wilayah').text(),
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
                    var salesmanList = table.column('nama_salesman:name').data().unique().sort();
                    var select = $('<select><option value=""></option></select>')
                        .appendTo('#filter-salesman')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            table.column('nama_salesman:name').search(val ? '^' + val + '$' : '',
                                true, false).draw();
                        });
                    salesmanList.each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });

                    var wilayahList = table.column('nama_wilayah:name').data().unique().sort();
                    var select = $('<select><option value=""></option></select>')
                        .appendTo('#filter-wilayah')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            table.column('nama_wilayah:name').search(val ? '^' + val + '$' : '',
                                true, false).draw();
                        });
                    wilayahList.each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                }
            });

            // MODAL ORDER
            $(document).on('click', ".btnOrder", function() {
                $('#orderModal').modal('show');
                table.draw();
            });

            // INIT EDIT ALAMAT
            $(document).on('click', ".editAlamat", function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var alamatAwal = $('#alamat' + index).text().trim();

                $('#index-ALAMAT').val(index);
                $('#id_mrdo-ALAMAT').val(id_mrdo);
                $('#alamat-awal').val(alamatAwal);

                // Tampilkan modal edit
                $('#editAlamatModal').modal('show');
            });

            // INIT EDIT KODE
            $(document).on('click', ".editKode", function() {
                var index = $(this).data('row-index');
                var id_mco = $(this).data('id_mco');
                var kodeAwal = $('#kode' + index).text().trim();

                $('#index-KODE').val(index);
                $('#id_mco-KODE').val(id_mco);
                $('#kode-awal').val(kodeAwal);

                // Tampilkan modal edit
                $('#editKodeModal').modal('show');
            });

            // EDIT ALAMAT
            $(document).on('click', "#saveEditAlamat", function() {
                // Ambil nilai kolom input field
                var id_mrdo = $('#id_mrdo-ALAMAT').val();
                var alamatBaru = $('#alamat-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var index = $('#index-ALAMAT').val();

                // Lakukan update pada data di database
                $.ajax({
                    type: 'post',
                    url: "{{ route('KodeCustomer.updateAlamat') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        id: id_mrdo,
                        alamat: alamatBaru
                    },
                    beforeSend: function() {
                        // Tampilkan modal loading sebelum request AJAX dikirim
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        // Update data pada tabel
                        $('#alamat' + index).text(response.alamat);

                        // Sembunyikan modal
                        $('#editAlamatModal').modal('hide');

                        // Sembunyikan modal loading setelah modal edit tertutup

                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);

                        // Sembunyikan modal loading setelah modal edit tertutup

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
                        kodeBaru: kodeBaru
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#kode' + index).text(response.kode_customer);
                        $('#editKodeModal').modal('hide');
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

            // SET RETAIL
            $(document).on('click', '#setRetail, #setGrosir', function() {
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

        });
    </script>
@endsection
