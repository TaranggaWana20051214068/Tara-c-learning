@extends('layouts.master')

@section('title', 'Update Tugas')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Update Tugas</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Project</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">Tugas</a></li>
                        <li class="breadcrumb-item">Update Tugas</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Update Tugas</h4>

                        <form action="{{ route('admin.projects.tugas', ['id' => $tugas->id]) }}" method="POST"
                            class='mt-3'>
                            @csrf
                            @method('post')
                            <div class="form-group row">
                                <label for="judul" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="judul"
                                        class='form-control @error('judul') is-invalid @enderror'
                                        value="{{ $tugas->nama_tugas }}">
                                    @error('judul')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="deskripsi" class='col-md-2 col-form-label'>Deskripsi</label>
                                <div class="col-md-10">
                                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ $tugas->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group mb-3">
                                    <label for="deadline" class='col-md-2 col-form-label'>Batas waktu</label>
                                    <div class="col-md-10">
                                        <input type="date" name="deadline"
                                            class='form-control  @error('deadline') is-invalid @enderror'
                                            value="{{ $tugas->deadline }}">
                                        @error('deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <code>Isi batas waktu clik icon Kalender</code>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="jenis" value="edit">
                            <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
