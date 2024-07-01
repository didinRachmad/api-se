@extends('layouts.app')
@section('content')
    <style>
        .input-group-text {
            width: 100px;
        }

        .tipe_outlet {
            white-space: nowrap;
        }

        .data {
            border: none;
            /* Remove default border */
            box-shadow: none;
            /* Remove default box shadow */
            background: none;
            /* Remove default background */
            width: auto;
            /* Let the width adjust according to the content */
            padding: 0;
            /* Optional: Remove padding if needed */
        }

        .table-responsive td {
            white-space: nowrap;
        }
    </style>

    <div class="card">
        {{-- <div class="card-header">Tool Excel</div> --}}
        <div class="card-body card-body-custom mt-3">
            {{-- <form class="form" method="POST" action="{{ route('ToolExcel.pindah') }}"> --}}
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="{{ asset('file/FORMAT_TOOL_EXCEL.xlsx') }}" download>
                                <button type="button" class="btn btn-sm btn-secondary">
                                    Download Format
                                </button>
                            </a>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-sm" id="excel_file" type="file" accept=".xlsx">
                                <span id="btn-import" class="btn btn-sm btn-success">
                                    Import
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-left my-auto">
                    <button type="button" class="btn btn-primary btn-sm" id="btnPindah">Pindah <span><i
                                class="bi bi-save"></i></span></button>
                </div>
            </div>
            {{-- </form> --}}
            <div class="table-responsive">
                <table class="table table-sm table-light table-striped  align-middle myTable" id="myTable">
                    <thead>
                        <tr class="text-center">
                            <th colspan="6" class="table-dark text-center">Rute Lama</th>
                            <th colspan="3" class="table-light text-center">Rute Baru</th>
                            <th rowspan="2" class="text-center align-middle">Keterangan</th>
                        </tr>
                        <tr>
                            <th class="table-dark">No</th>
                            <th class="table-dark">Id Wilayah</th>
                            <th class="table-dark">Wilayah</th>
                            <th class="table-dark">Salesman</th>
                            <th class="table-dark">Rute</th>
                            <th class="table-dark">Kode Customer</th>
                            <th class="table-light">Salesman</th>
                            <th class="table-light">Rute</th>
                            <th class="table-light">Hari</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-data">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table;
            $("#btn-import").click(function() {

                var file = $("#excel_file")[0].files[0];
                if (file == null) {
                    alert("File Belum Dipilih");
                }

                if (file) {
                    var reader = new FileReader();


                    reader.onload = function(e) {
                        var html = "";

                        var data = new Uint8Array(e.target.result);
                        var workbook = XLSX.read(data, {
                            type: "array"
                        });
                        var worksheet = workbook.Sheets[workbook.SheetNames[0]];
                        var range = XLSX.utils.decode_range(worksheet["!ref"]);

                        // $("#tbody-data").html(html);

                        for (var r = range.s.r + 1; r <= range.e.r; r++) {
                            var id_wilayah = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 0
                            })];
                            var wilayah = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 1
                            })];
                            var kode_customer = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 5
                            })];
                            var salesman_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 2
                            })];
                            var rute_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 3
                            })];
                            var hari_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 4
                            })];

                            if (
                                id_wilayah &&
                                wilayah &&
                                kode_customer &&
                                salesman_tujuan &&
                                hari_tujuan &&
                                rute_tujuan
                            ) {
                                html += '<tr>';
                                html += '<td class="no table-dark">' + r + '</td>';
                                html += '<td class="id_wilayah table-dark">' + id_wilayah.v +
                                    '</td>';
                                html += '<td class="wilayah table-dark">' + wilayah.v +
                                    '</td>';
                                html += '<td class="salesman_awal table-dark"></td>';
                                html += '<td class="rute_awal table-dark"></td>';
                                html += '<td class="kode_customer table-dark">' +
                                    kode_customer.v +
                                    '</td>';
                                html += '<td class="salesman_tujuan table-light">' + salesman_tujuan
                                    .v +
                                    '</td>';
                                html += '<td class="rute_tujuan table-light">' + rute_tujuan.v +
                                    '</td>';
                                html += '<td class="hari_tujuan table-light">' + hari_tujuan.v +
                                    '</td>';
                                html += '<td class="keterangan table-light text-danger"></td>';
                                html += "</tr>";
                            }
                        }
                        if (table == null) {
                            $("#tbody-data").html(html);
                            isiDataOutlet(initDatatables);

                        } else {
                            table.destroy();
                            $("#tbody-data").html(html);
                            isiDataOutlet(initDatatables);
                        }
                    };
                    reader.readAsArrayBuffer(file);
                }
            });

            function isiDataOutlet(callback) {
                var kode_customerAll = []; // Membuat array untuk menyimpan kode pelanggan
                var resAll = []; // Membuat array untuk menyimpan kode pelanggan
                var id_wilayah;
                $('.kode_customer').each(function(index) {
                    id_wilayah = $(this).closest('tr').find('.id_wilayah').text().trim();
                    var kode_customer = $(this).text().trim().toUpperCase();
                    kode_customerAll.push(kode_customer); // Menambahkan kode pelanggan ke dalam array
                });

                // Tentukan ukuran kelompok
                var chunkSize = 500;

                // Bagi data menjadi kelompok-kelompok yang lebih kecil
                var chunks = [];
                for (var i = 0; i < kode_customerAll.length; i += chunkSize) {
                    chunks.push(kode_customerAll.slice(i, i + chunkSize));
                }

                // Fungsi untuk mengirim permintaan AJAX untuk setiap kelompok
                function sendRequests(chunks, currentIndex) {
                    if (currentIndex < chunks.length) {
                        var currentChunk = chunks[currentIndex];

                        $.ajax({
                            type: 'POST',
                            url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/getData",
                            dataType: 'json',
                            encode: true,
                            data: {
                                depo: id_wilayah,
                                kode_customer: currentChunk,
                                type: 'ro'
                            },
                            success: function(response) {
                                let res = response.data;
                                resAll = resAll.concat(res);
                                sendRequests(chunks, currentIndex + 1);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    } else {
                        // console.log(resAll);
                        $('.kode_customer').each(function(index) {
                            var kode_customer = $(this).text().trim().toUpperCase();
                            var rute_tujuan = $(this).closest('tr').find('.rute_tujuan')
                                .text()
                                .trim().toUpperCase();
                            var salesman_tujuan = $(this).closest('tr').find(
                                    '.salesman_tujuan')
                                .text()
                                .trim().toUpperCase();
                            var ketemu = 0;
                            for (var i = 0; i < resAll.length; i++) {
                                if (kode_customer.toUpperCase() === resAll[i].kode_customer
                                    .toUpperCase()) {
                                    // var id_wilayah = resAll[i].id_wilayah ?? "";
                                    // $(this).closest('tr').find('.id_wilayah').html(
                                    //     id_wilayah);

                                    var salesman_awal = resAll[i].salesman.trim().toUpperCase();
                                    $(this).closest('tr').find('.salesman_awal').html(salesman_awal);

                                    var rute_awal = resAll[i].rute.trim().toUpperCase();
                                    $(this).closest('tr').find('.rute_awal').html(rute_awal);

                                    if (rute_tujuan !== rute_awal || salesman_tujuan !== salesman_awal) {
                                        $(this).closest('tr').find('.keterangan').html(
                                            "Berubah");
                                    }
                                    ketemu = 1;
                                    break;
                                }
                            }
                            if (!ketemu) {
                                $(this).closest('tr').find('.keterangan').html(
                                    "Tidak ditemukan");
                            }
                        });
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                }

                // Mulai mengirim permintaan untuk setiap kelompok
                sendRequests(chunks, 0);
            }


            // INIT DATATABLES
            function initDatatables() {
                table = $("#myTable")
                    .DataTable({
                        "dom": "<'row'<'col-sm-12 col-md-10'B><'col-sm-12 col-md-2 text-right'f>>" +
                            "<'row'<'col-sm-12 table-responsive'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "paging": false,
                    });
                table.on('order.dt search.dt', function() {
                    table.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

            };

            // PINDAH RUTE
            $('#btnPindah').click(function(e) {
                e.preventDefault();
                var selectedRows = [];

                $('.kode_customer').each(function(index) {
                    var keterangan = $(this).closest('tr').find('.keterangan').text()
                        .trim().toUpperCase();
                    if (keterangan == 'BERUBAH') {
                        var id_wilayah = $(this).closest('tr').find('.id_wilayah').text()
                            .trim();
                        var wilayah = $(this).closest('tr').find('.wilayah').text().trim();
                        var kode_customer = $(this).text().trim();
                        var salesman_awal = $(this).closest('tr').find('.salesman_awal').text()
                            .trim();
                        var salesman_tujuan = $(this).closest('tr').find('.salesman_tujuan')
                            .text()
                            .trim();
                        var hari_tujuan = $(this).closest('tr').find('.hari_tujuan').text()
                            .trim();
                        var rute_tujuan = $(this).closest('tr').find('.rute_tujuan').text()
                            .trim();

                        if (salesman_tujuan === '' || hari_tujuan === '' || rute_tujuan ===
                            '') {
                            alert("harap isi Rute tujuan");
                            return;
                        }

                        var dataObject = {};
                        dataObject['id_wilayah'] = id_wilayah;
                        dataObject['wilayah'] = wilayah;
                        dataObject['kode_customer'] = kode_customer;
                        dataObject['salesman'] = salesman_awal;
                        dataObject['pindah_salesman'] = salesman_tujuan;
                        dataObject['pindah_hari'] = hari_tujuan;
                        dataObject['pindah_rute'] = rute_tujuan;

                        selectedRows.push(dataObject);
                    }
                });

                if (selectedRows.length === 0) {
                    $('#errorModal #message').text("Tidak ada data yang berubah");
                    $('#errorModal').modal('show');
                } else {
                    $.ajax({
                        type: 'post',
                        url: "https://sales.motasaindonesia.co.id/api/tool/outletkandidat/uploadpindahtokobatch",
                        dataType: 'json',
                        encode: true,
                        data: {
                            data: selectedRows
                        },
                        beforeSend: function() {
                            $('.loading-overlay').show();
                        },
                        success: function(response) {
                            if (response.is_valid) {
                                $('#successModal').modal('show');
                                // setTimeout(function() {
                                //     $('#successModal').modal('hide');
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
                }
            });
        });
    </script>
@endsection
