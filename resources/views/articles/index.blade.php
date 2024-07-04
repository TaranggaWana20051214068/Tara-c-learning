@extends('layouts.app')

@section('content')
@section('title', 'Artikel')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="students">
    <div class="container">
        <div class="section-header">
            <h1>Daftar Materi</h1>
            <div class="divider"></div>
        </div>
        <div class="section-body">
            <a class="btn btn-primary mb-3 text-white" data-bs-toggle="modal" data-bs-target="#matapelajaran">Pilih Mata
                Pelajaran</a>
            {{-- modal mata pelajaran --}}
            <div class="modal fade" id="matapelajaran" tabindex="-1" aria-labelledby="matapelajaranLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="matapelajaranLabel">Pilih Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="">
                            <div class="modal-body">
                                <div class="containerr">
                                    @foreach ($subjects as $subject)
                                        <label>
                                            <input type="radio" name="subject" checked=""
                                                value="{{ $subject->id }}">
                                            <span>{{ $subject->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Pilih</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- modal mata pelajaran end --}}
            <div class="row row-cols-1 row-cols-md-3 g-4 text-center ">
                @forelse ($articles as $article)
                    <div class="col">
                        <a href="{{ route('article.show', ['id' => $article->id]) }}">
                            <article class="article-wrapper">
                                <div class="rounded-lg container-project">
                                    <img src="{{ Storage::url('images/articles/' . $article->thumbnail_image_name) }}"
                                        alt="">
                                </div>
                                <div class="project-info">
                                    <div class="flex-pr">
                                        <div class="project-title text-nowrap">{{ $article->title }}
                                        </div>
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
                                            class="project-type">• {{ $article->author->name }}</span>
                                        {{-- <span class="project-type">• {{ $article->author->name }}</span> --}}
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                @empty
                    <h5>Tidak ada materi yang tersedia.</h5>
                @endforelse

            </div>
            <div class="paginate float-right mt-2">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</section>


@endsection
@section('script-bottom')
@if (!request()->get('subject'))
    <script>
        window.onload = function() {
            var exampleModal = new bootstrap.Modal(document.getElementById('matapelajaran'));
            exampleModal.show();
        }
    </script>
@endif
@endsection
