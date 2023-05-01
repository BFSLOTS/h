@extends('layouts.app')
@section('title', __('Verify Email'))
@section('content')
    <div class="row align-items-center justify-content-center text-start" >
        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo" style="width:60%;">
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <div class="">
                        <h4 class="text-primary mb-3">{{ __('Verify Your Email Address') }}</h4>
                    </div>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
