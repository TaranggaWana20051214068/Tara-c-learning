@extends('layouts.master')

@section('css')
    <!-- Plugins css -->
@endsection
@section('title', 'Presensi')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Presensi</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Presensi</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Presensi</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh Presensi</p>

                        <div class="row mb-3">
                            <div class="col-md-2 ml-auto">
                                <a class="btn btn-primary float-right" href="{{ route('admin.presensis.detail') }}">Lihat
                                    Izin</a>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="" selected disabled>- Pilih bulan -</option>
                                        <option value="">Semua</option>
                                        @foreach ($monthName as $key => $month)
                                            <option value="{{ $key }}"
                                                {{ request()->input('bulan') == $key ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value=""selected disabled>Pilih tahun</option>
                                        @php
                                            $startYear = 2023;
                                            $endYear = date('Y');
                                        @endphp
                                        @for ($tahun = $startYear; $tahun <= $endYear; $tahun++)
                                            <option value="{{ $tahun }}"
                                                {{ request()->input('tahun') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Nama Siswa</label>
                                    <select name="name" id="name" class="form-select">
                                        <option value="" selected disabled>- Pilih nama siswa -
                                        </option>
                                        <option value="">Semua</option>
                                        @foreach ($siswa as $nama)
                                            <option value="{{ $nama }}"
                                                {{ request()->input('name') == $nama ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" id="button-search" class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </div>
                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi-lg bi-check-circle flex-shrink-0 me-2"></i>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        <div class="col" id="showHistoryy"></div>
                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection

@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
    {{-- history --}}
    <script>
        $(function() {
            $('#button-search').click(function(e) {
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                var name = $('#name').val();
                $.ajax({
                    type: 'POST',
                    url: '/admin/presensis/history',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                        name: name,
                    },
                    cache: false,
                    success: function(respond) {
                        $('#showHistoryy').html(respond);
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
