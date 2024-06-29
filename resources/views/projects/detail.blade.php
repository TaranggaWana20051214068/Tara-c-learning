@extends('layouts.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        <style>
            .card {
                --bs-card-color: #000000;
            }
        </style>
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
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#jadwal">Jadwal</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTab">
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
                                        @foreach ($tasks as $task)
                                            <a class="modal-trigger" href="#modalProject{{ $task->id }}"
                                                data-bs-toggle="modal">
                                                <div class="card">
                                                    <div class="card-body row row-cols-md-2">
                                                        <h5 class="card-title" style="color: rgb(76, 130, 231);"> <i
                                                                class="bi bi-journal-text"
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
                            @endforeach
                            {{-- TUGAS SELESAI END --}}

                            {{-- TUGAS BARU START --}}
                            @if ($nextTask)
                                <a class="modal-trigger" href="#modalProject{{ $nextTask->id }}" data-bs-toggle="modal">
                                    <div class="card">
                                        <div class="card-body row row-cols-md-2">
                                            <h5 class="card-title" style="color: rgb(76, 130, 231);"> <i
                                                    class="bi bi-journal-text"
                                                    style="font-size: 2rem; color: rgb(76, 130, 231);"></i>
                                                Tugas : {{ $nextTask->nama_tugas }}
                                            </h5>
                                            <p class="float-end"> Deadline:
                                                <code>
                                                    {{ \Carbon\Carbon::parse($nextTask->deadline)->format('d-m-Y') }}
                                                    @if (\Carbon\Carbon::now()->gt($nextTask->deadline))
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
                                                <h5 class="modal-title text-primary">{{ $nextTask->nama_tugas }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>{{ $nextTask->nama_tugas }}</h4>
                                                <p> Deadline:
                                                    <code>
                                                        {{ \Carbon\Carbon::parse($nextTask->deadline)->format('d-m-Y') }}
                                                        @if (\Carbon\Carbon::now()->gt($nextTask->deadline))
                                                            (Terlambat)
                                                        @endif
                                                    </code>
                                                </p>
                                                <p>{{ $nextTask->deskripsi }}</p>
                                                <form id="TugasForm"
                                                    action="{{ route('project.tugas', ['id' => $nextTask->id]) }}"
                                                    method="post" enctype="multipart/form-data">
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="people" class="tab-pane fade">
                <br>
                <h5>Guru</h5>
                <hr>
                <div class="row row-cols-1 row-cols-md-1 g-2">
                    @foreach ($users->where('role', '!=', 'siswa') as $user)
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
                <br>
                <h5>Teman Kelas <a data-bs-toggle="modal" data-bs-target="#role"
                        class="btn btn-sm btn-primary text-white">Atur
                        Role <i class="bi bi-person-fill-gear"></i> </a></h5>
                <hr>
                <div class="row row-cols-1 row-cols-md-1 g-2">
                    @foreach ($users->where('role', 'siswa') as $user)
                        <div class="avatar avatar-md">
                            @if (!$user->profile_pic)
                                <img src="{{ URL::asset('assets/images/faces/profile.gif') }}">
                            @else
                                <img src="{{ URL::asset('assets/images/faces/' . $user->profile_pic . '') }}">
                            @endif
                            @foreach ($user->kelompok as $kelompok)
                                <h3 style="margin-left: 15px">
                                    {{ $user->name }}
                                    @if ($kelompok->krole)
                                        <span class="badge badge-info text-sm">({{ $kelompok->krole }})</span>
                                    @endif
                                </h3>
                            @endforeach
                        </div>
                    @endforeach
                    {{-- modal form Role start --}}
                    <div class="modal modal-lg modal-centered fade" id="role" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Atur Role</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('project.role', ['id' => $project->id]) }}" method="POST"
                                    id="formRole">
                                    @csrf
                                    @method('POST')
                                    @php
                                        $roles = [
                                            'developer' => 'Developer',
                                            'project manager' => 'Project Manager',
                                            'analis' => 'Analis',
                                            'UI/UX' => 'UI/UX',
                                        ];
                                    @endphp
                                    <div class="modal-body">
                                        @foreach ($users->where('role', 'siswa') as $user)
                                            <div class="input-group mb-3">
                                                <label for="role_{{ $user->id }}"
                                                    class="col-md-2 col-form-label">{{ $user->name }}</label>
                                                <div class="col-md-10">
                                                    <select name="roles[{{ $user->id }}]"
                                                        id="role_{{ $user->id }}" class="form-control">
                                                        <option value="">Pilih Role</option>
                                                        @foreach ($user->kelompok as $kelompok)
                                                            @if ($kelompok->krole)
                                                                @foreach ($roles as $value => $label)
                                                                    <option value="{{ $value }}"
                                                                        {{ $kelompok->krole == $value ? 'selected' : '' }}>
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach ($roles as $value => $label)
                                                                    <option value="{{ $value }}">
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
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
                    {{-- modal form Role end  --}}
                </div>

            </div>
            <div id="jadwal" class="tab-pane fade">
                <br>
                <h5>Jadwal <a data-bs-toggle="modal" data-bs-target="#add" class="btn btn-sm btn-primary text-white">Add
                        <i class="bi bi-plus-circle"></i> </a> </h5>
                <hr>
                <div class="row g-2">
                    <table class="striped table-responsive-sm" style="border-collapse: collapse; width: 100%;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="border: 1px solid #ddd; padding: 8px;">No</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Title</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Description</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Date</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Pembuat</th>
                                @if (Auth::user()->role != 'guru')
                                    <th style="border: 1px solid #ddd; padding: 8px;"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal as $item)
                                <tr>
                                    <td style="width:5%;border: 1px solid #ddd; padding: 8px;">{{ $loop->iteration }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->title }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->description }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">
                                        {{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->user->name }}</td>
                                    @if (Auth::user()->role != 'guru')
                                        <td style="width:5%;border: 1px solid #ddd; padding: 8px;">
                                            <form
                                                action="{{ route('project.jadwal_destroy', ['logbooks' => $item->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class='btn btn-danger btn-delete'><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role == 'guru' ? '5' : '6' }}"
                                        style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                        Belum ada jadwal kamu nih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- modal form Jadwal start --}}
                    <div class="modal modal-lg modal-centered fade" id="add" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Buat Jadwal</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('project.jadwal', ['id' => $project->id]) }}" method="POST"
                                    id="formJadwal">
                                    <div class="modal-body">
                                        @csrf
                                        @method('POST')
                                        <div class="input-group mb-3">
                                            <label for="title" class='col-md-2 col-form-label'>Title</label>
                                            <div class="col-md-10">
                                                <input name="title" type="text"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Isi Title" aria-label="title"
                                                    aria-describedby="addon-wrapping" value="{{ old('title') }}">
                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label for="deskripsi" class='col-md-2 col-form-label'>Deskripsi</label>
                                            <div class="col-md-10">
                                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id=""
                                                    cols="30" rows="10">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="date" class='col-md-2 col-form-label'>Batas waktu</label>
                                        <div class="col-md-10">
                                            <input type="date" name="date"
                                                class='form-control  @error('date') is-invalid @enderror'
                                                value="{{ old('date') }}">
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <code>Isi tanggal click icon Calendar</code>
                                        </div>
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
                    {{-- modal form Jadwal end  --}}

                </div>
                <div class="paginate float-right mt-3">
                    {{ $jadwal->links() }}
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
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
    @if ($errors->has('file') || $errors->has('title') || $errors->has('description') || $errors->has('date'))
        <script>
            $.SweetAlert.showErr("Kesalahan pengisian silahkan ulangi.");
        </script>
    @elseif ($errors->has('judul') || $errors->has('deskripsi') || $errors->has('deadline'))
        <script>
            $(document).ready(function() {
                $('#add').modal('show');
            });
        </script>
    @elseif(session('error'))
        <script>
            $.SweetAlert.showErr("{{ session('error') }}");
        </script>
    @endif
@endsection
