@extends('layouts.app')

@section('content')
@section('title', 'Quiz')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .form-check-input {
            transform: scale(1.2);
        }

        .form-check-label {
            font-size: 1.2em;
        }

        .img {
            width: 50%;
            aspect-ratio: 1/1;
            object-fit: contain;
        }
    </style>
@endpush

<section class="quiz">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-primary h-100">
                    <div class="card-body row">
                        @foreach ($data as $index => $item)
                            <a class="btn btn-outline-primary" style="max-width: 50px;max-height:40px;margin:5px;"
                                href="#" onclick="showQuestion({{ $index }})">{{ $item['no_urut'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9 sm:mt-5">
                <div class="card text-primary h-100">
                    <div class="card-body">
                        <form action="{{ route('quiz.add', ['category' => $categorys]) }}" method="POST"
                            id="form">
                            @csrf
                            @method('post')
                            @foreach ($data as $index => $item)
                                <div class="question" id="question-{{ $index }}"
                                    style="{{ $index > 0 ? 'display: none;' : '' }}">
                                    <h4 class='mb-3'>{{ $item['question_text'] }}</h4>
                                    @if ($item['file'])
                                        <img class="img mb-3" src="{{ Storage::url('/images/quizs/' . $item['file']) }}"
                                            alt="question-file-{{ $index }}">
                                    @endif
                                    @foreach ($item['choices'] as $choiceIndex => $choice)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="answers[{{ $item['id'] }}]" value="{{ $choice['id'] }}"
                                                id="flexRadioDefault{{ $choiceIndex + 1 }}">
                                            <label class="form-check-label text-secondary"
                                                for="flexRadioDefault{{ $choiceIndex + 1 }}">
                                                {{ $choice['choice_text'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary float-right"
                                style="margin-left: 5px;">Selesai</button>
                            <button class="btn btn-outline-info next-button float-right" type="button">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script-bottom')
<script>
    var currentQuestion = 0;
    var totalQuestions = {{ count($data) }};

    function showQuestion(index) {
        // Sembunyikan semua pertanyaan
        document.querySelectorAll('.question').forEach(function(question) {
            question.style.display = 'none';
        });

        // Tampilkan pertanyaan yang dipilih
        document.getElementById('question-' + index).style.display = 'block';
        currentQuestion = index;
    }

    document.querySelectorAll('.next-button').forEach(function(button) {
        button.addEventListener('click', function() {
            if (currentQuestion < totalQuestions - 1) {
                showQuestion(currentQuestion + 1);
            }
        });
    });
    var form = document.getElementById('form');
    formAjaxProject(form, "{{ route('quiz.index') }}");
</script>
@endsection
