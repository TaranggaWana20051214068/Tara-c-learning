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
                                <label for="" class='col-md-2 col-form-label'>Lampiran</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control-file" name='thumbnail'>
                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($article->thumbnail_image_name)
                                        <a href="{{ Storage::url('images/articles/' . $article->thumbnail_image_name) }}"
                                            target="_blank">
                                            <i class="bi bi-file-earmark-medical" style="font-size: 3rem;"></i>
                                            <br>
                                            {{ $article->thumbnail_image_name }}
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
                                    <input type="text" class="form-control" id="hidden-youtube-link"
                                        name='youtube_links[]' style="display: none;" placeholder="Masukkan link YouTube">
                                    @error('youtube_links')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="submit-button">Masukkan Link YouTube</button>
                            <button type="submit" class='btn btn-primary float-right'>Submit</button>
                        </form>

                    </div>
                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
@section('script-bottom')
    <script>
        // Fungsi untuk menambahkan inputan link YouTube baru
        function addYoutubeLinkInput(url) {
            var container = document.getElementById('youtube-links-container');
            var inputs = container.getElementsByTagName('input');
            var hiddenInput = document.getElementById('hidden-youtube-link');
            var input = document.createElement('input');

            // Hapus semua input sebelum menambahkan yang baru
            if (inputs.length > 1) {
                input.name = 'youtube_links[]';
            } else {
                input.name = 'ss';
            }
            input.type = 'text';
            input.className = 'form-control';
            input.value = url; // Memasukkan nilai URL ke dalam input
            container.appendChild(input);
            hiddenInput.value = url;

        }
    </script>
    <script>
        document.getElementById('submit-button').addEventListener('click', async function() {
            const {
                value: url
            } = await Swal.fire({
                input: "url",
                inputLabel: "URL address",
                inputPlaceholder: "Enter the URL",
                showCancelButton: true
            });
            if (url) {
                addYoutubeLinkInput(url);
                document.getElementById('submit-button').style.display = 'none';
            }
        });
    </script>
@endsection
