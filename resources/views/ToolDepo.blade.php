@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }

        .TableOrderDouble tbody .ganjil {
            background-color: #252B3B !important;
            /* Warna biru tua */
            color: #f2f2f2 !important;
            /* Warna putih yang lebih lembut */
        }

        .TableOrderDouble tbody .genap {
            background-color: #b6c0de !important;
            /* Warna putih dengan sedikit nuansa biru */
            color: #252B3B !important;
            /* Warna biru tua */
        }

        .TableOrderDouble.table-light {
            background-color: initial;
        }

        .TableOrderDouble.table-light td {
            background-color: initial;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">Tool Depo</div> --}}
        <div class="card-body card-body-custom mt-3">
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group input-group-sm flex-nowrap mb-3">
                        <span class="input-group-text">Depo</span>
                        <select class="form-select form-select-sm select2-depo w-100" name="depo" id="depo">
                        </select>
                        <input type="hidden" name="nama_wilayah" id="nama_wilayah">
                    </div>
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-primary btn-sm" id="btnUpdateAR">Update AR<span><i
                                class="bi bi-save"></i></span></button>
                    {{-- <button type="button" class="btn btn-primary btn-sm" id="btnUpdateArByOrder">Update AR By Order<span><i
                                class="bi bi-save"></i></span></button> --}}
                    <button type="button" class="btn btn-warning btn-sm" id="btnUpdateBySP">Update By Survey Pasar<span><i
                                class="bi bi-file-earmark-arrow-up-fill"></i></span></button>
                    <button type="button" class="btn btn-info btn-sm" id="btnTukarRute">Tukar Rute<span><i
                                class="bi bi-toggles2"></i></span></button>
                </div>
                <div class="col-lg-3">
                    <div class="input-group input-group-sm flex-nowrap mb-3">
                        <span class="input-group-text">Tanggal</span>
                        <input type="date" class="form-control form-control-sm" id="editNoOrder-tanggal"
                            name="editNoOrder-tanggal" value="<?= date('Y-m-d') ?>">
                        <button type="button" class="btn btn-secondary btn-sm" id="btnEditNoOrder">Order Double <span><i
                                    class="bi bi-pencil-square"></i></span></button>
                    </div>
                    <div class="col-lg-2">
                    </div>
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
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:0.8rem;">
                    <div class="table-responsive">
                        <table class="table table-sm table-light table-bordered TableRute w-100 text-center align-midle"
                            id="bodyTukerRute">
                            {{-- <thead class="text-center">
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
                            </tbody> --}}
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

    <!-- Modal Edit NO Order -->
    <div class="modal fade" id="editNoOrderDipilihModal" tabindex="-1" role="dialog"
        aria-labelledby="editNoOrderDipilihModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoOrderDipilihModalLabel">Edit No Order</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered TableOrderDouble text-center align-midle w-100 nowrap"
                            id="tableEditNoOrder">
                            <thead class="text-center fw-bold">
                                <th>ID</th>
                                <th>No Order</th>
                                <th>Salesman</th>
                                <th>Kode Customer</th>
                                <th>Nama Toko</th>
                                <th>Tgl Transaksi</th>
                                <th>Total Transaksi</th>
                                <th>Pilih</th>
                            </thead>
                            <tbody id="bodyEditNoOrder">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditNoOrder">Simpan</button>
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
                minimumInputLength: 3,
                allowClear: true,
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }
                    return $('<span>').text(data.text).addClass('fw-bold').append(' - ' + data.id);
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#nama_wilayah').val(data.text);
            }).on('select2:unselect', function() {
                $('#nama_wilayah').val('');
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

            $('#btnUpdateAR').click(function(e) {
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

            $('#btnUpdateArByOrder').click(function(e) {
                var iddepo = $('#depo').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.updateArByOrder') }}",
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

            $('#btnUpdateBySP').click(function(e) {
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

            $('#btnTukarRute').click(function(e) {
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
                        const pivotTable = {};
                        response.data.forEach(data => {
                            const salesman = data.salesman;
                            const rute = data.rute.toUpperCase();
                            const hari = data.hari.toUpperCase();

                            if (!pivotTable[salesman]) {
                                pivotTable[salesman] = {};
                            }

                            data.rute = rute;
                            data.hari = hari;
                            pivotTable[salesman][rute] = data;
                        });

                        const orderedDays = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT',
                            'SABTU', 'MINGGU'
                        ];
                        const orderedPeriodik = ['GANJIL', 'GENAP'];

                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>Salesman</th>';

                        // Menambahkan header hari sesuai dengan urutan
                        orderedDays.forEach((hari) => {
                            html +=
                                `<th class="text-center align-middle">${hari}
                                    <input type="checkbox" class="btn-check checkAllHari" id="checkAll${hari}" data-hari="${hari}" autocomplete="off">
                                    <label class="btn btn-sm btn-outline-success" for="checkAll${hari}">All</label>
                                </td>`;
                        });

                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';

                        // Menambahkan data ke dalam tabel
                        for (const salesman in pivotTable) {
                            const periodikJenis = pivotTable[salesman].periodik_jenis;
                            // Menambahkan baris untuk data ganjil
                            html += '<tr>';
                            if (Object.keys(pivotTable[salesman]).some(key => key.includes(
                                    "GANJIL") || key.includes("GENAP"))) {
                                html +=
                                    `<td class="text-center align-middle salesman">${salesman}
                                            <input type="checkbox" class="btn-check checkAllSalesman" id="checkAll${salesman}" data-salesman="${salesman}" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-success" for="checkAll${salesman}">All</label>
                                            </td>`;
                            } else {
                                html +=
                                    `<td class="text-center align-middle salesman">${salesman}</td>`;
                            }

                            // Menambahkan data rute dan id untuk setiap hari dan periodik (GANJIL)
                            orderedDays.forEach((hari) => {
                                const dataRuteGanjil = `${hari} GANJIL`;
                                const dataGanjil = pivotTable[salesman][dataRuteGanjil];
                                const idGanjil = dataGanjil ? dataGanjil.id : '';
                                const ruteGanjil = dataGanjil ? dataGanjil.rute : '';
                                const periodikGanjil = dataGanjil ? dataGanjil
                                    .periodik_jenis : '';
                                const dataRuteGenap = `${hari} GENAP`;
                                const dataGenap = pivotTable[salesman][dataRuteGenap];
                                const idGenap = dataGenap ? dataGenap.id : '';
                                const ruteGenap = dataGenap ? dataGenap.rute : '';
                                const periodikGenap = dataGenap ? dataGenap
                                    .periodik_jenis : '';
                                // html += `<td class="id">${idGanjil}</td>`;
                                // html += `<td class="rute">${ruteGanjil}</td>`;
                                // html += `<td class="periodik">${periodikGanjil}</td>`;
                                if (periodikGanjil != "" && periodikGenap != "") {
                                    html +=
                                        `<td class="text-center align-middle"><input type="checkbox" class="btn-check check" id="check${idGanjil}" data-salesman="${salesman}" data-hari="${hari}" data-rute_ganjil="${ruteGanjil}" data-rute_genap="${ruteGenap}" data-periodik_ganjil="${periodikGanjil}" data-periodik_genap="${periodikGenap}" data-id_genap="${idGenap}" data-id_ganjil="${idGanjil}" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-success" for="check${idGanjil}">Pilih</label></td>`;
                                } else {
                                    html += `<td></td>`
                                }
                            });

                            html += '</tr>';

                            // Menambahkan baris untuk data genap
                            // html += '<tr>';

                            // // Menambahkan data rute dan id untuk setiap hari dan periodik (GENAP)
                            // orderedDays.forEach((hari) => {
                            //     const dataRuteGenap = `${hari} GENAP`;
                            //     const dataGenap = pivotTable[salesman][dataRuteGenap];
                            //     const idGenap = dataGenap ? dataGenap.id : '';
                            //     const ruteGenap = dataGenap ? dataGenap.rute : '';
                            //     const periodikGenap = dataGenap ? dataGenap
                            //         .periodik_jenis : '';
                            //     html += `<td class="id">${idGenap}</td>`;
                            //     html += `<td class="rute">${ruteGenap}</td>`;
                            //     html += `<td class="periodik">${periodikGenap}</td>`;
                            // });

                            // html += '</tr>';
                        }

                        html += '</tbody>';

                        $('#bodyTukerRute').html(html);
                        // Check All Salesman yang Sama
                        $(".checkAllSalesman").change(function() {
                            const salesman = $(this).data("salesman");
                            $(`.btn-check.check[data-salesman="${salesman}"]`).prop(
                                "checked", $(this).prop("checked"));
                        });

                        // Check All Hari yang Sama
                        $(".checkAllHari").change(function() {
                            const hari = $(this).data("hari");
                            $(`.btn-check.check[data-hari="${hari}"]`).prop("checked",
                                $(this).prop("checked"));
                        });
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

            $('#saveTukarRute').click(function(e) {
                var selectedRows = [];
                $('.check:checked').each(function() {
                    var salesman = $(this).data('salesman');
                    var hari = $(this).data('hari');
                    var periodikGanjil = $(this).data('periodik_ganjil');
                    var periodikGenap = $(this).data('periodik_genap');
                    var idGanjil = $(this).data('id_ganjil');
                    var idGenap = $(this).data('id_genap');
                    var ruteGanjil = $(this).data('rute_ganjil');
                    var ruteGenap = $(this).data('rute_genap');

                    // Tambahkan data dari baris saat ini
                    selectedRows.push({
                        salesman: salesman,
                        hari: hari,
                        rute: ruteGanjil,
                        periodik_jenis: periodikGanjil,
                        id: idGanjil
                    });
                    selectedRows.push({
                        salesman: salesman,
                        hari: hari,
                        rute: ruteGenap,
                        periodik_jenis: periodikGenap,
                        id: idGenap
                    });
                });
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

            // EDIT NO ORDER
            $('#btnEditNoOrder').on('click', function(e) {
                var nama_wilayah = $('#nama_wilayah').val();
                var tanggal = $('#editNoOrder-tanggal').val();
                if (nama_wilayah === null || nama_wilayah == '') {
                    $('#errorModal #message').text("Depo belum dipilih !");
                    $('#errorModal').modal('show');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.editNoOrder') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        nama_wilayah: nama_wilayah,
                        tanggal: tanggal
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        var html = '';
                        response.data.forEach((dataDouble, indexDouble) => {
                            dataDouble.forEach((data) => {
                                let rowClass = (indexDouble % 2 ===
                                    0) ? 'genap' : 'ganjil';
                                html += `<tr class="${rowClass}">`;
                                html +=
                                    `<td class="">${data.id}</td>
                                        <td class="">${data.no_order}</td>
                                        <td class="">${data.nama_salesman}</td>
                                        <td class="">${data.kode_customer}</td>
                                        <td class="">${data.nama_toko}</td>
                                        <td class="">${data.tgl_transaksi}</td>
                                        <td class="">${data.total_transaksi}</td>
                                        <td class=""><input type="checkbox" class="btn-check checkEditNoOrder" id="check${data.id}" data-id="${data.id}" data-nama_wilayah="${data.nama_wilayah}" data-tgl_transaksi="${data.tgl_transaksi}" autocomplete="off">
                                        <label class="btn btn-sm btn-outline-success" for="check${data.id}">Pilih</label></td>`;
                                html += `</tr>`;
                            });
                        });

                        html += '</tr>';
                        $('#bodyEditNoOrder').html(html);

                        // // Destroy the DataTable if it exists
                        // if (!$.fn.DataTable.isDataTable('#tableEditNoOrder')) {
                        //     // $('#tableEditNoOrder').DataTable().destroy();
                        //     var tableEditNoOrder = $("#tableEditNoOrder").DataTable({
                        //         dom: "<'row'<'col-sm-12 col-md-10'B><'col-sm-12 col-md-2 text-right'f>>" +
                        //             "<'row py-2'<'col-sm-12'tr>>" +
                        //             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        //         paging: false,
                        //         order: [],
                        //         columnDefs: [{
                        //             targets: [7],
                        //             className: 'no-export'
                        //         }],
                        //         buttons: [{
                        //             extend: 'copy',
                        //             title: 'Data Order - ' + $('#nama_wilayah')
                        //                 .val(),
                        //             exportOptions: {
                        //                 columns: ':not(.no-export)'
                        //             }
                        //         }, 'csv', {
                        //             extend: 'excel',
                        //             title: 'Data Order - ' + $('#nama_wilayah')
                        //                 .val(),
                        //             exportOptions: {
                        //                 columns: ':not(.no-export)'
                        //             },
                        //             customize: function(xlsx) {
                        //                 var sheet = xlsx.xl.worksheets[
                        //                     'sheet1.xml'];
                        //                 var rows = $('row', sheet);

                        //                 // Remove merged cells
                        //                 $('mergeCells', sheet).remove();
                        //                 $('mergeCell', sheet).remove();

                        //                 // Remove the first row
                        //                 rows.first().remove();

                        //                 // Update row numbers and cell references
                        //                 rows.each(function() {
                        //                     var rowIndex = parseInt(
                        //                         $(this).attr(
                        //                             'r'));
                        //                     if (rowIndex > 1) {
                        //                         $(this).attr('r',
                        //                             rowIndex - 1
                        //                         );
                        //                         $('c', this).each(
                        //                             function() {
                        //                                 var cellRef =
                        //                                     $(
                        //                                         this
                        //                                     )
                        //                                     .attr(
                        //                                         'r'
                        //                                     );
                        //                                 var newCellRef =
                        //                                     cellRef
                        //                                     .replace(
                        //                                         /[0-9]+/,
                        //                                         function(
                        //                                             match
                        //                                         ) {
                        //                                             return parseInt(
                        //                                                     match
                        //                                                 ) -
                        //                                                 1;
                        //                                         }
                        //                                     );
                        //                                 $(this)
                        //                                     .attr(
                        //                                         'r',
                        //                                         newCellRef
                        //                                     );
                        //                             });
                        //                     }
                        //                 });
                        //             }
                        //         }, {
                        //             extend: 'pdf',
                        //             title: 'Data Order - ' + $('#nama_wilayah')
                        //                 .val(),
                        //             exportOptions: {
                        //                 columns: ':not(.no-export)'
                        //             },
                        //             customize: function(doc) {
                        //                 doc.pageOrientation =
                        //                     'landscape'; // Set orientasi landscape
                        //                 doc.pageSize =
                        //                     'LEGAL'; // Set ukuran halaman 
                        //             }
                        //         }, 'print'],
                        //     });
                        // }

                        $('#editNoOrderDipilihModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        $('.loading-overlay').hide();
                        console.error(error);
                        $('#errorModal #message').text(xhr.responseJSON.message);
                        console.log(xhr.responseJSON.test);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            $('#saveEditNoOrder').click(function(e) {
                var selectedRows = [];
                $('.checkEditNoOrder:checked').each(function() {
                    var id = $(this).data('id');
                    var nama_wilayah = $(this).data('nama_wilayah');
                    var tgl_transaksi = $(this).data('tgl_transaksi');

                    selectedRows.push({
                        id: id,
                        nama_wilayah: nama_wilayah,
                        tgl_transaksi: tgl_transaksi
                    });
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolDepo.saveEditNoOrder') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        req: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#editNoOrderDipilihModal').modal('hide');
                        $('#successModal #message').text(response.message + ' ' + response
                            .updated_orders);
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
