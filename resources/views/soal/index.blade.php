@extends('layouts.app')

@section('content')
@section('title', 'Soal')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="students">
    <div class="container">
        <div class="section-header">
            <h1>Daftar Soal</h1>
            <div class="divider"></div>
        </div>
        <div class="section-body">
            <div class="row row-cols-2 row-cols-md-3 g-4 text-center ">
                @foreach ($questions as $question)
                    <div class="col" style="margin-bottom: 1rem;">
                        <div class="card text-primary footer-article-cards article-cards h-100">
                            <div class="article-imgs">
                                {{-- <img src="{{ Storage::url('images/articles/' . $question->thumbnail_image_name) }}"
                                    alt="" class="card-img-top article-img"> --}}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a
                                        href="{{ route('soal.show', ['id' => $question->id]) }} ">{{ $question->title }}</a>
                                </h5>

                                <a href="{{ route('soal.show', ['id' => $question->id]) }}"
                                    class="btn btn-primary">Lihat</a>
                            </div>
                            <div class="card-footer footer-article-cards" style="background-color: #ccc;">
                                <div class="card-author">
                                    <i class="bi bi-person-circle"></i> <span>{{ $question->author->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="paginate float-right mt-2">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
