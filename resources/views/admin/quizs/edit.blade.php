@extends('layouts.master')

@section('title', 'Ubah Soal')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Soal</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:window.history.back();">Soal</a></li>
                        <li class="breadcrumb-item">Ubah</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Ubah Soal</h4>

                        <form action="{{ route('admin.quizs.update', ['quiz' => $quiz->id]) }}" method="POST"
                            class='mt-3'>
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="category" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="category"
                                        class='form-control @error('category') is-invalid @enderror'
                                        value="{{ $quiz->category }}">
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="question" class='col-md-2 col-form-label'>Pertanyaan</label>
                                <div class="col-md-10">
                                    <input type="text" name="question"
                                        class='form-control @error('question') is-invalid @enderror'
                                        value="{{ $quiz->pertanyaan }}">
                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- @foreach ($quiz->choices as $index => $choice)
                                <div class="form-group row">
                                    <label for="choices{{ $index + 1 }}"
                                        class='col-md-2 col-form-label'>Pilihan-{{ $index + 1 }}</label>
                                    <div class="col-md-10">
                                        <input type="text" name="choices[]"
                                            class='form-control @error('choices') is-invalid @enderror'
                                            value="{{ $choice->choice_text }}">
                                        @error('choices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group row">
                                <label for="correct" class='col-md-2 col-form-label'>Jawaban</label>
                                <div class="col-md-10">
                                    <select name="correct" id="correct"
                                        class="form-control @error('correct') is-invalid @enderror">
                                        <option value="" disabled>Pilih Jawaban</option>
                                        @foreach ($quiz->choices as $index => $answer)
                                            <option
                                                value="{{ $index + 1 }}"{{ $answer->is_correct ? 'selected' : '' }}>
                                                {{ $answer->choice_text }}</option>
                                        @endforeach
                                    </select>
                                    @error('correct')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
