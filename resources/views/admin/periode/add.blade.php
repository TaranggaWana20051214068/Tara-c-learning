@extends('layouts.master')

@section('title', 'Tambah Tahun Ajaran')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Mata Pelajaran</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.periode.index') }}">Tahun Ajaran</a></li>
                        <li class="breadcrumb-item">Tambah</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Tambah Tahun Ajaran</h4>

                        <form action="{{ route('admin.periode.store') }}" method="POST" class='mt-3'>
                            @csrf
                            <div class="form-group row">
                                <label for="tahun" class='col-md-2 col-form-label'>Tahun</label>
                                <div class="col-md-10">
                                    <input type="text" name="tahun"
                                        class='form-control @error('tahun') is-invalid @enderror'>
                                    @error('tahun')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="semester" class='col-md-2 col-form-label'>Semester</label>
                                <div class="col-md-10">
                                    <select name="semester" id="semester" class="form-select">
                                        <option value="" disabled>Pilih Semester</option>
                                        <option value="ganjil">Ganjil</option>
                                        <option value="genap">Genap</option>
                                    </select>
                                    @error('semester')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class='col-md-2 col-form-label'>Status</label>
                                <div class="col-md-10">
                                    <select name="status" id="status" class="form-select">
                                        <option value="" disabled>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select> @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
