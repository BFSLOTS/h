@extends('layouts.app')
@section('title', __('2FA'))
@section('content')
    <div class="row align-items-center justify-content-center text-start" style="margin-top:195px;">
        <div class="col-xl-6 text-center">
            <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo" style="">
            </div>
            <div class="mx-3 mx-md-5">
                <h2 class="text-white mb-3"> {{ __('2-Step Verification') }}</h2>
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                                <label for="email" class="form-label mb-2">{{ __('One time Password') }}</label>
                                <input class="form-control {{ __('One time Password') }}"
                                    placeholder="{{ __('One Time Password') }}" type="text" name="one_time_password"
                                    id="one_time_password" value="{{ old('one_time_password') }}" onfocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            @if ($errors->has('one_time_password'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('one_time_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="form-control btn btn-primary my-4">{{ __('Verify') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
