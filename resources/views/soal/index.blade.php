@extends('layouts.app')

@section('content')
@section('title', 'Soal')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section>
    <div class="container">
        <div class="section-header">
            <h1>Latihan Soal</h1>
            <div class="divider"></div>
            @if ($nilai->isNotEmpty())
                <button type="button" class="waves-effect waves-light btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#modalNilai">Lihat Nilai <i class="bi bi-envelope-paper-fill"></i></button>
            @endif
        </div>
        <div class="section-body">
            <div class="row row-cols-1 row-cols-md-2 d-flex flex-wrap">
                @foreach ($questions as $question)
                    <a class="text-decoration-none  d-flex justify-content-center"
                        href="{{ route('soal.show', ['id' => $question->id]) }}">
                        <div class="card-soals">
                            <h3 class="card__title">{{ $question->judul }}</h3>
                            <p class="card__content">{{ substr($question->deskripsi, 0, 50) }}..</p>
                            <div class="card__date">
                                {{ \Carbon\Carbon::parse($question->create_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </div>
                            <div class="card__arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    height="15" width="15">
                                    <path fill="#fff"
                                        d="M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" id="modalNilai"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hasil Test</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Soal</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Nilai</th>
                                            <th scope="col">Output</th>
                                        </tr>
                                    </thead>
                                    @foreach ($nilai as $pertanyaan)
                                        @foreach ($pertanyaan->codes as $code)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $pertanyaan->judul }}</td>
                                                <td>{!! $code->score
                                                    ? '<span class="text-primary">Selesai</span>'
                                                    : '<span class="text-danger">Menunggu Penilaian</span>' !!}</td>
                                                <td>{!! $code->score ? '<span class="text-primary">' . $code->score . '</span>' : '-' !!}</td>
                                                <td>{{ $code->output }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="paginate float-right mt-2">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
