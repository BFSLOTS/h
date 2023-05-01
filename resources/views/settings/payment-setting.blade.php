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
                                        class="list-group-item list-group-item-action ">{{ __('Captcha') }}</a>
                                    <a href="{{ route('setting', 'payment-setting') }}"
                                        class="list-group-item list-group-item-action active">{{ __('Payment') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <form id="setting-form" action="{{ route('settings/stripe-setting/update') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                        <h5> {{ $t }}</h5>
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
                                                <label class="custom-radio col-4 mt-2 float-right">
                                                    <input name="paymentsetting[]"  class=" form-check-input form-check-input paymenttsetting"
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
                                                                <input type="text" name="stripe_secret"
                                                                    class="form-control"
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
                                                <label class="custom-radio col-4 mt-2 float-right">
                                                    <input name="paymentsetting[]" class="form-check-input form-check-input paymenttsetting"
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
                                                                <input type="text" name="razorpay_key"
                                                                    class="form-control"
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
                                                <label class=" col-4 mt-2 float-right ">
                                                    <input name="paymentsetting[]" class="form-check-input form-check-input paymenttsetting"
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
                                                                <input type="text" name="client_secret"
                                                                    class="form-control"
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
                                                    <label class="col-2 mt-2 float-right ">
                                                        <input name="paymentsetting[]"
                                                            class="form-check-input form-check-input paymenttsetting" type="checkbox"
                                                            value="offline"
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
@endpush
