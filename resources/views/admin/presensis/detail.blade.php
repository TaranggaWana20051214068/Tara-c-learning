@extends('layouts.master')

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('title', 'Izin')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Izin</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Izin</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Seluruh Siswa</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh siswa yang izin/sakit.</p>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="" class="form-inline">
                                    <input type="text" class="form-control mr-2" placeholder="Cari Data" name='search'>
                                    <button type="submit" class='btn btn-primary'>Cari</button>
                                </form>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Tanggal Izin</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($data->tgl_izin)) }}</td>
                                            <td>{{ $data->status == 's' ? 'Sakit' : 'Izin' }}</td>
                                            <td>{{ $data->keterangan }}</td>
                                            <td>
                                                @if ($data->status_approved == 0)
                                                    <button class="btn btn-warning approv-btn"
                                                        data-id="{{ $data->id }}"><i
                                                            class="bi bi-exclamation-triangle"></i></button>
                                                @elseif($data->status_approved == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data available to show</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="paginate float-right mt-3">
                            {{ $students->links() }}
                        </div>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.approv-btn', function(e) {
                var id = $(this).data('id');
                let that = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Dengan ini anda menyetujui izin.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, approved it!"
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: '/admin/presensis/izin/approved',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            cache: false,
                            success: function(respond) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: respond.success,
                                }).then(() => {
                                    location
                                        .reload(); // Refresh halaman setelah sukses
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: error
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
