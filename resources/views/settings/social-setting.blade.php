@extends('layouts.main')
@section('title', $t)
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
                                <a href="{{ route('setting', 'social-setting') }}" class="list-group-item list-group-item-action active">{{ __('Social') }}</a>
                                <a href="{{ route('setting', 'chat-setting') }}" class="list-group-item list-group-item-action">{{ __('Chat') }}</a>
                                <a href="{{ route('setting', 'general-setting') }}" class="list-group-item list-group-item-action">{{ __('General') }}</a>
                                <a href="{{ route('setting', 'captcha-setting') }}" class="list-group-item list-group-item-action ">{{ __('Captcha') }}</a>
                                <a href="{{ route('setting', 'payment-setting') }}" class="list-group-item list-group-item-action">{{ __('Payment') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form id="setting-form" action="{{ route('settings/social-setting/update') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h5> {{ $t }}</h5>
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
                                            href="{{ Storage::url('pdf/login with google.pdf') }}" class="m-2"
                                            target="_blank">{{ __('Document') }}</a></span>
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <label class="custom-radio  mt-2 float-right">
                                            <input name="socialsetting[]" class="form-check-input paymenttsetting form-check-input input-primary"
                                                type="checkbox" value="google"
                                                {{ $google_class == 'block' ? 'checked' : 'unchecked' }}
                                                {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'stripe')? 'checked': 'unchecked' }} --}}>
                                            {{--  <span class="custom-switch-indicator"></span>  --}}
                                        </label>
                                    </div>

                                </div>
                                <div id="google" class="desc  {{ $google_class }}">
                                    <div class="card-body">
                                        <div class="">
                                            <div class=" row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Google Client Id') }}</label>
                                                        <input type="text" name="google_client_id" class="form-control"
                                                            value="{{ env('GOOGLE_CLIENT_ID') }}"
                                                            placeholder="{{ __('Google Client Id') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Google Client Secret') }}</label>
                                                        <input type="text" name="google_client_secret"
                                                            class="form-control"
                                                            value="{{ env('GOOGLE_CLIENT_SECRET') }}"
                                                            placeholder="{{ __('Google Client Secret') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Google Redirect Url') }}</label>
                                                        <input type="text" name="google_redirect" class="form-control"
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
                                            href="{{ Storage::url('pdf/login with facebook.pdf') }}" class="m-2"
                                            target="_blank">{{ __('Document') }}</a></span>
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <label class="custom-radio  mt-2 float-right">
                                            <input name="socialsetting[]"  class="form-check-input paymenttsetting form-check-input input-primary"
                                                type="checkbox" value="facebook"
                                                {{ $facebook_class == 'block' ? 'checked' : 'unchecked' }}
                                                {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'razorpay')? 'checked': 'unchecked' }} --}}>
                                            <span class="custom-switch-indicator"></span>
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
                                                        <label for="name" class="form-label">{{ __('Facebook Client Id') }}</label>
                                                        <input type="text" name="facebook_client_id" class="form-control"
                                                            value="{{ env('FACEBOOK_CLIENT_ID') }}"
                                                            placeholder="{{ __('Facebook Client Id') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Facebook Client Secret') }}</label>
                                                        <input type="text" name="facebook_client_secret"
                                                            class="form-control"
                                                            value="{{ env('FACEBOOK_CLIENT_SECRET') }}"
                                                            placeholder="{{ __('Facebook Client Secret') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Facebook Redirect Url') }}</label>
                                                        <input type="text" name="facebook_redirect" class="form-control"
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
                                            href="{{ Storage::url('pdf/login with github.pdf') }}" class="m-2"
                                            target="_blank">{{ __('Document') }}</a></span>
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <label class="custom-radio mt-2 float-right ">
                                            <input name="socialsetting[]" class="form-check-input paymenttsetting form-check-input input-primary"
                                                type="checkbox" value="github"
                                                {{ $github_class == 'block' ? 'checked' : 'unchecked' }}
                                                {{-- {{ (Auth::user()->type == 'Admin'? Utility::getsettings('PAYMENTSETTING'): env('PAYMENTSETTING') == 'paypal')? 'checked': 'unchecked' }} --}}>

                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div id="github" class="desc {{ $github_class }} ">
                                    <div class="card-body">
                                        <div class="">
                                            <div class=" row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Github Client Id') }}</label>
                                                        <input type="text" name="github_client_id" class="form-control"
                                                            value="{{ env('GITHUB_CLIENT_ID') }}"
                                                            placeholder="{{ __('Github Client Id') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Github Client Secret') }}</label>
                                                        <input type="text" name="github_client_secret"
                                                            class="form-control"
                                                            value="{{ env('GITHUB_CLIENT_SECRET') }}"
                                                            placeholder="{{ __('Github Client Secret') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Github Redirect Url') }}</label>
                                                        <input type="text" name="github_redirect" class="form-control"
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
                                            href="{{ Storage::url('pdf/login with linkedin.pdf') }}" class="m-2"
                                            target="_blank">{{ __('Document') }}</a></span>
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <label class="custom-radio  mt-2 float-right ">
                                            <input name="socialsetting[]" class="form-check-input paymenttsetting form-check-input input-primary"
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
                                                        <label for="name" class="form-label">{{ __('Linkedin Client Id') }}</label>
                                                        <input type="text" name="linkedin_client_id" class="form-control"
                                                            value="{{ env('LINKEDIN_CLIENT_ID') }}"
                                                            placeholder="{{ __('Linkedin Client Id') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Linkedin Client Secret') }}</label>
                                                        <input type="text" name="linkedin_client_secret"
                                                            class="form-control"
                                                            value="{{ env('LINKEDIN_CLIENT_SECRET') }}"
                                                            placeholder="{{ __('Linkedin Client Secret') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ __('Linkedin Redirect Url') }}</label>
                                                        <input type="text" name="linkedin_redirect" class="form-control"
                                                            value="{{ env('LINKEDIN_REDIRECT') }}"
                                                            placeholder="{{ __('https://demo.test.com/callback/linkedin') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>
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
@endpush
