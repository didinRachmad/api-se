@extends('layouts.app')

@section('content')
    <div class="row justify-content-center text-center p-5 text-white">
        <div class="col-md-5 col-sm-12 mb-3 align-self-center">
            <input class="form-control form-control-sm" type="file" id="file-gambar" accept="image/*" maxfilesize="10485760"
                capture="camera" />
        </div>
        <div class="col-md-5 col-sm-12 mb-3 align-self-center">
            <div class="input-group input-group-sm">
                <span class="input-group-text">Nama Foto</span>
                <input class="form-control" type="text" id="nama-gambar" />
            </div>
        </div>
        <div class="col-md-2 col-sm-12 mb-3 align-self-center">
            <button class="btn btn-outline-success btn-sm tambah">Tambah Data</button>
            <button class="btn btn-outline-primary btn-sm kirim">Absen</button>
        </div>
    </div>
    <div class="row justify-content-center text-center text-white">
        <div class="col-md-6 my-3">
            <img id="hasil-gambar" src="#" alt="hasil" height="300" style="display: none" />

            <div class="message mb-3"></div>
        </div>
    </div>

    <div class="loading-overlay" style="display: none">
        <div class="card">
            <div class="card-body">
                <div class="spinner-grow m-5 text-primary" style="width: 6rem; height: 6rem" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".tambah").click(function(e) {
            // Mendapatkan data gambar
            var file_data = $("#file-gambar").prop("files")[0];
            var fileName = $("#nama-gambar").val();
            var url = URL.createObjectURL(file_data);

            // Membuat objek untuk kompresi gambar
            var reader = new FileReader();
            reader.readAsDataURL(file_data);
            reader.onload = function() {
                var img = new Image();
                img.src = reader.result;
                img.onload = function() {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    var width = img.width;
                    var height = img.height;
                    var ratio = 1;
                    if (file_data.size > 100000) {
                        ratio = Math.sqrt(100000 / file_data.size);
                        width = width * ratio;
                        height = height * ratio;
                    }
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    var base64image = canvas.toDataURL("image/jpeg", 0.5);

                    // Membuat request AJAX
                    $.ajax({
                        type: "POST",
                        url: "http://127.0.0.1:5000/addPerson",
                        data: JSON.stringify({
                            label: fileName,
                            image: base64image,
                        }),
                        contentType: "application/json",
                        beforeSend: function() {
                            $(".loading-overlay").show();
                        },
                        success: function(response) {
                            if (response.success) {
                                $("#hasil-gambar").attr("src", url);
                                $("#hasil-gambar").show();
                                $(".message").html(response.message);
                            } else {
                                $("#hasil-gambar").hide();
                                $(".message").html(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            console.log(xhr.responseJSON);
                        },
                        complete: function() {
                            $(".loading-overlay").hide();
                        },
                    });
                };
            };
        });

        $(".kirim").click(function(e) {
            // Mendapatkan data gambar
            var file_data = $("#file-gambar").prop("files")[0];
            var fileName = file_data.name.substring(
                0,
                file_data.name.lastIndexOf(".")
            );
            // Membuat objek untuk kompresi gambar
            var reader = new FileReader();
            reader.readAsDataURL(file_data);
            reader.onload = function() {
                var img = new Image();
                img.src = reader.result;
                img.onload = function() {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    var width = img.width;
                    var height = img.height;
                    var ratio = 1;
                    if (file_data.size > 100000) {
                        ratio = Math.sqrt(100000 / file_data.size);
                        width = width * ratio;
                        height = height * ratio;
                    }
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    var base64image = canvas.toDataURL("image/jpeg", 0.5);

                    $.ajax({
                        type: "POST",
                        url: "http://127.0.0.1:5000/recognize",
                        data: JSON.stringify({
                            label: fileName,
                            image: base64image,
                        }),
                        contentType: "application/json",
                        beforeSend: function() {
                            $(".loading-overlay").show();
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response.success) {
                                $("#hasil-gambar").attr(
                                    "src",
                                    "data:image/jpeg;base64," + response.image
                                );
                                $("#hasil-gambar").show();
                                $(".message").html("Data ditemukan : " + response.message);
                            } else {
                                $("#hasil-gambar").hide();
                                $(".message").html(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            console.log(xhr.responseJSON);
                        },
                        complete: function() {
                            $(".loading-overlay").hide();
                        },
                    });
                };
            };
        });
    </script>
@endsection
