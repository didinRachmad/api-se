@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }
    </style>

    <div class="card">
        <div class="card-header">Tool Depo</div>
        <div class="card-body card-body-custom">
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group input-group-sm flex-nowrap mb-3">
                        <span class="input-group-text">Depo</span>
                        <select class="form-select form-select-sm select2-depo w-100" name="depo" id="depo">
                        </select>
                    </div>
                </div>
                <div class="col-lg-8">
                    <button type="button" class="btn btn-primary btn-sm" id="btnUpdateAR">Update AR<span><i
                                class="bi bi-save"></i></span></button>
                    <button type="button" class="btn btn-warning btn-sm" id="btnUpdateBySP">Update By Survey Pasar<span><i
                                class="bi bi-file-earmark-arrow-up-fill"></i></span></button>
                    <button type="button" class="btn btn-info btn-sm" id="btnTukarRute">Tukar Rute<span><i
                                class="bi bi-toggles2"></i></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tukar Rute -->
    <div class="modal fade modal-lg" id="tukarRuteModal" tabindex="-1" role="dialog" aria-labelledby="tukarRuteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="tukarRuteModalLabel">Tukar Rute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:0.8rem;">
                    <div class="table-responsive">
                        <table class="table table-sm table-dark table-striped table-bordered TableRute w-100">
                            <thead class="text-center">
                                <th>Salesman</th>
                                <th>Rute</th>
                                <th>periodik</th>
                                <th>Rute Id</th>
                                <th class="text-center">
                                    <input type="checkbox" class="btn-check check-all" id="check-all" autocomplete="off">
                                    <label class="btn btn-sm btn-outline-success" for="check-all">All</label>
                                </th>
                            </thead>
                            <tbody id="bodyTukerRute">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveTukarRute">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2-depo').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('ToolDepo.getDepo') }}",
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
                placeholder: 'Pilih depo',
                // minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text).addClass('fw-bold').append(' - ' + data.id);
                }
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

            $('#btnUpdateAR').click(function() {
                var iddepo = $('#depo').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.updateAr') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        iddepo: iddepo
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        if (response.is_valid) {
                            $('#successModal #message').text("Dataar berhasil diupdate");
                            $('#successModal').modal('show');
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
            $('#btnUpdateBySP').click(function() {
                var iddepo = $('#depo').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.updateBySP') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        iddepo: iddepo
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
            $('#btnTukarRute').click(function() {
                var iddepo = $('#depo').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.getRute') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        iddepo: iddepo
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        let html = '';
                        let prevSalesman = null;
                        let rowspanCount = 0;
                        response.data.forEach((data, index) => {
                            html += '<tr>';
                            html += '<td class="salesman">' + data['salesman'] +
                                '</td>';
                            html += '<td class="rute">' + data['rute'] + '</td>';
                            html += '<td class="periodik">' + data['periodik_jenis'] +
                                '</td>';
                            html += '<td class="id">' + data['id'] + '</td>';
                            if (prevSalesman === null || prevSalesman !== data[
                                    'salesman']) {
                                prevSalesman = data['salesman'];
                                rowspanCount = response.data.filter(d => d[
                                    'salesman'] === prevSalesman).length;
                            }
                            if (rowspanCount > 1) {
                                html += `<td rowspan='${rowspanCount}' class="text-center align-middle">
                                        <input type="checkbox" class="btn-check check" id="check${index}" autocomplete="off">
                                        <label class="btn btn-sm btn-outline-success" for="check${index}">Pilih</label>
                                        </td>`;
                                rowspanCount = 0; // Reset rowspanCount
                            } else {
                                if (rowspanCount != 0) {
                                    console.log(prevSalesman + " - " + rowspanCount);
                                    html += `<td class="text-center align-middle">
                                        <input type="checkbox" class="btn-check check" id="check${index}" autocomplete="off">
                                        <label class="btn btn-sm btn-outline-success" for="check${index}">Pilih</label>
                                    </td>`;
                                }
                            }
                            html += '</tr>';
                        });

                        $('#bodyTukerRute').html(html);
                        $('#tukarRuteModal').modal('show');
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

            $('#saveTukarRute').click(function() {
                var selectedRows = [];
                $('.check:checked').each(function() {
                    var salesman = $(this).closest('tr').find('.salesman').text().trim();
                    var rute = $(this).closest('tr').find('.rute').text().trim();
                    var periodik = $(this).closest('tr').find('.periodik').text().trim();
                    var id = $(this).closest('tr').find('.id').text().trim();

                    // Tambahkan data dari baris saat ini
                    selectedRows.push({
                        salesman: salesman,
                        rute: rute,
                        periodik: periodik,
                        id: id
                    });

                    // Cek apakah ada baris selanjutnya yang dirowspan
                    var row2 = $(this).closest('tr').next('tr');
                    if (row2.length > 0) {
                        var salesman_row2 = row2.find('.salesman').text().trim();
                        var rute_row2 = row2.find('.rute').text().trim();
                        var periodik_row2 = row2.find('.periodik').text().trim();
                        var id_row2 = row2.find('.id').text().trim();

                        // Tambahkan data dari baris sebelah kiri yang di-`rowspan`
                        selectedRows.push({
                            salesman: salesman_row2,
                            rute: rute_row2,
                            periodik: periodik_row2,
                            id: id_row2
                        });
                    }
                });
                // console.log(selectedRows);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.tukarRute') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#tukarRuteModal').modal('hide');
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
        });
    </script>
@endsection
