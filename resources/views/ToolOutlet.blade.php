@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            min-width: 80px;
        }

        .tipe_outlet {
            white-space: nowrap;
        }

        .select2-container--open {
            z-index: 99999;
            /* The z-index of Bootstrap modals is typically 1050 */
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">Tool Outlet</div> --}}
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('ToolOutlet.getDataByRuteId') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_awal" name="salesman_awal"
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
                            <select class="form-select form-select-sm select2-hari_awal" name="hari_awal" id="hari_awal">
                                <option value="{{ old('hari_awal', $hari_awal ?? '') }}">
                                    {{ old('hari_awal', $hari_awal ?? '') }}
                                </option>
                            </select>
                            <div class="px-1"></div>
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute_awal" name="rute_id_awal"
                                id="rute_id_awal">
                                <option value="{{ old('rute_id_awal', $rute_id_awal ?? '') }}">
                                    {{ old('rute_awal', $rute_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="rute_awal" name="rute_awal"
                                value="{{ old('rute_awal', $rute_awal ?? '') }}">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Pasar</span>
                            <select class="form-select form-select-sm select2-id_pasar_awal" name="id_pasar_awal"
                                id="id_pasar_awal">
                                <option value="{{ old('id_pasar_awal', $id_pasar_awal ?? '') }}">
                                    {{ old('pasar_awal', $pasar_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="pasar_awal" name="pasar_awal"
                                value="{{ old('pasar_awal', $pasar_awal ?? '') }}">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Depo</span>
                            <select class="form-select form-select-sm select2-iddepo_awal" name="iddepo_awal"
                                id="iddepo_awal">
                                <option value="{{ old('iddepo_awal', $iddepo_awal ?? '') }}">
                                    {{ old('depo_awal', $depo_awal ?? '') }}
                                </option>
                            </select>
                            <input type="hidden" id="depo_awal" name="depo_awal"
                                value="{{ old('depo_awal', $depo_awal ?? '') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Type</span>
                            <select class="form-select form-select-sm type fw-bold" name="type" id="type">
                                <option value="" {{ old('type', $type ?? '') == '' ? 'selected' : '' }}>All</option>
                                <option value="ro" {{ old('type', $type ?? '') == 'ro' ? 'selected' : '' }}>RO</option>
                                <option value="kandidat" {{ old('type', $type ?? '') == 'kandidat' ? 'selected' : '' }}>
                                    Kandidat
                                </option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <textarea id="kode_customer_rute" name="kode_customer_rute" class="form-control" rows="5"
                                placeholder="Kode Customer">{{ old('kode_customer', $kode_customer ?? '') }}</textarea>
                            <div class="px-1"></div>
                            <textarea id="survey_pasar_id_rute" name="survey_pasar_id_rute" class="form-control" rows="5"
                                placeholder="ID Survey Pasar">{{ old('id_survey_pasar', $id_survey_pasar ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-1 text-center my-auto">
                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm">Search <span><i
                                    class="bi bi-search"></i></span></button>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-2">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman_akhir" name="salesman_akhir"
                                id="salesman_akhir">
                            </select>
                            <input type="hidden" id="id_salesman_akhir" name="id_salesman_akhir"
                                value="{{ old('id_salesman_akhir', $id_salesman_akhir ?? '') }}">
                            <input type="hidden" id="nama_wilayah_akhir" name="nama_wilayah_akhir">
                            <input type="hidden" id="id_wilayah_akhir" name="id_wilayah_akhir">
                        </div>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text">Rute</span>
                            <select class="form-select form-select-sm select2-rute_akhir" name="rute_id_akhir"
                                id="rute_id_akhir"></select>
                            <input type="hidden" id="rute_akhir" name="rute_akhir">
                        </div>
                    </div>
                    <div class="col-lg-1 text-center my-auto">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm" id="btnPindah">Pindah <span><i
                                    class="bi bi-sign-intersection-y-fill"></i></span></button>
                    </div> --}}
                    <div class="col-lg-3 text-center my-auto">
                        {{-- <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-info my-1" id="btnPindahPasar">Pindah Pasar <i
                                class="bi bi-sign-intersection-y-fill"></i></button> --}}
                        {{-- <button type="button" class="btn btn-outline-success btn-sm my-1" id="btnPindahLokasi">Pindah Lokasi
                            <i class="bi bi-sign-intersection-y-fill"></i></button> --}}
                        {{-- <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary my-1" id="btnEditKodeOrder">Update
                            Kode Order <i class="bi bi-pen-fill"></i></button> --}}
                        {{-- <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-warning my-1" id="btnClearKodeKandidat">Clear
                                Kode Kandidat <i class="bi bi-x-square-fill"></i></button> --}}
                        {{-- <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-danger my-1" id="btnHapusRODouble">Hapus RO
                            Double <i class="bi bi-trash"></i></button> --}}
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-warning my-1"
                            id="btnHapusROBiasa">Hapus RO
                            Biasa <i class="bi bi-trash"></i></button>
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-danger my-1"
                            id="btnHapusROPermanent">Hapus
                            RO
                            Permanent <i class="bi bi-trash"></i></button>
                        {{-- <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-warning my-1" id="btnEditKodeOKAN">Edit Kode OKAN<i
                                class="bi bi-trash"></i></button> --}}
                        <div class="btn-group">
                            <button class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tipe Outlet
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">Retail</a>
                                </li>
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">Grosir</a>
                                </li>
                                <li><a class="dropdown-item btnSetTipeOutlet" href="#">NOO</a>
                                </li>
                            </ul>
                        </div>
                        <br>
                        {{-- @if (isset($salesman_awal)) --}}
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-info btnOrder">Order
                            <span> <i class="bi bi-journal-text"></i></span></button>
                        <button type="button"
                            class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary btnKandidat">Visit
                            Kandidat
                            <span> <i class="bi bi-journal-text"></i></span></button>
                        {{-- @endi f --}}
                    </div>
                </div>
            </form>

            @if (isset($data) && !empty($data))
                <div class="row py-1 px-3 my-2 mx-3 rounded text-white" style="background-color: #252B3B;">
                    <div class="col-lg-12">
                        <p class="d-inline-block p-1">Distributor : <span class="fw-bold"
                                id="nama_distributor">{{ end($data)['nama_distributor'] ?? '' }}
                                ({{ end($data)['id_distributor'] }})</span>
                        </p>
                        <p class="d-inline-block p-1">Wilayah : <span class="fw-bold"
                                id="nama_wilayah">{{ end($data)['nama_wilayah'] ?? '' }}
                                ({{ end($data)['id_wilayah'] }})</span>
                        </p>
                        <p class="d-inline-block p-1">Nama Salesman : <span class="fw-bold"
                                id="nama_salesman">{{ end($data)['salesman'] ?? '' }}</span>
                        </p>
                    </div>
                </div>
            @else
                @php
                    $data = [];
                @endphp
                <div class="row py-1 px-3 my-2 mx-3 rounded text-white" style="background-color: #252B3B;">
                    {{-- <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-info btnOrder">Order <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-warning btnKandidat">Visit Kandidat <span> <i
                                    class="bi bi-journal-text"></i></span></button>
                    </div> --}}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle myTable w-100" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Wilayah</th>
                            <th id="filter-salesman">Salesman</th>
                            <th id="filter-rute">Rute</th>
                            <th>Hari</th>
                            <th>Rute ID</th>
                            <th>ID MRDO</th>
                            <th>Survey pasar ID <button type="button"
                                    class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary" id="salinID_SP"><i
                                        class="bi bi-clipboard-fill"></i></button></th>
                            <th>ID MCO</th>
                            <th>Kode Customer <button type="button"
                                    class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary" id="salinKode"><i
                                        class="bi bi-clipboard-fill"></i></button>
                            </th>
                            <th>Nama Toko <button type="button"
                                    class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary" id="salinNamaToko"><i
                                        class="bi bi-clipboard-fill"></i></button>
                            </th>
                            <th>Alamat <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary"
                                    id="salinAlamat"><i class="bi bi-clipboard-fill"></i></button>
                            </th>
                            <th>ID Pasar</th>
                            <th>Nama pasar</th>
                            <th>Tipe Outlet</th>
                            <th>Status Reject</th>
                            <th>QR</th>
                            {{-- <th class="text-center" id="action">Action</th> --}}
                            <th class="text-center">
                                <input type="checkbox" class="btn-check check-all" id="check-all" autocomplete="off">
                                <label class="btn btn-sm rounded-3 shadow-sm btn-outline-success"
                                    for="check-all">All</label>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            <th><input type="text" class="form-control form-control-sm w-100" placeholder="Search" />
                            </th>
                            {{-- <th></th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($data as $mr)
                            @php
                                $no += 1;
                            @endphp
                            <tr class="warnaBaris" data-id="{{ $mr['mrdo_id'] }}"
                                data-rute_detail_id="{{ $mr['rute_detail_id'] }}"
                                data-rute_hari_ini="{{ $mr['rute_hari_ini'] }}">
                                <td></td>
                                <td class="nama_wilayah {{ $mr['rute_hari_ini'] == 1 ? ' text-success fw-bolder' : '' }}">
                                    {{ $mr['nama_wilayah'] }} ({{ $mr['id_wilayah'] }})</td>
                                <td
                                    class="nama_salesman {{ $mr['rute_hari_ini'] == 1 ? ' text-success fw-bolder' : '' }}">
                                    {{ $mr['salesman'] }}</td>
                                <td class="rute {{ $mr['rute_hari_ini'] == 1 ? ' text-success fw-bolder' : '' }}">
                                    {{ $mr['rute'] }}</td>
                                <td class="hari {{ $mr['rute_hari_ini'] == 1 ? ' text-success fw-bolder' : '' }}">
                                    {{ $mr['hari'] }}</td>
                                <td class="rute_id">{{ $mr['id'] }}</td>
                                <td class="id_mrdo">{{ $mr['mrdo_id'] }}</td>
                                <td class="text-success fw-bolder id_survey_pasar">{{ $mr['survey_pasar_id'] }}</td>
                                <td class="id_mco">{{ $mr['id_qr_outlet'] }}</td>
                                <td class="text-primary fw-bolder kode_customer">{{ $mr['kode_customer'] }}
                                </td>
                                <td class="nama_toko">{{ $mr['nama_toko'] }}</td>
                                <td class="alamat" id="alamat{{ $no }}">{{ $mr['alamat'] }}</td>
                                <td class="id_pasar">{{ $mr['id_pasar'] }}</td>
                                <td class="nama_pasar">{{ $mr['nama_pasar'] }}</td>
                                <td class="tipe_outlet">
                                    {{ $mr['tipe_outlet'] ?? 'RETAIL' }} - {{ $mr['location_type'] }} -
                                    {{ $mr['source_type'] }}
                                </td>
                                <td class="statusReject text-danger">
                                    @php
                                        if ($mr['visit_kandidats']) {
                                            $lastVisitKandidat = end($mr['visit_kandidats']);
                                            if (!empty($lastVisitKandidat['keterangan_visit'])) {
                                                if ($lastVisitKandidat['keterangan_visit']['tipe'] == 'REJECT') {
                                                    echo $lastVisitKandidat['keterangan_visit']['keterangan'];
                                                } else {
                                                    echo '-';
                                                }
                                            } else {
                                                echo '-';
                                            }
                                        } else {
                                            echo '-';
                                        }
                                    @endphp
                                </td>
                                <td class="barcode fw-bold">
                                    @if ($mr['verifikasi_qr'])
                                        @if ($mr['verifikasi_qr']['flag_qr'])
                                            @if ($mr['pengajuan_by_pass'])
                                                <button type="button"
                                                    class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-danger btn-block w-100 btnBarcode"
                                                    data-id_qr="{{ $mr['pengajuan_by_pass'][0]['id'] }}">QR</button>
                                            @else
                                                Belum Isi QR Bermasalah
                                            @endif
                                        @else
                                            SUDAH BYPASS
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td>
                                    <div class="row px-2 py-1">
                                        <div class="col-12 px-0">
                                            <button type="button"
                                                class="btn btn-sm rounded-3 shadow-sm p-1 btn-outline-warning btn-block w-100 btnEdit">Edit</button>
                                        </div>
                                    </div>
                                </td> --}}
                                <td class="text-center">
                                    <input type="checkbox" class="btn-check check" id="check{{ $no }}"
                                        autocomplete="off">
                                    <label class="btn btn-sm rounded-3 shadow-sm btn-outline-success"
                                        for="check{{ $no }}">Pilih</label>
                                </td>
                            </tr>
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
                        <table class="table table-sm table-light table-striped TableOrder w-100 nowrap">
                            <thead class="text-center">
                                <th>no</th>
                                <th>id</th>
                                <th>wilayah</th>
                                <th>no order</th>
                                <th>nama salesman</th>
                                <th><button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-secondary"
                                        id="salinKodeOrder"><i class="bi bi-clipboard-fill"></i></button> kode customer
                                </th>
                                <th>nama toko</th>
                                <th>id pasar</th>
                                <th>nama pasar</th>
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
                        <table class="table table-sm table-light table-striped TableKandidat w-100 nowrap">
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="saveEdit">Simpan</button>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="savePindahPasar">Simpan</button>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="savePindahLokasi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- TOAST SALIN KODE --}}
    <div class="toast-container position-fixed top-0 end-0 p-5">
        <div class="toast align-items-center text-bg-success border-0" id="toastSalin" role="success"
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

            $('.btnOrder, .btnKandidat').hide();

            // Saat select berubah
            $('#salesman_awal').on('change', function() {
                let selected = $(this).val();
                if (selected && selected.trim() !== '') {
                    $('.btnOrder, .btnKandidat').show();
                } else {
                    $('.btnOrder, .btnKandidat').hide();
                }
            });

            // Trigger saat awal jika sudah ada isi (misal edit form)
            $('#salesman_awal').trigger('change');

            // $('form').submit(function() {
            //     let salesman = $('#salesman_awal').val();
            //     let id_pasar = $('#id_pasar_awal').val();
            //     if ((salesman == '' || salesman == null) && (
            //             id_pasar == '' || id_pasar == null)) {
            //         $('#salesman_awal').get(0).setCustomValidity('Harap Isi Salesman Awal');
            //         return false;
            //     }
            // });

            // SELECT SALESMAN AWAL
            $('.select2-salesman_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getSalesman') }}",
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
                placeholder: 'Pilih Salesman',
                minimumInputLength: 3,
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
                let data = e.params.data;
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
                    delay: 250,
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
                    delay: 250,
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
                let data = e.params.data;
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
                    delay: 250,
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
                minimumInputLength: 3,
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
                let data = e.params.data;
                $('#pasar_awal').val(data.text);
            });

            // SELECT DEPO AWAL
            $('.select2-iddepo_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getWilayah') }}",
                    dataType: 'json',
                    delay: 250,
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
                placeholder: 'Pilih Depo',
                minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.id).addClass('pull-right').append($('<b>')
                        .text(' - ' + data.text));
                },
                templateSelection: function(data) {
                    return data.text;
                }
            }).on('select2:select', function(e) {
                let data = e.params.data;
                $('#depo_awal').val(data.text);
            });

            // SELECT SALESMAN AKHIR
            $('.select2-salesman_akhir').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getSalesman') }}",
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
                placeholder: 'Pilih Salesman',
                minimumInputLength: 3,
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
                let data = e.params.data;
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
                    delay: 250,
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
                let data = e.params.data;
                $('#rute_akhir').val(data.text);
            });

            // SELECT PASAR AKHIR
            $('.select2-pasar_akhir').select2({
                dropdownParent: $('#PindahPasarModal'),
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolOutlet.getPasar') }}",
                    dataType: 'json',
                    delay: 250,
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
                minimumInputLength: 3,
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
                let data = e.params.data;
                $('#nama_pasar_akhir').val(data.text);
            });

            // GET WILAYAH
            $('#editNoOrderModal').on('shown.bs.modal', function() {
                $('.select2-nama_wilayah').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#editNoOrderModal .modal-body'),
                    ajax: {
                        url: "{{ route('ToolOutlet.getWilayah') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page || 1,
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Pilih Wilayah',
                    minimumInputLength: 3,
                    allowClear: true,
                    templateResult: function(data) {
                        if (data.loading) return data.text;
                        return $('<span>').text(data.text);
                    }
                });
            });

            let table = $('.myTable').DataTable({
                dom: "<'row mx-0'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-2 filter-NamaToko'><'col-sm-12 col-md-2 filter-Alamat'><'col-sm-12 col-md-2 filter-jenis_outlet'B><'col-sm-12 col-md-2 text-right'f>>" +
                    "<'row mx-0'<'col-sm-12 p-0'tr>>" +
                    "<'row mx-0'<'col-sm-12 p-0 col-md-5'i><'col-sm-12 p-0 col-md-7'p>>",
                paging: false,
                orderCellsTop: true,
                fixedHeader: true,
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
                    "targets": [0, 17, 17],
                    "className": 'no-export'
                }],
                "order": [
                    [12, 'asc'],
                    [9, 'desc'],
                    [5, 'asc'],
                    [3, 'asc'],
                    [2, 'asc'],
                    [1, 'asc'],
                ],
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-100">
                        <option value="" selected>Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-jenis_outlet')
                        .on('change', function() {
                            let val = $(this).val();
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
                            let filterSurveyPasar = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterSurveyPasar == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(7).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                let filterRegex = '^' + filterSurveyPasar.join('$|^') + '$';
                                table.column(7).search(filterRegex, true, false).draw();
                            }
                        });

                    // FILTER KODE CUSTOMER
                    $(`<textarea id="filterKodeCustomer" class="form-control" rows="3" placeholder="Filter Kode Customer"></textarea>`)
                        .appendTo('.filter-KodeCustomer')
                        .on('input', function() {
                            let filterKodeCustomer = $(this).val().trim().split('\n').map(
                                function(
                                    item) {
                                    return item.trim();
                                });
                            if (filterKodeCustomer == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(9).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                let filterRegex = '^' + filterKodeCustomer.join('$|^') + '$';
                                table.column(9).search(filterRegex, true, false).draw();
                            }
                        });

                    // FILTER NAMA TOKO
                    $(`<textarea id="filterNamaToko" class="form-control" rows="3" placeholder="Filter Nama Toko"></textarea>`)
                        .appendTo('.filter-NamaToko')
                        .on('input', function() {
                            let filterNamaToko = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterNamaToko == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(10).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                let filterRegex = '^' + filterNamaToko.join('$|^') + '$';
                                table.column(10).search(filterRegex, true, false).draw();
                            }
                        });
                    // FILTER ALAMAT
                    $(`<textarea id="filterAlamat" class="form-control" rows="3" placeholder="Filter Alamat"></textarea>`)
                        .appendTo('.filter-Alamat')
                        .on('input', function() {
                            let filterAlamat = $(this).val().trim().split('\n').map(function(
                                item) {
                                return item.trim();
                            });

                            if (filterAlamat == '') {
                                // Jika filter kosong, hapus pencarian pada kolom dan tampilkan semua data
                                table.column(11).search('').draw();
                            } else {
                                // Jika filter tidak kosong, lakukan pencarian pada kolom
                                let filterRegex = '^' + filterAlamat.join('$|^') + '$';
                                table.column(11).search(filterRegex, true, false).draw();
                            }
                        });

                    // let salesmanList = this.api().column(2).data().unique().sort();
                    // let salesmanSelect = $(
                    //         '<select class="w-100 form-select form-select-sm"><option value="" selected>All</option></select>'
                    //     )
                    //     .appendTo('#filter-salesman')
                    //     .on('change', function() {
                    //         let val = $.fn.dataTable.util.escapeRegex($(this).val());
                    //         table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
                    //     });
                    // salesmanList.each(function(d, j) {
                    //     salesmanSelect.append('<option value="' + d + '">' + d + '</option>');
                    // });

                    // let ruteList = this.api().column(3).data().unique().sort();
                    // let ruteSelect = $(
                    //         '<select class="w-100 form-select form-select-sm" selected><option value="">All</option></select>'
                    //     )
                    //     .appendTo('#filter-rute')
                    //     .on('change', function() {
                    //         let val = $.fn.dataTable.util.escapeRegex($(this).val());
                    //         table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
                    //     });
                    // ruteList.each(function(d, j) {
                    //     ruteSelect.append('<option value="' + d + '">' + d + '</option>');
                    // });
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

            $('.myTable thead tr:eq(1) th').each(function(i) {
                // let title = $(this).text();
                // $(this).html('<input type="text" placeholder="Search ' + title + '" />');

                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            $('#salinKode').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
                let filteredData = table.column(9, {
                    search: 'applied'
                }).data().toArray();

                let textToCopy = filteredData.join('\n');
                copyToClipboard(textToCopy);
            });
            $('#salinNamaToko').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
                let filteredData = table.column(10, {
                    search: 'applied'
                }).data().toArray();

                let textToCopy = filteredData.join('\n');
                copyToClipboard(textToCopy);
            });
            $('#salinAlamat').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
                let filteredData = table.column(11, {
                    search: 'applied'
                }).data().toArray();

                let textToCopy = filteredData.join('\n');
                copyToClipboard(textToCopy);
            });
            $('#salinID_SP').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
                let filteredData = table.column(7, {
                    search: 'applied'
                }).data().toArray();

                let textToCopy = filteredData.join('\n');
                copyToClipboard(textToCopy);
            });

            $('.check-all').click(function(e) {
                $('.check').prop('checked', this.checked);
            });

            $('.check').click(function(e) {
                if ($('.check:checked').length == $('.check').length) {
                    $('.check-all').prop('checked', true);
                } else {
                    $('.check-all').prop('checked', false);
                }
            });

            let TableOrder;
            $(document).on('click', ".btnOrder", function() {
                if (!TableOrder) {
                    TableOrder = $('.TableOrder').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row mx-0'<'col-sm-12 p-0 col-md-2'l><'col-sm-12 p-0 col-md-5'B><'col-sm-12 p-0 col-md-5 text-right'f >> " +
                            "<'row mx-0'<'col-sm-12 p-0'tr>>" +
                            "<'row mx-0'<'col-sm-12 p-0 col-md-5'i><'col-sm-12 p-0 col-md-7'p>>",
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
                                d.id_salesman = $('#id_salesman_awal').val();
                                d.tgl_transaksi = $('#tgl_transaksi')
                                    .val(); // ambil nilai input field id_transaksi
                            },
                        },
                        order: [
                            [10, 'asc'],
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
                                data: 'id_pasar',
                                name: 'id_pasar',
                                className: 'text-primary'
                            },
                            {
                                data: 'nama_pasar',
                                name: 'nama_pasar'
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
            $('#salinKodeOrder').click(function(e) {
                // Mengambil data kolom dengan filter yang aktif
                e.stopPropagation();
                let filteredData = TableOrder.column(5, {
                    search: 'applied'
                }).data().toArray();

                let textToCopy = filteredData.join('\n');

                copyToClipboard(textToCopy);

            });

            function numberWithCommas(x) {
                let parts = x.toFixed(3).toString().split(".");
                let integerPart = parts[0];
                let decimalPart = parts[1];

                integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                let formattedNumber = integerPart + "," + decimalPart;

                return formattedNumber;
            }

            // TABLE KANDIDAT
            let TableKandidat;
            $(document).on('click', ".btnKandidat", function() {
                if (!TableKandidat) {
                    TableKandidat = $('.TableKandidat').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: "<'row mx-0'<'col-sm-12 p-0 col-md-2'l><'col-sm-12 p-0 col-md-5'B><'col-sm-12 p-0 col-md-5 text-right'f >> " +
                            "<'row mx-0'<'col-sm-12 p-0'tr>>" +
                            "<'row mx-0'<'col-sm-12 p-0 col-md-5'i><'col-sm-12 p-0 col-md-7'p>>",
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
                                d.id_salesman = $('#id_salesman_awal').val();
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

            //     let selectedRows = [];

            //     let rute_id_akhir = $('#rute_id_akhir').val();
            //     $('.check:checked').each(function() {
            //         let id = $(this).closest('tr').find('.id_mrdo').text().trim();
            //         let id_pasar_awal = $(this).closest('tr').find('.id_pasar').text().trim();
            //         let id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
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

            //         let selectedRows = [];

            //         $('.check:checked').each(function() {
            //             let id = $(this).closest('tr').data('id');
            //             let id_mco = $(this).closest('tr').data('id_mco');
            //             let id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
            //             let rute_id_awal = $(this).closest('tr').data('rute_id_awal');
            //             let id_pasar_akhir = $('#id_pasar_akhir').val();
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

                let salesman_awal = $('#salesman_awal').val();
                let salesman_akhir = $('#salesman_akhir').val();
                let id_salesman_akhir = $('#id_salesman_akhir').val();
                let hari_akhir = $('#rute_id_akhir').text().split(' ')[0].trim();
                let rute_akhir = $('#rute_akhir').val();
                let rute_id_akhir = $('#rute_id_akhir').val();
                let nama_wilayah_akhir = $('#nama_wilayah_akhir').val();
                let id_wilayah_akhir = $('#id_wilayah_akhir').val();
                let selectedRows = [];

                if (rute_id_akhir === '' || rute_id_akhir == null) {
                    $('#rute_id_akhir').get(0).setCustomValidity('Harap isi Rute tujuan');
                    $('#rute_id_akhir').get(0).reportValidity(); // Menampilkan pesan kesalahan
                    return;
                }

                $('.check:checked').each(function(index) {
                    let id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                    let rute_id = $(this).closest('tr').find('.rute_id').text().trim();
                    let rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                    let id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                    let id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text()
                        .trim();
                    let kode_customer = $(this).closest('tr').find('.kode_customer').text()
                        .trim();
                    let wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim()
                        .replace(
                            /\s*\([^)]*\)$/, '');
                    let location_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                        '-')[1];
                    let toko = $(this).closest('tr').find('.nama_toko').text().trim();

                    let dataObject = {};
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
                    url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/pindahoutlet",
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
                                //     let row = $(this).closest('tr');
                                //     table.row(row).remove().draw();
                                // } else {
                                let mrdo_id = $(this).closest(
                                        'tr').find('.id_mrdo')
                                    .text().trim();

                                let rowData = table.row(
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

                    let selectedRows = [];
                    let valid = true;
                    $('.check:checked').each(function(index) {
                        let id_distributor = $('#nama_distributor').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        let id_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text()
                            .trim()
                            .match(/\(([^()]+)\)[^(]*$/)[1];
                        let id_survey_pasar = $(this).closest('tr').find(
                                '.id_survey_pasar')
                            .text().trim();
                        let id_qr_outlet = $(this).closest('tr').find('.id_mco').text()
                            .trim();
                        let mrdo_id = $(this).closest('tr').find('.id_mrdo').text()
                            .trim();
                        let rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                        let id = $(this).closest('tr').find('.rute_id').text().trim();
                        let rute = $(this).closest('tr').find('.rute').text().trim();
                        let hari = $(this).closest('tr').find('.hari').text().trim();
                        let nama_toko = $(this).closest('tr').find('.nama_toko').text()
                            .trim();
                        let alamat = $(this).closest('tr').find('.alamat').text() ?? '';
                        let kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        let nama_pasar = $(this).closest('tr').find('.nama_pasar')
                            .text().trim();
                        let nama_distributor = $('#nama_distributor').text().replace(
                            /\s*\([^)]*\)$/, '');
                        let nama_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text().trim().replace(/\s*\([^)]*\)$/, '');
                        let salesman = $('#salesman_awal').val();
                        let id_pasar = $(this).closest('tr').find('.id_pasar').text()
                            .trim();
                        let location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split('-')[1].trim();
                        let pasar = $(this).closest('tr').find('.tipe_outlet').text()
                            .split('-')[1].trim().toUpperCase();
                        if (pasar == 'PASAR') {
                            valid = confirm("LOKASI PASAR : " + nama_toko + " - " +
                                kode_customer);
                        }
                        if (!valid) {
                            return false;
                        }

                        let id_pasar_akhir = $('#pasar_akhir').val();

                        let dataObject = {};
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

                        let data = [];
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
                            url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/saveeditcustomer",
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

                                let id_pasar_akhir = $('#pasar_akhir')
                                    .val();
                                let nama_pasar_akhir = $(
                                    '#nama_pasar_akhir').val();

                                $('.check:checked').each(function(index) {
                                    let mrdo_id = $(this).closest(
                                            'tr').find('.id_mrdo')
                                        .text().trim();

                                    let rowData = table.row(
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

                    let selectedRows = [];
                    let valid = true;
                    $('.check:checked').each(function(index) {
                        let id_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text()
                            .trim()
                            .match(/\(([^()]+)\)[^(]*$/)[1];
                        let id_distributor = $('#nama_distributor').text().match(
                            /\(([^()]+)\)[^(]*$/)[1];
                        let id_survey_pasar = $(this).closest('tr').find(
                                '.id_survey_pasar')
                            .text().trim();
                        let id_qr_outlet = $(this).closest('tr').find('.id_mco').text()
                            .trim();
                        let mrdo_id = $(this).closest('tr').find('.id_mrdo').text()
                            .trim();
                        let rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                        let id = $(this).closest('tr').find('.rute_id').text().trim();
                        let rute = $(this).closest('tr').find('.rute').text().trim();
                        let hari = $(this).closest('tr').find('.hari').text().trim();
                        let nama_toko = $(this).closest('tr').find('.nama_toko').text()
                            .trim();
                        let alamat = $(this).closest('tr').find('.alamat').text() ?? '';
                        let kode_customer = $(this).closest('tr').find('.kode_customer')
                            .text().trim();
                        let nama_pasar = $(this).closest('tr').find('.nama_pasar')
                            .text().trim();
                        let nama_distributor = $('#nama_distributor').text().replace(
                            /\s*\([^)]*\)$/, '');
                        let nama_wilayah = $(this).closest('tr').find('.nama_wilayah')
                            .text().trim().replace(/\s*\([^)]*\)$/, '');
                        let salesman = $('#salesman_awal').val();
                        let id_pasar = $(this).closest('tr').find('.id_pasar').text()
                            .trim();
                        let location_type = $(this).closest('tr').find('.tipe_outlet')
                            .text().split('-')[1].trim();
                        let source_type = $(this).closest('tr').find('.tipe_outlet')
                            .text()
                            .split('-')[2].trim();
                        // if (source_type == 'MAS') {
                        //     alert("Source Type MAS : " + nama_toko + " - " + kode_customer);
                        //     valid = false;
                        //     $('#PindahLokasiModal').modal('hide');
                        //     return false;
                        // }

                        let lokasi = $('#lokasi').val();

                        let dataObject = {};
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

                        let data = [];
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
                            url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/saveeditcustomer",
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

                                    let lokasi = $('#lokasi').val();
                                    $('.check:checked').each(function(index) {
                                        let mrdo_id = $(this).closest(
                                                'tr').find('.id_mrdo')
                                            .text().trim();
                                        let tipe_outlet = $(this)
                                            .closest('tr').find(
                                                '.tipe_outlet').text()
                                            .trim();

                                        let tipe_outlet_parts =
                                            tipe_outlet.split('-');
                                        tipe_outlet_parts[1] = lokasi;
                                        let tipe_outlet_modified =
                                            tipe_outlet_parts.join(
                                                ' - ');

                                        let rowData = table.row(
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
                let nama_toko = $(this).closest('tr').find('.nama_toko');
                let alamat = $(this).closest('tr').find('.alamat');
                let kode_customer = $(this).closest('tr').find('.kode_customer');

                $('#alamat-baru').val(alamat.text().trim() ?? "");
                $('#nama_toko-baru').val(nama_toko.text().trim());
                $('#kode_customer-baru').val(kode_customer.text().trim());

                // Tampilkan modal edit
                $('#editModal').modal('show');

                let selectedRows = [];
                let valid = true;

                let id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().match(
                    /\(([^()]+)\)[^(]*$/)[1];
                let id_distributor = $('#nama_distributor').text().match(
                    /\(([^()]+)\)[^(]*$/)[1];
                let id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text().trim();
                let id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
                let mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                let rute_detail_id = $(this).closest('tr').data('rute_detail_id');
                let id = $(this).closest('tr').find('.rute_id').text().trim();
                let rute = $(this).closest('tr').find('.rute').text().trim();
                let hari = $(this).closest('tr').find('.hari').text().trim();
                let nama_wilayah = $(this).closest('tr').find('.nama_wilayah').text().trim().replace(
                    /\s*\([^)]*\)$/, '');
                let nama_pasar = $(this).closest('tr').find('.nama_pasar')
                    .text().trim();
                let nama_distributor = $('#nama_distributor').text().replace(
                    /\s*\([^)]*\)$/, '');
                let salesman = $('#salesman_awal').val();
                let id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
                let location_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[1]
                    .trim();
                let source_type = $(this).closest('tr').find('.tipe_outlet').text().split('-')[2].trim();

                let dataObject = {};
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
                    let nama_toko_akhir = $('#nama_toko-baru').val();
                    let alamat_akhir = $('#alamat-baru').val();
                    let kode_customer_akhir = $('#kode_customer-baru').val();

                    let data = [];
                    data.push(kode_customer_akhir);
                    data.push(nama_toko_akhir);
                    data.push(alamat_akhir);
                    data.push(location_type);
                    data.push(id_pasar);
                    data[5] = dataObject;
                    selectedRows.push(data);

                    $.ajax({
                        type: 'post',
                        url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/saveeditcustomer",
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

                                let rowData = table.row('[data-id="' +
                                    mrdo_id +
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

            // // SET RETAIL/GROSIR ALL
            // $(document).on('click', ".btnSetTipeOutlet", function(e) {
            //     e.preventDefault();
            //     let buttonValue = $(this).text().trim();

            //     let selectedRows = [];

            //     $('.check:checked').each(function(index) {
            //         let id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
            //         let rute_id = $(this).closest('tr').find('.rute_id').text().trim();
            //         let rute_detail_id = $(this).closest('tr').data('rute_detail_id');
            //         let id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
            //         let id_survey_pasar = $(this).closest('tr').find('.id_survey_pasar').text()
            //             .trim();
            //         let id_qr_outlet = $(this).closest('tr').find('.id_mco').text().trim();
            //         let kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
            //         let id_wilayah = $(this).closest('tr').find('.nama_wilayah').text().match(
            //             /\(([^()]+)\)[^(]*$/)[1].trim();
            //         let dataObject = {};
            //         dataObject['id_outlet'] = id_mrdo;
            //         dataObject['rute_id'] = rute_id;
            //         dataObject['rute_detail_id'] = rute_detail_id;
            //         dataObject['id_pasar'] = id_pasar;
            //         dataObject['survey_pasar'] = id_survey_pasar;
            //         dataObject['id_qr_outlet'] = id_qr_outlet;
            //         dataObject['kode_customer'] = kode_customer;
            //         dataObject['id_wilayah'] = id_wilayah;

            //         selectedRows.push(dataObject);
            //     });

            //     $.ajax({
            //         type: 'post',
            //         url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/settipeoutlet",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             data: selectedRows,
            //             type: buttonValue
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             if (response.is_valid) {
            //                 $('#successModal').modal('show');
            //                 $('.check:checked').each(function(index) {
            //                     let mrdo_id = $(this).closest(
            //                             'tr').find('.id_mrdo')
            //                         .text().trim();
            //                     let tipe_outlet = $(this).closest('tr').find(
            //                         '.tipe_outlet').text().trim();

            //                     let tipe = buttonValue;
            //                     if (buttonValue == "Grosir") {
            //                         tipe = "TPOUT_WHSL";
            //                     } else if (buttonValue == "NOO") {
            //                         tipe = "TPOUT_NOO";
            //                     }
            //                     let tipe_outlet_parts = tipe_outlet.split('-');
            //                     tipe_outlet_parts[0] = tipe;
            //                     let tipe_outlet_modified = tipe_outlet_parts.join(
            //                         ' - ');

            //                     let rowData = table.row(
            //                         '[data-id="' + mrdo_id +
            //                         '"]').data();

            //                     rowData[14] = tipe_outlet_modified;
            //                     rowData[15] = "-";

            //                     table.row('[data-id="' +
            //                         mrdo_id + '"]').data(
            //                         rowData).draw();
            //                 });
            //                 setTimeout(function() {
            //                     $('#successModal').modal('hide');
            //                     // location.reload();
            //                 }, 1000);
            //             } else {
            //                 $('#errorModal #message').text(response.message);
            //                 $('#errorModal').modal('show');
            //             }
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

            // SET RETAIL/GROSIR/NOO ALL
            $(document).on('click', ".btnSetTipeOutlet", function(e) {
                e.preventDefault();
                let buttonValue = $(this).text().trim();

                // Fungsi untuk mengecek apakah order sudah ada hari ini
                function cekOrderAjax(id_survey_pasar) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            type: 'post',
                            url: "{{ route('KodeCustomer.cekOrder') }}",
                            dataType: 'json',
                            data: {
                                id_survey_pasar: id_survey_pasar
                            },
                            success: function(response) {
                                resolve(response);
                            },
                            error: function(xhr) {
                                reject(xhr.responseJSON?.message ||
                                    "Terjadi kesalahan saat mengecek order.");
                            }
                        });
                    });
                }

                // Fungsi umum untuk mengubah rute (tanpa loading individual)
                function updateRute(url, mrdo_id, iddepo, tipe_baru, tipe_outlet) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            data: {
                                mrdo_id: mrdo_id,
                                iddepo: iddepo
                            },
                            success: function(response) {
                                if (response.is_valid) {
                                    updateTipeOutlet(mrdo_id, tipe_outlet, tipe_baru);
                                }
                                resolve(response);
                            },
                            error: function(xhr) {
                                reject(xhr.responseJSON?.message ||
                                    "Gagal memproses permintaan.");
                            }
                        });
                    });
                }

                // Fungsi untuk menangani perubahan tipe outlet di tabel
                function updateTipeOutlet(mrdo_id, tipe_outlet, tipe_baru) {
                    let tipe_outlet_parts = tipe_outlet.split('-');
                    tipe_outlet_parts[0] = tipe_baru;
                    let tipe_outlet_modified = tipe_outlet_parts.join(' - ');

                    let rowData = table.row(`[data-id="${mrdo_id}"]`).data();
                    rowData[14] = tipe_outlet_modified;

                    table.row(`[data-id="${mrdo_id}"]`).data(rowData).draw();
                }

                async function processData() {
                    // Tampilkan loading indicator global satu kali
                    $('.loading-overlay').show();

                    // Buat array promise untuk setiap data yang dicek
                    let promises = $('.check:checked').map(function() {
                        let $tr = $(this).closest('tr');
                        let rute_hari_ini = $tr.data('rute_hari_ini');
                        let id_survey_pasar = $tr.find('.id_survey_pasar').text().trim();
                        let mrdo_id = $tr.find('.id_mrdo').text().trim();
                        let iddepo = $tr.find('.nama_wilayah').text().match(
                            /\(([^()]+)\)[^(]*$/)[1].trim();
                        let kode_customer = $tr.find('.kode_customer').text().trim();
                        let nama_toko = $tr.find('.nama_toko').text().trim();
                        let tipe_outlet = $tr.find('.tipe_outlet').text().trim();

                        return (async function() {
                            try {
                                if (buttonValue === "Grosir") {
                                    let response = await cekOrderAjax(
                                        id_survey_pasar);
                                    if (rute_hari_ini && !response.is_valid) {
                                        // Jika data kunjungan belum masuk
                                        return `${kode_customer} - ${nama_toko}: Data kunjungan belum masuk ke sistem, jika sudah dikunjungi, silakan upload ulang dahulu datanya`;
                                    }
                                    let updateResponse = await updateRute(
                                        "https://sales.motasaindonesia.co.id/api/tool/rute/setGrosir",
                                        mrdo_id, iddepo, "TPOUT_WHSL",
                                        tipe_outlet
                                    );
                                    if (rute_hari_ini && !updateResponse.is_valid) {
                                        // Jika gagal set Grosir, ubah ke NOO dianggap sukses (tidak menghasilkan error)
                                        await updateRute(
                                            "https://sales.motasaindonesia.co.id/api/tool/rute/setNoo",
                                            mrdo_id, iddepo, "TPOUT_NOO",
                                            tipe_outlet
                                        );
                                        return ""; // Tidak mengembalikan pesan error
                                    } else if (!updateResponse.is_valid) {
                                        // Jika tidak valid, coba set Retail dan catat error
                                        await updateRute(
                                            "https://sales.motasaindonesia.co.id/api/tool/rute/setRetail",
                                            mrdo_id, iddepo, "RETAIL",
                                            tipe_outlet
                                        );
                                        return `${kode_customer} - ${nama_toko}: outlet belum memenuhi kriteria`;
                                    }
                                    return "";
                                } else if (buttonValue === "Retail") {
                                    let updateResponse = await updateRute(
                                        "https://sales.motasaindonesia.co.id/api/tool/rute/setRetail",
                                        mrdo_id, iddepo, "Retail", tipe_outlet
                                    );
                                    if (!updateResponse.is_valid) {
                                        return `${kode_customer} - ${nama_toko}: Gagal set Retail`;
                                    }
                                    return "";
                                } else if (buttonValue === "NOO") {
                                    let updateResponse = await updateRute(
                                        "https://sales.motasaindonesia.co.id/api/tool/rute/setNoo",
                                        mrdo_id, iddepo, "TPOUT_NOO",
                                        tipe_outlet
                                    );
                                    if (!updateResponse.is_valid) {
                                        return `${kode_customer} - ${nama_toko}: Gagal set NOO`;
                                    }
                                    return "";
                                }
                            } catch (error) {
                                console.error(error);
                                return `${kode_customer} - ${nama_toko}: Error - ${error}`;
                            }
                        })();
                    }).get();

                    // Tunggu semua proses selesai
                    let results = await Promise.all(promises);

                    // Filter hanya pesan error (string yang tidak kosong)
                    let errorMessages = results.filter(msg => msg.trim() !== "");

                    let finalMessage = "Sudah diproses, kecuali \n";
                    if (errorMessages.length > 0) {
                        // Jika ada outlet yang gagal, tampilkan pesan error akumulasi
                        finalMessage += errorMessages.join("\n");
                        copyToClipboard(finalMessage);
                        $('.loading-overlay').hide();
                        $('#errorModal #message').text(finalMessage);
                        $('#errorModal').modal('show');
                    } else {
                        // Jika semua outlet sukses, tampilkan pesan umum
                        finalMessage = "Sudah diproses | Segera diinput / direvisi";
                        copyToClipboard(finalMessage);
                        $('.loading-overlay').hide();
                        $('#successModal #message').text(finalMessage);
                        $('#successModal').modal('show');
                    }
                }

                // Panggil fungsi untuk memproses data
                processData();
            });

            // // SET RETAIL / GROSIR
            // $(document).on('click', '.btnSetRetail, .btnSetGrosir, .btnSetNOO', function() {
            //     let id_mrdo = $(this).data('id_mrdo');
            //     let id_mco = $(this).data('id_mco');
            //     let set = $(this).data('set');
            //     let tipe_outlet = $(this).closest('tr').find('.tipe_outlet');

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
            //             let tipe_outlet_all = tipe_outlet.text().trim();
            //             let tipe_outlet_parts = tipe_outlet_all.split('-');
            //             tipe_outlet_parts[0] = response.tipe_outlet ?? "RETAIL";
            //             let tipe_outlet_modified = tipe_outlet_parts.join(' - ');
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

            // // CLEAR KODE KANDIDAT
            // $('#btnClearKodeKandidat').off('click').on('click', function(e) {
            //     e.preventDefault();
            //     let salesman = $('#salesman_awal').val();
            //     $.ajax({
            //         type: 'post',
            //         url: "{{ route('ToolOutlet.clear_kode_kandidat') }}",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             salesman: salesman
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             $('#successModal #message').text(response.message);
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

            // DELETE RO DOUBLE
            $('#btnHapusRODouble').click(function(e) {
                e.preventDefault();
                let selectedRows = [];
                let codeCountMap = {}; // Objek untuk melacak kemunculan kode customer
                $('.kode_customer').each(function() {
                    let kode_customer = $(this).text().trim();
                    let id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
                    let source_type = $(this).closest('tr').find('.tipe_outlet').text().split(
                        '-')[
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
                let mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                let dataToEncrypt = [{
                    id: $(this).data('id_qr')
                }];
                let jsonData = JSON.stringify(dataToEncrypt);
                let encryptedData = btoa(jsonData);

                $.ajax({
                    type: 'POST',
                    url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/bypassqr",
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

                        let rowData = table.row(
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

            // HAPUS OUTLET BIASA
            $('#btnHapusROBiasa').on('click', function(e) {
                if ($('.check:checked').length === 0) {
                    $('#errorModal #message').text("Belum ada data yang dipilih");
                    $('#errorModal').modal('show');
                } else {
                    let keterangan = prompt("Isi Keterangan", "");
                    if (!keterangan) {
                        $('#errorModal').modal('show');
                        return;
                    }
                    let completedRequests = 0;
                    $('.check:checked').each(function(index) {
                        let mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                        let iddepo = $(this).closest('tr').find('.nama_wilayah').text().match(
                            /\(([^()]+)\)[^(]*$/)[1].trim();
                        let id_distributor = $(this).closest('tr').data('id_distributor');
                        let kode_customer = $(this).closest('tr').find('.kode_customer').text()
                            .trim();
                        let tipe = "";

                        $.ajax({
                            type: 'POST',
                            url: "https://sales.motasaindonesia.co.id/api/tool/rute/hapusOutlet",
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
                                completedRequests++;
                                if (completedRequests === $('.check:checked').length) {
                                    $('.loading-overlay').hide();
                                    $('#successModal').modal('show');
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('.loading-overlay').hide();
                                console.error(error);
                                $('#errorModal').modal('show');
                            },
                            // complete: function() {
                            //     $('.loading-overlay').hide();
                            // }
                        });
                    });
                }
            });

            // HAPUS OUTLET PERMANEN
            $('#btnHapusROPermanent').on('click', function(e) {
                if ($('.check:checked').length === 0) {
                    $('#errorModal #message').text("Belum ada data yang dipilih");
                    $('#errorModal').modal('show');
                } else {
                    let keterangan = prompt("Isi Keterangan", "");
                    if (!keterangan) {
                        $('#errorModal').modal('show');
                        return;
                    }
                    let completedRequests = 0;
                    $('.check:checked').each(function(index) {
                        let mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                        let iddepo = $(this).closest('tr').find('.nama_wilayah').text().match(
                            /\(([^()]+)\)[^(]*$/)[1].trim();
                        let id_distributor = $(this).closest('tr').data('id_distributor');
                        let kode_customer = $(this).closest('tr').find('.kode_customer').text()
                            .trim();
                        let tipe = "permanent";

                        $.ajax({
                            type: 'POST',
                            url: "https://sales.motasaindonesia.co.id/api/tool/rute/hapusOutlet",
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
                                completedRequests++;
                                if (completedRequests === $('.check:checked').length) {
                                    $('.loading-overlay').hide();
                                    $('#successModal').modal('show');
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('.loading-overlay').hide();
                                console.error(error);
                                $('#errorModal').modal('show');
                            },
                            // complete: function() {
                            //     $('.loading-overlay').hide();
                            // }
                        });
                    });
                }
            });

            // HAPUS OUTLET PERMANEN
            $('#btnEditKodeOKAN').on('click', function(e) {

                let completedRequests = 0;
                $('.check:checked').each(function(index) {
                    let mrdo_id = $(this).closest('tr').find('.id_mrdo').text().trim();
                    let rute_id = $(this).closest('tr').find('.rute_id').text().trim();
                    let kode_customer_old = $(this).closest('tr').find('.kode_customer').text()
                        .trim();
                    let kode_customer_new = 0;
                    let change_mainroad = "pasar";

                    $.ajax({
                        type: 'POST',
                        url: "https://sales.motasaindonesia.co.id/api/tool/rute/updateKodeOutlet",
                        dataType: 'json',
                        encode: true,
                        data: {
                            mrdo_id: mrdo_id,
                            rute_id: rute_id,
                            kode_customer_old: kode_customer_old,
                            kode_customer_new: kode_customer_new,
                            change_mainroad: change_mainroad,
                        },
                        beforeSend: function() {
                            $('.loading-overlay').show();
                        },
                        success: function(response) {
                            completedRequests++;
                            if (completedRequests === $('.check:checked').length) {
                                $('.loading-overlay').hide();
                                $('#successModal').modal('show');
                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.loading-overlay').hide();
                            console.error(error);
                            $('#errorModal').modal('show');
                        },
                        // complete: function() {
                        //     $('.loading-overlay').hide();
                        // }
                    });
                });

            });

            // cek_rute_aktif();
            // // CEK RUTE AKTIF
            function cek_rute_aktif() {
                let salesman_awal = $('#salesman_awal').val();
                let id_salesman_awal = $('#id_salesman_awal').val();
                let iddepo = $('#id_wilayah_awal').val();
                let id_pasar = $('#id_pasar_awal').val();
                let rute_awal = $('#rute_awal').val();
                let hari = rute_awal ? rute_awal.split(' ')[0].trim() : '';
                let periodik = (rute_awal && rute_awal.split(' ')[1]) ? rute_awal.split(' ')[1].trim() :
                    '';

                $.ajax({
                    type: 'post',
                    url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/getData",
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
                        let dataRuteID = {};
                        let dataMRDO_ID = {};
                        $.each(response.data, function(index, item) {
                            let id = item.id;
                            let mrdo_id = item.mrdo_id;
                            if (!dataRuteID[id] && item.rute_hari_ini == 1) {
                                dataRuteID[id] = id;
                            }
                            // if (!dataMRDO_ID[mrdo_id] && item.visit_kandidats[0]) {
                            //     if (item.visit_kandidats[item.visit_kandidats.length - 1]
                            //         .keterangan_visit['tipe'] ==
                            //         "REJECT") {
                            //         dataMRDO_ID[mrdo_id] = item.visit_kandidats[item
                            //                 .visit_kandidats.length - 1]
                            //             .keterangan_visit[
                            //                 'keterangan'];
                            //     }
                            // }
                        });
                        $('.warnaBaris').each(function() {
                            let ruteId = $(this).find('.rute_id').text().trim();
                            let mrdo_id = $(this).find('.id_mrdo').text().trim();
                            let nama_wilayah = $(this).find('.nama_wilayah');
                            let nama_salesman = $(this).find('.nama_salesman');
                            let rute = $(this).find('.rute');
                            let hari = $(this).find('.hari');
                            // Mencocokkan ruteId dengan dataRuteID
                            if (dataRuteID[ruteId]) {
                                nama_wilayah.addClass(
                                    'text-success fw-bolder shadow-sm');
                                nama_salesman.addClass(
                                    'text-success fw-bolder shadow-sm');
                                rute.addClass('text-success fw-bolder shadow-sm');
                                hari.addClass('text-success fw-bolder shadow-sm');
                            } else {
                                nama_wilayah.removeClass(
                                    'text-success fw-bolder shadow-sm');
                                nama_salesman.removeClass(
                                    'text-success fw-bolder shadow-sm');
                                rute.removeClass(
                                    'text-success fw-bolder shadow-sm');
                                hari.removeClass(
                                    'text-success fw-bolder shadow-sm');
                            }
                            // if (dataMRDO_ID[mrdo_id]) {
                            //     let rowData = table.row(
                            //         '[data-id="' + mrdo_id +
                            //         '"]').data();

                            //     rowData[16] = dataMRDO_ID[mrdo_id];

                            //     table.row('[data-id="' +
                            //         mrdo_id + '"]').data(
                            //         rowData).draw();
                            // }

                        });
                    },
                    error: function(xhr, status, error) {},
                    complete: function() {}
                });
            }
        });

        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                // Opsi 1: Menggunakan Clipboard API jika tersedia
                return navigator.clipboard.writeText(text)
                    .then(() => {
                        $('#toastSalin').show();
                        setTimeout(function() {
                            $('#toastSalin').hide();
                        }, 2000);
                    })
                    .catch(err => {
                        console.error("Gagal menyalin teks dengan Clipboard API:", err);
                        fallbackCopy(text);
                    });
            } else {
                // Opsi 2: Fallback ke execCommand
                fallbackCopy(text);
            }
        }

        // Fungsi fallback menggunakan execCommand
        function fallbackCopy(text) {
            const textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();

            try {
                if (document.execCommand("copy")) {
                    $('#toastSalin').show();
                    setTimeout(function() {
                        $('#toastSalin').hide();
                    }, 2000);
                } else {
                    console.error("Gagal menyalin teks dengan execCommand.");
                }
            } catch (err) {
                console.error("Error saat menyalin teks:", err);
            }

            document.body.removeChild(textarea);
        }
    </script>
@endsection
