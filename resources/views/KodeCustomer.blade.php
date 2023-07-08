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
                                <tr class="warnaBaris" data-rute_detail_id="{{ $mrdo->rute_detail_id }}">
                                    <td class="nama_wilayah">
                                        {{ $mrdo->mr?->w?->nama_wilayah }} ({{ $mrdo->mr?->w?->id_wilayah }})
                                    </td>
                                    <td class="salesman">{{ $mrdo->mr?->salesman }}
                                        ({{ $mrdo->mr?->kr?->id_salesman_mss ?? '' }})
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
                                                    class="btn btn-sm p-1 btn-secondary w-100 btnPindah">Pindah</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-info w-100 btnSetRetail"
                                                    data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mco->id }}"
                                                    data-set={{ null }}>Retail</button>
                                            </div>
                                            <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-success w-100 btnSetGrosir"
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

    <!-- Modal Pindah Outlet -->
    <div class="modal fade" id="PindahRuteModal" tabindex="-1" role="dialog" aria-labelledby="PindahRuteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="PindahRuteModalLabel">Pindah Outlet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

            // // EDIT ALAMAT
            // $(document).on('click', "#saveEditAlamat", function() {
            //     // Ambil nilai kolom input field
            //     var survey_pasar_id = $('#survey_pasar_id-ALAMAT').val();
            //     var id_mco = $('#id_mco-ALAMAT').val();
            //     var nama_tokoBaru = $('#nama_toko-baru').val();
            //     var alamatBaru = $('#alamat-baru').val();

            //     // Ambil urutan baris tabel terkait dengan modal edit
            //     var index = $('#index-ALAMAT').val();

            //     if (alamatBaru === '' || alamatBaru == null) {
            //         $('#alamat-baru').get(0).setCustomValidity('Harap isi Alamat');
            //         $('#alamat-baru').get(0).reportValidity(); // Menampilkan pesan kesalahan
            //         return;
            //     }
            //     if (nama_tokoBaru === '' || nama_tokoBaru == null) {
            //         $('#nama_toko-baru').get(0).setCustomValidity('Harap isi Nama Toko');
            //         $('#nama_toko-baru').get(0).reportValidity(); // Menampilkan pesan kesalahan
            //         return;
            //     }

            //     // Lakukan update pada data di database
            //     $.ajax({
            //         type: 'post',
            //         url: "{{ route('KodeCustomer.updateAlamat') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             survey_pasar_id: survey_pasar_id,
            //             id_mco: id_mco,
            //             nama_toko: nama_tokoBaru,
            //             alamat: alamatBaru,
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             $('#alamat' + index).text(response.alamat);
            //             $('#nama_toko' + index).text(response.nama_toko);
            //             $('#editAlamatModal').modal('hide');
            //             $('.modal-input').val('');
            //             $('#successModal').modal('show');
            //             $('#alamat-baru').val('');
            //             $('#nama_toko-baru').val('');
            //         },
            //         error: function(xhr, status, error) {
            //             // console.error(error);
            //             $('#errorModal #message').text(xhr.responseJSON.message);
            //             $('#errorModal').modal('show');
            //         },
            //         complete: function() {
            //             $('.loading-overlay').hide();
            //         }
            //     });
            // });

            // // EDIT KODE
            // $(document).on('click', '#saveEditKode', function() {
            //     var id_mco = $('#id_mco-KODE').val();
            //     var survey_pasar_id = $('#survey_pasar_id-KODE').val();
            //     var kodeBaru = $('#kode-baru').val();

            //     // Ambil urutan baris tabel terkait dengan modal edit
            //     var index = $('#index-KODE').val();

            //     $.ajax({
            //         type: 'POST',
            //         url: "{{ route('KodeCustomer.updateKode') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             // _token: "{{ csrf_token() }}",
            //             id_mco: id_mco,
            //             survey_pasar_id: survey_pasar_id,
            //             kodeBaru: kodeBaru
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             $('#kode' + index).text(response.kode_customer);
            //             $('#editKodeModal').modal('hide');
            //             $('.modal-input').val('');
            //             $('#successModal').modal('show');
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

            // PINDAH OUTLET
            // $(document).on('click', '#savePindahRute', function() {
            //     var id = $('#id_mrdo').val();
            //     var id_pasar_awal = $('#id_pasar_awal').val();
            //     var rute_id_akhir = $('#rute_id_akhir').val();
            //     var id_survey_pasar = $('#id_survey_pasar').val();

            //     if (rute_id_akhir === '' || rute_id_akhir == null) {
            //         $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
            //         $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
            //         return;
            //     }

            //     $.ajax({
            //         type: 'POST',
            //         url: "{{ route('KodeCustomer.pindah') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             id: id,
            //             id_pasar_awal: id_pasar_awal,
            //             rute_id_akhir: rute_id_akhir,
            //             id_survey_pasar: id_survey_pasar
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             // console.log(response.message);
            //             $('#PindahRuteModal').modal('hide');
            //             $('#successModal #message').text(response.message);
            //             $('.modal-input').val('');
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
                        ' - ' +
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

                // Tampilkan modal edit
                $('#editModal').modal('show');

                var selectedRows = [];

                var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().match(
                    /\(([^()]+)\)[^(]*$/)[1];
                var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text();
                var id_qr_outlet = $(this).closest('tr').find('.id_mco').text();
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text();
                var id = $(this).closest('tr').find('.rute_id').text();
                var rute = $(this).closest('tr').find('.rute').text();
                var hari = $(this).closest('tr').find('.hari').text();
                var nama_toko = $(this).closest('tr').find('.nama_toko').text();
                var alamat = $(this).closest('tr').find('.alamat').text();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var nama_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $(this).closest('tr').find('.salesman').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
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

            // PINDAH RUTE
            $('.btnPindah').click(function(e) {
                e.preventDefault();

                $('#PindahRuteModal').modal('show');

                var selectedRows = [];
                var id_mrdo = $(this).closest('tr').find('.id_mrdo').text();
                var rute_id = $(this).closest('tr').find('.rute_id').text();
                var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                var id_pasar = $(this).closest('tr').find('.id_pasar').text();
                var id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text();
                var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                var wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $(this).closest('tr').find('.salesman').text().trim().replace(
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
                dataObject['salesman'] = salesman;
                dataObject['location_type'] = location_type;
                dataObject['toko'] = toko;

                selectedRows.push(dataObject);

                $('#savePindahRute').click(function(e) {
                    e.preventDefault();

                    var salesman_akhir = $('#salesman_akhir').val();
                    var hari = $('#rute_id_akhir').text().split(' ')[0];
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
            });

            // SET RETAIL
            $(document).on('click', '.btnSetRetail, .btnSetGrosir', function() {
                var id_mrdo = $(this).data('id_mrdo');
                var id_mco = $(this).data('id_mco');
                var set = $(this).data('set');
                var tipe_outlet = $(this).closest('tr').find('.tipe_outlet');

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

            // BYPASS QR
            $(document).on('click', '.bypassQR', function() {
                var survey_pasar_id = $(this).data('survey_pasar_id');
                var encodedData = btoa(JSON.stringify(survey_pasar_id));
                $.ajax({
                    type: 'POST',
                    url: "http://10.11.1.37/api/tool/outletkandidat/bypassqr",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        survey_pasar: encodedData
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
