@extends('layouts.main')
@section('title', __($t))
@section('content')
    <div class="row">
        <div class="main-content">
            <section class="section">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h4 class="m-b-10">{{ __('Dashboard') }}</h4>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
                                    <li class="breadcrumb-item">{{ __($t) }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-body">

                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card sticky-top">
                                <div class="list-group list-group-flush" id="useradd-sidenav">
                                    <a href="{{ route('setting', 'app-setting') }}"
                                        class="list-group-item list-group-item-action active">{{ __('App Setting') }}</a>
                                    <a href="{{ route('setting', 'storage-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Storage') }}</a>
                                    <a href="{{ route('setting', 'mail-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Email') }}</a>
                                    <a href="{{ route('setting', 'social-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Social') }}</a>
                                    <a href="{{ route('setting', 'chat-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Chat') }}</a>
                                    <a href="{{ route('setting', 'general-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('General') }}</a>
                                    <a href="{{ route('setting', 'captcha-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Captcha') }}</a>
                                    <a href="{{ route('setting', 'payment-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Payment') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <form id="setting-form" action="{{ route('settings/app-name/update') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                        <h5> {{ __($t) }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted"> {{ __('App Name') }} {{ __('& App Logo') }}</p>
                                        <div class="">
                                            <div class=" row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('Application Name') }} </label>
                                                        <input type="text" name="app_name" class="form-control"
                                                            value="{{ Utility::getsettings('app_name') }}"
                                                            placeholder="{{ __('Application Name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group bg-light text-center">
                                                        <img id="app-dark-logo"
                                                            class=" img-responsive my-5 w-50 justify-content-center text-center"
                                                            src="{{ Utility::getsettings('app_logo') ? Storage::url('uploads/appLogo/app-logo.png') : '' }}"
                                                            alt="App_logo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">{{ __('Select Logo') }}</label>
                                                        <input type="file" name="app_logo" class="form-control"
                                                            value="Select  Logo">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group bg-light text-center">
                                                        <img id="app-dark-logo"
                                                            class=" img-responsive my-5 w-50 justify-content-center logo "
                                                            src="{{ Utility::getsettings('app_small_logo') ? Storage::url('uploads/appLogo/app-small-logo.png') : '' }}"
                                                            alt="app_small_logo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">{{ __('Select small Logo') }}</label>
                                                        <input type="file" name="app_small_logo" class="form-control"
                                                            value="Select Small  Logo">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group bg-light text-center">
                                                        <img id="app-dark-logo"
                                                            class=" img-responsive my-5
                                                            w-50 justify-content-center logo "
                                                            src="{{ Utility::getsettings('favicon_logo') ? Storage::url('uploads/appLogo/app-favicon-logo.png') : '' }}"
                                                            alt="favicon_logo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">{{ __('Select favicon Logo') }}</label>
                                                        <input type="file" name="favicon_logo" class="form-control"
                                                            value="Select Favicon Logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <hr>
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                        <a href="{{ route('settings') }}"
                                            class="btn btn-secondary">{{ __('Cancel') }}</a>
                                    </div></div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
