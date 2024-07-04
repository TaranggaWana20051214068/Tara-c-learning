@extends('layouts.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @endpush

    <section class="article">
        <div class="container">
            <form action="{{ route('soal.questions_code', ['id' => $question->id]) }}" method="POST" class='mt-3'
                enctype="multipart/form-data" id="myForm">
                @csrf
                @error('stderr')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <div id="error" class="alert alert-danger" role="alert" style="display: none;">
                </div>
                @error('filee')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <div class="card">
                    <h5 class="card-header">
                        <span class="text-primary">{{ strtoupper($question->judul) }}</span>
                    </h5>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p class="card-text" style="margin-left: 1.6rem">{{ $question->deskripsi }}</p>
                            <textarea name="output" class="form-text form-control" id="" placeholder="Isi Jawaban Disini" rows="10"></textarea>
                        </div>
                        <div class="card-action">
                            <button type="submit" id="btn" class='btn-lg btn-primary float-right'
                                style="margin:10px;">Selesai</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="thumbnail">
            </div>
        </div>
    </section>
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
@endsection
