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
                <input type="hidden" name="language" id="language" required>
                <input type="hidden" name="stdin" id="stdin">
                <input type="hidden" name="filee" id="filee">
                <input type="hidden" name="stderr" id="stderr">
                <input type="hidden" name="output" id="output">
                <div class="card">
                    <h5 class="card-header">
                        {{ $question->judul }}
                    </h5>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p class="card-text">{{ $question->deskripsi }}</p>
                            <iframe id="oc-editor" frameBorder="0" height="400px" width="100%"
                                src="{{ $link }}"></iframe>
                        </div>
                        <div class="card-action">
                            <button type="submit" id="btn" class='btn-lg btn-primary float-right'>Selesai</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="thumbnail">
            </div>
        </div>
    </section>
    <script src="{{ URL::asset('js/main.js') }}"></script>
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

    <script>
        var btn = document.getElementById('btn');
        window.onmessage = function(e) {
            btn.addEventListener('click', function() {
                if (e.data && e.data.result) {
                    if (e.data.result.success == false) {
                        document.getElementById('stderr').value = e.data.result.output;
                    } else {
                        document.getElementById('stderr').value = '';
                        document.getElementById('output').value = e.data.result.output;
                    }
                    if (e.data.stdin != undefined) {
                        document.getElementById('stdin').value = e.data.stdin;
                    }
                    // input
                    document.getElementById('filee').value = JSON.stringify(e.data.files);
                    document.getElementById('language').value = e.data.language;
                }
            });
        }
    </script>
    <script>
        var form = document.getElementById('myForm');
        formAjax(form, "{{ route('soal.index') }}");
    </script>
@endsection
