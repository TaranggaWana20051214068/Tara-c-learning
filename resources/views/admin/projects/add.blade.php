@extends('layouts.master')

@section('title', 'Tambah Project')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Project</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">Project</a></li>
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

                        <h4 class="mt-0 header-title">Tambah Project</h4>

                        <form action="{{ route('admin.projects.store') }}" method="POST" class='mt-3'
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="subject" class='col-md-2 col-form-label'>Mata Pelajaran</label>
                                <div class="col-md-10">
                                    <select name="subject" class="form-select @error('subject') is-invalid @enderror"
                                        id="">
                                        <option value="" disabled>Pilih Mata Pelajaran</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ old('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="judul"
                                        class='form-control @error('judul') is-invalid @enderror'
                                        value="{{ old('judul') }}">
                                    @error('judul')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Deskripsi</label>
                                <div class="col-md-10">
                                    <textarea name="deskripsi" id="" rows="5" class="form-control  @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Thumbnail</label>
                                <div class="col-md-10">
                                    <input type="file"
                                        class="form-control  @error('thumbnail') is-invalid @enderror form-control-sm"
                                        id="formFileThumnail" name='thumbnail' value="{{ old('thumbnail') }}">
                                    <code>Thumbnail Harus Berupa Gambar. </code>
                                    @error('thumbnail')
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
@section('script-bottom')
    {{-- <script>
        $(document).ready(function() {
            var tugasCount = 1; // Inisialisasi jumlah tugas
            function tambahTugas(judul, deskripsi) {
                var newRow = $("<tr>");
                newRow.append("<td>" + judul + "</td>");
                newRow.append("<td>" + deskripsi + "</td>");
                $("#table").append(newRow);
            }
            $("#btnSimpan").click(function() {
                var judul = $("#recipient-name").val();
                var deskripsi = $("#message-text").val();
                tambahTugas(judul, deskripsi);
                $("#nama_tugas_" + tugasCount).val(judul);
                $("#deskripsi_tugas_" + tugasCount).val(deskripsi);
                tugasCount++;
                $("#recipient-name").val("");
                $("#message-text").val("");
                $("#nama_tugas1").val(judul);
                $("#deskripsi_tugas1").val(deskripsi);
                $("#modalEx").modal("hide");
            });
        });
    </script> --}}

@endsection
