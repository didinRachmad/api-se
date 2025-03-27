@extends('layouts.app')
@section('content')
    <style>
        .card-body-custom {
            /* padding: 5px; */
            /* ukuran padding yang lebih kecil */
            font-size: smaller;
            /* ukuran font yang lebih kecil */
        }

        .btn-sm {
            font-size: 8pt;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">PENGGABUNGAN RUTE</div> --}}
        <div class="card-body card-body-custom mt-3">
            <form class="form" method="POST" action="{{ route('GabungRute.prosesGabungRute') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <label for="salesman" class="sr-only">Salesman</label>
                        <select class="form-select form-select-sm select2-salesman w-100" name="salesman" id="salesman"
                            required oninvalid="this.setCustomValidity('Harap Pilih Salesman')"
                            oninput="setCustomValidity('')">
                            <option value="{{ old('salesman', $salesman ?? '') }}">
                                {{ old('salesman', $salesman ?? '') }}</option>
                        </select>
                        <input type="hidden" name="id_salesman" id="id_salesman"
                            value="{{ old('id_salesman', $id_salesman ?? '') }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="rute_id" class="sr-only">Rute</label>
                        <select class="form-select form-select-sm select2-rute w-100" name="rute_id" id="rute_id">
                            <option value="{{ old('rute_id', $rute_id ?? '') }}">
                                {{ old('rute', $rute ?? '') }}</option>
                        </select>
                        <input type="hidden" id="rute" name="rute" value="{{ old('rute', $rute ?? '') }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="tgl_pengganti" class="sr-only">Tgl Pengganti</label>
                        <input type='date' class='form-control form-control-sm date' id='tgl_pengganti'
                            name='tgl_pengganti' value='<?= date('Y-m-d') ?>'>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm">Gabung <span> <i
                                    class="bi bi-save"></i></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var id_salesman = 'tes';
            $('.select2-salesman').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('GabungRute.getSalesman') }}",
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
            });

            $('.select2-rute').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('GabungRute.getRute') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page ||
                                1, // Menambahkan parameter 'page' saat melakukan permintaan ke server
                            salesman: $('#salesman').val()
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
        });
    </script>
@endsection
