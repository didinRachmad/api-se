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
                            <th colspan="16" class="text-warning">Rute Lama</th>
                            <th colspan="3" class="text-success">Rute Baru</th>
                        </tr>
                        <tr>
                            <th>no</th>
                            <th>wilayah</th>
                            <th>id wilayah</th>
                            <th>salesman</th>
                            <th>rute</th>
                            <th>hari</th>
                            <th>rute id</th>
                            <th>rute detail id</th>
                            <th>id mrdo</th>
                            <th>survey pasar id</th>
                            <th>Kode Customer</th>
                            <th>Nama Toko</th>
                            <th>Alamat</th>
                            <th>id pasar</th>
                            <th>nama pasar</th>
                            <th>Lokasi</th>
                            <th>salesman</th>
                            <th>hari</th>
                            <th>rute</th>
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
                            var salesman = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 1
                            })];
                            var rute = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 2
                            })];
                            var hari = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 3
                            })];
                            // var rute_id = worksheet[XLSX.utils.encode_cell({
                            //     r: r,
                            //     c: 4
                            // })];
                            // var rute_detail_id = worksheet[XLSX.utils.encode_cell({
                            //     r: r,
                            //     c: 5
                            // })];
                            // var id_mrdo = worksheet[XLSX.utils.encode_cell({
                            //     r: r,
                            //     c: 6
                            // })];
                            // var survey_pasar_id = worksheet[XLSX.utils.encode_cell({
                            //     r: r,
                            //     c: 7
                            // })];
                            var kode_customer = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 8
                            })];
                            var nama_toko = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 9
                            })];
                            var alamat = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 10
                            })];
                            var id_pasar = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 11
                            })];
                            var nama_pasar = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 12
                            })];
                            var lokasi = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 13
                            })];
                            var salesman_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 14
                            })];
                            var hari_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 15
                            })];
                            var rute_tujuan = worksheet[XLSX.utils.encode_cell({
                                r: r,
                                c: 16
                            })];

                            if (
                                wilayah &&
                                salesman &&
                                // rute_id &&
                                // rute_detail_id &&
                                // id_mrdo &&
                                // survey_pasar_id &&
                                kode_customer &&
                                nama_toko &&
                                id_pasar &&
                                lokasi &&
                                salesman_tujuan &&
                                hari_tujuan &&
                                rute_tujuan
                            ) {
                                html += "<tr>";
                                html += '<td class="no">' + r + '</td>';
                                html += '<td class="wilayah">' + wilayah.v + '</td>';
                                html += '<td class="id_wilayah"></td>';
                                html += '<td class="salesman">' + salesman.v + '</td>';
                                html += '<td class="rute">' + rute.v + '</td>';
                                html += '<td class="hari">' + hari.v + '</td>';
                                html += '<td class="rute_id"></td>';
                                html += '<td class="rute_detail_id"></td>';
                                html += '<td class="id_mrdo"></td>';
                                html += '<td class="survey_pasar_id"></td>';
                                html += '<td class="kode_customer text-info">' + kode_customer.v +
                                    '</td>';
                                html += '<td class="nama_toko">' + nama_toko.v + '</td>';
                                html += '<td class="alamat">' + alamat.v + '</td>';
                                html += '<td class="id_pasar">' + id_pasar.v + '</td>';
                                html += '<td class="nama_pasar">' + nama_pasar.v + '</td>';
                                html += '<td class="lokasi">' + lokasi.v + '</td>';
                                html += '<td class="salesman_tujuan">' + salesman_tujuan.v + '</td>';
                                html += '<td class="hari_tujuan">' + hari_tujuan.v + '</td>';
                                html += '<td class="rute_tujuan">' + rute_tujuan.v + '</td>';
                                html += "</tr>";
                            }
                        }
                        $("#tbody-data").html(html);
                        isiDataOutlet();
                    };
                    reader.readAsArrayBuffer(file);
                }
            });

            function isiDataOutlet() {
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

                            // Loop melalui data dalam res
                            for (var i = 0; i < res.length; i++) {
                                if (kode_customer === res[i].kode_customer) {
                                    // Jika kode_customer cocok, Anda dapat mengambil data sesuai indeks i di res
                                    var id_wilayah = res[i]['mrdo'][0]['mr'].id_wilayah;
                                    var rute_id = res[i]['mrdo'][0].rute_id;
                                    var rute_detail_id = res[i]['mrdo'][0].rute_detail_id;
                                    var id_mrdo = res[i]['mrdo'][0].id;
                                    var survey_pasar_id = res[i]['mrdo'][0].survey_pasar_id;

                                    // Lakukan sesuatu dengan data yang Anda ambil di sini
                                    // Misalnya, Anda bisa mengisinya ke dalam elemen HTML yang sesuai
                                    // Contoh:
                                    $(this).closest('tr').find('.id_wilayah').html(id_wilayah);
                                    $(this).closest('tr').find('.rute_id').html(rute_id);
                                    $(this).closest('tr').find('.rute_detail_id').html(
                                        rute_detail_id);
                                    $(this).closest('tr').find('.id_mrdo').html(id_mrdo);
                                    $(this).closest('tr').find('.survey_pasar_id').html(
                                        survey_pasar_id);

                                    // Keluar dari loop karena Anda sudah menemukan yang cocok
                                    break;
                                }
                            }
                        });
                    },

                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            }

            // // PINDAH RUTE
            // $('#btnPindah').click(function(e) {
            //     e.preventDefault();

            //     var selectedRows = [];
            //     $('.check:checked').each(function(index) {
            //         var id_mrdo = $(this).closest('tr').find('.id_mrdo').text().trim();
            //         var rute_id = $(this).closest('tr').find('.rute_id').text().trim();
            //         var rute_detail_id = $(this).closest('tr').data('rute_detail_id');
            //         var id_pasar = $(this).closest('tr').find('.id_pasar').text().trim();
            //         var survey_pasar_id = $(this).closest('tr').data('survey_pasar_id');
            //         var kode_customer = $(this).closest('tr').find('.kode_customer').text().trim();
            //         var wilayah = $(this).closest('tr').find('.wilayah').text() trim();
            //         var location_type = $(this).closest('tr').find('.lokasi').text() trim();
            //         var toko = $(this).closest('tr').find('.nama_toko').text().trim();

            //         var dataObject = {};
            //         dataObject['id_mrdo'] = id_mrdo;
            //         dataObject['rute_id'] = rute_id;
            //         dataObject['rute_detail_id'] = rute_detail_id;
            //         dataObject['id_pasar'] = id_pasar;
            //         dataObject['survey_pasar_id'] = survey_pasar_id;
            //         dataObject['kode_customer'] = kode_customer;
            //         dataObject['wilayah'] = wilayah;
            //         dataObject['salesman'] = salesman_awal;
            //         dataObject['location_type'] = location_type;
            //         dataObject['toko'] = toko;

            //         selectedRows.push(dataObject);

            //         var salesman_akhir = $(this).closest('tr').find('.salesman_tujuan').text()
            //             .trim();
            //         var hari = $(this).closest('tr').find('.hari_tujuan').text().trim();
            //         var rute = $(this).closest('tr').find('.rute_tujuan').text().trim();
            //     });

            //     $.ajax({
            //         type: 'post',
            //         url: "http://10.11.1.37/api/tool/outletkandidat/pindahoutlet",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             salesman: salesman_akhir,
            //             hari: hari,
            //             rute: rute,
            //             data_all: selectedRows
            //         },
            //         beforeSend: function() {
            //             $('.loading-overlay').show();
            //         },
            //         success: function(response) {
            //             if (response.is_valid) {
            //                 $('#successModal').modal('show');
            //                 setTimeout(function() {
            //                     $('#successModal').modal('hide');
            //                     location.reload();
            //                 }, 2000);
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

            // PINDAH RUTE
            $('#btnPindah').click(function(e) {
                e.preventDefault();

                var selectedRows = [];

                $('.id_mrdo').each(function() {
                    var id = $(this).text().trim();
                    var id_pasar_awal = $(this).closest('tr').find('.id_pasar').text().trim();
                    var id_survey_pasar = $(this).closest('tr').find('.survey_pasar_id').text()
                        .trim();
                    var salesman_tujuan = $(this).closest('tr').find('.salesman_tujuan').text()
                    var hari_tujuan = $(this).closest('tr').find('.hari_tujuan').text()
                        .trim();
                    selectedRows.push({
                        id: id,
                        id_pasar_awal: id_pasar_awal,
                        id_survey_pasar: id_survey_pasar,
                        salesman_tujuan: salesman_tujuan,
                        hari_tujuan: hari_tujuan
                    });
                });
                // console.log(selectedRows);
                $.ajax({
                    type: 'post',
                    url: "{{ route('ToolExcel.pindah') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        detail: selectedRows
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        // console.log(response.message);
                        $('#successModal #message').text(response.message);
                        $('#successModal').modal('show');
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            // location.reload();
                        }, 2000);
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

            // // CEK RUTE AKTIF
            // var nama_sales = $('#salesman_awal').val();
            // if (nama_sales !== '') {
            //     var iddepo = $('#nama_wilayah').text().match(/\(([^()]+)\)[^(]*$/)[1];
            //     $.ajax({
            //         type: 'post',
            //         url: "http://10.11.1.37/api/tool/rute/getData",
            //         dataType: 'json',
            //         encode: true,
            //         data: {
            //             nama_sales: nama_sales,
            //             iddepo: iddepo
            //         },
            //         success: function(response) {
            //             $('.warnaBaris').each(function() {
            //                 var ruteId = $(this).find('.rute_id').text().trim();
            //                 var rute = $(this).find('.rute');
            //                 if (ruteId == response.rute_hari_ini) {
            //                     rute.addClass('text-success fw-bolder shadow-lg');
            //                 }
            //             });
            //         },
            //         error: function(xhr, status, error) {},
            //         complete: function() {}
            //     });
            // }
        });
    </script>
@endsection
