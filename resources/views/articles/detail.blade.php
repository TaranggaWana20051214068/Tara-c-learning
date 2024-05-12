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
                    <div class="card-detail">
                        <span><i class="bi bi-person-circle"></i> {{ $article->author->name }}</span> <span
                            class='ml-10'>{{ Carbon\Carbon::parse($article->created_at)->format('d F Y H:i:s') }}</span>

                    </div>
                    <h1 class="card-title mt-2">{{ $article->title }}</h1>
                    <p>{!! nl2br($article->content) !!}</p>
                    @foreach ($questionIds as $questionId)
                        <a href="{{ route('soal.show', ['id' => $questionId]) }}" class="btn btn-primary">Latihan
                            Soal</a>
                    @endforeach
                    @if ($links->count() > 0 || $article->file_name)
                        <div class="container-sm text-center">
                            <h4 class="mt-2">Lampiran</h4>
                            <div class="row">
                                <div class="col">
                                    @if ($article->file_name)
                                        <a href="{{ Storage::url('images/articles/file/' . $article->file_name) }}"
                                            target="_blank">
                                            <i class="bi bi-file-earmark-medical" style="font-size: 3rem;"></i>
                                            <br>
                                            {{ $article->file_name }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col">
                                    <div id="players-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="thumbnail"></div>
        </div>
    </section>
    <script>
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
            console.log(youtubeLinks);
            // 1. Memeriksa koneksi internet
            if (youtubeLinks != "") {
                if (checkInternetConnection()) {
                    // Jika ada koneksi internet, memuat video menggunakan IFrame Player API
                    youtubeLinks.forEach(function(videoId) {
                        var playerDiv = document.createElement('div');
                        var vId = getVidId(videoId);
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
                    });
                } else {
                    // Jika tidak ada koneksi internet, tampilkan tautan menuju video YouTube
                    var playersContainer = document.getElementById('players-container');
                    youtubeLinks.forEach(function(videoId) {
                        var youtubeLink = document.createElement('a');
                        youtubeLink.href = "https://www.youtube.com/watch?v=" + videoId;
                        youtubeLink.textContent = "Tonton di YouTube";
                        playersContainer.appendChild(youtubeLink);
                        playersContainer.appendChild(document.createElement('br'));
                    });
                }
            }
        }

        // Memuat video YouTube atau menampilkan tautan jika tidak ada koneksi internet saat halaman dimuat
        window.onload = loadYouTubeVideos;
    </script>

@endsection
