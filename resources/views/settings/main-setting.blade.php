@php
$lang = \App\Facades\UtilityFacades::getValByName('default_language');
$primary_color = \App\Facades\UtilityFacades::getsettings('color');
if (isset($primary_color)) {
    $color = $primary_color;
} else {
    $color = 'theme-4';
}
@endphp
@extends('layouts.main')
@section('title', __('Settings'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Dashboard') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3" >
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('App Setting') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action">{{ __('General Setting') }}<div
                                    class="float-end"></div></a>
                            <a href="#useradd-3"
                                class="list-group-item list-group-item-action">{{ __('Storage Setting') }}<div
                                    class="float-end"></div></a>
                            <a href="#useradd-4" class="list-group-item list-group-item-action">{{ __('Chat Setting') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-5" class="list-group-item list-group-item-action">{{ __('Social Setting') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-6" class="list-group-item list-group-item-action">{{ __('Email Setting') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-7"
                                class="list-group-item list-group-item-action">{{ __('Captcha Setting') }}<div
                                    class="float-end"></div></a>
                            <a href="#useradd-8"
                                class="list-group-item list-group-item-action">{{ __('Payment Setting') }}<div
                                    class="float-end"></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    <div id="useradd-1" class="card">
                        <form id="setting-form" action="{{ route('settings/app-name/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-header">
                                <h5> {{ __('App Settings') }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted"> {{ __('App Name') }} {{ __('& App Logo') }}</p>
                                <div class="">
                                    <div class=" row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ __('Application Name') }}
                                                </label>
                                                <input type="text" name="app_name" class="form-control"
                                                    value="{{ Utility::getsettings('app_name') }}"
                                                    placeholder="{{ __('Application Name') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group bg-light text-center">
                                                <img id="app-dark-logo"
                                                    class="img-responsive my-5 w-50 justify-content-center text-center"
                                                    src="{{ Utility::getsettings('app_logo') ? Storage::url('uploads/appLogo/app-logo.png') : '' }}"
                                                    alt="App_logo">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ __('Select Logo') }}</label>
                                                <input type="file" name="app_logo" class="form-control"
                                                    value="Select  Logo">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <div class="form-group bg-light text-center">
                                                <img id="app-dark-logo"
                                                    class="img img-responsive my-5 w-auto justify-content-center text-center"
                                                    src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('uploads/appLogo/app-dark-logo.png') : '' }}"
                                                    alt="App_dark_logo">
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ __('Select Dark Logo') }}</label>
                                                <input type="file" name="app_dark_logo" class="form-control"
                                                    value="Select Logo">
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-12">
                                            <div class="form-group bg-light text-center">
                                                <img id="app-dark-logo"
                                                    class="img img-responsive my-5 w-auto justify-content-center text-center"
                                                    src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('uploads/appLogo/app-dark-logo.png') : '' }}"
                                                    alt="App_dark_logo">
                                            </div>
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Select Dark Logo') }}</label>
                                                <input type="file" name="app_dark_logo" class="form-control"
                                                    value="Select Logo">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group bg-light text-center">
                                                <img id="app-dark-logo"
                                                    class="img img-responsive my-5 justify-content-center logo "
                                                    src="{{ Utility::getsettings('favicon_logo') ? Storage::url('uploads/appLogo/app-favicon-logo.png') : '' }}"
                                                    alt="favicon_logo">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="name">{{ __('Select favicon Logo') }}</label>
                                                <input type="file" name="favicon_logo" class="form-control"
                                                    value="Select Favicon Logo">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer ">
                                <button class="btn btn-primary float-end mb-3" type="submit"
                                    id="save-btn">{{ __('Save Changes') }}</button>


                            </div>
                        </form>
                    </div>
                    <div id="useradd-2" class="">
                        <form id="setting-form" action="{{ route('settings/auth-settings/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5>{{ __('General Settings') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class=" row">
                                        <div class="col-lg-12">
                                            <div class="form-group row">
                                                <div class="col-md-8">
                                                    <strong
                                                        class="d-block">{{ __('Two Factor Authentication') }}</strong>
                                                    {{ !Utility::getsettings('2fa') ? __('Activate') : __('Deactivate') }}
                                                    {{ __('Two factor authentication for application.') }}
                                                </div>
                                                <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                    <label class="custom-switch mt-2 float-right">

                                                        <input name="two_factor_auth" data-onstyle="primary"
                                                            class="form-check-input input-primary" type="checkbox"
                                                            {{ Utility::getsettings('2fa') ? 'checked' : 'unchecked' }} />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-8">
                                                    <strong class="d-block">{{ __('RTL Setting') }}</strong>
                                                    {{ Utility::getsettings('rtl') == '0' ? __('Deactivate') : __('Activate') }}
                                                    {{ __('RTL setting for application.') }}
                                                </div>
                                                <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                    <label class="custom-switch mt-2 float-right">
                                                        <input type="checkbox" data-onstyle="primary"
                                                            class="form-check-input input-primary" name="rtl_setting"
                                                            id="site_rtl"
                                                            {{ Utility::getsettings('rtl') == '1' ? 'checked="checked"' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex row ">
                                                <div class="col-md-8">
                                                    <strong class="d-block">{{ __('Dark Layout') }}</strong>
                                                    {{ !Utility::getsettings('on') ? __('Activate') : __('Deactivate') }}
                                                    {{ __('Dark mode for application.') }}
                                                </div>
                                                <div class="col-md-4 form-check rtl-hide form-switch custom-switch-v1">
                                                    <label
                                                        class="custom-switch form-check-label mt-2 custom-left float-end">
                                                        <input type="checkbox" data-onstyle="primary"
                                                            class="form-check-input input-primary" id="cust-darklayout"
                                                            name="dark_mode"
                                                            @if (\App\Facades\UtilityFacades::getsettings('dark_mode') == 'on') checked @endif />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group align-items-center" style="display: flex;">
                                                <div class="col-md-8">
                                                    <strong class="d-block"
                                                        style="margin-left: -15px;">{{ __('Primary color settings') }}
                                                    </strong>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="theme-color themes-color float-end">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                            data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                        <input type="radio" class="theme_color " name="color"
                                                            value="theme-1" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-2' ? 'active_color' : '' }}"
                                                            data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-2" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                            data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-3" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                            data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-4" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!extension_loaded('imagick'))
                                                <small>
                                                    {{ __('Note: for 2FA your server must have Imagick.') }}
                                                    <a href="https://www.php.net/manual/en/book.imagick.php"
                                                        target="_new">{{ __('Imagick Document') }}</a>
                                                </small>
                                            @endif
                                            <div class="form-group ">
                                                <label for="name"
                                                    class="form-label">{{ __('Default Language') }}</label>
                                                {{-- <label class="col-form-label col-lg-4 col-sm-12 text-lg-end">Default</label> --}}


                                                <select class="form-control" data-trigger name="choices-single-default"
                                                    id="choices-single-default"
                                                    placeholder="{{ __('This is a search placeholder') }}">
                                                    @foreach (\App\Facades\UtilityFacades::languages() as $language)
                                                        <option @if ($lang == $language) selected @endif
                                                            value="{{ $language }}">
                                                            {{ Str::upper($language) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @hasrole('Super Admin')
                                                <div class="col-lg-12">
                                                    <div class="form-group ">
                                                        <label for="name"
                                                            class="form-label">{{ __('Gtag Tracking ID') }}
                                                            <a href="https://support.google.com/analytics/answer/1008080?hl=en#zippy=%2Cin-this-article"
                                                                class="m-2"
                                                                target="_blank">{{ __('Document') }}</a></label>
                                                        <input type="text" name="gtag" class="form-control"
                                                            value="{{ Utility::getsettings('gtag') }}"
                                                            placeholder="{{ __(' Enter Gtag Tracking ID') }}">
                                                    </div>
                                                </div>
                                            @endhasrole
                                            @if (\Auth::user()->type == 'Super Admin')
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Approved Domain Request') }}</label>
                                                    <select name="approve_type" class="form-control">
                                                        <option value="Manually"
                                                            {{ Utility::getsettings('approve_type') == __('Manually') ? 'selected' : '' }}>
                                                            {{ __('Manually') }}</option>
                                                        <option value="Auto"
                                                            {{ Utility::getsettings('approve_type') == __('Auto') ? 'selected' : '' }}>
                                                            {{ __('Auto') }}</option>
                                                    </select>
                                                </div>
                                            @endif
                                            @if (\Auth::user()->type == 'Super Admin')
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Currency Name') }}</label>
                                                    <input type="text" name="currency" class="form-control"
                                                        value="{{ env('CURRENCY') }}" required
                                                        placeholder="{{ __('Currency name') }}">
                                                    <p>{{ __('The name of currency is to be taken frome this document.') }}
                                                        <a href="https://stripe.com/docs/currencies" class="m-2"
                                                            target="_blank">{{ __('Document') }}</a>
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Currency Symbol') }}</label>
                                                    <input type="text" name="currency_symbol" class="form-control"
                                                        value="{{ env('CURRENCY_SYMBOL') }}" required
                                                        placeholder="{{ __('Currency Symbol') }}">
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div id="useradd-3" class=" ">
                        <form id="setting-form" action="{{ route('settings/wasabi-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __('Storage Settings') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status_toggle" class="form-label">{{ __('Local') }}
                                            </label>
                                            <label class="form-switch   custom-switch-v1 col-3 mt-2 "
                                                style="margin-bottom: 12px !important;">
                                                <input type="radio" name="settingtype" value="local
                                                    " class="form-check-input input-primary m-auto"
                                                    {{ Utility::getsettings('settingtype') == 'local' ? 'checked' : 'unchecked' }}>
                                            </label>
                                            <label for="status_toggle"
                                                class="form-label">{{ __('S3 setting') }}</label>
                                            <label class="form-switch   custom-switch-v1 col-3 mt-2 "
                                                style="margin-bottom: 12px !important;">
                                                <input type="radio" name="settingtype" value="s3"
                                                    class="form-check-input input-primary m-auto"
                                                    {{ Utility::getsettings('settingtype') == 's3' ? 'checked' : 'unchecked' }}>
                                            </label>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="status_toggle" class="form-label">{{ __('Local') }}
                                            </label>
                                            <label class="form-switch custom-switch-v1 col-3 mt-2 ms-2">
                                                <input type="radio" name="settingtype" value="local"
                                                    class="form-check-input input-primary"
                                                    {{ Utility::getsettings('settingtype') == 'local' ? 'checked' : 'unchecked' }}>
                                            </label>
                                            <label for="status_toggle"
                                                class="form-label">{{ __('S3 setting') }}</label>
                                            <label class="form-switch custom-switch-v1 col-3 mt-2 ms-2">
                                                <input type="radio" name="settingtype" value="s3"
                                                    class="form-check-input input-primary"
                                                    {{ Utility::getsettings('settingtype') == 's3' ? 'checked' : 'unchecked' }}>
                                            </label>
                                        </div> --}}
                                    </div>
                                    <div id="s3"
                                        class="desc {{ Utility::getsettings('settingtype') == 's3' ? 'block' : 'd-none' }}">
                                        <div class="">
                                            <div class=" row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 Key') }}</label>
                                                        <input type="text" name="s3_key" class="form-control"
                                                            value="{{ Utility::getsettings('s3_key') }}"
                                                            placeholder="{{ __('S3 Key') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 Secret') }}</label>
                                                        <input type="text" name="s3_secret" class="form-control"
                                                            value="{{ Utility::getsettings('s3_secret') }}"
                                                            placeholder="{{ __('S3 Secret') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 Region') }}</label>
                                                        <input type="text" name="s3_region" class="form-control"
                                                            value="{{ Utility::getsettings('s3_region') }}"
                                                            placeholder="{{ __('S3 Region') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 Bucket') }}</label>
                                                        <input type="text" name="s3_bucket" class="form-control"
                                                            value="{{ Utility::getsettings('s3_bucket') }}"
                                                            placeholder="{{ __('S3 Bucket') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 URL') }}</label>
                                                        <input type="text" name="s3_url" class="form-control"
                                                            value="{{ Utility::getsettings('s3_url') }}"
                                                            placeholder="{{ __('S3 URL') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="form-label">{{ __('S3 Endpoint') }}</label>
                                                        <input type="text" name="s3_endpoint" class="form-control"
                                                            value="{{ Utility::getsettings('s3_endpoint') }}"
                                                            placeholder="{{ __('S3 Endpoint') }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="useradd-4" class="">
                        <form id="setting-form" action="{{ route('settings/pusher-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __('Chat Settings') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted"> {{ __('Pusher Setting') }} <a target="_blank"
                                            href="https://pusher.com/" class="m-2">{{ __('Document') }}</a>
                                    </p>
                                    <div class="">
                                        <div class=" row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Pusher App ID') }}</label>
                                                    <input type="text" name="pusher_id" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_id') }}"
                                                        placeholder="{{ __('Pusher App ID') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Pusher Key') }}</label>
                                                    <input type="text" name="pusher_key" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_key') }}"
                                                        placeholder="{{ __('Pusher Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Pusher Secret') }}</label>
                                                    <input type="text" name="pusher_secret" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_secret') }}"
                                                        placeholder="{{ __('Pusher Secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Pusher Cluster') }}</label>
                                                    <input type="text" name="pusher_cluster" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_cluster') }}"
                                                        placeholder="{{ __('Pusher Cluster') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <div class="col-md-8">
                                                        <label for="status_toggle">{{ __('Status') }}</label>
                                                    </div>
                                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                        <label class="custom-switch mt-2 float-right">
                                                            <input name="pusher_status"
                                                                class="form-check-input form-check-input input-primary"
                                                                type="checkbox"
                                                                {{ Utility::getsettings('pusher_status') ? 'checked' : 'unchecked' }}>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="useradd-5" class="">
                        <form id="setting-form" action="{{ route('settings/social-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __('Social Settings') }}</h5>
                                </div>
                                @php
                                    // dd(env('RAZORPAYSETTING'));
                                    $google_class = 'd-none';
                                    $facebook_class = 'd-none';
                                    $github_class = 'd-none';
                                    $linkdin_class = 'd-none';
                                    
                                    if (env('GOOGLESETTING') == 'on') {
                                        $google_class = 'block';
                                    }
                                    if (env('FACEBOOKSETTING') == 'on') {
                                        $facebook_class = 'block';
                                    }
                                    if (env('GITHUBSETTING') == 'on') {
                                        $github_class = 'block';
                                    }
                                    if (env('LINKEDINSETTING') == 'on') {
                                        $linkdin_class = 'block';
                                    }
                                    
                                @endphp
                                <div class="card-body">

                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Google Setting') }}</strong>
                                            <span>{{ __('How To Enable Login With Google') }}<a
                                                    href="{{ Storage::url('pdf/login with google.pdf') }}"
                                                    class="m-2"
                                                    target="_blank">{{ __('Document') }}</a></span>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio  mt-2 float-right">
                                                <input name="socialsetting[]"
                                                    class="form-check-input paymenttsetting form-check-input input-primary"
                                                    type="checkbox" value="google"
                                                    {{ $google_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'stripe')? 'checked': 'unchecked' }} --}}>
                                                {{-- <span class="custom-switch-indicator"></span> --}}
                                            </label>
                                        </div>

                                    </div>
                                    <div id="google" class="desc  {{ $google_class }}">
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Google Client Id') }}</label>
                                                            <input type="text" name="google_client_id"
                                                                class="form-control"
                                                                value="{{ env('GOOGLE_CLIENT_ID') }}"
                                                                placeholder="{{ __('Google Client Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Google Client Secret') }}</label>
                                                            <input type="text" name="google_client_secret"
                                                                class="form-control"
                                                                value="{{ env('GOOGLE_CLIENT_SECRET') }}"
                                                                placeholder="{{ __('Google Client Secret') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Google Redirect Url') }}</label>
                                                            <input type="text" name="google_redirect"
                                                                class="form-control"
                                                                value="{{ env('GOOGLE_REDIRECT') }}"
                                                                placeholder="{{ __('https://demo.test.com/callback/google') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Facebook Setting') }}</strong>
                                            <span>{{ __('How To Enable Login With Facebook') }}<a
                                                    href="{{ Storage::url('pdf/login with facebook.pdf') }}"
                                                    class="m-2"
                                                    target="_blank">{{ __('Document') }}</a></span>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio  mt-2 float-right">
                                                <input name="socialsetting[]"
                                                    class="form-check-input paymenttsetting form-check-input input-primary"
                                                    type="checkbox" value="facebook"
                                                    {{ $facebook_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'razorpay')? 'checked': 'unchecked' }} --}}>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="facebook" class="desc {{ $facebook_class }} ">
                                        {{-- <p class="text-muted"> {{ __('Razorpay Setting') }}</p> --}}
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Facebook Client Id') }}</label>
                                                            <input type="text" name="facebook_client_id"
                                                                class="form-control"
                                                                value="{{ env('FACEBOOK_CLIENT_ID') }}"
                                                                placeholder="{{ __('Facebook Client Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Facebook Client Secret') }}</label>
                                                            <input type="text" name="facebook_client_secret"
                                                                class="form-control"
                                                                value="{{ env('FACEBOOK_CLIENT_SECRET') }}"
                                                                placeholder="{{ __('Facebook Client Secret') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Facebook Redirect Url') }}</label>
                                                            <input type="text" name="facebook_redirect"
                                                                class="form-control"
                                                                value="{{ env('FACEBOOK_REDIRECT') }}"
                                                                placeholder="{{ __('https://demo.test.com/callback/facebook') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Github Setting') }}</strong>
                                            <span>{{ __('How To Enable Login With Github') }}<a
                                                    href="{{ Storage::url('pdf/login with github.pdf') }}"
                                                    class="m-2"
                                                    target="_blank">{{ __('Document') }}</a></span>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio mt-2 float-right ">
                                                <input name="socialsetting[]"
                                                    class="form-check-input paymenttsetting form-check-input input-primary"
                                                    type="checkbox" value="github"
                                                    {{ $github_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'paypal')? 'checked': 'unchecked' }} --}}>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="github" class="desc {{ $github_class }} ">
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Github Client Id') }}</label>
                                                            <input type="text" name="github_client_id"
                                                                class="form-control"
                                                                value="{{ env('GITHUB_CLIENT_ID') }}"
                                                                placeholder="{{ __('Github Client Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Github Client Secret') }}</label>
                                                            <input type="text" name="github_client_secret"
                                                                class="form-control"
                                                                value="{{ env('GITHUB_CLIENT_SECRET') }}"
                                                                placeholder="{{ __('Github Client Secret') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Github Redirect Url') }}</label>
                                                            <input type="text" name="github_redirect"
                                                                class="form-control"
                                                                value="{{ env('GITHUB_REDIRECT') }}"
                                                                placeholder="{{ __('https://demo.test.com/callback/github') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Linkedin Setting') }}</strong>
                                            <span>{{ __('How To Enable Login With Linkedin') }}<a
                                                    href="{{ Storage::url('pdf/login with linkedin.pdf') }}"
                                                    class="m-2"
                                                    target="_blank">{{ __('Document') }}</a></span>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio  mt-2 float-right ">
                                                <input name="socialsetting[]"
                                                    class="form-check-input paymenttsetting form-check-input input-primary"
                                                    type="checkbox" value="linkedin"
                                                    {{ $linkdin_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'paypal')? 'checked': 'unchecked' }} --}}>

                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="linkedin" class="desc {{ $linkdin_class }} ">
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Linkedin Client Id') }}</label>
                                                            <input type="text" name="linkedin_client_id"
                                                                class="form-control"
                                                                value="{{ env('LINKEDIN_CLIENT_ID') }}"
                                                                placeholder="{{ __('Linkedin Client Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Linkedin Client Secret') }}</label>
                                                            <input type="text" name="linkedin_client_secret"
                                                                class="form-control"
                                                                value="{{ env('LINKEDIN_CLIENT_SECRET') }}"
                                                                placeholder="{{ __('Linkedin Client Secret') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Linkedin Redirect Url') }}</label>
                                                            <input type="text" name="linkedin_redirect"
                                                                class="form-control"
                                                                value="{{ env('LINKEDIN_REDIRECT') }}"
                                                                placeholder="{{ __('https://demo.test.com/callback/linkedin') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="useradd-6" class="">
                        <form id="setting-form" action="{{ route('settings/email-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __('Email Settings') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class=" row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail Mailer') }}</label>
                                                <input type="text" name="mail_mailer" class="form-control"
                                                    value="{{ Utility::getsettings('mail_mailer') }}"
                                                    placeholder="{{ __('Mail Mailer') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ __('Mail Host') }}</label>
                                                <input type="text" name="mail_host" class="form-control"
                                                    value="{{ Utility::getsettings('mail_host') }}"
                                                    placeholder="{{ __('Mail Host') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ __('Mail Port') }}</label>
                                                <input type="text" name="mail_port" class="form-control"
                                                    value="{{ Utility::getsettings('mail_port') }}"
                                                    placeholder="{{ __('Mail Port') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail Username') }}</label>
                                                <input type="email" name="mail_username" class="form-control"
                                                    value="{{ Utility::getsettings('mail_username') }}"
                                                    placeholder="{{ __('Mail Username') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail Password') }}</label>
                                                <input type="password" name="mail_password" class="form-control"
                                                    value="{{ Utility::getsettings('mail_password') }}"
                                                    placeholder="{{ __('Mail Password') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail Encryption') }}</label>
                                                <input type="text" name="mail_encryption" class="form-control"
                                                    value="{{ Utility::getsettings('mail_encryption') }}"
                                                    placeholder="{{ __('Mail Encryption') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail From Address') }}</label>
                                                <input type="text" name="mail_from_address" class="form-control"
                                                    value="{{ Utility::getsettings('mail_from_address') }}"
                                                    placeholder="{{ __('Mail From Address') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="form-label">{{ __('Mail From Name') }}</label>
                                                <input type="text" name="mail_from_name" class="form-control"
                                                    value="{{ Utility::getsettings('mail_from_name') }}"
                                                    placeholder="{{ __('Mail From Name') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a class="btn btn-info send_mail d-inline" href="javascript:void(0);"
                                            id="test-mail" data-action="{{ route('test.mail') }}">
                                            {{ __('Send Test Mail') }}</a>
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="useradd-7" class="">
                        <form id="setting-form" action="{{ route('settings/captcha-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header level"
                                    style="display: flex;justify-content: space-between;align-items: center;">
                                    <h5> {{ __('Capcha Settings') }}</h5>
                                    <div class="form-check form-switch custom-switch-v1">
                                        <label class="custom-switch float-right">
                                            <input name="captchasetting"
                                                class="form-check-input form-check-input input-primary " type="checkbox"
                                                value="1"
                                                {{ Utility::getsettings('captchasetting') ? 'checked' : 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body {{ Utility::getsettings('captchasetting') != 0 ? 'block' : 'd-none' }}"
                                    id="captcha_setting">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status_toggle">{{ __('Google Captcha') }}</label>
                                            <label class="form-switch   custom-switch-v1 col-3 mt-2"
                                                style="margin-bottom: 12px !important;">
                                                <input name="captcha" class="form-check-input input-primary m-auto"
                                                    type="radio" value="recaptcha" checked
                                                    {{ Utility::getsettings('captcha') == 'recaptcha' ? 'checked' : 'unchecked' }}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                            <label for="status_toggle">{{ __('hcaptcha setting') }}</label>
                                            <label class="form-switch   custom-switch-v1 col-3 mt-2"
                                                style="margin-bottom: 12px !important;">
                                                <input name="captcha" class="form-check-input input-primary m-auto"
                                                    type="radio" value="hcaptcha"
                                                    {{ Utility::getsettings('captcha') == 'hcaptcha' ? 'checked' : 'unchecked' }}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="recaptcha"
                                        class="desc {{ Utility::getsettings('captcha') != 'hcaptcha' ? 'block' : 'd-none' }}">
                                        <p class="text-muted"> {{ __('Recaptcha Setting') }}<a
                                                class="m-2" target="_blank"
                                                href="https://www.google.com/recaptcha/admin">{{ __('Document') }}</a>

                                        <div class=" row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Recaptcha Key') }}</label>
                                                    <input type="text" name="recaptcha_key" class="form-control"
                                                        value="{{ Utility::getsettings('recaptcha_key') }}"
                                                        placeholder="{{ __('Recaptcha Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Recaptcha Secret') }}</label>
                                                    <input type="text" name="recaptcha_secret" class="form-control"
                                                        value="{{ Utility::getsettings('recaptcha_secret') }}"
                                                        placeholder="{{ __('Recaptcha Secret') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="hcaptcha"
                                        class="desc {{ Utility::getsettings('captcha') == 'hcaptcha' ? 'block' : 'd-none' }}">
                                        <p class="text-muted"> {{ __('Hcaptcha Setting') }} <a
                                                class="m-2" target="_blank"
                                                href="https://docs.hcaptcha.com/switch">{{ __('Document') }}</a></p>
                                        <div class=" row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Hcaptcha Key') }}</label>
                                                    <input type="text" name="hcaptcha_key" class="form-control"
                                                        value="{{ Utility::getsettings('hcaptcha_key') }}"
                                                        placeholder="{{ __('Hcaptcha Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Hcaptcha Secret') }}</label>
                                                    <input type="text" name="hcaptcha_secret" class="form-control"
                                                        value="{{ Utility::getsettings('hcaptcha_secret') }}"
                                                        placeholder="{{ __('Hcaptcha Secret') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="useradd-8" class="">
                        <form id="setting-form" action="{{ route('settings/stripe-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __('Payment Settings') }}</h5>
                                </div>
                                @php
                                    // dd(env('RAZORPAYSETTING'));
                                    $paypal_class = 'd-none';
                                    $razor_pay_class = 'd-none';
                                    $stripe_class = 'd-none';
                                    $offline_class = 'd-none';
                                    
                                    if (\Auth::user()->type == 'Super Admin') {
                                        if (env('STRIPESETTING') == 'on') {
                                            $stripe_class = 'block';
                                        }
                                        if (env('RAZORPAYSETTING') == 'on') {
                                            $razor_pay_class = 'block';
                                        }
                                        if (env('PAYPALSETTING') == 'on') {
                                            $paypal_class = 'block';
                                        }
                                        if (env('OFFLINESETTING') == 'on') {
                                            $offline_class = 'block';
                                        }
                                    } else {
                                        if (env('STRIPESETTING') == 'on') {
                                            $stripe_class = 'block';
                                        }
                                        if (env('RAZORPAYSETTING') == 'on') {
                                            $razor_pay_class = 'block';
                                        }
                                        if (env('PAYPALSETTING') == 'on') {
                                            $paypal_class = 'block';
                                        }
                                    }
                                @endphp
                                <div class="card-body">

                                    <div class="form-group row align-items-center">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Stripe Payment') }}</strong>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio  float-right">
                                                <input name="paymentsetting[]"
                                                    class=" form-check-input form-check-input paymenttsetting"
                                                    type="checkbox" value="stripe"
                                                    {{ $stripe_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? env('PAYMENTSETTING'): env('PAYMENTSETTING') == 'stripe')? 'checked': 'unchecked' }} --}}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="stripe" class="desc  {{ $stripe_class }}">
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Stripe Key') }}</label>
                                                            <input type="text" name="stripe_key" class="form-control"
                                                                value="{{ env('STRIPE_KEY') }}"
                                                                placeholder="{{ __('Stripe key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Stripe Secret') }}</label>
                                                            <input type="text" name="stripe_secret" class="form-control"
                                                                value="{{ env('STRIPE_SECRET') }}"
                                                                placeholder="{{ __('Stripe Secret') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Razorpay Payment') }}</strong>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="custom-radio float-right">
                                                <input name="paymentsetting[]"
                                                    class="form-check-input form-check-input paymenttsetting"
                                                    type="checkbox" value="razorpay"
                                                    {{ $razor_pay_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? env('PAYMENTSETTING'): env('PAYMENTSETTING') == 'razorpay')? 'checked': 'unchecked' }} --}}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="razorpay" class="desc {{ $razor_pay_class }} ">
                                        {{-- <p class="text-muted"> {{ __('Razorpay Setting') }}</p> --}}
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Razorpay Key') }}</label>
                                                            <input type="text" name="razorpay_key" class="form-control"
                                                                value="{{ env('RAZORPAY_KEY') }}"
                                                                placeholder="{{ __('Razorpay Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Razorpay Secret') }}</label>
                                                            <input type="text" name="razorpay_secret"
                                                                class="form-control"
                                                                value="{{ env('RAZORPAY_SECRET') }}"
                                                                placeholder="{{ __('Razorpay Secret') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @if (\Auth::user()->type == 'Super Admin') --}}

                                    <div class="form-group row align-items-center">
                                        <div class="col-md-8">
                                            <strong class="d-block">{{ __('Paypal Payment') }}</strong>
                                        </div>
                                        <div class="col-md-4 form-check form-switch custom-switch-v1">
                                            <label class="  float-right ">
                                                <input name="paymentsetting[]"
                                                    class="form-check-input form-check-input paymenttsetting"
                                                    type="checkbox" value="paypal"
                                                    {{ $paypal_class == 'block' ? 'checked' : 'unchecked' }}
                                                    {{-- {{ (Auth::user()->type == 'Admin'? env('PAYMENTSETTING'): env('PAYMENTSETTING') == 'paypal')? 'checked': 'unchecked' }} --}}>

                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="paypal" class="desc {{ $paypal_class }} ">
                                        <div class="card-body">
                                            <div class="">
                                                <div class=" row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Paypal Key') }}</label>
                                                            <input type="text" name="client_id" class="form-control"
                                                                value="{{ env('PAYPAL_SANDBOX_CLIENT_ID') }}"
                                                                placeholder="{{ __('Paypal Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="form-label">{{ __('Paypal Secret') }}</label>
                                                            <input type="text" name="client_secret" class="form-control"
                                                                value="{{ env('PAYPAL_SANDBOX_CLIENT_SECRET') }}"
                                                                placeholder="{{ __('Paypal Secret') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (\Auth::user()->type == 'Super Admin')
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-8">
                                                <strong class="d-block">{{ __('Offline Payment') }}</strong>
                                            </div>
                                            <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                <label class="float-right ">
                                                    <input name="paymentsetting[]"
                                                        class="form-check-input form-check-input paymenttsetting"
                                                        type="checkbox" value="offline"
                                                        {{ $offline_class == 'block' ? 'checked' : 'unchecked' }}
                                                        {{-- {{ (Auth::user()->type == 'Admin'? env('PAYMENTSETTING'): env('PAYMENTSETTING') == 'paypal')? 'checked': 'unchecked' }} --}}>

                                                </label>
                                            </div>
                                        </div>
                                        <div id="offline" class="desc {{ $offline_class }} ">
                                            <div class="card-body">
                                                <div class="">
                                                    <div class=" row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name"
                                                                    class="form-label">{{ __('Offline Mode Name') }}</label>
                                                                <input type="text" name="payment_mode"
                                                                    class="form-control"
                                                                    value="{{ env('PAYMENT_MODE') }}"
                                                                    placeholder="{{ __('Payment Mode') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="name"
                                                                    class="form-label">{{ __('Payment Details') }}</label>
                                                                <textarea name="payment_details" class="form-control"> {{ env('PAYMENT_DETAILS') }}</textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-primary" type="submit"
                                            id="save-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
@push('script')
    <script>
        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        $('body').on('click', '.send_mail', function() {
            var action = $(this).data('action');
            var modal = $('#common_modal');
            console.log(modal);
            $.get(action, function(response) {
                modal.find('.modal-title').html('{{ __('Test Mail') }}');
                modal.find('.modal-body').html(response);
                modal.modal('show');
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".paymenttsetting").trigger("select");
            // paymenttsetting4();
        });

        // function paymenttsetting4(params) {
        //     $(".paymenttsetting").each(function() {
        //         if ($(this).is(':checked')) {
        //             if (test == 'razorpay') {
        //                 $("#razorpay").fadeIn(500);
        //                 $("#razorpay").removeClass('d-none');
        //             } else if (test == 'stripe') {
        //                 $("#stripe").fadeIn(500);
        //                 $("#stripe").removeClass('d-none');
        //             } else if (test == 'paypal') {
        //                 $("#paypal").fadeIn(500);
        //                 $("#paypal").removeClass('d-none');
        //             }
        //         } else {
        //             if (test == 'razorpay') {
        //                 $("#razorpay").fadeOut(500);
        //                 $("#razorpay").addClass('d-none');
        //             } else if (test == 'stripe') {
        //                 $("#stripe").fadeOut(500);
        //                 $("#stripe").addClass('d-none');
        //             } else if (test == 'paypal') {
        //                 $("#paypal").fadeOut(500);
        //                 $("#paypal").addClass('d-none');
        //             }
        //         }
        //     });
        // }


        // $(document).on('change', "input[name$='paymentsetting'], .paymenttsetting", function() {
        $(document).on('change', ".paymenttsetting", function() {

            var test = $(this).val();


            if ($(this).is(':checked')) {

                if (test == 'google') {
                    $("#google").fadeIn(500);
                    $("#google").removeClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeIn(500);
                    $("#facebook").removeClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeIn(500);
                    $("#github").removeClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeIn(500);
                    $("#linkedin").removeClass('d-none');
                }

            } else {

                if (test == 'google') {
                    $("#google").fadeOut(500);
                    $("#google").addClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeOut(500);
                    $("#facebook").addClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeOut(500);
                    $("#github").addClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeOut(500);
                    $("#linkedin").addClass('d-none');
                }
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $(".paymenttsetting").trigger("select");
            // paymenttsetting4();
        });

        // function paymenttsetting4(params) {
        //     $(".paymenttsetting").each(function() {
        //         if ($(this).is(':checked')) {
        //             if (test == 'razorpay') {
        //                 $("#razorpay").fadeIn(500);
        //                 $("#razorpay").removeClass('d-none');
        //             } else if (test == 'stripe') {
        //                 $("#stripe").fadeIn(500);
        //                 $("#stripe").removeClass('d-none');
        //             } else if (test == 'paypal') {
        //                 $("#paypal").fadeIn(500);
        //                 $("#paypal").removeClass('d-none');
        //             }
        //         } else {
        //             if (test == 'razorpay') {
        //                 $("#razorpay").fadeOut(500);
        //                 $("#razorpay").addClass('d-none');
        //             } else if (test == 'stripe') {
        //                 $("#stripe").fadeOut(500);
        //                 $("#stripe").addClass('d-none');
        //             } else if (test == 'paypal') {
        //                 $("#paypal").fadeOut(500);
        //                 $("#paypal").addClass('d-none');
        //             }
        //         }
        //     });
        // }


        // $(document).on('change', "input[name$='paymentsetting'], .paymenttsetting", function() {
        $(document).on('change', ".paymenttsetting", function() {

            var test = $(this).val();


            if ($(this).is(':checked')) {

                if (test == 'razorpay') {
                    $("#razorpay").fadeIn(500);
                    $("#razorpay").removeClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeIn(500);
                    $("#stripe").removeClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeIn(500);
                    $("#paypal").removeClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeIn(500);
                    $("#offline").removeClass('d-none');
                }

            } else {

                if (test == 'razorpay') {
                    $("#razorpay").fadeOut(500);
                    $("#razorpay").addClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeOut(500);
                    $("#stripe").addClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeOut(500);
                    $("#paypal").addClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeOut(500);
                    $("#offline").addClass('d-none');
                }
            }

        });
    </script>
    <script>
        $(document).on('click', "input[name$='captchasetting']", function() {
            if (this.checked) {
                $('#captcha_setting').fadeIn(500);

                $("#captcha_setting").removeClass('d-none');
                $("#captcha_setting").addClass('d-block');
            } else {
                $('#captcha_setting').fadeOut(500);

                $("#captcha_setting").removeClass('d-block');
                $("#captcha_setting").addClass('d-none');

            }


        })
        $(document).on('click', "input[name$='captcha']", function() {
            var test = $(this).val();

            if (test == 'hcaptcha') {
                $("#hcaptcha").fadeIn(500);

                $("#hcaptcha").removeClass('d-none');
                $("#recaptcha").addClass('d-none');

            } else {
                $("#recaptcha").fadeIn(500);

                $("#recaptcha").removeClass('d-none');
                $("#hcaptcha").addClass('d-none');

            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='settingtype']", function() {
            var test = $(this).val();

            if (test == 's3') {
                $("#s3").fadeIn(500);
                $("#s3").removeClass('d-none');
            } else {
                $("#s3").fadeOut(500);
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }

            var textRemove = new Choices(
                document.getElementById('choices-text-remove-button'), {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: 5,
                    removeItemButton: true,
                }
            );

            var textUniqueVals = new Choices('#choices-text-unique-values', {
                paste: false,
                duplicateItemsAllowed: false,
                editItems: true,
            });

            var texti18n = new Choices('#choices-text-i18n', {
                paste: false,
                duplicateItemsAllowed: false,
                editItems: true,
                maxItemCount: 5,
                addItemText: function(value) {
                    return (
                        'Appuyez sur Entrée pour ajouter <b>"' + String(value) + '"</b>'
                    );
                },
                maxItemText: function(maxItemCount) {
                    return String(maxItemCount) + 'valeurs peuvent être ajoutées';
                },
                uniqueItemText: 'Cette valeur est déjà présente',
            });

            var textEmailFilter = new Choices('#choices-text-email-filter', {
                editItems: true,
                addItemFilter: function(value) {
                    if (!value) {
                        return false;
                    }

                    const regex =
                        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    const expression = new RegExp(regex.source, 'i');
                    return expression.test(value);
                },
            }).setValue(['joe@bloggs.com']);

            var textDisabled = new Choices('#choices-text-disabled', {
                addItems: false,
                removeItems: false,
            }).disable();

            var textPrependAppendVal = new Choices(
                '#choices-text-prepend-append-value', {
                    prependValue: 'item-',
                    appendValue: '-' + Date.now(),
                }
            ).removeActiveItems();

            var textPresetVal = new Choices('#choices-text-preset-values', {
                items: [
                    'Josh Johnson',
                    {
                        value: 'joe@bloggs.co.uk',
                        label: 'Joe Bloggs',
                        customProperties: {
                            description: 'Joe Blogg is such a generic name',
                        },
                    },
                ],
            });

            var multipleDefault = new Choices(
                document.getElementById('choices-multiple-groups')
            );

            var multipleFetch = new Choices('#choices-multiple-remote-fetch', {
                placeholder: true,
                placeholderValue: 'Pick an Strokes record',
                maxItemCount: 5,
            }).setChoices(function() {
                return fetch(
                        'https://api.discogs.com/artists/55980/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW'
                    )
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        return data.releases.map(function(release) {
                            return {
                                value: release.title,
                                label: release.title
                            };
                        });
                    });
            });

            var multipleCancelButton = new Choices(
                '#choices-multiple-remove-button', {
                    removeItemButton: true,
                }
            );

            /* Use label on event */
            var choicesSelect = new Choices('#choices-multiple-labels', {
                removeItemButton: true,
                choices: [{
                        value: 'One',
                        label: 'Label One'
                    },
                    {
                        value: 'Two',
                        label: 'Label Two',
                        disabled: true
                    },
                    {
                        value: 'Three',
                        label: 'Label Three'
                    },
                ],
            }).setChoices(
                [{
                        value: 'Four',
                        label: 'Label Four',
                        disabled: true
                    },
                    {
                        value: 'Five',
                        label: 'Label Five'
                    },
                    {
                        value: 'Six',
                        label: 'Label Six',
                        selected: true
                    },
                ],
                'value',
                'label',
                false
            );


            choicesSelect.passedElement.element.addEventListener(
                'addItem',
                function(event) {
                    document.getElementById('message').innerHTML =
                        '<span class="badge bg-light-primary"> You just added "' + event.detail.label +
                        '"</span>';
                }
            );
            choicesSelect.passedElement.element.addEventListener(
                'removeItem',
                function(event) {
                    document.getElementById('message').innerHTML =
                        '<span class="badge bg-light-danger"> You just removed "' + event.detail.label +
                        '"</span>';
                }
            );

            var singleFetch = new Choices('#choices-single-remote-fetch', {
                    searchPlaceholderValue: 'Search for an Arctic Monkeys record',
                })
                .setChoices(function() {
                    return fetch(
                            'https://api.discogs.com/artists/391170/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW'
                        )
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(data) {
                            return data.releases.map(function(release) {
                                return {
                                    label: release.title,
                                    value: release.title
                                };
                            });
                        });
                })
                .then(function(instance) {
                    instance.setChoiceByValue('Fake Tales Of San Francisco');
                });

            var singleXhrRemove = new Choices('#choices-single-remove-xhr', {
                removeItemButton: true,
                searchPlaceholderValue: "Search for a Smiths' record",
            }).setChoices(function(callback) {
                return fetch(
                        'https://api.discogs.com/artists/83080/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW'
                    )
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(data) {
                        return data.releases.map(function(release) {
                            return {
                                label: release.title,
                                value: release.title
                            };
                        });
                    });
            });

            var singleNoSearch = new Choices('#choices-single-no-search', {
                searchEnabled: false,
                removeItemButton: true,
                choices: [{
                        value: 'One',
                        label: 'Label One'
                    },
                    {
                        value: 'Two',
                        label: 'Label Two',
                        disabled: true
                    },
                    {
                        value: 'Three',
                        label: 'Label Three'
                    },
                ],
            }).setChoices(
                [{
                        value: 'Four',
                        label: 'Label Four',
                        disabled: true
                    },
                    {
                        value: 'Five',
                        label: 'Label Five'
                    },
                    {
                        value: 'Six',
                        label: 'Label Six',
                        selected: true
                    },
                ],
                'value',
                'label',
                false
            );

            var singlePresetOpts = new Choices('#choices-single-preset-options', {
                placeholder: true,
            }).setChoices(
                [{
                        label: 'Group one',
                        id: 1,
                        disabled: false,
                        choices: [{
                                value: 'Child One',
                                label: 'Child One',
                                selected: true
                            },
                            {
                                value: 'Child Two',
                                label: 'Child Two',
                                disabled: true
                            },
                            {
                                value: 'Child Three',
                                label: 'Child Three'
                            },
                        ],
                    },
                    {
                        label: 'Group two',
                        id: 2,
                        disabled: false,
                        choices: [{
                                value: 'Child Four',
                                label: 'Child Four',
                                disabled: true
                            },
                            {
                                value: 'Child Five',
                                label: 'Child Five'
                            },
                            {
                                value: 'Child Six',
                                label: 'Child Six'
                            },
                        ],
                    },
                ],
                'value',
                'label'
            );

            var singleSelectedOpt = new Choices('#choices-single-selected-option', {
                searchFields: ['label', 'value', 'customProperties.description'],
                choices: [{
                        value: 'One',
                        label: 'Label One',
                        selected: true
                    },
                    {
                        value: 'Two',
                        label: 'Label Two',
                        disabled: true
                    },
                    {
                        value: 'Three',
                        label: 'Label Three',
                        customProperties: {
                            description: 'This option is fantastic',
                        },
                    },
                ],
            }).setChoiceByValue('Two');

            var customChoicesPropertiesViaDataAttributes = new Choices(
                '#choices-with-custom-props-via-html', {
                    searchFields: ['label', 'value', 'customProperties'],
                }
            );

            var singleNoSorting = new Choices('#choices-single-no-sorting', {
                shouldSort: false,
            });

            var cities = new Choices(document.getElementById('cities'));
            var tubeStations = new Choices(
                document.getElementById('tube-stations')
            ).disable();

            cities.passedElement.element.addEventListener('change', function(e) {
                if (e.detail.value === 'London') {
                    tubeStations.enable();
                } else {
                    tubeStations.disable();
                }
            });

            var customTemplates = new Choices(
                document.getElementById('choices-single-custom-templates'), {
                    callbackOnCreateTemplates: function(strToEl) {
                        var classNames = this.config.classNames;
                        var itemSelectText = this.config.itemSelectText;
                        return {
                            item: function(classNames, data) {
                                return strToEl(
                                    '\
                                                                                                                                                    <div\
                                                                                                                                                    class="' +
                                    String(classNames.item) +
                                    ' ' +
                                    String(
                                        data.highlighted ?
                                        classNames.highlightedState :
                                        classNames.itemSelectable
                                    ) +
                                    '"\
                                                                                                                                                    data-item\
                                                                                                                                                    data-id="' +
                                    String(data.id) +
                                    '"\
                                                                                                                                                    data-value="' +
                                    String(data.value) +
                                    '"\
                                                                                                                                                    ' +
                                    String(data.active ? 'aria-selected="true"' : '') +
                                    '\
                                                                                                                                                    ' +
                                    String(data.disabled ? 'aria-disabled="true"' : '') +
                                    '\
                                                                                                                                                    >\
                                                                                                                                                    <span style="margin-right:10px;">🎉</span> ' +
                                    String(data.label) +
                                    '\
                                                                                                                                                    </div>\
                                                                                                                                                    '
                                );
                            },
                            choice: function(classNames, data) {
                                return strToEl(
                                    '\
                                                                                                                                                    <div\
                                                                                                                                                    class="' +
                                    String(classNames.item) +
                                    ' ' +
                                    String(classNames.itemChoice) +
                                    ' ' +
                                    String(
                                        data.disabled ?
                                        classNames.itemDisabled :
                                        classNames.itemSelectable
                                    ) +
                                    '"\
                                                                                                                                                    data-select-text="' +
                                    String(itemSelectText) +
                                    '"\
                                                                                                                                                    data-choice \
                                                                                                                                                    ' +
                                    String(
                                        data.disabled ?
                                        'data-choice-disabled aria-disabled="true"' :
                                        'data-choice-selectable'
                                    ) +
                                    '\
                                                                                                                                                    data-id="' +
                                    String(data.id) +
                                    '"\
                                                                                                                                                    data-value="' +
                                    String(data.value) +
                                    '"\
                                                                                                                                                    ' +
                                    String(
                                        data.groupId > 0 ? 'role="treeitem"' : 'role="option"'
                                    ) +
                                    '\
                                                                                                                                                    >\
                                                                                                                                                    <span style="margin-right:10px;">👉🏽</span> ' +
                                    String(data.label) +
                                    '\
                                                                                                                                                    </div>\
                                                                                                                                                    '
                                );
                            },
                        };
                    },
                }
            );

            var resetSimple = new Choices(document.getElementById('reset-simple'));

            var resetMultiple = new Choices('#reset-multiple', {
                removeItemButton: true,
            });
        });
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }


        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
@endpush
