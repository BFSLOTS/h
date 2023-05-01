@extends('layouts.app')
@section('title', __('Register'))
@section('content')


    <div class="row align-items-center justify-content-center text-start">
        <div class="col-xl-6 text-center">
             <div class="mx-3 mx-md-5 mb-5">
                <img src="{{ asset('vendor/img/prime-white.png') }}" class="logo" style="width:60%;">
            </div>
            <div class="card">
                <div class="card-body mx-auto">
                    <div class="text-start">
                        <div class="">
                            <h4 class="text-primary mb-3">{{ __('Register with') }}</h4>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" name="name" required autocomplete="name" autofocus
                                    value="{{ old('name') }}" class="form-control" placeholder="{{ __('Name') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" placeholder="{{ __('Email') }}"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" placeholder="{{ __('Password') }}"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}"
                                    class="form-control" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Role') }}</label>
                                {!! Form::select('role', $roles, null, ['class' => 'form-control custom_select ']) !!}

                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="terms" value="agree" id=" customCheckLogin"
                                        type="checkbox">
                                    <label class="form-check-label" for=" customCheckLogin">
                                        <span class="text-muted">{{ __('I agree to the') }} <a
                                                href="#">{{ __('Terms') }}</a></span>
                                    </label>

                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit"
                                    class="btn btn-primary btn-block mt-2">{{ __('Register') }}</button>
                            </div>
                        </form>
                    </div>
                    <p class="mt-1">{{ __('Already have an account?') }} <a href="{{ url('/') }}"
                            class="f-w-400">{{ __('Signin') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $(".custom_select").select2();
        })
    </script>
@endpush
