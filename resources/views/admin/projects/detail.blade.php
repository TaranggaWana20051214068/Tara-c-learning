@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Siswa')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Daftar Siswa</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">{{ $project->judul }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Siswa</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Daftar Siswa</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh siswa begabung project
                            {{ $project->judul }}</p>

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
                        {{-- <p>{{ $codes->kode }}</p> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Project</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $siswa)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $siswa->nama_siswa }}</td>
                                            <td>{{ $siswa->project->judul }}</td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <form action="{{ route('admin.projects.siswa', ['id' => $siswa->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('post')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="table-resposive text-lg-center text-white text-bg-info">Belum Ada
                                                siswa yang bergabung
                                            </td>
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
@endsection
