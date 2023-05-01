@extends('layouts.app')
@section('title', __('Send Mail'))
@section('content')
    <div class="row align-items-center justify-content-center text-start" style="margin-top:195px;">
        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo mt-5" width="175">
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <div class="">
                        <h4 class="text-primary mb-3">{{ __('Send Mail') }}</h4>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label mb-2">{{ __('Email') }}</label>
                            <input class="form-control {{ __('Email') }}" placeholder="{{ __('E-Mail Address') }}"
                                type="email" name="email" id="email" value="{{ old('email') }}" onfocus>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('Forgot Password') }}</button>
                            <a href="{{ url('/login') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
