@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="main-content">
            <section class="section">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h4 class="m-b-10">{{ __('Settings') }}</h4>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-palette"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('App Setting') }}</h4>
                                    <p>{{ __('Logo & App Name Setting') }}</p>
                                    <a href="#useradd-1" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-file-analytics"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('Storage Setting') }}</h4>
                                    <p>{{ __('AWS , S3 Storage Configuration') }}</p>
                                    <a href="#useradd-2" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-brand-hipchat"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('Chat Setting') }}</h4>
                                    <p>{{ __('Pusher Setting') }}</p>
                                    <a href="#useradd-3" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-arrow-bar-to-right"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('Social Setting') }}</h4>
                                    <p>{{ __('Social Login Setting') }}</p>
                                    <a href="#useradd-4" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-mail-opened"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('Email') }}</h4>
                                    <p>{{ __('Email SMTP settings, notifications and others related to email.') }}</p>
                                    <a href="#useradd-5" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-settings"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('General') }}</h4>
                                    <p>{{ __('General Setting') }}</p>
                                    <a href="#useradd-6" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @if (\Auth::user()->type == 'Admin')
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="ti ti-brand-google"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ __('Captcha') }}</h4>
                                        <p>{{ __('Captcha Setting') }}</p>
                                        <a href="#useradd-7" class="card-cta">{{ __('Change Setting') }} <i
                                                class="ti ti-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="ti ti-businessplan"></i>
                                </div>
                                <div class="card-body">
                                    <h4>{{ __('Payment') }}</h4>
                                    <p>{{ __('Payment Setting') }}</p>
                                    <a href="#useradd-8" class="card-cta">{{ __('Change Setting') }} <i
                                            class="ti ti-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
