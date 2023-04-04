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
        <div class="card-header">Search Data by Route ID</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('RuteId.getDataByRuteId') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <label for="salesman" class="sr-only">Salesman</label>
                        <select class="form-control select2-salesman w-100" name="salesman" id="salesman" required
                            oninvalid="this.setCustomValidity('Harap Pilih Salesman')" oninput="setCustomValidity('')">
                            <option value="{{ old('salesman', $salesman ?? '') }}">
                                {{ old('salesman', $salesman ?? '') }}</option>
                        </select>
                        <input type="hidden" name="id_salesman" id="id_salesman"
                            value="{{ old('id_salesman', $id_salesman ?? '') }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="rute_id" class="sr-only">Rute</label>
                        <select class="form-control select2-rute w-100" name="rute_id" id="rute_id">
                            <option value="{{ old('rute_id', $rute_id ?? '') }}">
                                {{ old('rute', $rute ?? '') }}</option>
                        </select>
                        <input type="hidden" id="rute" name="rute" value="{{ old('rute', $rute ?? '') }}">
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                        <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                        <button type="button" class="btn btn-warning btn-sm btnKandidat">Kandidat <span> <i
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
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered myTable">
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
                                    <tr>
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
                                        <td id="tipe_outlet{{ $no }}">{{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning btnEditAlamat w-100"
                                                data-row-index="{{ $no }}"
                                                data-alamat-awal="{{ $mrdo->alamat }}"
                                                data-id_mrdo="{{ $mrdo->id }}">Alamat</button>
                                            <button type="button" class="btn btn-sm btn-primary btnEditKode w-100"
                                                data-row-index="{{ $no }}"
                                                data-kode-awal="{{ $mco->kode_customer }}"
                                                data-id_mco="{{ $mco->id }}">Kode</button>
                                            <button type="button" class="btn btn-sm btn-info w-100 btnSetRetail"
                                                data-row-index="{{ $no }}" data-id_mrdo="{{ $mrdo->id }}"
                                                data-id_mco="{{ $mco->id }}"
                                                data-set={{ null }}>Retail</button>
                                            <button type="button" class="btn btn-sm btn-success w-100 btnSetGrosir"
                                                data-row-index="{{ $no }}" data-id_mrdo="{{ $mrdo->id }}"
                                                data-id_mco="{{ $mco->id }}" data-set="TPOUT_WHSL">Grosir</button>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Data Order</h5>
                    <input type='date' class='form-control form-control-sm date' id='tgl_transaksi' name='tanggal'
                        value='<?= date('Y-m-d') ?>'>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered TableOrder">
                            <thead class="table-dark text-center">
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="KandidatModalLabel">Data Kandidat</h5>
                    <input type='date' class='form-control form-control-sm date' id='tgl_visit' name='tanggal'
                        value='<?= date('Y-m-d') ?>'>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered TableKandidat w-100">
                            <thead class="table-dark text-center">
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlamatModalLabel">Edit Alamat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
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
            var id_salesman = 'tes';
            $('.select2-salesman').select2({
                ajax: {
                    url: "{{ route('RuteId.getSalesman') }}",
                    dataType: 'json',
                    delay: 250,
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
                // mengubah value dari id_salesman
                $('#id_salesman').val(data.id_salesman);
            });

            $('.select2-rute').select2({
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

            $('.myTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // scrollY: 260,
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
                "lengthMenu": [10, 25, 50, 75, 100, 500],
                "pageLength": 500,
                "columnDefs": [{
                    "targets": [6],
                    "createdCell": function(td, cellData, rowData, rowIndex, colIndex) {
                        $(td).addClass('editable');
                    }
                }],
                "order": [
                    [2, 'asc'],
                    [6, 'desc'],
                    [11, 'asc']
                ],
            });

            var TableOrder = $('.TableOrder').DataTable({
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

            var TableKandidat = $('.TableKandidat').DataTable({
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
                    url: "{{ route('RuteId.getKandidat') }}",
                    type: 'POST',
                    data: function(d) {
                        d.id_salesman = $('#id_salesman').val(); // ambil nilai input field id_salesman
                        d.tgl_visit = $('#tgl_visit').val(); // ambil nilai input field id_visit
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

            // MODAL ORDER
            $(document).on('click', ".btnOrder", function() {
                $('#orderModal').modal('show');
                TableOrder.draw();
            });
            $(document).on('change', "#tgl_transaksi", function() {
                TableOrder.draw();
            });

            // MODAL KANDIDAT
            $(document).on('click', ".btnKandidat", function() {
                $('#KandidatModal').modal('show');
                TableKandidat.draw();
            });
            $(document).on('change', "#tgl_visit", function() {
                TableKandidat.draw();
            });

            // INIT EDIT ALAMAT
            $(document).on('click', ".btnEditAlamat", function() {
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
            $(document).on('click', ".btnEditKode", function() {
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
                    url: "{{ route('RuteId.updateAlamat') }}",
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
                    url: "{{ route('RuteId.updateKode') }}",
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
