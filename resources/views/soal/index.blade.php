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
