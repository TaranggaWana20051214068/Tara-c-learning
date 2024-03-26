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
            <div class="row row-cols-1 row-cols-md-2 g-1">
                @foreach ($questions as $question)
                    <div class="col" style="margin-bottom: 1rem;">
                        <div class="card text-primary article-cards h-100">
                            <div class="card-body row">
                                <h3 href="{{ route('soal.show', ['id' => $question->id]) }}"
                                    class="card-title col order-first">{{ $question->judul }}</h3>
                                @if (isset($question->user->id))
                                    <p class="col-1 col-sm-2 order-last">Status :
                                        {{ $question->score ? '<span class="text-warning">Selesai</span>' : '<span class="text-warning">Menunggu Penilaian</span>' }}
                                    </p>
                                    <p class="col-1 col-sm-2 ">Score :
                                        {{ $question->score ? $question->score : '<span class="text-warning">Belum dinilai</span>' }}
                                    </p>
                                @else
                                    <a class="btn btn-primary float-right"
                                        href="{{ route('soal.show', ['id' => $question->id]) }}">Mulai</a>
                                @endif
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
