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
            <div class="row row-cols-1 row-cols-md-3 g-1">
                @forelse ($quizs as $quiz)
                    <div class="col">
                        <a href="{{ route('quiz.show', ['category' => $quiz->category]) }}">
                            <article class="article-wrapper">
                                <div class="rounded-lg container-project">
                                    <img src="{{ Storage::url('images/logo/' . config('web_config')['WEB_LOGO']) }}"
                                        alt="">
                                </div>
                                <div class="project-info">
                                    <div class="flex-pr">
                                        <div class="project-title text-nowrap">{{ $quiz->category }}</div>
                                        <div class="project-hover">
                                            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em"
                                                height="2em" color="black" stroke-linejoin="round"
                                                stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2"
                                                fill="none" stroke="currentColor">
                                                <line y2="12" x2="19" y1="12" x1="5">
                                                </line>
                                                <polyline points="12 5 19 12 12 19"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="types">
                                        <span
                                            style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);"
                                            class="project-type">• New</span>
                                        {{-- <span class="project-type">• {{ $article->author->name }}</span> --}}
                                    </div>
                                </div>
                            </article>
                        </a>
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
