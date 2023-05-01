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
                                        class="list-group-item list-group-item-action ">{{ __('App Setting') }}</a>
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
                                        class="list-group-item list-group-item-action active">{{ __('Captcha') }}</a>
                                    <a href="{{ route('setting', 'payment-setting') }}"
                                        class="list-group-item list-group-item-action">{{ __('Payment') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <form id="setting-form" action="{{ route('settings/captcha-setting/update') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="card" id="settings-card">
                                    <div class="card-header level">
                                        <h5> {{ __($t) }}</h5>
                                        <div class="form-check form-switch custom-switch-v1">
                                            <label class="custom-switch mt-2 float-right">
                                                <input name="captchasetting"
                                                    class="form-check-input form-check-input input-primary"
                                                    type="checkbox" value="1"
                                                    {{ Utility::getsettings('captchasetting') ? 'checked' : 'unchecked' }}>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body {{ Utility::getsettings('captchasetting') != 0 ? 'block' : 'd-none' }}"
                                        id="captcha_setting">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="status_toggle">{{ __('Google Captcha') }}</label>
                                                <label class="custom-radio col-3 mt-2 ">
                                                    <input name="captcha" class="form-check-input input-light-primary pl-2"
                                                        type="radio" value="recaptcha" checked
                                                        {{ Utility::getsettings('captcha') == 'recaptcha' ? 'checked' : 'unchecked' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                                <label for="status_toggle">{{ __('hcaptcha setting') }}</label>
                                                <label class="custom-radio col-3 mt-2 ">
                                                    <input name="captcha" class="form-check-input input-light-primary pl-2"
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
                                        <hr>
                                        <div class="float-right">
                                            <button class="btn btn-primary" type="submit"
                                                id="save-btn">{{ __('Save Changes') }}</button>
                                            <a href="{{ route('settings') }}"
                                                class="btn btn-secondary">{{ __('Cancel') }}</a>
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
@push('script')
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
@endpush
