@extends('layouts.app')
@section('title', __('Confirm Password'))

@section('content')
    <div class="row align-items-center justify-content-center text-start" style="margin-top:195px;">
        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo" style="width:60%;">
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                        <div class="">
                            <h4 class="text-primary mb-3">{{ __('Confirm Password') }}</h4>
                        </div>
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="password" class="form-label mb-2">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block mt-2">
                                    {{ __('Confirm Password') }}</button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
