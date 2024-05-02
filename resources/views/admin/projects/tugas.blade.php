@extends('layouts.master')

@section('css')
@endsection
@section('title', 'Tugas')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">TUGAS</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Project</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tugas</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="col-md-2 ml-auto">
                            <a class="btn btn-primary float-right text-white" data-bs-toggle="modal"
                                data-bs-target="#add">Tambah</a>
                        </div>
                        <h4 class="mt-0 header-title">{{ $projects->judul }}</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh tugas dari project
                            {{ $projects->judul }}</p>
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
                                        <th>deskripsi</th>
                                        <th>Nilai</th>
                                        <th>Deadline</th>
                                        <th>Pengumpulan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tugas as $data)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_tugas }}</td>
                                            <td>{{ substr($data->deskripsi, 0, 10) }}..</td>
                                            <td>{{ $data->nilai ? $data->nilai : '-' }} </td>
                                            <td class="text-danger">{{ $data->deadline }}</td>
                                            <td>
                                                @if ($data->attachments->isEmpty())
                                                    KOSONG
                                                @else
                                                    <a class="btn btn-{{ !$data->nilai ? 'warning' : 'outline-primary' }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#nilai{{ $data->id }}">Nilai</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <a href="{{ route('admin.projects.editTugas', ['id' => $data->id]) }}"
                                                        class='btn btn-warning mr-2'><i class="bi bi-pencil-fill"></i></a>
                                                    <form action="{{ route('admin.projects.tugas', ['id' => $data->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('post')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- modal form nilai --}}
                                        <div class="modal fade" id="nilai{{ $data->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Hasil
                                                            Pengerjaan Siswa</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="form{{ $data->id }}"
                                                        action="{{ route('admin.projects.tugas', ['id' => $data->id]) }}"
                                                        method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('post')
                                                            <div class="row">
                                                                <h5>Judul: {{ $data->nama_tugas }}</h5>
                                                                @foreach ($data->attachments as $attachment)
                                                                    <div class="col-md-12">
                                                                        <h5><i class="bi bi-person-circle"></i> Pembuat:
                                                                        </h5>
                                                                        <p>{{ $attachment->user->name }}</p>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <h5><i class="bi bi-journal-code"></i> File:</h5>
                                                                        <p>{{ $attachment->file_name }}</p>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <h5><i class="bi bi-file-earmark-code"></i> waktu:
                                                                        </h5>
                                                                        <p>{{ $attachment->updated_at }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <label for="nilai"
                                                                    class='col-md-2 col-form-label'>Nilai</label>
                                                                <div class="col-md-10">
                                                                    <input name="nilai" type="number"
                                                                        class="form-control @error('nilai') is-invalid @enderror"
                                                                        placeholder="Isi nilai"
                                                                        value="{{ old('nilai') ? old('nilai') : $data->nilai }}">
                                                                    <code>nilai 1-100</code>
                                                                    @error('nilai')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <label for="catatan"
                                                                    class='col-md-2 col-form-label'>Catatan</label>
                                                                <div class="col-md-10">
                                                                    <textarea name="catatan" cols='40' rows="5" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') ? old('catatan') : $data->catatan }}</textarea>
                                                                    @error('catatan')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="jenis" value="nilai">
                                                        <input type="hidden" name="code" value="{{ $data->id }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Selesai</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- modal form nilai end --}}
                                    @empty
                                        <tr>
                                            <td colspan="7" class='text-center'>Data tidak ditemukan, Mohon <a
                                                    class="btn" style="text-decoration: underline; color: blue;"
                                                    data-bs-toggle="modal" data-bs-target="#add">Tambah
                                                    Data</a></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->
            {{-- modal form tambah start --}}
            <div class="modal modal-lg modal-centered fade" id="add" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Tugas</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.projects.tugas', ['id' => $id]) }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @method('post')
                                <div class="input-group mb-3">
                                    <label for="judul" class='col-md-2 col-form-label'>Judul</label>
                                    <div class="col-md-10">
                                        <input name="judul" type="text"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            placeholder="Isi Judul" aria-label="Judul" aria-describedby="addon-wrapping"
                                            value="{{ old('judul') }}">
                                        @error('judul')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="deskripsi" class='col-md-2 col-form-label'>Deskripsi</label>
                                    <div class="col-md-10">
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id=""
                                            cols="30" rows="10">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label for="deadline" class='col-md-2 col-form-label'>Batas waktu</label>
                                <div class="col-md-10">
                                    <input type="date" name="deadline"
                                        class='form-control  @error('deadline') is-invalid @enderror'
                                        value="{{ old('deadline') }}">
                                    @error('deadline')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <code>Isi batas waktu clik icon jam</code>
                                </div>
                            </div>
                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <input type="hidden" name="jenis" value="add">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Selesai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- modal form tambah end  --}}

        </div> <!-- end row -->
    </div> <!-- container-fluid -->
@endsection
@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                $.SweetAlert.showErr("{{ $error }}");
            @endforeach
        </script>
    @endif
    @if ($errors->has('judul') || $errors->has('deskripsi') || $errors->has('deadline'))
        <script>
            $(document).ready(function() {
                $('#add').modal('show');
            });
        </script>
    @endif
    @if ($errors->has('nilai') || $errors->has('catatan'))
        <script>
            $(document).ready(function() {
                $('#nilai{{ old('code') }}').modal('show');
            });
        </script>
    @endif
@endsection
