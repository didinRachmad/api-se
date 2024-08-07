@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">List Rute</div> --}}
        <div class="card-body card-body-custom mt-3">
            <form class="form" method="POST" action="{{ route('ListRute.getListRute') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm flex-nowrap mb-3">
                            <span class="input-group-text">Salesman</span>
                            <select class="form-select form-select-sm select2-salesman w-100" name="salesman" id="salesman"
                                required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                                oninput="setCustomValidity('')">
                                <option value="{{ old('salesman', $salesman ?? '') }}">
                                    {{ old('salesman', $salesman ?? '') }}
                                </option>
                            </select>
                        </div>
                        <input type="hidden" name="id_salesman" id="id_salesman"
                            value="{{ old('id_salesman', $id_salesman ?? '') }}">
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnSearch">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                    </div>

                    <div class="col-lg-6">
                        @if (isset($total))
                            <p class="d-inline-block pe-3">Total : <span class="fw-bold">({{ $total ?? '' }})</span></p>
                            <p class="d-inline-block pe-3">RO : <span class="fw-bold">({{ $ro ?? '' }})</span></p>
                            <p class="d-inline-block pe-3">OC : <span class="fw-bold">({{ $kandidat ?? '' }})</span></p>
                        @endif
                    </div>
                </div>
            </form>
            {{-- <textarea name="tes" id="tes" class="form-control w-100" cols="30" rows="10"></textarea> --}}
            @if (isset($data) && !empty($data))
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-light table-striped  align-middle myTable">
                        <thead class="text-center">
                            <th>no</th>
                            <th>nama wilayah</th>
                            <th>salesman</th>
                            <th>rute id</th>
                            <th>id mrdo</th>
                            <th>survey pasar id</th>
                            <th>kode customer <button type="button" class="btn btn-sm btn-secondary"
                                    id="salin_kode_customer"><i class="bi bi-clipboard-fill"></i></button></th>
                            <th>nama toko</th>
                            <th>alamat</th>
                            <th>id mco</th>
                            <th>id dataar</th>
                            <th>id pasar</th>
                            <th>nama pasar</th>
                            <th>lokasi</th>
                            <th>latitude</th>
                            <th>longitude</th>
                            <th>visited</th>
                        </thead>
                        <tbody id="bodyTabelRute">
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($data as $mr)
                                @php
                                    $no += 1;
                                @endphp
                                <tr class="warnaBaris">
                                    <td></td>
                                    <td>{{ $mr['nama_wilayah'] }} ({{ $mr['iddepo'] }})</td>
                                    <td>{{ $mr['nama_sales_ekslusif'] }}</td>
                                    <td>{{ $mr['rute_id'] }}</td>
                                    <td>{{ $mr['rute_outlet_id'] }}</td>
                                    <td>{{ $mr['id_survey_pasar'] }}</td>
                                    <td class="text-primary fw-bold kode_customer">{{ $mr['kode_toko'] }}</td>
                                    <td>{{ $mr['nama_toko'] }}</td>
                                    <td>{{ $mr['alamat_toko'] }}</td>
                                    <td class="id_mco">{{ $mr['id'] }}</td>
                                    <td>{{ $mr['dataar'] }}</td>
                                    <td>{{ $mr['id_pasar'] }}</td>
                                    <td>{{ $mr['nama_pasar'] }}</td>
                                    <td>{{ $mr['location_type'] ?? '' }}</td>
                                    <td>{{ $mr['latitude'] }}</td>
                                    <td>{{ $mr['longitude'] }}</td>
                                    <td>
                                        @if ($mr['is_visited'])
                                            <i class="bi bi-check-square-fill text-success">1</i>
                                        @else
                                            <i class="bi bi-x-square-fill text-danger">0</i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @if (isset($message))
                    <div class="json-viewer text-center" style="white-space: pre-wrap;">{{ $message }}</div>
                @endif
            @endif
            {{-- @php
                // echo $message;
            @endphp --}}
        </div>
    </div>

    {{-- TOAST SALIN KODE --}}
    <div class="toast-container position-fixed top-0 end-0 p-5">
        <div class="toast align-items-center text-bg-success border-0" id="toastSalin" role="alert" aria-live="assertive"
            aria-atomic="true">
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
                        ' (' + data.id_salesman + ') ' + ' - ' + data.nama_wilayah));
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                // mengubah value dari id_salesman
                $('#id_salesman').val(data.id_salesman);
                id_salesman = data.id_salesman;
                $('.select2-rute').val(null).trigger('change');
            });

            var table = $('.myTable').DataTable({
                "dom": "<'row'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-3 filter-NamaToko'><'col-sm-12 col-md-3 filter-jenis_outlet'B><'col-sm-12 col-md-2 text-right'f>>" +
                    "<'row'<'col-sm-12 table-responsive'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                buttons: [{
                    extend: 'copy',
                    title: 'Data ' + $('#salesman').val() + " - " + $('#id_salesman')
                        .val(),
                }, 'csv', {
                    extend: 'excel',
                    title: 'Data ' + $('#salesman').val() + " - " + $('#id_salesman')
                        .val(),
                }, 'pdf', 'print'],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0],
                }],
                "order": [
                    [6, 'desc']
                ],
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-50">
                        <option value="">Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-jenis_outlet')
                        .on('change', function() {
                            var val = $(this).val();
                            if (val === '') {
                                table.column(6).search('').draw();
                            } else if (val === 'KANDIDAT') {
                                table.column(6).search('^(0|null|)$', true, false).draw();
                            } else if (val === 'RO') {
                                table.column(6).search('^(?!0$|null$).+$', true, false).draw();
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

            $('#salin_kode_customer').click(function(e) {
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

                var toast = $('#toastSalin');
                toast.show();
                setTimeout(function() {
                    toast.hide();
                }, 2000);
            });
        });
    </script>
@endsection
