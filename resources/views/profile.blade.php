@extends('layouts.master')
@section('page_title'){{ 'Profile - '.config("app.name") }}@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
        </div>
        <div class="card">
            <form action="{{ route('profile.update') }}" method="POST">
            @csrf
                <div class="card-header">
                    Update Basic Details
                </div>
                <div class="card-body">
                    <div class="col-12">
                        @if (session()->has("details_success"))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! session()->get('details_success') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row m-3">
                            <div class="col-6">
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="First name"
                                    value="{{ old('firstname', auth()->user()->firstname) }}" name="firstname">
                                @error('firstname')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Last name"
                                    value="{{ old('lastname', auth()->user()->lastname) }}" name="lastname">
                                @error('lastname')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-6">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    value="{{ old('email', auth()->user()->email) }}" name="email">
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success btn-lg">Update</button>
                    <button type="button" class="btn btn-danger btn-lg" onclick="window.location.reload()">Cancel</button>
                </div>
            </form>
        </div>

        <div class="card mt-5">
            <form action="{{ route('userpassword.change') }}" method="POST">
            @csrf
                <div class="card-header">
                    Change Password
                </div>
                <div class="card-body">
                    <div class="col-12">
                        @if (session()->has("password_success"))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! session()->get('password_success') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row m-3">
                            <div class="col-6">
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Your old password"
                                    value="{{ old('old_password') }}" name="old_password">
                                @error('old_password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if(session()->has("old_password"))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ session()->get("old_password") }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="New password" name="password">
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if(session()->has("password"))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ session()->get("password") }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-6">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success btn-lg">Update</button>
                    <button type="button" class="btn btn-danger btn-lg" onclick="window.location.reload()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
