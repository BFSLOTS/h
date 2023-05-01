@extends('layouts.app')
@section('title', __('Login'))
@section('content')
    <div class="row align-items-center justify-content-center text-start">

        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5" style="margin-top:95px;">

                <img src="{{ Storage::url(setting('app_logo')) ? Storage::url('uploads/appLogo/app-logo.png') : '' }}"  class="app-logo mt-5 " width="175"/>
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <div class="">
                        <h4 class="text-primary mb-3">{{ __('Sign in') }}</h4>
                    </div>
                    <form method="POST" class="needs-validation" action="{{ route('login') }}">
                        @csrf
                        <div class="text-start">
                            <div class="form-group mb-3">
                                <label class="form-label mb-2" for="email">{{ __('E-Mail Address') }}</label>
                                <input class="form-control {{ __('Email') }}" placeholder="{{ __('E-Mail Address') }}"
                                    type="email" name="email" id="email" value="{{ old('email') }}" onfocus>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="password">{{__('Enter Password')}}</label>
                                <a href="{{ route('password.request') }}" class="text-small float-end">
                                    {{ __('Forgot Password ?') }}
                                </a>
                                <input id="password" type="password" class="form-control"  placeholder="{{__('Password')}}" name="password" tabindex="2" required
                                    autocomplete="current-password">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-check mt-2  form-switch d-flex ">
                                <input type="checkbox" class="form-check-input" style="margin-right: 5px;"
                                    id="customswitch1">
                                <label class="form-check-label" for="customswitch1">{{ __('Remember me') }}</label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-block  ">{{ __('Sign In') }}</button>
                        </div>
                    </form>
                    @if (env('GOOGLESETTING') == 'on' || env('LINKEDINSETTING') == 'on' || env('FACEBOOKSETTING') == 'on' || env('GITHUBSETTING') == 'on')

                        <div class="mt-4 scl_btn">

                            Login with
                        </div>
                        <div class="row mb-4 mt-4">

                            @if (env('GOOGLESETTING') == 'on')
                                <div class="col-3">
                                    <div class="d-grid"><a href="{{ url('/redirect/google') }}"
                                            class="btn btn-light"><img
                                                src="{{ asset('assets/images/auth/img-google.svg') }}" alt=""
                                                class="img-fluid wid-25"></a></div>
                                </div>
                            @endif
                            @if (env('LINKEDINSETTING') == 'on')
                                <div class="col-3">
                                    <div class="d-grid"><a href="{{ url('/redirect/linkedin') }}"
                                            class="btn btn-light"><img src="{{ asset('assets/images/auth/link.png') }}"
                                                alt="" class="img-fluid wid-25"></a></div>
                                </div>
                            @endif
                            @if (env('FACEBOOKSETTING') == 'on')
                                <div class="col-3">
                                    <div class="d-grid"><a href="{{ url('/redirect/facebook') }}"
                                            class="btn btn-light"><img
                                                src="{{ asset('assets/images/auth/img-facebook.svg') }}" alt=""
                                                class="img-fluid wid-25"></a></div>
                                </div>
                            @endif
                            @if (env('GITHUBSETTING') == 'on')
                                <div class="col-3">
                                    <div class="d-grid"><a href="{{ url('/redirect/github') }}"
                                            class="btn btn-light"><img
                                                src="{{ asset('assets/images/auth/github.svg') }}" alt=""
                                                class="img-fluid wid-25"></a></div>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
