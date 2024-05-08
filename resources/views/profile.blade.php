@extends('layouts.app')

@section('content')
@section('title', 'profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section class="student">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @if (!auth()->user()->profile_pic)
                    <i class="bi bi-person" style="font-size: 10rem; color:grey;"></i>
                @else
                    <img src="{{ URL::asset('assets/images/faces/' . auth()->user()->profile_pic . '') }}">
                @endif
                <br>
                <a href="" class="btn btn-primary" style="margin-top: 1rem;">Edit profile <i
                        class="bi bi-pencil-square"></i></a>
            </div>
            <div class="col-md-9 sm:mt-5">
                <h1 class='mb-3'>{{ $student->name }}</h1>
                <p> Caption <br>
                    {!! nl2br($student->description ? $student->description : 'No caption.') !!}</p>
            </div>
        </div>
    </div>
</section>

@endsection
