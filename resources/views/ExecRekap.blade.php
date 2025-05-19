@extends('layouts.app')
@section('content')
    <div class="card">
        {{-- <div class="card-header">Exec Rekap Call</div> --}}
        <div class="card-body">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table  table-light table-striped table-sm align-middle myTable">
                            <thead class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>id_salesman_mss</th>
                                <th>id depo</th>
                                <th>nama depo</th>
                                <th width="200">nama distributor</th>
                                <th width="200">response</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($data as $salesman)
                                    @php
                                        $no += 1;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $salesman->nama }}</td>
                                        <td class="fw-bold id-salesman notif">{{ $salesman->id_salesman_mss }}</td>
                                        <td>{{ $salesman->iddepo }}</td>
                                        <td>{{ $salesman->nama_depo }}</td>
                                        <td>{{ $salesman->nama_distributor }}</td>
                                        <td class="response"></td>
                                        <td>
                                            <button type="button" name="kirim[]"
                                                class="btn btn-sm rounded-3 shadow-sm btn-outline-primary kirim-satu">Upload</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
                "dom": "<'row mx-0'<'col-sm-12 col-md-6 btn_upload'><'col-sm-12 col-md-6 text-right'f>>" +
                    "<'row mx-0 py-2'<'col-sm-12'tr>>" +
                    "<'row mx-0'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "paging": false,
                "scrollY": 260,
                "columnDefs": [{
                    targets: [6, 7],
                    orderable: false
                }],
            });
            $(".btn_upload").html(
                `<div class="row row-cols-lg-auto g-3 align-items-center justify-content-center pb-3">
                    <label for="datepicker">Tgl :</label>
                    <div class="col-12">
                        <div class="input-group input-group-sm flex-nowrap">
    <input type="text" class="form-control form-control-sm" id="datepicker" placeholder="dd-mm-yy" />
    <span class="input-group-text">📅</span>
</div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-sm rounded-3 shadow-sm btn-outline-primary" id="kirim-all">
                            Upload Semua
                        </button>
                    </div>
                </div>`
            );

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0");
            var yy = String(today.getFullYear()).substr(-4);
            today = dd + "-" + mm + "-" + yy;
            $("#datepicker").val(today);
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: "dd-mm-yy",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2022, 1 - 1, 1),
                    maxDate: new Date(2030, 12 - 1, 31),
                });
            });


            // Kirim data ke server saat tombol kirim diklik
            var eksekusi = 0;
            var jumlah = 0;
            $("#kirim-all").click(function(e) {
                eksekusi = 0;
                jumlah = $(".id-salesman").length;
                var inputDate = $("#datepicker").val();
                var splitDate = inputDate.split("-");
                var newDate = splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0];
                var tgl = newDate;
                console.log(tgl);

                $(".id-salesman").each(function(index) {
                    const idSalesman = $(this).html();
                    const notif = $(this).closest("tr").find(".notif");
                    const result = $(this).closest("tr").find(".response");

                    $.ajax({
                        url: "http://10.11.1.37/api/order/execRekapCallTool",
                        type: "POST",

                        data: {
                            id_salesman: idSalesman,
                            date: tgl
                        },
                        beforeSend: function() {
                            // Tampilkan modal loading sebelum request AJAX dikirim
                            $('.loading-overlay').show();
                        },
                        success: function(response) {
                            eksekusi += 1;
                            notif.addClass('text-success');
                            result.html("<span class='text-success fw-bold'>✓ </span>" +
                                "Berhasil (" +
                                "Target = " +
                                response.target_call +
                                ", Actual = " +
                                response.actual_call +
                                ")"
                            );
                            result.addClass('text-success');
                            berhasil();
                        },
                        error: function(xhr, status, error) {
                            eksekusi += 1;
                            notif.addClass('text-danger');
                            result.html("<span class='text-success fw-bold'>X </span>" +
                                "Gagal");
                            result.addClass('text-danger');
                            berhasil();
                        },
                    });
                });
            });

            $(document).on("click", ".kirim-satu", function(index) {
                const idSalesman = $(this).closest("tr").find(".id-salesman").html();
                // const notif = $(this).closest("tr").find(".notif");
                const result = $(this).closest("tr").find(".response");
                var inputDate = $("#datepicker").val();
                var splitDate = inputDate.split("-");
                var newDate = splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0];
                var tgl = newDate;
                $.ajax({
                    url: "http://10.11.1.37/api/order/execRekapCallTool",
                    type: "POST",
                    data: {
                        id_salesman: idSalesman,
                        date: tgl
                    },
                    beforeSend: function() {
                        // Tampilkan modal loading sebelum request AJAX dikirim
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        // notif.addClass('text-success');
                        result.html("<span class='text-success fw-bold'>✓ </span>" +
                            "Berhasil (" +
                            "Target = " +
                            response.target_call +
                            ", Actual = " +
                            response.actual_call +
                            ")"
                        );
                        result.addClass('text-success');
                    },
                    error: function(xhr, status, error) {
                        // notif.addClass('text-danger');
                        result.html("<span class='text-success fw-bold'>X </span>" + "Gagal");
                        result.addClass('text-danger');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            function berhasil(eksekusi, jumlah) {
                if (eksekusi == jumlah) {
                    alert("Berhasil Terkirim Semua");
                    $('.loading-overlay').hide();
                }
            }
        });
    </script>
@endsection
