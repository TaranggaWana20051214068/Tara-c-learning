@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Project')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Project</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Project</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Project</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh project</p>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="" class="form-inline">
                                    <input type="text" class="form-control mr-2" placeholder="Cari Data" name='search'>
                                    <button type="submit" class='btn btn-primary'>Cari</button>
                                </form>
                            </div>
                            <div class="col-md-2 ml-auto">
                                <a class="btn btn-primary float-right"
                                    href="{{ route('admin.projects.create') }}">Tambah</a>
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
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>Tugas</th>
                                        <th>Siswa</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $project->judul }}</td>
                                            <td>{{ substr($project->deskripsi, 0, 50) }}..</td>
                                            <td><a href="{{ route('admin.projects.show', ['project' => $project->id]) }}"
                                                    class='btn btn-outline-primary mr-2'><i
                                                        class="bi bi-pencil-square"></i></a></a>
                                            </td>
                                            <td><a href="{{ route('admin.projects.show', ['project' => $project->id]) }}"
                                                    class='btn btn-outline-primary mr-2'><i class="bi bi-people"></i></a>
                                            </td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <a href="{{ route('admin.projects.edit', ['project' => $project->id]) }}"
                                                        class='btn btn-warning mr-2'><i class="bi bi-pencil-fill"></i></a>
                                                    <form
                                                        action="{{ route('admin.projects.destroy', ['project' => $project->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @forelse ($projects as $project)
                                    @empty
                                        <tr>
                                            <td colspan="5" class='text-center'>Data tidak ditemukan, Mohon <a
                                                    href="{{ route('admin.projects.create') }}">Tambah
                                                    Data</a></td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <div></div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="paginate float-right mt-3">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection

@section('script')

    <script src="{{ asset('js/main.js') }}"></script>
@endsection
@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
@endsection
