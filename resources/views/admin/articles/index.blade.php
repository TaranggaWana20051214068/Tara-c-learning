@extends('layouts.master')

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('title', 'Materi')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Materi</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Materi</a></li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Seluruh Materi</h4>
                        <p class="text-muted m-b-30 font-14">Berikut adalah daftar seluruh materi</p>
                        <form action="" class="form-inline">
                            <div class="row mb-3">
                                <div class="col-md-5 mb-3">
                                    <div class="input-group">
                                        <select name="subject" id="subject" class="form-select">
                                            <option value="" selected disabled>- Pilih Mata Pelajaran -</option>
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
                                <div class="col-md-5 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari Data" name="search"
                                            value="{{ request()->get('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 ml-auto float-right">
                                    <a class="btn btn-primary " href="{{ route('admin.articles.create') }}">Tambah</a>
                                </div>
                            </div>
                        </form>
                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi-lg bi-check-circle flex-shrink-0 me-2"></i>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Lampiran</th>
                                        <th>Judul</th>
                                        <th>Konten</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $article)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                @if ($article->file_name)
                                                    <a href="{{ Storage::url('images/articles/file/' . $article->file_name) }}"
                                                        target="_blank">
                                                        <i class="bi bi-file-earmark-medical"></i>
                                                    </a>
                                                @else
                                                    Tidak Tersedia
                                                @endif
                                            </td>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ substr($article->content, 0, 50) }}..</td>
                                            <td>{{ Carbon\Carbon::parse($article->created_at)->format('d F Y H:i:s') }}
                                            </td>
                                            <td>
                                                <div class='d-inline-flex'>
                                                    <a href="{{ route('admin.articles.edit', ['article' => $article->id]) }}"
                                                        class='btn btn-warning mr-2'><i class="bi bi-pencil-fill"></i></a>
                                                    <form
                                                        action="{{ route('admin.articles.destroy', ['article' => $article->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class='btn btn-danger btn-delete'><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data <a
                                                    href="{{ route('admin.articles.create') }}">tambah data.</a></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="paginate float-right mt-3">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection

@section('script')

    <script src="{{ asset('js/main.js') }}"></script>
@endsection
@section('script-bottom')
    @if (session('success'))
        <script>
            $.SweetAlert.showSucc("{{ session('success') }}");
        </script>
    @endif
@endsection
