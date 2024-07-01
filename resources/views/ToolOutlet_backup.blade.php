@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            min-width: 80px;
        }

        .tipe_outlet {
            white-space: nowrap;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">Tool Outlet</div> --}}
        <div class="card-body card-body-custom mt-3">
            <form class="form" method="POST" action="{{ route('ToolOutlet.getDataByRuteId') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-control form-select-sm select2-salesman_awal" name="salesman_awal"
                                id="salesman_awal">
                                <option value="{{ old('salesman_awal', $salesman_awal ?? '') }}">
                                    {{ old('salesman_awal', $salesman_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="id_salesman_awal" name="id_salesman_awal"
                                value="{{ old('id_salesman_awal', $id_salesman_awal ?? '') }}">
                            <input type="hidden" id="nama_wilayah_awal" name="nama_wilayah_awal"
                                value="{{ old('nama_wilayah_awal', $nama_wilayah_awal ?? '') }}">
                            <input type="hidden" id="id_wilayah_awal" name="id_wilayah_awal"
                                value="{{ old('id_wilayah_awal', $id_wilayah_awal ?? '') }}">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Hari</span>
                            <select class="form-control form-select-sm select2-hari_awal" name="hari_awal" id="hari_awal">
                                <option value="{{ old('hari_awal', $hari_awal ?? '') }}">
                                    {{ old('hari_awal', $hari_awal ?? '') }}
                                </option>
                            </select>
                            <div class="px-1"></div>
                            <span class="input-group-text">Rute</span>
                            <select class="form-control form-select-sm select2-rute_awal" name="rute_id_awal"
                                id="rute_id_awal">
                                <option value="{{ old('rute_id_awal', $rute_id_awal ?? '') }}">
                                    {{ old('rute_awal', $rute_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="rute_awal" name="rute_awal"
                                value="{{ old('rute_awal', $rute_awal ?? '') }}">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Pasar</span>
                            <select class="form-control form-select-sm select2-id_pasar_awal" name="id_pasar_awal"
                                id="id_pasar_awal">
                                <option value="{{ old('id_pasar_awal', $id_pasar_awal ?? '') }}">
                                    {{ old('pasar_awal', $pasar_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="pasar_awal" name="pasar_awal"
                                value="{{ old('pasar_awal', $pasar_awal ?? '') }}">
                        </div>
                    </div>
                    <div class="col-lg-1 text-center my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span><i
                                    class="bi bi-search"></i></span></button>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-control form-select-sm select2-salesman_akhir" name="salesman_akhir"
                                id="salesman_akhir">
                            </select>
                            <input type="hidden" id="id_salesman_akhir" name="id_salesman_akhir"
                                value="{{ old('id_salesman_akhir', $id_salesman_akhir ?? '') }}">
                            <input type="hidden" id="nama_wilayah_akhir" name="nama_wilayah_akhir">
                            <input type="hidden" id="id_wilayah_akhir" name="id_wilayah_akhir">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-control form-select-sm select2-rute_akhir" name="rute_id_akhir"
                                id="rute_id_akhir"></select>
                            <input type="hidden" id="rute_akhir" name="rute_akhir">
                        </div>
                    </div>
                    <div class="col-lg-1 text-center my-auto">
                        <button type="button" class="btn btn-primary btn-sm" id="btnPindah">Pindah <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                    </div>
                    <div class="col-lg-2 text-center my-auto">
                        <button type="button" class="btn btn-info btn-sm my-1" id="btnPindahPasar">Pindah Pasar <i
                                class="bi bi-sign-intersection-y-fill"></i></button>
                        <button type="button" class="btn btn-success btn-sm my-1" id="btnPindahLokasi">Pindah Lokasi
                            <i class="bi bi-sign-intersection-y-fill"></i></button>
                        {{-- <button type="button" class="btn btn-secondary btn-sm my-1" id="btnEditKodeOrder">Update
                            Kode Order <i class="bi bi-pen-fill"></i></button> --}}
                        {{-- <button type="button" class="btn btn-warning btn-sm my-1" id="btnClearKodeKandidat">Clear
                                Kode Kandidat <i class="bi bi-x-square-fill"></i></button> --}}
                        <button type="button" class="btn btn-danger btn-sm my-1" id="btnHapusRODouble">Hapus RO
                            Double <i class="bi bi-trash"></i></button>
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Tipe Outlet
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">Retail</a></li>
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">Grosir</a></li>
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">NOO</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>

            @if (!isset($data))
                @php
                    $data = collect();
                @endphp
                <div class="row p-1"></div>
            @else
                <div class="row py-1 px-3 my-2 mx-1 rounded text-white" style="background-color: #252B3B;">
                    <div class="col-lg-12">
                        <p class="d-inline-block p-1">Distributor : <span class="fw-bold"
                                id="nama_distributor">{{ $data->first()->d?->nama_distributor ?? '' }}
                                ({{ $data->first()->d?->id_distributor ?? '' }})</span>
                        </p>
                        <p class="d-inline-block p-1">Wilayah : <span class="fw-bold"
                                id="nama_wilayah">{{ $data->first()->w->nama_wilayah ?? '' }}
                                ({{ $data->first()->w->id_wilayah ?? '' }})</span>
                        </p>
                        <p class="d-inline-block p-1">Nama Salesman : <span class="fw-bold"
                                id="nama_salesman">{{ $data->first()->salesman ?? '' }}
                                ({{ $data->first()->kr?->id_salesman_mss ?? '' }})</span>
                        </p>
                        @if (isset($salesman_awal))
                            <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                        class="bi bi-journal-text"></i></span></button>
                            <button type="button" class="btn btn-warning btn-sm btnKandidat">Visit Kandidat <span> <i
                                        class="bi bi-journal-text"></i></span></button>
                        @endif
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-sm table-light table-striped align-middle myTable" id="myTable">
                    <thead class="text-center">
                        <th>No</th>
                        <th>Wilayah</th>
                        <th id="filter-salesman">Salesman</th>
                        <th id="filter-rute">Rute</th>
                        <th>Hari</th>
                        <th>Rute ID</th>
                        <th>ID MRDO</th>
                        <th>Survey pasar ID</th>
                        <th>ID MCO <button type="button" class="btn btn-sm btn-secondary"
                                id="salinID_MCO">Salin</button>
                        </th>
                        <th>Kode Customer <button type="button" class="btn btn-sm btn-secondary"
                                id="salinKode">Salin</button>
                        </th>
                        <th>Nama Toko <button type="button" class="btn btn-sm btn-secondary"
                                id="salinNamaToko">Salin</button>
                        </th>
                        <th>Alamat <button type="button" class="btn btn-sm btn-secondary"
                                id="salinAlamat">Salin</button>
                        </th>
                        <th>ID Pasar</th>
                        <th>Nama pasar</th>
                        <th>Tipe Outlet</th>
                        <th>Status Reject</th>
                        <th>QR</th>
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
                                @php
                                    $no += 1;
                                @endphp
                                <tr class="warnaBaris" data-id="{{ $mrdo->id }}"
                                    data-rute_detail_id="{{ $mrdo->rute_detail_id }}">
                                    <td></td>
                                    <td class="nama_wilayah">
                                        {{ $mr->w->nama_wilayah ?? '' }} ({{ $mr->w->id_wilayah ?? '' }})
                                    </td>
                                    <td class="nama_salesman">
                                        {{ $mr->salesman }} ({{ $mr->kr->id_salesman_mss ?? '' }})
                                    </td>
                                    <td class="rute">{{ $mr->rute }}</td>
                                    <td class="hari">{{ $mr->hari }}</td>
                                    <td class="rute_id">{{ $mrdo->rute_id }}</td>
                                    <td class="id_mrdo">{{ $mrdo->id }}</td>
                                    <td class="survey_pasar_id">{{ $mrdo->survey_pasar_id }}</td>
                                    <td class="id_mco">{{ $mrdo->mco->id ?? '' }}</td>
                                    <td class="text-primary fw-bold kode_customer">{{ $mrdo->mco->kode_customer ?? '' }}
                                    </td>
                                    <td class="nama_toko">{{ $mrdo->nama_toko }}</td>
                                    <td class="alamat" id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                    <td class="id_pasar">{{ $mrdo->mrd->id_pasar ?? '' }}</td>
                                    <td class="nama_pasar">{{ $mrdo->mrd->nama_pasar ?? '' }}</td>
                                    <td class="tipe_outlet">
                                        {{ $mrdo->tipe_outlet ?? 'RETAIL' }} - {{ $mrdo->sp->location_type ?? '' }} -
                                        {{ $mrdo->sp->source_type ?? '' }}
                                    </td>
                                    <td class="statusReject text-danger"></td>
                                    <td class="barcode fw-bold"></td>
                                    <td>
                                        <div class="row px-2 py-1">
                                            <div class="col-12 px-0">
                                                <button type="button"
                                                    class="btn btn-sm p-1 btn-warning btn-block w-100 btnEdit">Edit</button>
                                            </div>
                                            {{-- <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-info btn-block w-100 btnSetRetail"
                                                    data-row-index="{{ $no }}"
                                                    data-id_mrdo="{{ $mrdo->id }}"
                                                    data-id_mco="{{ $mrdo->mco->id ?? '' }}"
                                                    data-set={{ null }}>Retail</button>
                                                </div>
                                                <div class="col-6 px-0">
                                                    <button type="button" class="btn btn-sm p-1 btn-success btn-block w-100 btnSetGrosir" data-row-index="{{ $no }}" data-id_mrdo="{{ $mrdo->id }}" data-id_mco="{{ $mrdo->mco->id ?? '' }}" data-set="TPOUT_WHSL">Grosir</button>
                                            </div> --}}
                                            {{-- <div class="col-6 px-0">
                                                <button type="button" class="btn btn-sm p-1 btn-light w-100 bypassQR"
                                                    data-survey_pasar_id="{{ $mrdo->survey_pasar_id }}">QR</button>
                                            </div> --}}
                                            {{-- <div class="col-6 px-0">
                                                    <button type="button"
                                                        class="btn btn-sm p-1 btn-danger btn-block w-100 btnHapus">Hapus</button>
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
                    <div class="mx-auto w-50 px-5">
                        <input type="date" class="form-control form-control-sm" id="tgl_transaksi"
                            name="tgl_transaksi" value="<?= date('Y-m-d') ?>">
                    </div>
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
                                <th>no order</th>
                                <th>nama salesman</th>
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
                                <th>tipe Outlet</th>
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

    <!-- Modal Kandidat -->
    <div class="modal fade" id="KandidatModal" tabindex="-1" role="dialog" aria-labelledby="KandidatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="KandidatModalLabel">Data Kandidat</h5>
                    <div class="mx-auto w-50 px-5">
                        <input type="date" class="form-control form-control-sm" id="tgl_visit" name="tgl_visit"
                            value="<?= date('Y-m-d') ?>">
                    </div>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-light table-striped  TableKandidat w-100">
                            <thead class="text-center">
                                <th>No</th>
                                <th>id</th>
                                <th>Distributor</th>
                                <th>Wilayah</th>
                                <th>id_salesman</th>
                                <th>Salesman</th>
                                <th>Nama Toko</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>ID Survey Pasar</th>
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
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Pasar</span>
                            <select class="form-select form-select-sm select2-pasar_akhir w-100" id="pasar_akhir">
                            </select>
                        </div>
                        <input type="hidden" id="nama_pasar_akhir" name="nama_pasar_akhir" readonly>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
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
                <button type="button" class="btn-close bg-danger btn-close bg-danger-white me-2 m-auto"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $('form').submit(function() {
                // Nonaktifkan validasi ketika form di-submit
                isValidationEnabled = false;
                $('#rute_id_akhir').get(0).setCustomValidity(''); // Menghapus validasi pada rute_id_akhir
            });

            // SELECT SALESMAN AWAL
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
                placeholder: 'Pilih Salesman',
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
                $('.select2-rute_awal').val(null).trigger('change');
                $('#hari_awal').val(null).trigger('change');
                $('#rute_awal').val('');
                $('#id_salesman_awal').val(data.id_salesman);
                $('#nama_wilayah_awal').val(data.nama_wilayah);
                $('#id_wilayah_awal').val(data.id_wilayah);
            }).on('select2:unselect', function() {
                $('.select2-rute_awal').val(null).trigger('change');
                $('#hari_awal').val(null).trigger('change');
                $('#rute_awal').val('');
                $('#id_salesman_awal').val('');
                $('#nama_wilayah_awal').val('');
                $('#id_wilayah_awal').val('');
            });

            // SELECT HARI AWAL
            $('.select2-hari_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getHari') }}",
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
                placeholder: 'Pilih Hari',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text);
                }
            });

            // SELECT RUTE AWAL
            $('.select2-rute_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getRute') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('#salesman_awal').val(),
                            hari: $('#hari_awal').val()
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
                $('#rute_awal').val(data.text);
            }).on('select2:unselect', function() {
                $('#rute_awal').val('');
            });

            // SELECT PASAR AWAL
            $('.select2-id_pasar_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getPasar') }}",
                    dataType: 'json',
                    // delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1,
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
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.id_pasar).addClass('pull-right').append($('<b>').text(
                        ' - ' + data.text)).addClass('pull-right').append($('<b>').text(
                        ' - ' + data.nama_wilayah));
                },
                templateSelection: function(data) {
                    return data.text;
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#pasar_awal').val(data.text);
            });

            // SELECT SALESMAN AKHIR
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
                placeholder: 'Pilih Salesman',
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
                $('.select2-rute_akhir').val(null).trigger('change');
                $('#id_salesman_akhir').val(data.id_salesman);
                $('#nama_wilayah_akhir').val(data.nama_wilayah);
                $('#id_wilayah_akhir').val(data.id_wilayah);
            });

            // SELECT RUTE AKHIR
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
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#rute_akhir').val(data.text);
            });

            // SELECT PASAR AKHIR
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
                "dom": "<'row'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-2 filter-NamaToko'><'col-sm-12 col-md-2 filter-Alamat'><'col-sm-12 col-md-2 filter-jenis_outlet'B><'col-sm-12 col-md-2 text-right'f>>" +
                    "<'row'<'col-sm-12 table-responsive'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                buttons: [{
                    extend: 'copy',
                    title: 'Data SE - ' + $('#nama_salesman').text().trim(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }, 'csv', {
                    extend: 'excel',
                    title: 'Data SE - ' + $('#nama_salesman').text().trim(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }, {
                    extend: 'pdf',
                    title: 'Data SE - ' + $('#nama_salesman').text().trim(),
                    exportOptions: {
                        columns: ':not(.no-export)'
                    },
                    customize: function(doc) {
                        doc.pageOrientation =
                            'landscape'; // Set orientasi landscape
                        doc.pageSize =
                            'A4'; // Set ukuran halaman 
                    }
                }],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 17, 18],
                    "className": 'no-export'
                }],
                "order": [
                    [2, 'asc'],
                    [3, 'asc'],
                    [9, 'desc'],
                    [12, 'asc']
                ],
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-100">
                        <option value="">Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-jenis_outlet')
                        .on('change', function() {
                            var val = $(this).val();
                            if (val === '') {
                                table.column(9).search('').draw();
                            } else if (val === 'KANDIDAT') {
                                table.column(9).search('^(0|null|)$', true, false).draw();
                            } else if (val === 'RO') {
                                table.column(9).search('^(?!0$|null$).+$', true, false).draw();
                            }
                        });

                    // FILTER SURVEY_PASAR
                    $(`<textarea id="filterSurveyPasar" class="form-control" rows="3" placeholder="Filter Survey Pasar"></textarea>`)
                        .appendTo('.filter-survey_pasar')
                        .on('input', function() {
                            var filterSurveyPasar = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterSurveyPasar == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(7).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                var filterRegex = '^' + filterSurveyPasar.join('$|^') + '$';
                                table.column(7).search(filterRegex, true, false).draw();
                            }
                        });

                    // FILTER KODE CUSTOMER
                    $(`<textarea id="filterKodeCustomer" class="form-control" rows="3" placeholder="Filter Kode Customer"></textarea>`)
                        .appendTo('.filter-KodeCustomer')
                        .on('input', function() {
                            var filterKodeCustomer = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });
                            if (filterKodeCustomer == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(9).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                var filterRegex = '^' + filterKodeCustomer.join('$|^') + '$';
                                table.column(9).search(filterRegex, true, false).draw();
                            }
                        });

                    // FILTER NAMA TOKO
                    $(`<textarea id="filterNamaToko" class="form-control" rows="3" placeholder="Filter Nama Toko"></textarea>`)
                        .appendTo('.filter-NamaToko')
                        .on('input', function() {
                            var filterNamaToko = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterNamaToko == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(10).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                var filterRegex = '^' + filterNamaToko.join('$|^') + '$';
                                table.column(10).search(filterRegex, true, false).draw();
                            }
                        });
                    // FILTER ALAMAT
                    $(`<textarea id="filterAlamat" class="form-control" rows="3" placeholder="Filter Alamat"></textarea>`)
                        .appendTo('.filter-Alamat')
                        .on('input', function() {
                            var filterAlamat = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterAlamat == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(11).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                var filterRegex = '^' + filterAlamat.join('$|^') + '$';
                                table.column(11).search(filterRegex, true, false).draw();
                            }
                        });

                    var salesmanList = this.api().column(2).data().unique().sort();
                    var salesmanSelect = $(
                            '<select class="w-100"><option value="">All</option></select>')
                        .appendTo('#filter-salesman')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    salesmanList.each(function(d, j) {
                        salesmanSelect.append('<option value="' + d + '">' + d + '</option>');
                    });

                    var ruteList = this.api().column(3).data().unique().sort();
                    var ruteSelect = $(
                            '<select class="w-100"><option value="">All</option></select>')
                        .appendTo('#filter-rute')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    ruteList.each(function(d, j) {
                        ruteSelect.append('<option value="' + d + '">' + d + '</option>');
                    });
                }
            });
            table.column(5).search($('#rute_id_awal').val()).draw();
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
                var filteredData = table.column(8, {
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
                }, 1000);
            });
            $('#salinNamaToko').click(function() {
                // Mengambil data kolom dengan filter yang aktif
                var filteredData = table.column(9, {
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
                }, 1000);
            });
            $('#salinAlamat').click(function() {
                // Mengambil data kolom dengan filter yang aktif
                var filteredData = table.column(10, {
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
                }, 1000);
            });
            $('#salinID_MCO').click(function() {
                // Mengambil data kolom dengan filter yang aktif
                var filteredData = table.column(11, {
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
                }, 1000);
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
                            "<'row'<'col-sm-12 table-responsive'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data SE - ' + $('#salesman_awal').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data SE - ' + $('#salesman_awal').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, {
                            extend: 'pdf',
                            title: 'Data SE - ' + $('#salesman_awal').val(),
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
                            url: "{{ route('ToolOutlet.getOrder') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#nama_salesman').text().match(/\((.*?)\)/)[
                                    1];
                                d.tgl_transaksi = $('#tgl_transaksi')
                                    .val(); // ambil nilai input field id_transaksi
                            },
                        },
                        order: [
                            [12, 'asc'],
                            [2, 'asc'],
                            [4, 'asc']
                        ],
                        columnDefs: [{
                            targets: [1, 13, 17],
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
                            "<'row'<'col-sm-12 table-responsive'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        // scrollY: 260,
                        "lengthMenu": [10, 25, 50, 75, 100, 500],
                        "pageLength": 100,
                        buttons: [{
                            extend: 'copy',
                            title: 'Data SE - ' + $('#salesman_awal').val(),
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, 'csv', {
                            extend: 'excel',
                            title: 'Data SE - ' + $('#salesman_awal').val(),
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
                            url: "{{ route('ToolOutlet.getKandidat') }}",
                            type: 'POST',
                            data: function(d) {
                                d.id_salesman = $('#nama_salesman').text().match(/\((.*?)\)/)[
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
                                data: 'id',
                                name: 'id'
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
                                data: 'id_survey_pasar',
                                name: 'id_survey_pasar'
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
            //         var id = $(this).closest('tr').find('.id_mrdo').text().trim();
            //         var id_pasar_awal = $(this).closest('tr').find('.id_pasar').text().trim();
            //         var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text().trim();
            //         selectedRows.push({
            //             id: id,
            //             id_pasar_awal: id_pasar_awal,
            //             rute_id_akhir: rute_id_akhir,
            //             id_survey_pasar: id_survey_pasar
            //         });
            //     });
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
            //             $('#successModal #message').text(response.message);
            //             $('#successModal').modal('show');
            //             setTimeout(function() {
            //                 $('#successModal').modal('hide');
            //                 location.reload();
            //             }, 1000);
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
            // $(document).on('click', "#btnPindahPasar", function(e) {
            //     e.preventDefault();
            //     // Tampilkan modal edit
            //     $('#PindahPasarModal').modal('show');

            //     $('#savePindahPasar').click(function(e) {
            //         e.preventDefault();

            //         var selectedRows = [];

            //         $('.check:checked').each(function() {
            //             var id = $(this).closest('tr').data('id');
            //             var id_mco = $(this).closest('tr').data('id_mco');
            //             var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text().trim();
            //             var rute_id_awal = $(this).closest('tr').data('rute_id_awal');
            //             var id_pasar_akhir = $('#id_pasar_akhir').val();
            //             selectedRows.push({
            //                 id: id,
            //                 id_mco: id_mco,
            //                 id_survey_pasar: id_survey_pasar,
            //                 id_pasar_akhir: id_pasar_akhir,
            //                 rute_id_awal: rute_id_awal
            //             });
            //         });
            //         $.ajax({
            //             type: 'post',
            //             url: "{{ route('ToolOutlet.pindahPasar') }}",
            //             dataType: 'json',
            //             encode: true,
            //             data: {
            //                 detail: selectedRows
            //             },
            //             beforeSend: function() {
            //                 $('.loading-overlay').show();
            //             },
            //             success: function(response) {
            //                 $('#successModal #message').text(response.message);
            //                 $('#successModal').modal('show');
            //                 $('#id_pasar_akhir').val(null);
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

            // PINDAH RUTE
            $('#btnPindah').click(function(e) {
                e.preventDefault();

                var salesman_awal = $('#salesman_awal').val();
                var salesman_akhir = $('#salesman_akhir').val();
                var id_salesman_akhir = $('#id_salesman_akhir').val();
                var hari_akhir = $('#rute_id_akhir').text().split(' ')[0].trim();
                var rute_akhir = $('#rute_akhir').val();
                var rute_id_akhir = $('#rute_id_akhir').val();
                var nama_wilayah_akhir = $('#nama_wilayah_akhir').val();
                var id_wilayah_akhir = $('#id_wilayah_akhir').val();
                var selectedRows = [];

                if (rute_id_akhir === '' || rute_id_akhir == null) {
                    $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
                    $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }

                $('.check:checked').each(function(index) {
                    var id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                    var rute_id = $(this).closest('tr').find('.rute_id').text().trim();
                    var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                    var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                    var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text()
                        .trim();
                    var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                    var wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                        /\s*\([^)]*\)$/, '');
                    var location_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                        '-')[1];
                    var toko = $(this).closest('tr').find('.nama_toko').text().trim();

                    var dataObject = {};
                    dataObject['id_mrdo'] = id_mrdo;
                    dataObject['rute_id'] = rute_id;
                    dataObject['rute_detail_id'] = rute_detail_id;
                    dataObject['id_wilayah'] = id_wilayah_akhir;
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
                        hari: hari_akhir,
                        rute: rute_id_akhir,
                        data_all: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            $('#successModal').modal('show');
                            $('.check:checked').each(function(index) {
                                // if (salesman_awal != salesman_akhir) {
                                //     var row = $(this).closest('tr');
                                //     table.row(row).remove().draw();
                                // } else {
                                var mrdo_id = $(this).closest(
                                        'tr').find('.id_mrdo')
                                    .text().trim();

                                var rowData = table.row(
                                    '[data-id="' + mrdo_id +
                                    '"]').data();

                                rowData[1] =
                                    nama_wilayah_akhir + " (" + id_wilayah_akhir + ")";
                                rowData[2] = salesman_akhir;
                                rowData[3] =
                                    rute_akhir;
                                rowData[4] =
                                    hari_akhir;
                                rowData[5] =
                                    rute_id_akhir;

                                table.row('[data-id="' +
                                    mrdo_id + '"]').data(
                                    rowData).draw();
                                // }
                            });
                            table.column(2).search(salesman_awal).draw();
                            cek_rute_aktif();
                            setTimeout(function() {
                                $('#successModal').modal('hide');
                                // location.reload();
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

            // PINDAH PASAR
            $(document).on('click', "#btnPindahPasar", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahPasarModal').modal('show');

                $('#savePindahPasar').off('click').on('click', function(e) {
                    e.preventDefault();

                    var selectedRows = [];
                    var valid = true;
                    $('.check:checked').each(function(index) {
                        var id_distributor = $('#nama_distributor').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text()
                            .trim()
                            .match(/\(([^()]+)\)[^(]*$/)[1];
                        var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id')
                            .text().trim();
                        var id_qr_outlet = $(this).closest('tr').find('.id_mco').text()
                            .trim();
                        var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                        var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                        var id = $(this).closest('tr').find('.rute_id').text().trim();
                        var rute = $(this).closest('tr').find('.rute').text().trim();
                        var hari = $(this).closest('tr').find('.hari').text().trim();
                        var nama_toko = $(this).closest('tr').find('.nama_toko').text()
                            .trim();
                        var alamat = $(this).closest('tr').find('.alamat').text() ?? '';
                        var kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        var nama_pasar = $(this).closest('tr').find('.nama_pasar')
                            .text().trim();
                        var nama_distributor = $('#nama_distributor').text().replace(
                            /\s*\([^)]*\)$/, '');
                        var nama_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text().trim().replace(/\s*\([^)]*\)$/, '');
                        var salesman = $('#salesman_awal').val();
                        var id_pasar = $(this).closest('tr').find('.id_pasar').text()
                            .trim();
                        var location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split('-')[1].trim();
                        var pasar = $(this).closest('tr').find('.tipe_outlet').text()
                            .split('-')[1].trim().toUpperCase();
                        // if (pasar == 'PASAR') {
                        //     // alert("LOKASI PASAR : " + nama_toko + " - " + kode_customer);
                        //     valid = false;
                        //     return false;
                        // }
                        var id_pasar_akhir = $('#pasar_akhir').val();

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
                                $('#PindahPasarModal').modal('hide');
                                $('#successModal').modal('show');

                                var id_pasar_akhir = $('#pasar_akhir')
                                    .val();
                                var nama_pasar_akhir = $(
                                    '#nama_pasar_akhir').val();

                                $('.check:checked').each(function(index) {
                                    var mrdo_id = $(this).closest(
                                            'tr').find('.id_mrdo')
                                        .text().trim();

                                    var rowData = table.row(
                                        '[data-id="' + mrdo_id +
                                        '"]').data();
                                    rowData[12] = id_pasar_akhir;
                                    rowData[13] = nama_pasar_akhir;

                                    table.row('[data-id="' +
                                        mrdo_id + '"]').data(
                                        rowData).draw();
                                });

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
                        $('#errorModal #message').text("Terdapat data yang lokasinya PASAR");
                        $('#errorModal').modal('show');
                        $('#PindahPasarModal').modal('hide');
                    }
                });
            });

            // PINDAH LOKASI
            $(document).on('click', "#btnPindahLokasi", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahLokasiModal').modal('show');

                $('#savePindahLokasi').off('click').on('click', function(e) {
                    e.preventDefault();

                    var selectedRows = [];
                    var valid = true;
                    $('.check:checked').each(function(index) {
                        var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text()
                            .trim()
                            .match(/\(([^()]+)\)[^(]*$/)[1];
                        var id_distributor = $('#nama_distributor').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id')
                            .text().trim();
                        var id_qr_outlet = $(this).closest('tr').find('.id_mco').text()
                            .trim();
                        var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                        var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                        var id = $(this).closest('tr').find('.rute_id').text().trim();
                        var rute = $(this).closest('tr').find('.rute').text().trim();
                        var hari = $(this).closest('tr').find('.hari').text().trim();
                        var nama_toko = $(this).closest('tr').find('.nama_toko').text()
                            .trim();
                        var alamat = $(this).closest('tr').find('.alamat').text() ?? '';
                        var kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        var nama_pasar = $(this).closest('tr').find('.nama_pasar')
                            .text().trim();
                        var nama_distributor = $('#nama_distributor').text().replace(
                            /\s*\([^)]*\)$/, '');
                        var nama_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text().trim().replace(/\s*\([^)]*\)$/, '');
                        var salesman = $('#salesman_awal').val();
                        var id_pasar = $(this).closest('tr').find('.id_pasar').text()
                            .trim();
                        var location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split('-')[1].trim();
                        var source_type = $(this).closest('tr').find('.tipe_outlet').text()
                            .split('-')[2].trim();
                        // if (source_type == 'MAS') {
                        //     alert("Source Type MAS : " + nama_toko + " - " + kode_customer);
                        //     valid = false;
                        //     $('#PindahLokasiModal').modal('hide');
                        //     return false;
                        // }

                        var lokasi = $('#lokasi').val();

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
                                    $('#PindahLokasiModal').modal('hide');

                                    var lokasi = $('#lokasi').val();
                                    $('.check:checked').each(function(index) {
                                        var mrdo_id = $(this).closest(
                                                'tr').find('.id_mrdo')
                                            .text().trim();
                                        var tipe_outlet = $(this)
                                            .closest('tr').find(
                                                '.tipe_outlet').text()
                                            .trim();

                                        var tipe_outlet_parts =
                                            tipe_outlet.split('-');
                                        tipe_outlet_parts[1] = lokasi;
                                        var tipe_outlet_modified =
                                            tipe_outlet_parts.join(
                                                ' - ');

                                        var rowData = table.row(
                                            '[data-id="' + mrdo_id +
                                            '"]').data();

                                        rowData[14] =
                                            tipe_outlet_modified;

                                        table.row('[data-id="' +
                                            mrdo_id + '"]').data(
                                            rowData).draw();
                                    });
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
                    }
                });
            });

            // EDIT OUTLET
            $(document).on('click', ".btnEdit", function() {
                var nama_toko = $(this).closest('tr').find('.nama_toko');
                var alamat = $(this).closest('tr').find('.alamat');
                var kode_customer = $(this).closest('tr').find('.kode_customer');

                $('#alamat-baru').val(alamat.text().trim() ?? "");
                $('#nama_toko-baru').val(nama_toko.text().trim());
                $('#kode_customer-baru').val(kode_customer.text().trim());

                // Tampilkan modal edit
                $('#editModal').modal('show');

                var selectedRows = [];
                var valid = true;

                var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().match(
                    /\(([^()]+)\)[^(]*$/)[1];
                var id_distributor = $('#nama_distributor').text().match(
                    /\(([^()]+)\)[^(]*$/)[1];
                var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text().trim();
                var id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
                var mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                var id = $(this).closest('tr').find('.rute_id').text().trim();
                var rute = $(this).closest('tr').find('.rute').text().trim();
                var hari = $(this).closest('tr').find('.hari').text().trim();
                var nama_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                var nama_pasar = $(this).closest('tr').find('.nama_pasar')
                    .text().trim();
                var nama_distributor = $('#nama_distributor').text().replace(
                    /\s*\([^)]*\)$/, '');
                var salesman = $('#salesman_awal').val();
                var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                var location_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[1].trim();
                var source_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[2].trim();

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
                dataObject['nama_toko'] = nama_toko.text().trim();
                dataObject['kode_customer'] = kode_customer.text().trim();
                dataObject['nama_wilayah'] = nama_wilayah;
                dataObject['nama_pasar'] = nama_pasar;
                dataObject['salesman'] = salesman;
                dataObject['id_pasar'] = id_pasar;
                dataObject['location_type'] = location_type;

                $('#saveEdit').off('click').on('click', function(e) {
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
                                $('#editModal').modal('hide');

                                var rowData = table.row('[data-id="' + mrdo_id +
                                    '"]').data();
                                rowData[9] = kode_customer_akhir;
                                rowData[10] = nama_toko_akhir;
                                rowData[11] = alamat_akhir;

                                table.row('[data-id="' + mrdo_id + '"]').data(
                                    rowData).draw();
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

            // SET RETAIL/GROSIR ALL
            $(document).on('click', ".btnSetTipeOutlet", function(e) {
                e.preventDefault();
                var buttonValue = $(this).text().trim();

                var selectedRows = [];

                $('.check:checked').each(function(index) {
                    var id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                    var rute_id = $(this).closest('tr').find('.rute_id').text().trim();
                    var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                    var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                    var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text()
                        .trim();
                    var id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
                    var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
                    var id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().match(
                        /\(([^()]+)\)[^(]*$/)[1].trim();
                    var dataObject = {};
                    dataObject['id_outlet'] = id_mrdo;
                    dataObject['rute_id'] = rute_id;
                    dataObject['rute_detail_id'] = rute_detail_id;
                    dataObject['id_pasar'] = id_pasar;
                    dataObject['survey_pasar'] = id_survey_pasar;
                    dataObject['id_qr_outlet'] = id_qr_outlet;
                    dataObject['kode_customer'] = kode_customer;
                    dataObject['id_wilayah'] = id_wilayah;

                    selectedRows.push(dataObject);
                });

                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/outletkandidat/settipeoutlet",
                    dataType: 'json',
                    encode: true,
                    data: {
                        data: selectedRows,
                        type: buttonValue
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            $('#successModal').modal('show');
                            $('.check:checked').each(function(index) {
                                var mrdo_id = $(this).closest(
                                        'tr').find('.id_mrdo')
                                    .text().trim();
                                var tipe_outlet = $(this).closest('tr').find(
                                    '.tipe_outlet').text().trim();

                                var tipe = buttonValue;
                                if (buttonValue == "Grosir") {
                                    tipe = "TPOUT_WHSL";
                                }
                                var tipe_outlet_parts = tipe_outlet.split('-');
                                tipe_outlet_parts[0] = tipe;
                                var tipe_outlet_modified = tipe_outlet_parts.join(
                                    ' - ');

                                var rowData = table.row(
                                    '[data-id="' + mrdo_id +
                                    '"]').data();

                                rowData[14] = tipe_outlet_modified;
                                rowData[15] = "-";

                                table.row('[data-id="' +
                                    mrdo_id + '"]').data(
                                    rowData).draw();
                            });
                            // setTimeout(function() {
                            //     $('#successModal').modal('hide');
                            //     // location.reload();
                            // }, 1000);
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

            // DELETE RO DOUBLE
            $('#btnHapusRODouble').click(function(e) {
                e.preventDefault();
                var selectedRows = [];
                var codeCountMap = {}; // Objek untuk melacak kemunculan kode customer
                $('.kode_customer').each(function() {
                    var kode_customer = $(this).text().trim();
                    var id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                    var source_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[
                        2].trim();

                    if (kode_customer != null && kode_customer != '' && kode_customer != '0') {
                        if (!codeCountMap[kode_customer]) {
                            codeCountMap[kode_customer] = {
                                count: 1,
                                id_mrdo: source_type === "MAS" ? id_mrdo : null
                            };
                        } else {
                            codeCountMap[kode_customer].count += 1;
                            if (source_type === "MAS") {
                                codeCountMap[kode_customer].id_mrdo = id_mrdo;
                            } else {
                                if (codeCountMap[kode_customer].id_mrdo == null) {
                                    codeCountMap[kode_customer].id_mrdo = id_mrdo;
                                }
                            }
                            selectedRows.push({
                                kode_customer: kode_customer,
                                id_mrdo: codeCountMap[kode_customer].id_mrdo
                            });
                        }
                    }
                });

                $.ajax({
                    type: 'post',
                    url: "{{ route('ToolOutlet.hapus_ro_double') }}",
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

                        rowData[16] = 'SUDAH BYPASS';

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
                var salesman_awal = $('#salesman_awal').val();
                var id_salesman_awal = $('#id_salesman_awal').val();
                var iddepo = $('#id_wilayah_awal').val();
                var id_pasar = $('#id_pasar_awal').val();
                var rute_awal = $('#rute_awal').val();
                var hari = rute_awal ? rute_awal.split(' ')[0].trim() : '';
                var periodik = (rute_awal && rute_awal.split(' ')[1]) ? rute_awal.split(' ')[1].trim() : '';

                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/outletkandidat/getData",
                    dataType: 'json',
                    encode: true,
                    data: {
                        salesman: id_salesman_awal,
                        depo: iddepo,
                        pasar: id_pasar,
                        type: "",
                        hari: hari,
                        periodik: periodik
                    },
                    success: function(response) {
                        const dataRuteID = {};
                        const dataMRDO_ID = {};
                        const dataQR = {};
                        $.each(response.data, function(index, item) {
                            const id = item.id;
                            const mrdo_id = item.mrdo_id;
                            if (!dataRuteID[id] && item.rute_hari_ini == 1) {
                                dataRuteID[id] = id;
                            }
                            if (!dataMRDO_ID[mrdo_id] && item.visit_kandidats[0]) {
                                if (item.visit_kandidats[item.visit_kandidats.length - 1]
                                    .keterangan_visit['tipe'] ==
                                    "REJECT") {
                                    dataMRDO_ID[mrdo_id] = item.visit_kandidats[item
                                            .visit_kandidats.length - 1]
                                        .keterangan_visit[
                                            'keterangan'];
                                } else {
                                    dataMRDO_ID[mrdo_id] = '-';
                                }
                            } else {
                                dataMRDO_ID[mrdo_id] = '-';
                            }
                            if (item.verifikasi_qr) {
                                if (item.verifikasi_qr['flag_qr']) {
                                    if (item.pengajuan_by_pass[0]) {
                                        dataQR[mrdo_id] = `<button type="button"
                                                    class="btn btn-sm p-1 btn-danger btn-block w-100 btnBarcode"
                                                    data-id_qr="` + item.pengajuan_by_pass[0].id + `">QR</button>`;
                                    } else {
                                        dataQR[mrdo_id] = 'Belum Isi QR Bermasalah';
                                    }
                                } else {
                                    dataQR[mrdo_id] = 'SUDAH BYPASS';
                                }
                            } else {
                                dataQR[mrdo_id] = '-';
                            }
                        });
                        $('.warnaBaris').each(function() {
                            var ruteId = $(this).find('.rute_id').text().trim();
                            var mrdo_id = $(this).find('.id_mrdo').text().trim();
                            var nama_wilayah = $(this).find('.nama_wilayah');
                            var nama_salesman = $(this).find('.nama_salesman');
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
                            if (dataMRDO_ID[mrdo_id]) {
                                var rowData = table.row(
                                    '[data-id="' + mrdo_id +
                                    '"]').data();

                                rowData[15] = dataMRDO_ID[mrdo_id];

                                table.row('[data-id="' +
                                    mrdo_id + '"]').data(
                                    rowData).draw();
                            }
                            if (dataQR[mrdo_id]) {
                                var rowData = table.row(
                                    '[data-id="' + mrdo_id +
                                    '"]').data();

                                rowData[16] = dataQR[mrdo_id];

                                table.row('[data-id="' +
                                    mrdo_id + '"]').data(
                                    rowData).draw();
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
