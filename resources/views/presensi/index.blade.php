@extends('layouts.app')

@section('content')
@section('title', 'Presensi')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="student">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#presensi">Presensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#history">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#izin">Izin</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content" id="myTab">
                    <div id="presensi" class="tab-pane fade show active">
                        <h3 class='mb-3'>{{ auth()->user()->name }}</h3>
                        @if (empty($presensi->jam_out))
                            <div class="row">
                                <div class="col">
                                    <p id="currentDateTime"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    @if ($check > 0)
                                        <button id="takeabsen" class="btn btn-primary"><ion-icon
                                                name="camera"></ion-icon>Absen
                                            Pulang</button>
                                    @else
                                        <button id="takeabsen" class="btn btn-primary"><ion-icon
                                                name="camera"></ion-icon>Absen
                                            Masuk</button>
                                    @endif
                                </div>
                            </div>
                        @else
                            <h5>Anda Sudah presensi hari ini, selamat istirahat.</h5>
                        @endif
                    </div>
                    <div id="history" class="tab-pane fade show">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="bulan" id="bulan" class="form-control">
                                                <option value="" class="text-mute">- Select month -</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ date('m') == $i ? 'selected' : '' }}>{{ $monthName[$i] }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="tahun" id="tahun" class="form-control">
                                                <option value="">Year</option>
                                                @php
                                                    $startYear = 2023;
                                                    $endYear = date('Y');
                                                @endphp
                                                @for ($tahun = $startYear; $tahun <= $endYear; $tahun++)
                                                    <option value="{{ $tahun }}"
                                                        {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" id="button-search">
                                                <ion-icon name="search-outline"></ion-icon>
                                                Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" id="showHistory"></div>
                        </div>
                    </div>
                    <div id="izin" class="tab-pane fade show">
                        <div id="containerIzin" onload="loadIzinData()"></div>
                        <button style="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Add <i class="bi bi-plus-circle" style="font-size: 1rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add izin/sakit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="date" name="tgl_izin" id="tgl_izin"
                                    class='form-control  @error('tgl_izin') is-invalid @enderror'
                                    value="{{ old('tgl_izin') }}">
                                @error('tgl_izin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control">
                                    <option value="" class="text-muted">- Pilih -</option>
                                    <option value="i">Izin</option>
                                    <option value="s">Sakit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"
                                    placeholder="Tulis keterangan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="button-izin" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
            <audio type="audio/mpeg" id="notif_in" src="{{ asset('assets/audio/in.wav') }}"></audio>
            <audio type="audio/mpeg" id="notif_out" src="{{ asset('assets/audio/out.wav') }}"></audio>
        </div>
    </div>
</section>

@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
@endsection
@section('script-bottom')
@if (empty($presensi->jam_out))
    <script>
        var notif_in = document.getElementById('notif_in');
        var notif_out = document.getElementById('notif_out');

        // Fungsi untuk mendapatkan waktu dan tanggal saat ini
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentDateTime').innerText = `Tanggal: ${date} | Jam: ${time}`;
        }

        // Memperbarui waktu dan tanggal setiap detik
        setInterval(updateDateTime, 1000);

        // Memperbarui waktu dan tanggal saat halaman pertama kali dimuat
        updateDateTime();

        function errorCallback() {

        }

        $('#takeabsen').click(function(e) {
            $.ajax({
                type: "POST",
                url: "/presensi/camera-snap",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split('|');
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notif_in.play();
                        } else {
                            notif_out.play();
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success'
                        })
                        setTimeout("location.href='/home'", 2500);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error'
                        })
                    }
                }
            })
        });
    </script>
@endif
{{-- history --}}
<script>
    $(function() {
        $('#button-search').click(function(e) {
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            $.ajax({
                type: 'POST',
                url: '/presensi/get-history',
                data: {
                    _token: "{{ csrf_token() }}",
                    bulan: bulan,
                    tahun: tahun,
                },
                cache: false,
                success: function(respond) {
                    $('#showHistory').html(respond);
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: "error",
                        title: error
                    });
                }
            });
        });
    });
</script>
{{-- izin --}}
<script>
    function loadIzinData() {
        $.ajax({
            type: 'GET',
            url: '/presensi/presensi-izin',
            cache: false,
            success: function(respond) {
                $('#containerIzin').html(respond);
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: "error",
                    title: error
                });
            }
        });
    }
    $(document).ready(function() {
        loadIzinData();
    });

    $(function() {
        $('#button-izin').click(function(e) {
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = $('#keterangan').val();
            // Pengecekan untuk inputan kosong
            if (!tgl_izin || !status || !keterangan) {
                Swal.fire({
                    icon: "error",
                    title: 'Kesalahan',
                    text: "data tidak boleh kosong",
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: '/presensi/presensi-izin/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_izin: tgl_izin,
                    status: status,
                    keterangan: keterangan,
                },
                cache: false,
                success: function(respond) {
                    Swal.fire({
                        icon: "success",
                        title: 'Berhasil',
                        text: respond.success,
                    });
                    $('#exampleModal').modal('hide');
                    loadIzinData();
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: "error",
                        title: error
                    });
                }
            });
        });
    });
</script>
@endsection
