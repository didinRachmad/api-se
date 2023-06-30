@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card">
        <div class="card-header">List Rute</div>
        <div class="card-body card-body-custom">
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group input-group-sm flex-nowrap mb-3">
                        <span class="input-group-text">Salesman</span>
                        <select class="form-select form-select-sm select2-salesman w-100" name="salesman" id="salesman"
                            required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                            oninput="setCustomValidity('')">
                        </select>
                    </div>
                    <input type="hidden" name="id_salesman" id="id_salesman">
                </div>
                <div class="col-lg-4">
                    <button type="button" class="btn btn-primary btn-sm" id="btnSearch">Search <span> <i
                                class="bi bi-search"></i></span></button>
                    {{-- <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                class="bi bi-journal-text"></i></span></button>
                    <button type="button" class="btn btn-warning btn-sm btnKandidat">Kandidat <span> <i
                                class="bi bi-journal-text"></i></span></button> --}}
                </div>
            </div>
            {{-- <textarea name="tes" id="tes" class="form-control w-100" cols="30" rows="10"></textarea> --}}
            <div class="table-responsive pt-3">
                <table class="table table-sm table-dark table-striped table-bordered align-middle myTable">
                    <thead class="text-center">
                        <th>no</th>
                        <th>nik_user</th>
                        <th>alamat_toko</th>
                        <th>kode_toko</th>
                        <th>nama_toko</th>
                        <th>nama_pemilik</th>
                        <th>no_telp</th>
                        <th>nama_wilayah</th>
                        <th>id_pasar</th>
                        <th>nama_pasar</th>
                        <th>id_survey_pasar</th>
                        <th>id_sales_ekslusif</th>
                        <th>nama_sales_ekslusif</th>
                        <th>id_qrcode</th>
                        <th>latitude</th>
                        <th>longitude</th>
                    </thead>
                    <tbody id="bodyTabelRute">
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
                    <input type='date' class='form-control form-control-sm date' id='tgl_transaksi' name='tanggal'
                        value='<?= date('Y-m-d') ?>'>
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
                    <input type='date' class='form-control form-control-sm date' id='tgl_visit' name='tanggal'
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
                            <label for="alamat-baru">Alamat</label>
                            <input type="text" class="form-control modal-input" id="alamat-baru" name="alamat-baru">
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="alamat-baru">Nama Toko</label>
                            <input type="text" class="form-control modal-input" id="nama_toko-baru"
                                name="nama_toko-baru">
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
                        <input type="hidden" id="id_mrdo-PASAR" readonly>
                        <input type="hidden" id="id_mco-PASAR" readonly>
                        <input type="hidden" id="survey_pasar_id-PASAR" readonly>
                        <input type="hidden" id="rute_id-PASAR" readonly>
                        <input type="hidden" id="id_pasar-PASAR" readonly>
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

    {{-- TOAST SALIN KODE --}}
    <div class="toast-container position-fixed top-0 end-0 p-5">
        <div class="toast align-items-center text-bg-success border-0" id="toastSalinKode" role="alert"
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
            var id_salesman = '';
            $('.select2-salesman').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ListRute.getSalesman') }}",
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
                id_salesman = data.id_salesman;
                $('.select2-rute').val(null).trigger('change');
            });

            var table = $('.myTable').DataTable({
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-sm-12 col-md-12'B>> " +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // scrollY: 260,
                // "lengthMenu": [10, 25, 50, 75, 100, 500],
                // "pageLength": 100,
                "paging": false,
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
                    url: "http://sales.motasaindonesia.co.id/api/downloadrute/getListRute",
                    type: 'POST',
                    data: function(d) {
                        d.id_salesman = $('#id_salesman').val();
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
                        },
                        "name": "no"
                    }, {
                        data: "nik_user",
                        name: "nik_user"
                    },
                    {
                        data: "alamat_toko",
                        name: "alamat_toko"
                    },
                    {
                        data: "kode_toko",
                        name: "kode_toko"
                    },
                    {
                        data: "nama_toko",
                        name: "nama_toko"
                    },
                    {
                        data: "nama_pemilik",
                        name: "nama_pemilik"
                    },
                    {
                        data: "no_telp",
                        name: "no_telp"
                    },
                    {
                        data: "nama_wilayah",
                        name: "nama_wilayah"
                    },
                    {
                        data: "id_pasar",
                        name: "id_pasar"
                    },
                    {
                        data: "nama_pasar",
                        name: "nama_pasar"
                    },
                    {
                        data: "id_survey_pasar",
                        name: "id_survey_pasar"
                    },
                    {
                        data: "id_sales_ekslusif",
                        name: "id_sales_ekslusif"
                    },
                    {
                        data: "nama_sales_ekslusif",
                        name: "nama_sales_ekslusif"
                    },
                    {
                        data: "id_qrcode",
                        name: "id_qrcode"
                    },
                    {
                        data: "latitude",
                        name: "latitude"
                    },
                    {
                        data: "longitude",
                        name: "longitude"
                    },
                ],
            });

            $(document).on('click', "#btnSearch", function() {
                table.draw();
            });
        });
    </script>
@endsection
