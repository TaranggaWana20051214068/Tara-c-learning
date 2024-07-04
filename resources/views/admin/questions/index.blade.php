@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Soal')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Soal</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Soal</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Daftar Soal</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh soal</p>
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
                                    <a class="btn btn-primary text-white" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Tambah</a>
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
                                        <th>Deskripsi Soal</th>
                                        <th>Materi</th>
                                        <th>Tanggal</th>
                                        <th>Pengumpulan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($questions as $question)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $question->judul }}</td>
                                            <td>{{ substr($question->deskripsi, 0, 50) }}..</td>
                                            <td>{{ $question->article_title }}</td>
                                            <td>{{ Carbon\Carbon::parse($question->created_at)->format('d F Y H:i:s') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.questions.show', ['question' => $question->id]) }}"
                                                    class='btn btn-outline-primary mr-2'>Lihat <i
                                                        class="bi bi-pencil-square"></i></a>
                                            </td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <a href="{{ route('admin.questions.edit', ['question' => $question->id]) }}"
                                                        class='btn btn-warning mr-2'><i class="bi bi-pencil-fill"></i></a>
                                                    <form
                                                        action="{{ route('admin.questions.destroy', ['question' => $question->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <strong>Tidak ada data,</strong>
                                                @if (request()->search || request()->subject)
                                                    <a href="{{ route('admin.questions.index') }}">Kembali</a>
                                                @else
                                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="paginate float-right mt-3">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
{{-- modal form 2 --}}
@section('modal-title')
    Pilih Mata Pelajaran
@endsection

{{-- Set nilai variabel Blade untuk konten modal --}}
@section('modal-content')
    <form id="form2" action="{{ route('admin.questions.createCustom') }}" method="post">
        @csrf
        @method('post')
        <div class="input-group">
            <select name="subject" id="subject" class="form-select">
                <option value="" selected disabled>- Pilih Mata Pelajaran -</option>
                @foreach ($subjects as $subject)
                    @php
                        $isSelected = false;
                        if (request()->has('subject')) {
                            $isSelected = request()->input('subject') == $subject->id;
                        } else {
                            $id = $questions->pluck('subject_id')->toArray();
                            $isSelected = in_array($subject->id, $id);
                        }
                    @endphp
                    <option value="{{ $subject->id }}" {{ $isSelected ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endsection
    @section('modal-content-bottom')
    </form>
@endsection
@section('modal-button')
    Selesai
@endsection
{{-- modal form 2 end --}}
@section('script')

    <script src="{{ asset('js/main.js') }}"></script>
@endsection
@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            $.SweetAlert.showErr("{{ session('error') }}");
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
