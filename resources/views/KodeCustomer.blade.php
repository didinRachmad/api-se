@extends('layouts.app')
@section('content')
    <style>
        .card-body-custom {
            /* padding: 5px; */
            /* ukuran padding yang lebih kecil */
            font-size: smaller;
            /* ukuran font yang lebih kecil */
        }

        .myTable {
            font-size: 8pt;
            font-weight: 600;
            padding: 5px;
        }

        .btn-sm {
            font-size: 8pt;
        }

        .select2-results__option {
            font-size: 8pt;
        }

        .select2-search__field {
            height: 25px;
            font-size: 8pt;
        }

        p {
            margin: 0;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 0 5px;
        }
    </style>

    <div class="card">
        <div class="card-header">Search Data by Kode Customer</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('KodeCustomer.getDataByKodeCustomer') }}">
                @csrf
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <input type="search" name="kode_customer" class="form-control form-control-sm" id="kode_customer"
                            placeholder="Kode Customer" value="{{ old('kode_customer', $kode_customer ?? '') }}" required
                            oninvalid="this.setCustomValidity('Harap isi kode customer')" oninput="setCustomValidity('')">
                    </div>
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary btn-sm">Search <span> <i
                                    class="bi bi-search"></i></span></button>
                    </div>
                </div>
            </form>

            @if (!isset($data))
                @php
                    $data = collect();
                @endphp
            @endif
            {{-- <h3>Hasil Pencarian:</h3> --}}
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered myTable">
                    <thead class="thead-dark text-center">
                        <th>Wilayah</th>
                        <th>Salesman</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>rute detail id</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer</th>
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>id pasar mrd</th>
                        <th>nama pasar mrd</th>
                        <th>id pasar mrdo</th>
                        <th>nama pasar mp</th>
                        <th>Tipe Outlet</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($data as $mco)
                            @php
                                $no += 1;
                            @endphp
                            <tr>
                                <td>{{ $mco->mrdo?->mr->w->nama_wilayah . ' (' . $mco->mrdo?->mr->w->id_wilayah . ') ' }}
                                </td>
                                <td>{{ $mco->mrdo?->mr->salesman }}</td>
                                <td class="text-success">{{ $mco->mrdo?->mr->rute }}</td>
                                <td>{{ $mco->mrdo?->mr->hari }}</td>
                                <td>{{ $mco->mrdo?->rute_id }}</td>
                                <td>{{ $mco->mrdo?->rute_detail_id }}</td>
                                <td>{{ $mco->mrdo?->survey_pasar_id }}</td>
                                <td class="text-primary font-weight-bold" id="kode{{ $no }}">
                                    {{ $mco->kode_customer }}</td>
                                <td>{{ $mco->mrdo?->nama_toko }}</td>
                                <td id="alamat{{ $no }}">{{ $mco->mrdo?->alamat }}</td>
                                <td>{{ $mco->mrdo?->mrd->id_pasar }}</td>
                                <td>{{ $mco->mrdo?->mrd->nama_pasar }}</td>
                                <td>{{ $mco->mrdo?->id_pasar }}</td>
                                <td>{{ $mco->mrdo?->mp->nama_pasar ?? ('' ?? '') }}</td>
                                <td id="tipe_outlet{{ $no }}">{{ $mco->mrdo?->tipe_outlet ?? 'RETAIL' }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning editAlamat w-100"
                                        data-row-index="{{ $no }}" data-alamat-awal="{{ $mco->mrdo?->alamat }}"
                                        data-id_mrdo="{{ $mco->mrdo?->id }}">Alamat</button>
                                    <button type="button" class="btn btn-sm btn-primary editKode w-100"
                                        data-row-index="{{ $no }}" data-kode-awal="{{ $mco->kode_customer }}"
                                        data-id_mco="{{ $mco->id }}">Kode</button>
                                    <button type="button" class="btn btn-sm btn-info w-100" id="setRetail"
                                        data-row-index="{{ $no }}" data-id_mrdo="{{ $mco->mrdo?->id }}"
                                        data-id_mco="{{ $mco->id }}" data-set={{ null }}>Retail</button>
                                    <button type="button" class="btn btn-sm btn-success w-100" id="setGrosir"
                                        data-row-index="{{ $no }}" data-id_mrdo="{{ $mco->mrdo?->id }}"
                                        data-id_mco="{{ $mco->id }}" data-set="TPOUT_WHSL">Grosir</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit Alamat -->
    <div class="modal fade" id="editAlamatModal" tabindex="-1" role="dialog" aria-labelledby="editAlamatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlamatModalLabel">Edit Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAlamat">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <input type="hidden" id="index-ALAMAT" name="index-ALAMAT" readonly>
                            <input type="hidden" id="id_mrdo-ALAMAT" name="id_mrdo-ALAMAT" readonly>
                            <label for="alamat-awal">Alamat Awal</label>
                            <input type="text" class="form-control" id="alamat-awal" name="alamat-awal" readonly>
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="alamat-baru">Alamat Baru</label>
                            <input type="text" class="form-control" id="alamat-baru" name="alamat-baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditAlamat">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kode Customer -->
    <div class="modal fade" id="editKodeModal" tabindex="-1" role="dialog" aria-labelledby="editKodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKodeModalLabel">Edit Kode Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editKode">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <input type="hidden" id="index-KODE" name="index-KODE" readonly>
                            <input type="hidden" id="id_mco-KODE" name="id_mco-KODE" readonly>
                            <label for="kode-awal">Kode Customer Awal</label>
                            <input type="text" class="form-control" id="kode-awal" name="kode-awal" readonly>
                        </div>
                        <!-- Kolom input field untuk alamat yang akan diupdate -->
                        <div class="form-group">
                            <label for="kode-baru">Kode Customer Baru</label>
                            <input type="text" class="form-control" id="kode-baru" name="kode-baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditKode">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2-salesman').select2({
                ajax: {
                    url: "{{ route('RuteId.getSalesman') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih salesman',
                // minimumInputLength: 3,
                allowClear: true
            });

            var rute = '';
            $('.select2-rute').select2({
                ajax: {
                    url: "{{ route('RuteId.getRute') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            salesman: $('.select2-salesman').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih Rute',
                // minimumInputLength: 3,
                allowClear: true,
                templateSelection: function(data) {
                    if (data.id === '') { // jika nilai kosong dipilih
                        return 'Pilih Rute';
                    } else {
                        rute = data.text;
                        return data.text; // tampilkan teks nilai yang dipilih
                    }
                },
            }).on('change', function() {
                $('#select2-rute-rute').val(rute);
                console.log(rute); // mengubah nilai input field tersembunyi
            });

            $('.myTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-5 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    'copy', 'csv', {
                        extend: 'excel',
                        title: 'Data ' + $('#nama-salesman').text() + " - " + $('#nama-distributor')
                            .text() + " - " +
                            $('#nama-wilayah').text(),
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    }, 'pdf', 'print'
                ],
                columnDefs: [{
                    targets: [14], // kolom pertama
                    className: 'no-export' // kelas no-export
                }],
                "lengthMenu": [10, 25, 50, 75, 100, 500],
                "pageLength": 500
            });

            // INIT EDIT ALAMAT
            $(document).on('click', ".editAlamat", function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var alamatAwal = $('#alamat' + index).text().trim();

                $('#index-ALAMAT').val(index);
                $('#id_mrdo-ALAMAT').val(id_mrdo);
                $('#alamat-awal').val(alamatAwal);

                // Tampilkan modal edit
                $('#editAlamatModal').modal('show');
            });

            // INIT EDIT KODE
            $(document).on('click', ".editKode", function() {
                var index = $(this).data('row-index');
                var id_mco = $(this).data('id_mco');
                var kodeAwal = $('#kode' + index).text().trim();

                $('#index-KODE').val(index);
                $('#id_mco-KODE').val(id_mco);
                $('#kode-awal').val(kodeAwal);

                // Tampilkan modal edit
                $('#editKodeModal').modal('show');
            });

            // EDIT ALAMAT
            $(document).on('click', "#saveEditAlamat", function() {
                // Ambil nilai kolom input field
                var id_mrdo = $('#id_mrdo-ALAMAT').val();
                var alamatBaru = $('#alamat-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var index = $('#index-ALAMAT').val();

                // Lakukan update pada data di database
                $.ajax({
                    type: 'post',
                    url: "{{ route('KodeCustomer.updateAlamat') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        id: id_mrdo,
                        alamat: alamatBaru
                    },
                    beforeSend: function() {
                        // Tampilkan modal loading sebelum request AJAX dikirim
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        // Update data pada tabel
                        $('#alamat' + index).text(response.alamat);

                        // Sembunyikan modal
                        $('#editAlamatModal').modal('hide');

                        // Sembunyikan modal loading setelah modal edit tertutup

                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);

                        // Sembunyikan modal loading setelah modal edit tertutup

                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            // EDIT KODE
            $(document).on('click', '#saveEditKode', function() {
                var id_mco = $('#id_mco-KODE').val();
                var kodeBaru = $('#kode-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var index = $('#index-KODE').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('KodeCustomer.updateKode') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        id_mco: id_mco,
                        kodeBaru: kodeBaru
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#kode' + index).text(response.kode_customer);
                        $('#editKodeModal').modal('hide');
                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#errorModal').modal('show');
                    },
                    complete: function() {
                        $('.loading-overlay').hide();
                    }
                });
            });

            // SET RETAIL
            $(document).on('click', '#setRetail, #setGrosir', function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var id_mco = $(this).data('id_mco');
                var set = $(this).data('set');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('KodeCustomer.setOutlet') }}",
                    dataType: 'json',
                    encode: true,
                    data: {
                        // _token: "{{ csrf_token() }}",
                        id_mrdo: id_mrdo,
                        id_mco: id_mco,
                        set: set
                    },
                    beforeSend: function() {
                        $('.loading-overlay').show();
                    },
                    success: function(response) {
                        $('#tipe_outlet' + index).text(response.tipe_outlet ?? "RETAIL");

                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
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
