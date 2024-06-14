@extends('layouts.app')

@section('content')
@section('title', 'profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            padding: .75rem 1.25rem;
            position: relative;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }

        .card-title {
            float: left;
            font-size: 1.1rem;
            font-weight: 400;
            margin: 0;
        }

        .card-header>.card-tools {
            float: right;
            margin-right: -0.625rem;
        }

        .card-header>.card-tools .input-group,
        .card-header>.card-tools .nav,
        .card-header>.card-tools .pagination {
            margin-bottom: -.3rem;
            margin-top: -.3rem;
        }

        .pagination {
            display: -ms-flexbox;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: .25rem;
        }
    </style>
@endpush

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (!$user->profile_pic)
                                <i class="bi bi-person" style="font-size: 4rem; color:grey;"></i>
                            @else
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ Storage::url('images/faces/' . $user->profile_pic) }}">
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->role }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="bi bi-person-vcard-fill"></i></b> <a
                                    class="float-right">{{ $user->username }}</a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="bi bi-envelope-at-fill"></i></b> <a
                                    class="float-right">{{ $user->email }}</a>
                            </li>
                        </ul>
                        <a href="{{ route('user.profileEdit') }}" class="btn btn-primary btn-block"
                            style="margin-top: 1rem;"><b>Edit Profile
                                <i class="bi bi-pencil-square"></i></b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col sm:mt-5">
                <div class="grid gap-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Soal Latihan</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    {{ $nilai->links() }}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Niai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @forelse ($nilai as $pertanyaan)
                                            @foreach ($pertanyaan->codes as $code)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $pertanyaan->judul }}</td>
                                        <td>{{ Carbon\Carbon::parse($pertanyaan->created_at)->format('d F Y') }}
                                        </td>
                                        <td>{!! $code->score
                                            ? '<span class="badge bg-primary">Selesai</span>'
                                            : '<span class="badge bg-warning text-dark">Menunggu Penilaian</span>' !!}</td>
                                        <td>{!! $code->score ? '<span class="text-primary">' . $code->score . '</span>' : '-' !!}</td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5">Anda belum menyelesaikan Soal.</td>
                                    </tr>
                                    @endforelse
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quiz</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    {{ $paginator->links() }}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($paginator as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['category'] }}</td>
                                            <td>{{ Carbon\Carbon::parse($item['completed_at'])->format('d F Y') }}</td>
                                            <td>{{ number_format($item['score'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Anda belum menyelesaikan Quiz.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script-bottom')
@if (session('success'))
    <script>
        showSucc('', "{{ session('success') }}");
    </script>
@endif
@if (session('error'))
    <script>
        showError('Maaf..!', "{{ session('error') }}");
    </script>
@endif
@endsection
