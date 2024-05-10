@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Quiz')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Quiz</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Quiz</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Quiz</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar judul quiz</p>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="" class="form-inline">
                                    <input type="text" class="form-control mr-2" placeholder="Cari Data" name='search'>
                                    <button type="submit" class='btn btn-primary'>Cari</button>
                                </form>
                            </div>
                            <div class="col-md-2 ml-auto">
                                <a class="btn btn-primary float-right" href="{{ route('admin.quizs.create') }}">Tambah</a>
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
                                        <th>Total Pertanyaan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($quizs as $quiz)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $quiz->category }}</td>
                                            <td>{{ $quiz->total }}</td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <a href="{{ route('admin.quizs.detail', ['category' => $quiz->category]) }}"
                                                        class="btn btn-info text-white">Lihat
                                                        <i class="bi bi-arrow-right-circle"></i></a>
                                                    {{-- <form action="{{ route('admin.quizs.destroy', ['quiz' => $quiz->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class='text-center'>Data tidak ditemukan, Mohon <a
                                                    href="{{ route('admin.quizs.create') }}">Tambah
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
                            {{ $quizs->links() }}
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
