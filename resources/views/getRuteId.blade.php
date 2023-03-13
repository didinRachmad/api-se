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

        .editAlamat {
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
        <div class="card-header">Search Data by Route ID</div>
        <div class="card-body card-body-custom">
            <form class="form" method="POST" action="{{ route('getRuteId.getDataByRuteId') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <label for="salesman" class="sr-only">Salesman</label>
                        <select class="form-control select2-salesman w-100" name="salesman" id="salesman"
                            onchange="tes(this.value)">
                            <option value="{{ old('salesman', $salesman ?? '') }}">
                                {{ old('salesman', $salesman ?? '') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="rute_id" class="sr-only">Rute</label>
                        <select class="form-control select2-rute w-100" name="rute_id" id="rute_id">
                            <option value="{{ old('rute_id', $rute_id ?? '') }}">
                                {{ old('rute', $rute ?? '') }}</option>
                        </select>
                        <input type="hidden" id="select2-rute-rute" name="rute">
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-sm mb-2">Search</button>
                    </div>
                </div>
            </form>
            @if (!isset($data))
                @php
                    $data = collect();
                @endphp
            @endif
            <h3>Hasil Pencarian:</h3>
            <div class="row">
                <div class="col-lg-12">
                    <p class="d-inline-block pr-3">Distributor : <span
                            class="font-weight-bold">{{ $data->first()->d->nama_distributor ?? '' }}
                            ({{ $data->first()->d->id_distributor ?? '' }})
                        </span>
                    </p>
                    <p class="d-inline-block pr-3">Wilayah : <span
                            class="font-weight-bold">{{ $data->first()->w->nama_wilayah ?? '' }}
                            ({{ $data->first()->w->id_wilayah ?? '' }})</span></p>
                    <p class="d-inline-block pr-3">Nama Salesman : <span
                            class="font-weight-bold">{{ $data->first()->salesman ?? '' }}</span>
                    </p>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered myTable">
                    <thead class="thead-dark text-center">
                        <th>no</th>
                        <th>rute</th>
                        <th>hari</th>
                        <th>rute id</th>
                        <th>rute detail id</th>
                        <th>survey pasar id</th>
                        <th>Kode Customer</th>
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>Nama Pemilik</th>
                        <th>id pasar mrd</th>
                        <th>nama pasar mrd</th>
                        <th>id pasar mrdo</th>
                        <th>nama pasar mp</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($data as $mr)
                            @foreach ($mr->mrdo as $mrdo)
                                @foreach ($mrdo->mco as $mco)
                                    @php
                                        $no += 1;
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td class="text-success">{{ $mr->rute }}</td>
                                        <td>{{ $mr->hari }}</td>
                                        <td>{{ $mrdo->rute_id }}</td>
                                        <td>{{ $mrdo->rute_detail_id }}</td>
                                        <td>{{ $mrdo->survey_pasar_id }}</td>
                                        <td class="text-primary font-weight-bold">{{ $mco->kode_customer }}</td>
                                        <td>{{ $mrdo->nama_toko }}</td>
                                        <td id="alamat{{ $no }}">{{ $mrdo->alamat }}</td>
                                        <td>{{ $mrdo->nama_pemilik }}</td>
                                        <td>{{ $mrdo->mrd->id_pasar }}</td>
                                        <td>{{ $mrdo->mrd->nama_pasar }}</td>
                                        <td>{{ $mrdo->id_pasar }}</td>
                                        <td>{{ $mrdo->mp->nama_pasar ?? '' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning editAlamat"
                                                data-row-index="{{ $no }}"
                                                data-alamat-awal="{{ $mrdo->alamat }}"
                                                data-id_mrdo="{{ $mrdo->id }}">Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajax-form">
                        @csrf
                        <!-- Tambahkan kolom baru -->
                        <div class="form-group">
                            <input type="hidden" id="index" name="index" readonly>
                            <input type="hidden" id="id_mrdo" name="id_mrdo" readonly>
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

    <script>
        function tes(value) {
            console.log(value);
        }

        $(document).ready(function() {
            $('.select2-salesman').select2({
                ajax: {
                    url: "{{ route('getSalesman') }}",
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
                    url: "{{ route('getRute') }}",
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
                "lengthMenu": [10, 25, 50, 75, 100, 500],
                "pageLength": 500
            });

            // Event handler untuk tombol edit pada baris tabel
            $(document).on('click', ".editAlamat", function() {
                var index = $(this).data('row-index');
                var id_mrdo = $(this).data('id_mrdo');
                var alamatAwal = $(this).data('alamat-awal');

                // Set nilai kolom alamat awal dan nama pasar pada modal
                $('#index').val(index);
                $('#id_mrdo').val(id_mrdo);
                $('#alamat-awal').val(alamatAwal);

                // Tampilkan modal edit
                $('#editModal').modal('show');
            });

            $(document).on('click', "#saveEditAlamat", function() {
                // Ambil nilai kolom input field
                var id_mrdo = $('#id_mrdo').val();
                var alamatBaru = $('#alamat-baru').val();

                // Ambil urutan baris tabel terkait dengan modal edit
                var rowIndex = $('#index').val();

                // Lakukan update pada data di database
                $.ajax({
                    type: 'post',
                    url: "{{ route('getRuteId.updateAlamat') }}",
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
                        $('#alamat' + rowIndex).text(response.alamat);

                        // Sembunyikan modal
                        $('#editModal').modal('hide');

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
        });
    </script>
@endsection
