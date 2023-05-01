@php
$lang = \App\Facades\UtilityFacades::getValByName('default_language');
@endphp
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
                                <a href="{{ route('setting', 'app-setting') }}" class="list-group-item list-group-item-action ">{{ __('App Setting') }}</a>
                                <a href="{{ route('setting', 'storage-setting') }}" class="list-group-item list-group-item-action">{{ __('Storage') }}</a>
                                <a href="{{ route('setting', 'mail-setting') }}" class="list-group-item list-group-item-action">{{ __('Email') }}</a>
                                <a href="{{ route('setting', 'social-setting') }}" class="list-group-item list-group-item-action">{{ __('Social') }}</a>
                                <a href="{{ route('setting', 'chat-setting') }}" class="list-group-item list-group-item-action">{{ __('Chat') }}</a>
                                <a href="{{ route('setting', 'general-setting') }}" class="list-group-item list-group-item-action active">{{ __('General') }}</a>
                                <a href="{{ route('setting', 'captcha-setting') }}" class="list-group-item list-group-item-action ">{{ __('Captcha') }}</a>
                                <a href="{{ route('setting', 'payment-setting') }}" class="list-group-item list-group-item-action">{{ __('Payment') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form id="setting-form" action="{{ route('settings/auth-settings/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __($t) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="">
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
                                                            {{--  <input name="two_factor_auth" class="form-check-input"
                                                                type="checkbox"
                                                                {{ Utility::getsettings('2fa') ? 'checked' : 'unchecked' }}>  --}}
                                                                <input name="two_factor_auth" class="form-check-input input-primary"
                                                                type="checkbox"
                                                                {{ Utility::getsettings('2fa') ? 'checked' : 'unchecked' }}>
                                                            {{--  <span class="custom-switch-indicator"></span>  --}}
                                                        </label>
                                                    </div>
                                                    @if (!extension_loaded('imagick'))
                                                        <small>
                                                            {{ __('Note: for 2FA your server must have Imagick.') }} <a
                                                                href="https://www.php.net/manual/en/book.imagick.php"
                                                                target="_new">{{ __('Imagick Document') }}</a>
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-8">
                                                        <strong class="d-block">{{ __('RTL Setting') }}</strong>
                                                        {{ Utility::getsettings('rtl') == '0' ? __('Activate') : __('Deactivate') }}
                                                        {{ __('RTL setting for application.') }}
                                                    </div>
                                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                        <label class="custom-switch mt-2 float-right">
                                                            <input name="rtl_setting"  class="form-check-input input-primary form-check-input"
                                                                type="checkbox"
                                                                {{ Utility::getsettings('rtl') == '1' ? 'checked' : 'unchecked' }}>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                    <div class="form-group ">
                                                        <label for="name" class="form-label">{{ __('Default Language') }}</label>
                                                        <select name="default_language" id="default_language"
                                                            class="form-control select2 " tabindex="-1" aria-hidden="true">
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
                                                            <label for="name" class="form-label">{{ __('Gtag Tracking ID') }} <a
                                                                    href="https://support.google.com/analytics/answer/1008080?hl=en#zippy=%2Cin-this-article"
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
                                                        <label for="name" class="form-label">{{ __('Approved Domain Request') }}</label>
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
                                                        <label for="name" class="form-label">{{ __('Currency Name') }}</label>
                                                        <input type="text" name="currency" class="form-control"
                                                            value="{{ env('CURRENCY') }}" required
                                                            placeholder="{{ __('Currency name') }}">
                                                        <p>{{ __('The name of currency is to be taken frome this document.') }}
                                                            <a href="https://stripe.com/docs/currencies"
                                                                class="m-2"
                                                                target="_blank">{{ __('Document') }}</a>
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Currency Symbol') }}</label>
                                                        <input type="text" name="currency_symbol" class="form-control"
                                                            value="{{ env('CURRENCY_SYMBOL') }}" required
                                                            placeholder="{{ __('Currency Symbol') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div><hr>
                                <div class="float-right">
                                    <button class="btn btn-primary" type="submit"
                                        id="save-btn">{{ __('Save Changes') }}</button>
                                    <a href="{{ route('settings') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </section>
    </div>
</div>
@endsection
