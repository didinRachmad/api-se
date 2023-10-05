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
        <div class="card-header">Tool Excel</div>
        <div class="card-body card-body-custom">
            {{-- <form class="form" method="POST" action="{{ route('ToolExcel.pindah') }}"> --}}
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="{{ asset('file/FORMAT_TOOL_EXCEL.xlsx') }}" download>
                                <button type="button" class="btn btn-sm btn-secondary">
                                    Download List Salesman
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
                <table class="table table-sm table-dark table-striped table-bordered align-middle myTable" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th colspan="6" class="text-warning">Rute Lama</th>
                            <th colspan="3" class="text-info">Rute Baru</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Id Wilayah</th>
                            <th>Wilayah</th>
                            <th>Kode Customer</th>
                            <th>Salesman</th>
                            <th>Rute</th>
                            <th>Salesman</th>
                            <th>Rute</th>
                            <th>Hari</th>
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
                            var wilayah = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 0
                            })];
                            var kode_customer = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 1
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
                                wilayah &&
                                kode_customer &&
                                salesman_tujuan &&
                                hari_tujuan &&
                                rute_tujuan
                            ) {
                                html += "<tr>";
                                html += '<td class="no text-warning">' + r + '</td>';
                                html += '<td class="id_wilayah text-warning"></td>';
                                html += '<td class="wilayah text-warning">' + wilayah.v + '</td>';
                                html += '<td class="kode_customer text-warning">' + kode_customer.v +
                                    '</td>';
                                html += '<td class="salesman_awal text-warning"></td>';
                                html += '<td class="rute_awal text-warning"></td>';
                                html += '<td class="salesman_tujuan text-info">' + salesman_tujuan
                                    .v +
                                    '</td>';
                                html += '<td class="rute_tujuan text-info">' + rute_tujuan.v +
                                    '</td>';
                                html += '<td class="hari_tujuan text-info">' + hari_tujuan.v +
                                    '</td>';
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
                var wilayah;
                $('.kode_customer').each(function(index) {
                    wilayah = $(this).closest('tr').find('.wilayah').text().trim();
                    var kode_customer = $(this).text().trim().toUpperCase();

                    kode_customerAll.push(kode_customer); // Menambahkan kode pelanggan ke dalam array
                });
                // console.log(kode_customerAll);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ToolExcel.getDataOutlet') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        wilayah: wilayah,
                        kode_customer: kode_customerAll
                    },
                    success: function(response) {
                        let res = response.data;
                        // console.log(res);

                        $('.kode_customer').each(function(index) {
                            var kode_customer = $(this).text().trim().toUpperCase();

                            for (var i = 0; i < res.length; i++) {
                                if (kode_customer.toUpperCase() === res[i].kode_customer
                                    .toUpperCase()) {
                                    var id_wilayah = res[i]['mrdo'][0]['mr'].id_wilayah;
                                    $(this).closest('tr').find('.id_wilayah').html(id_wilayah);

                                    var salesman_awal = res[i]['mrdo'][0]['mr'].salesman;
                                    $(this).closest('tr').find('.salesman_awal').html(
                                        salesman_awal);

                                    var rute_awal = res[i]['mrdo'][0]['mr'].rute;
                                    $(this).closest('tr').find('.rute_awal').html(
                                        rute_awal);
                                    break;
                                }
                            }
                        });
                        if (typeof callback === 'function') {
                            callback(); // Menjalankan callback jika ada
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            }

            // INIT DATATABLES
            function initDatatables() {
                table = $("#myTable")
                    .DataTable({
                        "dom": "<'row'<'col-sm-12 col-md-10'B><'col-sm-12 col-md-2 text-right'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "paging": false,
                    });
            };

            // PINDAH RUTE
            $('#btnPindah').click(function(e) {
                e.preventDefault();
                var selectedRows = [];

                $('.kode_customer').each(function(index) {
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
                });

                $.ajax({
                    type: 'post',
                    url: "http://10.11.1.37/api/tool/outletkandidat/uploadpindahtokobatch",
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
            });
        });
    </script>
@endsection
