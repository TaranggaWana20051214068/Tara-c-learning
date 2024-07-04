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

                        <form action="" class="form-inline">
                            <div class="row mb-3">
                                <div class="col-md-5 mb-3">
                                    <div class="input-group">
                                        <select name="subject" id="subject" class="form-select">
                                            <option value="" selected disabled>- Pilih Mata Pelajaran -</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ request()->input('subject') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari Data" name="search"
                                            value="{{ request()->get('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 ml-auto float-right">
                                    <a class="btn btn-primary " href="{{ route('admin.quizs.create') }}">Tambah</a>
                                </div>
                            </div>
                        </form>
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
                                                    <a href="{{ route('admin.quizs.siswa', ['category' => $quiz->category]) }}"
                                                        class="btn btn-warning mr-2">Siswa
                                                        <i class="bi bi-people"></i></a>
                                                    <a href="{{ route('admin.quizs.detail', ['category' => $quiz->category]) }}"
                                                        class="btn btn-info text-white">Lihat Soal
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
                                            <td colspan="4" class='text-center'>Data tidak ditemukan, Mohon
                                                @if (request()->search || request()->subject)
                                                    <a href="{{ route('admin.quizs.index') }}">Kembali</a>
                                                @else
                                                    <a href="{{ route('admin.quizs.create') }}">Tambah</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
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
    @if ($subjects->isEmpty())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mata Pelajaran tidak ditemukan, Silahkan Isi Mata Pelajaran Terlebih Dahulu',
            }).then(function() {
                window.location.href = "{{ route('admin.subjects.create') }}";
            });
        </script>
    @endif
@endsection
