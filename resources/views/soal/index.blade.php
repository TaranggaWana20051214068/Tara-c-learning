@extends('layouts.app')

@section('content')
@section('title', 'Soal')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="students">
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
            <div class="row row-cols-1 row-cols-md-2 g-1">
                @foreach ($questions as $question)
                    <div class="card text-primary h-100">
                        <div class="card-body row row-cols-md-2">
                            <h3 href="{{ route('soal.show', ['id' => $question->id]) }}" class="card-title">
                                {{ $question->judul }}</h3>
                            <a class="btn btn-primary"
                                href="{{ route('soal.show', ['id' => $question->id]) }}">Mulai</a>
                        </div>
                    </div>
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
