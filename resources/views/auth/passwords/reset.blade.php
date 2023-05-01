@extends('layouts.app')
@section('title', __('Reset Password'))
@section('content')
    <div class="row align-items-center justify-content-center text-start" style="margin-top:195px;">
        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo" style="width:60%;">
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <div class="">
                        <h4 class="text-primary mb-3">{{ __('Reset Password') }}</h4>
                    </div>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group mb-3">
                                <label for="email" class="form-label mb-2">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                    autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block mt-2">
                                    {{ __('Reset Password') }}</button>

                            </div>

                        </form>


                </div>
            </div>
        </div>
    </div>
@endsection
