@extends('layouts.app')

@section('content')
@section('title', 'Soal')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section>
    <div class="container">
        <div class="section-header">
            <div class="card">
                <div class="card-body">
                    <div class="row" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col-md-5">
                            <h3 class="card-title text-primary">Hi, {{ auth()->user()->name }}</h3>
                            <p class="text-justify">Jangan lupa untuk mengerjakan pertanyaan hari ini dan asah kemampuan
                                kamu. Kami
                                menantikan skor terbaikmu!</p>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            <img src="{{ Storage::url('images/front/' . config('web_config')['HERO_BACKGROUND_IMAGE']) }}"
                                alt="Motivational Image"
                                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mb-3">
                <form action="" class="form-inline">
                    <div class="col-md-5 mb-3">
                        <div class="input-group">
                            <select name="subject" id="subject" class="form-select">
                                <option value="" selected disabled>- Pilih Mata Pelajaran -</option>
                                <option value="">All</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ request()->input('subject') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row row-cols-1 row-cols-md-3 d-flex flex-wrap">
                @forelse ($questions as $question)
                    <a class="text-decoration-none  d-flex justify-content-center" href="{!! $question->codes->count() == 0 ? route('soal.show', ['id' => $question->id]) : '#' !!}">
                        <div class="card-soals">
                            <h3 class="card__title"><i class="bi bi-journal-code"></i>
                                {{ $question->judul }}</h3>
                            @if ($question->codes->count() > 0)
                                <p class="card__content">
                                    @if ($question->nilai != null)
                                        Nilai: {{ $question->nilai }}
                                    @endif
                                    <br>
                                    Status: {!! $question->nilai
                                        ? '<span class="badge bg-primary">Selesai</span>'
                                        : '<span class="badge bg-warning text-dark">Menunggu Penilaian</span>' !!}
                                </p>
                            @endif
                            <div class="card__date">
                                {{ \Carbon\Carbon::parse($question->create_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </div>
                            @if ($question->codes->count() == 0)
                                <div class="card__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        height="15" width="15">
                                        <path fill="#fff"
                                            d="M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <h5>Tidak ada soal tersedia.</h5>
                @endforelse
            </div>
            <div class="paginate float-right mt-2">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
