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
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnSearch">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                        {{-- <button type="button" class="btn btn-info btn-sm btnOrder">Order <span> <i
                                class="bi bi-journal-text"></i></span></button>
                    <button type="button" class="btn btn-warning btn-sm btnKandidat">Kandidat <span> <i
                                class="bi bi-journal-text"></i></span></button> --}}
                    </div>
                </div>
            </form>
            {{-- <textarea name="tes" id="tes" class="form-control w-100" cols="30" rows="10"></textarea> --}}
            <div class="table-responsive pt-3">
                <table class="table table-sm table-dark table-striped table-bordered align-middle myTable">
                    <thead class="text-center">
                        <th>no</th>
                        <th>nama wilayah</th>
                        <th>id_salesman</th>
                        <th>salesman</th>
                        <th>id_survey_pasar</th>
                        <th>kode customer</th>
                        <th>nama toko</th>
                        <th>alamat</th>
                        <th>pemilik</th>
                        <th>id_pasar</th>
                        <th>nama pasar</th>
                        <th>id_qrcode</th>
                        <th>latitude</th>
                        <th>longitude</th>
                    </thead>
                    <tbody id="bodyTabelRute">
                        @if (!isset($data))
                            @php
                                $data = [];
                            @endphp
                        @endif
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($data as $mr)
                            @php
                                $no += 1;
                            @endphp
                            <tr class="warnaBaris">
                                <td></td>
                                <td>{{ $mr['nama_wilayah'] }}</td>
                                <td>{{ $mr['id_sales_ekslusif'] }}</td>
                                <td>{{ $mr['nama_sales_ekslusif'] }}</td>
                                <td>{{ $mr['id_survey_pasar'] }}</td>
                                <td class="text-primary fw-bold">{{ $mr['kode_toko'] }}</td>
                                <td>{{ $mr['nama_toko'] }}</td>
                                <td>{{ $mr['alamat_toko'] }}</td>
                                <td>{{ $mr['nama_pemilik'] }}</td>
                                <td>{{ $mr['id_pasar'] }}</td>
                                <td>{{ $mr['nama_pasar'] }}</td>
                                <td>{{ $mr['id_qrcode'] }}</td>
                                <td>{{ $mr['latitude'] }}</td>
                                <td>{{ $mr['longitude'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                "dom": "<'row'<'col-sm-12 col-md-2 filter-survey_pasar'><'col-sm-12 col-md-2 filter-KodeCustomer'><'col-sm-12 col-md-3 filter-NamaToko'><'col-sm-12 col-md-3 filter-jenis_outlet'B><'col-sm-12 col-md-2 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                buttons: [{
                    extend: 'copy',
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#id_salesman')
                        .text(),
                }, 'csv', {
                    extend: 'excel',
                    title: 'Data ' + $('#nama-salesman').text() + " - " + $('#id_salesman')
                        .text(),
                }, 'pdf', 'print'],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0],
                }],
                "order": [
                    [5, 'desc']
                ],
                "initComplete": function(settings, json) {
                    $(`<select class="form-select form-select-sm w-50">
                        <option value="">Semua</option>
                        <option value="KANDIDAT">Kandidat</option>
                        <option value="RO">RO</option>
                        </select>`)
                        .appendTo('.filter-jenis_outlet')
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            if (val === '') {
                                table.columns(3).search('').draw();
                            } else if (val ===
                                'KANDIDAT') {
                                table.columns(3).search('^(0|null|)$', true, false).draw();
                            } else if (val === 'RO') {
                                table.columns(3).search('^(?!0|!|!null).+$', true, false).draw();
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
        });
    </script>
@endsection
