@extends('layouts.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @endpush

    <section class="article">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img
                                    class="img-fluid"src="{{ Storage::url('images/articles/' . $article->thumbnail_image_name) }}">
                            </div>
                            <br>
                            <p class="text-primary text-center"><b>{{ $article->title }}</b></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @if (!empty($article->file_name) || $questionIds->isNotEmpty())
                        <div class="card">
                            <div class="card-body">
                                @if ($article->file_name)
                                    <a href="{{ Storage::url('images/articles/file/' . $article->file_name) }}"
                                        class="btn btn-primary btn-block" download><b>Unduh Materi</b></a>
                                @endif
                                @foreach ($questionIds as $questionId)
                                    <a href="{{ route('soal.show', ['id' => $questionId]) }}"
                                        class="btn btn-primary btn-block"><b>Latihan
                                            Soal {{ $loop->iteration }}</b></a>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endif
                </div>
                <div class="col sm:mt-5">
                    <div class="grid gap-3">
                        <div class="card">
                            <div class="card-body pt-4">
                                <div class="card-detail">
                                    <span><i class="bi bi-person-circle"></i> {{ $article->author->name }}</span> <span
                                        class='ml-10'>{{ Carbon\Carbon::parse($article->created_at)->format('d F Y H:i:s') }}</span>
                                </div>
                                <br>
                                <p class="text-dark text-justify">{!! nl2br(htmlspecialchars($article->content)) !!}</p>
                                @if ($youtubeVideos)
                                    <div class="container-sm text-center">
                                        <h5 class="mt-2">Lampiran</h5>
                                        <div class="row">
                                            @foreach ($youtubeVideos as $youtubeVideo)
                                                @if ($youtubeVideo)
                                                    <div class="col">
                                                        {!! $youtubeVideo !!}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script-bottom')
    {{-- <script>
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>
    <script src="{{ URL::asset('assets/pages/article-youtube.js') }}"></script>
    <script>
        // Fungsi untuk memeriksa koneksi internet
        function checkInternetConnection() {
            return navigator.onLine; // Mengembalikan true jika ada koneksi internet, false jika tidak
        }

        // Fungsi untuk memuat video YouTube atau menampilkan tautan jika tidak ada koneksi internet
        function loadYouTubeVideos() {
            // Daftar link video YouTube yang tersedia
            var youtubeLinks = [
                @if ($links->count() > 0)
                    @foreach ($links as $link)
                        '{{ $link }}',
                    @endforeach
                @endif
            ];

            if (youtubeLinks.length > 0) {
                if (checkInternetConnection()) {
                    // Jika ada koneksi internet, memuat video menggunakan IFrame Player API
                    youtubeLinks.forEach(function(videoUrl) {
                        var vId = getVidId(videoUrl);
                        if (vId) {
                            var playerDiv = document.createElement('div');
                            playerDiv.id = 'player-' + vId;
                            document.getElementById('players-container').appendChild(playerDiv);
                            var player = new YT.Player(playerDiv.id, {
                                height: '150',
                                width: '250',
                                videoId: vId,
                                playerVars: {
                                    'playsinline': 1,
                                    'autoplay': 0
                                }
                            });
                        }
                    });
                } else {
                    // Jika tidak ada koneksi internet, tampilkan tautan menuju video YouTube
                    var playersContainer = document.getElementById('players-container');
                    youtubeLinks.forEach(function(videoUrl) {
                        var vId = getVidId(videoUrl);
                        if (vId) {
                            var youtubeLink = document.createElement('a');
                            youtubeLink.href = "https://www.youtube.com/watch?v=" + vId;
                            youtubeLink.textContent = "Tonton di YouTube";
                            playersContainer.appendChild(youtubeLink);
                            playersContainer.appendChild(document.createElement('br'));
                        }
                    });
                }
            }
        }

        // Fungsi untuk mendapatkan ID video dari URL
        function getVidId(url) {
            var match = url.match(/[?&]v=([^&]+)/);
            return match ? match[1] : null;
        }

        // Memuat video YouTube atau menampilkan tautan jika tidak ada koneksi internet saat halaman dimuat
        window.onload = loadYouTubeVideos;
    </script> --}}
@endsection
