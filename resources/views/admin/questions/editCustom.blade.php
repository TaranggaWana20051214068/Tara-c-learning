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

                        <form action="{{ route('admin.questions.update', ['question' => $question->id]) }}" method="POST"
                            class='mt-3'>
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="subject" class='col-md-2 col-form-label'>Mata Pelajaran</label>
                                <div class="col-md-10">
                                    <select name="subject" class="form-select @error('subject') is-invalid @enderror"
                                        id="">
                                        <option value="" disabled>Pilih Mata Pelajaran</option>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->id == 1)
                                            @else
                                                <option value="{{ $subject->id }}"
                                                    {{ ($question->subject_id == $subject->id ? 'selected' : old('subject') == $subject->id) ? 'selected' : '' }}>
                                                    {{ $subject->name }}</option>
                                            @endif
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
                                    <textarea name="judul" id="judul" rows="5" class="form-control @error('judul') is-invalid @enderror">{{ $question->judul }}</textarea>
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
                                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ $question->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Materi</label>
                                <div class="col-md-10">
                                    <select name="materi" id="materi"
                                        class="form-control @error('materi') is-invalid @enderror">
                                        <option value="">Pilih materi</option>
                                        @foreach ($articles as $article)
                                            <option
                                                value="{{ $article->id }}"{{ $article->id == $question->article_id ? 'selected' : '' }}>
                                                {{ $article->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('materi')
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
