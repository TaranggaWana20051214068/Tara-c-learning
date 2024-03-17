@extends('layouts.app')
@section('content')
@section('title', $question->title)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="article">
    <div class="container">
        <iframe frameBorder="0" height="700px" width="100%" src="{{ $link }}"></iframe>
        <div class="thumbnail">
        </div>

    </div>
</section>
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
