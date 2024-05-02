@extends('layouts.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @endpush

    <section class="article">
        <div class="container">
            <div class="card">
                {{-- <img src="{{ Storage::url('images/articles/'.$article->thumbnail_image_name) }}" class='card-img-top'> --}}
                <div class="card-body pt-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tasks">ClassWork</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#people">People</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade show active">
                            <h1 class="card-title mt-2">{{ $project->judul }}</h1>
                            <p>{!! nl2br($project->deskripsi) !!}</p>
                            <div class="container">
                                <div class="row">
                                    <div class="row row-cols-1 row-cols-md-1 g-4">
                                        @forelse($tasks as $task)
                                            <div class="card">
                                                <div class="card-body row row-cols-md-1">
                                                    <h5 class="card-title"> <i class="bi bi-journal-text"
                                                            style="font-size: 2rem; color: rgb(76, 130, 231);"></i>
                                                        Tugas : {{ $task->nama_tugas }}
                                                    </h5>
                                                </div>
                                            </div>
                                        @empty
                                            <h5>Belum ada tugas yang diunggah.</h5>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tasks" class="tab-pane fade">
                            <div class="container">
                                <div class="row">
                                    <div class="row row-cols-1 row-cols-md-1 g-2">
                                        @forelse($tasks as $task)
                                            <a href="#das">
                                                <div class="card">
                                                    <div class="card-body row row-cols-md-1">
                                                        <h5 class="card-title"> <i class="bi bi-journal-text"
                                                                style="font-size: 2rem; color: rgb(76, 130, 231);"></i>
                                                            Tugas : {{ $task->nama_tugas }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <h5>Belum ada tugas yang diunggah.</h5>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="people" class="tab-pane fade">
                            <br>
                            <h5>Teman Kelas</h5>
                            <hr>
                            <div class="row row-cols-1 row-cols-md-1 g-2">
                                @foreach ($users as $user)
                                    <div class="avatar avatar-md">
                                        <img src="{{ URL::asset('assets/images/faces/' . $user->profile_pic . '') }}">
                                        <h3 style="margin-left: 15px">{{ $user->name }}</h3>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="thumbnail"></div>
        </div>
    </section>
@endsection
