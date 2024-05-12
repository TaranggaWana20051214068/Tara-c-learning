@extends('layouts.app')

@section('content')
@section('title', 'Quiz')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="students">
    <div class="container">
        <div class="section-header">
            <h1>Quiz</h1>
            <div class="divider"></div>
        </div>
        <div class="section-body">
            <div class="row row-cols-1 row-cols-md-2 g-1">
                @forelse ($quizs as $quiz)
                    <div class="card text-primary h-100">
                        <div class="card-body row row-cols-md-2">
                            <h3 class="card-title">
                                {{ $quiz->category }}</h3>
                            <a class="btn btn-primary"
                                href="{{ route('quiz.show', ['category' => $quiz->category]) }}">Mulai</a>
                        </div>
                    </div>
                @empty
                    <h5>Tidak ada Quiz yang tersedia.</h5>
                @endforelse
            </div>
            <div class="paginate float-right mt-2">
                {{ $quizs->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
