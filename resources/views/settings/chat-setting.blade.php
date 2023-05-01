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
                                <a href="{{ route('setting', 'chat-setting') }}" class="list-group-item list-group-item-action active">{{ __('Chat') }}</a>
                                <a href="{{ route('setting', 'general-setting') }}" class="list-group-item list-group-item-action">{{ __('General') }}</a>
                                <a href="{{ route('setting', 'captcha-setting') }}" class="list-group-item list-group-item-action ">{{ __('Captcha') }}</a>
                                <a href="{{ route('setting', 'payment-setting') }}" class="list-group-item list-group-item-action">{{ __('Payment') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form id="setting-form" action="{{ route('settings/pusher-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ __($t) }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted"> {{ __('Pusher Setting') }} <a target="_blank"
                                            href="https://pusher.com/" class="m-2">{{ __('Document') }}</a>
                                    </p>
                                    <div class="">
                                        <div class=" row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ __('Pusher App ID') }}</label>
                                                    <input type="text" name="pusher_id" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_id') }}"
                                                        placeholder="{{ __('Pusher App ID') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ __('Pusher Key') }}</label>
                                                    <input type="text" name="pusher_key" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_key') }}"
                                                        placeholder="{{ __('Pusher Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ __('Pusher Secret') }}</label>
                                                    <input type="text" name="pusher_secret" class="form-control"
                                                        value="{{ Utility::getsettings('pusher_secret') }}"
                                                        placeholder="{{ __('Pusher Secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ __('Pusher Cluster') }}</label>
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
                                                            <input name="pusher_status"  class="form-check-input form-check-input input-primary"
                                                                type="checkbox"
                                                                {{ Utility::getsettings('pusher_status') ? 'checked' : 'unchecked' }}>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><hr>
                                <div class="float-right">
                                    <button class="btn btn-primary" type="submit"
                                        id="save-btn">{{ __('Save Changes') }}</button>
                                    <a href="{{ route('settings') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
