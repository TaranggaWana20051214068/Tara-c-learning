@extends('layouts.master')

@section('title', 'Tambah Materi')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Materi</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Materi</a></li>
                        <li class="breadcrumb-item">Tambah</li>
                    </ol>


                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Tambah Materi</h4>

                        <form action="{{ route('admin.articles.store') }}" method="POST" class='mt-3'
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="title"
                                        class='form-control @error('title') is-invalid @enderror'>
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
                                    <textarea name="content" id="" rows="5" class="form-control  @error('content') is-invalid @enderror"></textarea>
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
                                    <input type="file"
                                        class="form-control @error('thumbnail') is-invalid @enderror form-control-sm"
                                        id="formFileThumnail" name='thumbnail'>
                                    <code>Thumbnail Harus Berupa Gambar. </code>
                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class='col-md-2 col-form-label'>Lampiran</label>
                                <div class="col-md-10">
                                    <input class="form-control form-control-sm" id="formFileArticle" type="file"
                                        name="file_name">
                                    <code>Gambar/file/dokumen MAX 10MB</code>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-form-label">Link YouTube</label>
                                <div class="col-md-10" id="youtube-links-container">
                                    <input type="text" class="form-control" id="hidden-youtube-link"
                                        name='youtube_links[]' style="display: none;" placeholder="Masukkan link YouTube">
                                    <button type="button" class="btn btn-primary" id="submit-button">Masukkan Link
                                        YouTube</button>

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


    </div> <!-- container-fluid -->
@endsection
@section('script-bottom')
    <script src="{{ URL::asset('assets/pages/article-youtube.js') }}"></script>
    <script>
        addYT();
    </script>
@endsection
