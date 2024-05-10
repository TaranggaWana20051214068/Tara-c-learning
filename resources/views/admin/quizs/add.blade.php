@extends('layouts.master')

@section('title', 'Tambah Quiz')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Quiz</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">Quiz</a></li>
                        <li class="breadcrumb-item">Tambah</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <form id="form" action="{{ route('admin.quizs.addQuiz') }}" method="post" class='mt-3'>
                    @csrf
                    @method('post')
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Judul</h4>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="category"
                                        class='form-control @error('category') is-invalid @enderror'>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Tambah Pertanyaan</h4>
                            <div class="form-group row">
                                <label for="question" class='col-md-2 col-form-label'>Pertanyaan</label>
                                <div class="col-md-10">
                                    <input type="text" name="question" id="pertanyaan"
                                        class='form-control @error('question') is-invalid @enderror'>
                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choices" class='col-md-2 col-form-label'>Pilihan 1</label>
                                <div class="col-md-10">
                                    <input type="text" name="choices[]" id="choice-1"
                                        class='form-control @error('choices') is-invalid @enderror'>
                                    @error('choices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choices" class='col-md-2 col-form-label'>Pilihan 2</label>
                                <div class="col-md-10">
                                    <input type="text" name="choices[]" id="choice-2"
                                        class='form-control @error('choices') is-invalid @enderror'>
                                    @error('choices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choices" class='col-md-2 col-form-label'>Pilihan 3</label>
                                <div class="col-md-10">
                                    <input type="text" name="choices[]" id="choice-3"
                                        class='form-control @error('choices') is-invalid @enderror'>
                                    @error('choices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choices" class='col-md-2 col-form-label'>Pilihan 4</label>
                                <div class="col-md-10">
                                    <input type="text" name="choices[]" id="choice-4"
                                        class='form-control @error('choices') is-invalid @enderror'>
                                    @error('choices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="correct" class='col-md-2 col-form-label'>Jawaban</label>
                                <div class="col-md-10">
                                    <select class="form-select form-control @error('correct') is-invalid @enderror"
                                        name="correct" id="correct">
                                        <option disabled selected>Pilih Jawaban Benar</option>
                                        <option value="1">Pilihan 1</option>
                                        <option value="2">Pilihan 2</option>
                                        <option value="3">Pilihan 3</option>
                                        <option value="4">Pilihan 4</option>
                                    </select>
                                    @error('correct')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="btnSimpan" class='btn btn-success float-right'>Tambah <i
                                    class="bi bi-plus-circle"></i></button>
                </form>
            </div>
        </div>
        <div class="card m-b-20">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pertanyaan</th>
                            <th>Pilihan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody id="table">
                    </tbody>
                </table>
                <a href="{{ route('admin.quizs.index') }}" class='btn btn-primary float-right'>Selesai</a>
            </div>
        </div>
    </div> <!-- end col -->

    </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
@section('script')
    {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
@endsection
@section('script-bottom')
    <script>
        $(document).ready(function() {
            $("#btnSimpan").click(function() {
                var judul = $("#pertanyaan").val();
                var choice1 = $("#choice-1").val();
                var choice2 = $("#choice-2").val();
                var choice3 = $("#choice-3").val();
                var choice4 = $("#choice-4").val();
                var jawaban = $("#correct").val();
                deskripsi = [choice1, choice2, choice3, choice4];
                var form = document.getElementById('form');
                formAjaxQuiz(form, judul, deskripsi, jawaban);

            });
        });
    </script>
@endsection
