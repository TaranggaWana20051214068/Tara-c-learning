@extends('layouts.app')

@section('content')
@section('title', 'Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<section>
    <div class="container">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Ubah Pengguna</h4>

                            <form action="{{ route('user.profileUpdate') }}" method="POST"
                                class='mt-3'enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Nama</label>
                                    <div class="col-md-10">
                                        <input type="text" name="name"
                                            class='form-control @error('name') is-invalid @enderror'
                                            value="{{ $user->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Username</label>
                                    <div class="col-md-10">
                                        <input type="text" name="username"
                                            class='form-control @error('username') is-invalid @enderror'
                                            value="{{ $user->username }}">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Email</label>
                                    <div class="col-md-10">
                                        <input type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Password</label>
                                    <div class="col-md-10">
                                        <input type="text" name="password"
                                            class='form-control @error('password') is-invalid @enderror'
                                            placeholder="Isi jika ingin diubah">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Role</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" value="{{ $user->role }}"
                                            aria-label="role" disabled readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-2 col-form-label'>Gambar</label>
                                    <div class="col-md-10">
                                        <input type="file" class="form-control" name='photo'>
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <img src="{{ Storage::url('images/faces/' . $user->profile_pic) }} "
                                            alt="" srcset="" style="width: 100px">
                                    </div>
                                </div>
                                <button type="submit" class='btn btn-primary float-right'>Submit</button>
                            </form>

                        </div>
                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->
        </div>
    </div>
</section>

@endsection
