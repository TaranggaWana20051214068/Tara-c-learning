@extends('layouts.master')

@section('title', 'Ubah Artikel')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Artikel</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Artikel</a></li>
                        <li class="breadcrumb-item">Ubah</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Ubah Artikel</h4>

                        <form action="{{ route('admin.articles.update', ['article' => $article->id]) }}" method="POST"
                            class='mt-3' enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="title"
                                        class='form-control @error('title') is-invalid @enderror'
                                        value="{{ $article->title }}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Konten</label>
                                <div class="col-md-10">
                                    <textarea name="content" id="" rows="5" class="form-control  @error('content') is-invalid @enderror">{{ $article->content }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Thumbnail</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control form-control-sm" id="formFileThumnail"
                                        name='thumbnail'>
                                    <code>Thumbnail Harus Berupa Gambar. </code>
                                    <br>
                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($article->thumbnail_image_name)
                                        <img src="{{ Storage::url('images/articles/' . $article->thumbnail_image_name) }}"
                                            alt="current image" class="img-thumbnail" style="max-width: 7rem"
                                            srcset="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Lampiran</label>
                                <div class="col-md-10">
                                    <input class="form-control form-control-sm" id="formFileArticle" type="file"
                                        name="file">
                                    <code>Gambar/file/dokumen MAX 10MB</code>
                                    <br>
                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($article->file_name)
                                        <a href="{{ Storage::url('images/articles/file/' . $article->file_name) }}"
                                            target="_blank">
                                            <i class="bi bi-file-earmark-medical" style="font-size: 3rem;"></i>
                                            <br>
                                            {{ $article->file_name }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-form-label">Link YouTube</label>
                                <div class="col-md-10" id="youtube-links-container">
                                    @foreach ($links as $link)
                                        <input type="text" class="form-control" value="{{ $link }}"
                                            name="youtube_links[]"
                                            @if ($link == null) style="display: none;" @endif>
                                    @endforeach
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Tambah Link Youtube
                                    </button>
                                    <input type="text" class="form-control" id="hidden-youtube-link"
                                        name='youtube_links[]' style="display: none;" placeholder="Masukkan link YouTube">
                                    @error('youtube_links')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->
    @section('modal-title')
        Masukkan URL
    @endsection


    {{-- Set nilai variabel Blade untuk konten modal --}}
    @section('modal-content')

        <form action="{{ route('admin.articles.url') }}" method="post">
            @csrf
            <input class="form-control" name="link" type="text" placeholder="Masukkan URL" aria-label="link">
            <input type="hidden" name="id" value="{{ $article->id }}">
            <input type="hidden" name="title" value="{{ $article->title }}">

        @endsection
        @section('modal-content-bottom')
        @section('modal-button')
            kirim
        @endsection
    </form>
@endsection

</div> <!-- container-fluid -->

<script src="{{ URL::asset('assets/pages/article-youtube.js') }}"></script>

@endsection
@section('script-bottom')
@if (session('success'))
<script>
    $.SweetAlert.showSucc("{{ session('success') }}");
</script>
@endif
@if (session('error'))
<script>
    $.SweetAlert.showErr("{{ session('error') }}");
</script>
@endif
@endsection
