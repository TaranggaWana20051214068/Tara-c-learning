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
                    <a href="{{ route('project.index') }}" class="btn btn-secondary float-end">Back <i
                            class="bi bi-arrow-right"></i></a>
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
                            <br>
                            <h1 class="card-title mt-2 text-primary">{{ $project->judul }}</h1>
                            <p>{!! nl2br($project->deskripsi) !!}</p>
                            <hr>
                        </div>
                        <div id="tasks" class="tab-pane fade">
                            <br>
                            <h5>Daftar Tugas</h5>
                            progress:
                            <div class="progress" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                aria-valuemax="100">
                                <div class="progress-bar"style="width: {{ $progress }}%;">
                                    {{ $progress }}%</div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="row row-cols-1 row-cols-md-1 g-2">
                                        {{-- TUGAS SELESAI START --}}
                                        @forelse($tasks as $task)
                                            <a class="modal-trigger" href="#modalProject{{ $task->id }}"
                                                data-bs-toggle="modal">
                                                <div class="card">
                                                    <div class="card-body row row-cols-md-2">
                                                        <h5 class="card-title"> <i class="bi bi-journal-text"
                                                                style="font-size: 2rem; color: rgb(76, 130, 231);"></i>
                                                            Tugas : {{ $task->nama_tugas }}
                                                        </h5>
                                                        @if ($task->attachments->isEmpty())
                                                            <p class="float-end"> Deadline:
                                                                <code>
                                                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}
                                                                    @if (\Carbon\Carbon::now()->gt($task->deadline))
                                                                        (Terlambat)
                                                                    @endif
                                                                </code>
                                                            </p>
                                                        @elseif ($task->nilai === null)
                                                            <h5 class="text-warning">Menunggu Penilaian</h5>
                                                        @else
                                                            <h5 class="text-primary">Nilai: {{ $task->nilai }}</h5>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Modal Structure -->
                                            <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                id="modalProject{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $task->nama_tugas }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>{{ $task->nama_tugas }}</h4>
                                                            <p> Deadline:
                                                                <code>
                                                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}
                                                                    @if (\Carbon\Carbon::now()->gt($task->deadline))
                                                                        (Terlambat)
                                                                    @endif
                                                                </code>
                                                            </p>
                                                            <p>{{ $task->deskripsi }}</p>
                                                            @if ($task->attachments->isEmpty())
                                                                <form id="TugasForm"
                                                                    action="{{ route('project.tugas', ['id' => $task->id]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="file" name="file" id="file"
                                                                        class="form-control @error('file') is-invalid @enderror"
                                                                        value="{{ old('file') }}">
                                                                    @error('file')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <code>Max ukuran file 10MB</code>
                                                                    <br>
                                                                    <code>Pastikan file benar karena tidak dapat
                                                                        diubah.</code>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Selesai</button>
                                                        </div>
                                                        </form>
                                                    @elseif($task->nilai === null)
                                                        <a href="{{ Storage::url('images/projects/tugas/' . $attachments->where('tugas_id', $task->id)->first()->file_name) }}"
                                                            id="downloadLink" download>
                                                            <i class="bi bi-file-code" style="font-size: 2rem"></i>
                                                            {{ $attachments->where('tugas_id', $task->id)->first()->file_name }}
                                                        </a>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                @else
                                                    <p>Nilai : {{ $task->nilai }}</p>
                                                    <p>catatan: <br>
                                                        {{ $task->catatan }}</p>
                                                    <a href="{{ Storage::url('images/projects/tugas/' . $attachments->where('tugas_id', $task->id)->first()->file_name) }}"
                                                        id="downloadLink" download>
                                                        <i class="bi bi-file-code" style="font-size: 2rem"></i>
                                                        {{ $attachments->where('tugas_id', $task->id)->first()->file_name }}
                                                    </a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- modal End --}}
                        @empty
                            <h5>Belum ada tugas yang diunggah.</h5>
                            @endforelse
                            {{-- TUGAS SELESAI END --}}

                            {{-- TUGAS BARU START --}}
                            <a class="modal-trigger" href="#modalProject{{ $nextTask->id }}" data-bs-toggle="modal">
                                <div class="card">
                                    <div class="card-body row row-cols-md-2">
                                        <h5 class="card-title"> <i class="bi bi-journal-text"
                                                style="font-size: 2rem; color: rgb(76, 130, 231);"></i>
                                            Tugas : {{ $nextTask->nama_tugas }}
                                        </h5>
                                        <p class="float-end"> Deadline:
                                            <code>
                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}
                                                @if (\Carbon\Carbon::now()->gt($task->deadline))
                                                    (Terlambat)
                                                @endif
                                            </code>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <!-- Modal Structure -->
                            <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
                                id="modalProject{{ $nextTask->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $nextTask->nama_tugas }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>{{ $nextTask->nama_tugas }}</h4>
                                            <p> Deadline:
                                                <code>
                                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}
                                                    @if (\Carbon\Carbon::now()->gt($task->deadline))
                                                        (Terlambat)
                                                    @endif
                                                </code>
                                            </p>
                                            <p>{{ $nextTask->deskripsi }}</p>
                                            <form id="TugasForm"
                                                action="{{ route('project.tugas', ['id' => $nextTask->id]) }}"
                                                method="post">
                                                @csrf
                                                <input type="file" name="file" id="file"
                                                    class="form-control @error('file') is-invalid @enderror"
                                                    value="{{ old('file') }}">
                                                @error('file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <code>Max ukuran file 10MB</code>
                                                <br>
                                                <code>Pastikan file benar karena tidak dapat
                                                    diubah.</code>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Selesai</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- modal End --}}
                            {{-- TUGAS BARU END --}}
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
                            @if (!$user->profile_pic)
                                <img src="{{ URL::asset('assets/images/faces/profile.gif') }}">
                            @else
                                <img src="{{ URL::asset('assets/images/faces/' . $user->profile_pic . '') }}">
                            @endif
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
@section('script-bottom')
    <script>
        var form = document.getElementById('TugasForm');
        formAjaxProject(form, "{{ route('project.show', ['id' => $project->id]) }}");
    </script>
@endsection
