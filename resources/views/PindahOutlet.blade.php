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
            <form class="form" method="POST" action="{{ route('PindahOutlet.getDataByRuteId') }}">
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
                    @endif
                    {{-- <h3>Hasil Pencarian:</h3> --}}
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
                            <p class="d-inline-block pe-3">Rute : <span class="fw-bold"
                                    id="nama-salesman">{{ $data->first()->rute ?? '' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-sm table-dark table-striped table-bordered align-middle myTable" id="myTable">
                    <thead class="text-center">
                        <th>no</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>rute detail id</th>
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
                        <th class="text-center">
                            <input type="checkbox" class="btn-check check-all" id="check-all" autocomplete="off">
                            <label class="btn btn-outline-success" for="check-all">All</label>
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
                                        data-id_survey_pasar="{{ $mrdo->survey_pasar_id }}">
                                        <td></td>
                                        <td class="rute">{{ $mr->rute }}</td>
                                        <td>{{ $mr->hari }}</td>
                                        <td class="rute_id">{{ $mrdo->rute_id }}</td>
                                        <td>{{ $mrdo->rute_detail_id }}</td>
                                        <td>{{ $mrdo->survey_pasar_id }}</td>
                                        <td class="text-primary fw-bold" id="kode{{ $no }}">
                                            {{ $mco->kode_customer }}
                                        </td>
                                        <td>{{ $mrdo->nama_toko }}</td>
                                        <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                        <td class="id_qr_outlet">{{ $mco->id }}</td>
                                        <td>{{ $mrdo->mrd->id_pasar ?? '' }}</td>
                                        <td>{{ $mrdo->mrd->nama_pasar ?? '' }}</td>
                                        <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                        <td id="tipe_outlet{{ $no }}">
                                            {{ $mrdo->tipe_outlet ?? 'RETAIL' }}
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="btn-check check" id="check{{ $no }}"
                                                autocomplete="off">
                                            <label class="btn btn-outline-success"
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
                $('.select2-rute_awal').val(null).trigger('change');
            });

            $('.select2-rute_awal').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('PindahOutlet.getRute') }}",
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
                $('.select2-rute_akhir').val(null).trigger('change');
            });

            $('.select2-rute_akhir').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('PindahOutlet.getRute') }}",
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
                    url: "{{ route('PindahOutlet.getPasar') }}",
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
                "dom": "<'row'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-3 filter-NamaToko'><'col-sm-12 col-md-2 filter-kode_customer'><'col-sm-12 col-md-3 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
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

            // INIT PINDAH PASAR
            $(document).on('click', "#btnPindahPasar", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahPasarModal').modal('show');
            });

            // INIT PINDAH PASAR
            $(document).on('click', "#btnPindahLokasi", function(e) {
                e.preventDefault();
                // Tampilkan modal edit
                $('#PindahLokasiModal').modal('show');
            });

            $('#btnPindah').click(function(e) {
                e.preventDefault();

                var selectedRows = [];

                var rute_id_akhir = $('#rute_id_akhir').val();
                $('.check:checked').each(function() {
                    var id = $(this).closest('tr').data('id');
                    var id_pasar_awal = $(this).closest('tr').data('id_pasar_awal');
                    var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                    selectedRows.push({
                        id: id,
                        id_pasar_awal: id_pasar_awal,
                        rute_id_akhir: rute_id_akhir,
                        id_survey_pasar: id_survey_pasar
                    });
                });
                // console.log(selectedRows);
                $.ajax({
                    type: 'post',
                    url: "{{ route('PindahOutlet.pindah') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        console.log(response.message);
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

            // PINDAH PASAR
            $('#savePindahPasar').click(function(e) {
                e.preventDefault();

                var selectedRows = [];

                $('.check:checked').each(function() {
                    var id = $(this).closest('tr').data('id');
                    var id_mco = $(this).closest('tr').data('id_mco');
                    var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                    var rute_id_awal = $(this).closest('tr').data('rute_id_awal');
                    var id_pasar_akhir = $('#id_pasar_akhir').val();
                    selectedRows.push({
                        id: id,
                        id_mco: id_mco,
                        id_survey_pasar: id_survey_pasar,
                        id_pasar_akhir: id_pasar_akhir,
                        rute_id_awal: rute_id_awal
                    });
                });
                // console.log(selectedRows);
                $.ajax({
                    type: 'post',
                    url: "{{ route('PindahOutlet.pindahPasar') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        console.log(response.message);
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
                        $('#id_pasar_akhir').val(null);
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

            // PINDAH LOKASI
            $('#savePindahLokasi').click(function(e) {
                e.preventDefault();

                var selectedRows = [];
                $('.check:checked').each(function(index) {
                    var id_survey_pasar = $(this).closest('tr').data('id_survey_pasar');
                    var id_wilayah = $('#nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
                    var lokasi = $('#lokasi').val();

                    var dataObject = {};
                    dataObject['id_wilayah'] = id_wilayah;
                    dataObject['survey_pasar_id'] = id_survey_pasar;
                    dataObject['id_qr_outlet'] = id_survey_pasar;
                    dataObject['rute'] = id_survey_pasar;
                    dataObject['hari'] = id_survey_pasar;
                    dataObject['lokasi'] = lokasi;

                    var data = [];
                    data.push('CUST-220426');
                    data.push('CUST-220426');
                    data.push('CUST-220426');
                    data.push(lokasi);
                    data.push('CUST-220426');
                    data[5] = dataObject;
                    selectedRows.push(data);
                });

                console.log(selectedRows);

                // var requestData = {};

                // for (var i = 0; i < selectedRows.length; i++) {
                //     var dataKey = 'data[' + i + '][]';

                //     for (var j = 0; j < Object.keys(selectedRows[i]).length; j++) {
                //         var objectKey = Object.keys(selectedRows[i])[j];
                //         var objectValue = selectedRows[i][objectKey];

                //         var nestedKey = dataKey + '[' + j + ']';

                //         requestData[nestedKey] = objectValue;
                //     }
                // }
                // console.log(selectedRows);
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
                        console.log(response.message);
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
                        // $('#lokasi').val(null);
                        // setTimeout(function() {
                        //     $('#successModal').modal('hide');
                        //     location.reload();
                        // }, 3000);
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
            var nama_sales = $('#salesman_awal').val();
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
