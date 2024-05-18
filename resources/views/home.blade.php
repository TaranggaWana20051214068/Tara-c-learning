@extends('layouts.app')

@section('content')
@section('logo', Storage::url('/images/logo/' . config('web_config')['WEB_LOGO']))
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <style>
        .menu-image {
            max-width: 300px;
            max-height: 300px;
            object-fit: contain;
        }
    </style>
@endpush
<section class="hero bg-white">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="col-md-6 justify-center">
                <div class="hero-text">
                    <div class="text-title text-dark fw-bold" style="line-height: 1.1;">
                        {{ config('web_config')['HERO_TEXT_HEADER'] }}
                        <br>
                        <span class="text-primary"> {{ config('web_config')['WEB_TITLE'] }}</span>
                    </div>
                    <p class="text-secondary">{{ config('web_config')['HERO_TEXT_DESCRIPTION'] }}</p>
                    <a href="{{ route('article.index') }}" class="btn btn-primary btn-lg"
                        style="border-radius: 12px;">Mulai Belajar</a>
                </div>
            </div>
            <div class="col-7 col-md-6 d-none d-md-block">
                <img class="img-fluid image float-end"
                    src="{{ Storage::url('images/front/' . config('web_config')['HERO_BACKGROUND_IMAGE']) }}"
                    alt="">
            </div>
        </div>
    </div>
</section>
<section class="articles">
    <div class="container">
        <div class="section-header text-center">
            <h1>Menu</h1>
            <div class="divider mx-auto"></div>
        </div>
        <div class="section-body">
            <div class="row">
                @foreach ($menus as $menu)
                    <div class="col-sm">
                        <div class="card h-100">
                            <div class="container text-center">
                                <div class="row mb-3  d-flex justify-content-center">
                                    <img class="menu-image"
                                        src="{{ Storage::url('images/front/' . $menu->image_name) }}" alt="">
                                </div>
                                <div class="row mb-3">
                                    <div class="fw-bold">
                                        <h5>{{ $menu->judul }}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>{{ $menu->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='text-right mt-5'>
                <a href="{{ route('article.index') }}">Lihat Selengkapnya <i class='bi bi-chevron-right'></i></a>
            </div>
        </div>
    </div>
</section>
<section class="articles">
    <div class="container">
        <div class="section-header text-center">
            <h1>Tentang C-Learning</h1>
            <div class="divider mx-auto" style="width: 140px;"></div>
        </div>
        <div class="section-body">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="col-7 col-md-6 d-none d-md-block" style="margin-right: 7rem;">
                        <img class="img-fluid image float-end" style="width: 80%;object-fit:contain;"
                            src="{{ Storage::url('images/front/' . $ttg['image_name']) }}" alt="">
                    </div>
                    <div class="col-md-4">
                        <div class="hero-text">
                            <img src="{{ Storage::url('images/logo/' . config('web_config')['WEB_LOGO']) }}"
                                alt="Logo" style="height: 3rem; margin-bottom:15px;">
                            <p class="text-secondary">{{ $ttg['description'] }}</p>
                            <a href="{{ route('article.index') }}" class="btn btn-primary btn-md"
                                style="border-radius: 12px;">Belajar Sekarang!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@endpush
