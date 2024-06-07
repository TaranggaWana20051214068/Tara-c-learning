@extends('layouts.app')

@section('content')
@section('title', 'Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .customm-loader {
            display: none;
            /* Loader tidak terlihat secara default */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
            justify-content: center;
            align-items: center;
        }

        .loader-spinner {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .card-body {
            position: relative;
            overflow: hidden;
        }
    </style>
@endpush

<section>
    <div class="container">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Panduan User
                                <a href="{{ route('unduh-panduan') }}" class="btn btn-primary float-lg-right">Unduh
                                    Panduan PDF</a>
                            </h4>
                            <div id="loader" class="customm-loader">
                                <div class="loader-spinner"></div>
                            </div>
                            <br>
                            <embed class="" id="pdfEmbed" src="{{ Storage::url('pdf/buku_panduan.pdf') }}"
                                type="application/pdf" width="100%" height="600px" />
                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->
        </div>
    </div>
</section>

@endsection
@section('script-bottom')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loader = document.getElementById('loader');
        var pdfEmbed = document.getElementById('pdfEmbed');

        // Tampilkan loader saat PDF sedang dimuat
        loader.style.display = 'flex';

        // Sembunyikan loader saat PDF selesai dimuat
        pdfEmbed.onload = function() {
            loader.style.display = 'none';
        };

        // Sembunyikan loader jika terjadi kesalahan saat memuat PDF
        pdfEmbed.onerror = function() {
            loader.style.display = 'none';
            alert('Terjadi kesalahan saat memuat PDF.');
        };
    });
</script>
@endsection
