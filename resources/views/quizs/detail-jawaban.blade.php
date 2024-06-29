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
                <div class="card text-primary">
                    <div class="card-body row">
                        @foreach ($data as $index => $item)
                            <a class="btn btn-outline-primary" style="max-width: 50px; max-height:40px; margin:5px;"
                                onclick="showQuestion({{ $index }})">{{ $item['no_urut'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9 sm:mt-5">
                <div class="card text-primary h-100">
                    <div class="card-body">
                        <h5 class="text-info">score: {{ number_format($normalizedScore, 2) }}</h5>
                        @foreach ($data as $index => $item)
                            <div class="question" id="question-{{ $index }}"
                                style="{{ $index > 0 ? 'display: none;' : '' }}">
                                <h4 class='mb-3'>{{ $item['question_text'] }}
                                </h4>
                                @if ($item['file'])
                                    <img class="img mb-3" src="{{ Storage::url('/images/quizs/' . $item['file']) }}"
                                        alt="question-file-{{ $index }}">
                                @endif
                                @foreach ($item['choices'] as $choiceIndex => $choice)
                                    <div class="mb-2">
                                        <span
                                            class="alert d-flex align-items-center @if ($choice['is_selected'] && $choice['is_correct']) alert-primary @elseif(!$choice['is_selected'] && $choice['is_correct']) alert-primary @elseif($choice['is_selected'] && !$choice['is_correct']) alert-danger @else alert-light @endif">
                                            <div class="flex-shrink-0 me-2">
                                                @if ($choice['is_selected'] && $choice['is_correct'])
                                                    <i class="bi bi-check-circle ms-2"></i>
                                                @elseif(!$choice['is_selected'] && $choice['is_correct'])
                                                    <i class="bi bi-check-circle ms-2"></i>
                                                @elseif($choice['is_selected'] && !$choice['is_correct'])
                                                    <i class="bi bi-x-circle ms-2"></i>
                                                @endif
                                            </div>
                                            <div>
                                                {{ $choice['choice_text'] }}
                                            </div>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <button type="button" onclick="window.history.back();" class="btn btn-primary float-right"
                            style="margin-left: 5px;">Kembali</button>
                        <button class="btn btn-outline-info next-button float-right" type="button">Next</button>
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
    var buttons = document.querySelectorAll('.btn-outline-primary');

    function updateButtonActivity() {
        buttons.forEach(function(button, index) {
            if (index === currentQuestion) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    function showQuestion(index) {
        // Sembunyikan semua pertanyaan
        document.querySelectorAll('.question').forEach(function(question) {
            question.style.display = 'none';
        });

        // Tampilkan pertanyaan yang dipilih
        document.getElementById('question-' + index).style.display = 'block';
        currentQuestion = index;
        updateButtonActivity();
    }

    buttons.forEach(function(button, index) {
        button.addEventListener('click', function() {
            showQuestion(index);
        });
    });

    // Membuat tombol pertama menjadi aktif saat dimulai
    updateButtonActivity();

    document.querySelectorAll('.next-button').forEach(function(button) {
        button.addEventListener('click', function() {
            if (currentQuestion < totalQuestions - 1) {
                showQuestion(currentQuestion + 1);
            }
        });
    });

    function updateButtonClass(radioButton) {
        var questionIndex = radioButton.getAttribute('data-question-index');
        var questionButton = document.querySelector('.card-body').children[questionIndex];
        if (radioButton.checked) {
            questionButton.classList.remove('btn-outline-primary');
            questionButton.classList.add('btn-primary');
        } else {
            questionButton.classList.remove('btn-primary');
            questionButton.classList.add('btn-outline-primary');
        }
    }

    var form = document.getElementById('form');
    formAjaxProject(form, "{{ route('quiz.index') }}");
</script>
@endsection