@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Soal Detail')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Detail Soal</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">Soal</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $question->judul }}</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">{{ $question->judul }}</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh siswa submit</p>

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
                                        <th>Output</th>
                                        <th>Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($codes as $code)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $code->author->name }}</td>
                                            <td>{{ $code->output }}..</td>
                                            <td>{{ $code->score }}</td>
                                            <td>
                                                @if (is_null($code->score))
                                                    <a class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop"><i
                                                            class="bi bi-exclamation-triangle"></i></a>
                                                @else
                                                    <a class='btn btn-info' data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"><i class="bi bi-pencil-fill"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @forelse ($codes as $code)
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="table-resposive text-lg-center text-white text-bg-info">Belum Ada
                                                siswa yang menyelesaikan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="paginate float-right mt-3">
                            {{ $codes->links() }}
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
{{-- modal form 1 --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hasil
                    Pengerjaan Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form1" action="{{ route('admin.questions.nilai', ['id' => $code->id]) }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-12">
                            <h5><i class="bi bi-person-circle"></i> Pembuat:
                            </h5>
                            <p>{{ $code->author->name }}</p>
                        </div>
                        <div class="col-md-12">
                            <h5><i class="bi bi-journal-code"></i> Pertanyaan:</h5>
                            <p>{{ $question->deskripsi }}</p>
                        </div>
                        <div class="col-md-12">
                            <h5><i class="bi bi-file-earmark-code"></i> Jawaban:</h5>
                            <p>{{ $code->output }}</p>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i
                                class="bi bi-star-fill"style="margin-top:-0.7rem;"></i></span>
                        <input name="score" type="number" class="form-control" placeholder="Isi nilai"
                            aria-label="Nilai" aria-describedby="addon-wrapping">
                        @error('score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="hidden" name="name" value="{{ $code->author->name }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- modal form 1 end --}}
{{-- modal form 2 --}}
@section('modal-title')
    Ubah Nilai
@endsection

{{-- Set nilai variabel Blade untuk konten modal --}}
@section('modal-content')
    <form id="form2" action="{{ route('admin.questions.editNilai', ['id' => $code->id]) }}" method="post">
        @csrf
        @method('post')
        <div class="row">
            <div class="col-md-12">
                <h5><i class="bi bi-person-circle"></i> Pembuat:
                </h5>
                <p>{{ $code->author->name }}</p>
            </div>
            <div class="col-md-12">
                <h5><i class="bi bi-journal-code"></i> Pertanyaan:</h5>
                <p>{{ $question->deskripsi }}</p>
            </div>
            <div class="col-md-12">
                <h5><i class="bi bi-file-earmark-code"></i> Output:
                </h5>
                <p>{{ $code->output }}</p>
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i
                    class="bi bi-star-fill"style="margin-top:-0.7rem;"></i></span>
            <input class="form-control" name="scoress" type="number" placeholder="Masukkan Nilai" aria-label="nilai"
                value="{{ $code->score }}">
            <input type="hidden" name="name" value="{{ $code->author->name }}">
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
    @if (empty($code->score))
        <script>
            var form1 = document.getElementById('form1');
            var modal1 = "$('#staticBackdrop').modal('hide')";
            formAjaxAdmin(form1, null, "ya", modal1);
        </script>
    @else
        <script>
            var form2 = document.getElementById('form2');
            var modal2 = "$('#exampleModal').modal('hide')";
            formAjaxAdmin(form2, null, "ya", modal2);
        </script>
    @endif
@endsection
@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
@endsection
