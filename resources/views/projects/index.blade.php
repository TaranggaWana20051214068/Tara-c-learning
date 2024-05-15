@extends('layouts.app')

@section('content')
@section('title', 'Project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="students">
    <div class="container">
        <div class="section-header">
            <h1>Project</h1>
            <div class="divider"></div>
            <button type="button" class="waves-effect waves-light btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#modalAdd">Add Project <i class="bi bi-arrow-right-circle-fill"></i></button>
        </div>
        <div class="section-body">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($takenProjects as $project)
                    <div class="col">
                        <a href="{{ route('project.show', ['id' => $project->id]) }}">
                            <article class="article-wrapper">
                                <div class="rounded-lg container-project">
                                    <img src="{{ Storage::url('images/projects/' . $project->thumbnail) }}"
                                        alt="">
                                </div>
                                <div class="project-info">
                                    <div class="flex-pr">
                                        <div class="project-title text-nowrap">{{ $project->judul }}</div>
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
                                            class="project-type">• Joined</span>
                                        {{-- <span class="project-type">• {{ $article->author->name }}</span> --}}
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                    {{-- <div class="card text-primary h-100">
                        <div class="card-body row row-cols-md-2">
                            <h3 href="{{ route('project.show', ['id' => $project->id]) }}" class="card-title">
                                {{ $project->judul }}</h3>
                            <a class="btn btn-primary"
                                href="{{ route('project.show', ['id' => $project->id]) }}">Lihat</a>
                        </div>
                    </div> --}}
                @empty
                    <div class="card-body">
                        <h5>Belum ada project yang kamu ambil nih. <a class="btn btn-link link-primary"
                                style="text-decoration: underline; color: blue;" data-bs-toggle="modal"
                                data-bs-target="#modalAdd">Add Project <i class="bi bi-arrow-right-circle-fill"></i></a>
                        </h5>

                    </div>
                @endforelse
                <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" id="modalAdd"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Project</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @forelse ($projects as $data)
                                    <form action="{{ route('project.join', ['id' => $data->id]) }}" method="POST"
                                        id="myForm">
                                        <div class="card text-primary">
                                            <div class="card-body">
                                                <h3 href="{{ route('project.show', ['id' => $data->id]) }}"
                                                    class="card-title">
                                                    {{ $data->judul }}</h3>
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-primary">Pilih</button>
                                            </div>
                                        </div>
                                    </form>
                                @empty
                                    <h5>Tidak ada Project yang bisa kamu pilih.</h5>
                                @endforelse
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="paginate float-right mt-2">
                {{ $takenProjects->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
@section('script-bottom')
@if (session('success'))
    <script>
        $.SweetAlert.showSucc("{{ session('success') }}");
    </script>
@endif
@endsection
