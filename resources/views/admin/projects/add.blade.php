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

                        <form action="{{ route('admin.projects.store') }}" method="POST" class='mt-3'>
                            @csrf
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="judul"
                                        class='form-control @error('judul') is-invalid @enderror'>
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
                                    <textarea name="deskripsi" id="" rows="5" class="form-control  @error('deskripsi') is-invalid @enderror"></textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <h4 class="mt-0 header-title">Tugas<button type="button" class='btn btn-primary float-right'
                                    data-bs-toggle="modal" data-bs-target="#modalEx">Tambah Tugas</button></h4>
                            <br>
                            <div class="modal" tabindex="-1" id="modalEx">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Tugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Judul:</label>
                                                <input type="text" class="form-control" id="recipient-name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Deskripsi:</label>
                                                <textarea class="form-control" id="message-text"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('nama_tugas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('deskripsi_tugas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="30%">Judul</th>
                                        <th width="70%">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                </tbody>
                            </table>
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
@section('script-bottom')
    <script>
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
    </script>

@endsection
