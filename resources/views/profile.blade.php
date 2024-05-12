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
                <h1 class='mb-3'>{{ $user->name }}</h1>
                <div class="card mb-5">
                    <div class="card-header">
                        <h3>Nilai</h3>
                    </div>
                    <div class="card-body">
                        <table class="bordered">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
