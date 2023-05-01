<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' ? 'rtl' : '' }}">

<head>
    @php
        $primary_color = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primary_color)) {
            $color = $primary_color;
        } else {
            $color = 'theme-4';
        }
    @endphp
      <title>@yield('title') | {{ Utility::getsettings('app_name') }}</title>

    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn not work if you view the page via file:// -->
    <!--[if lt IE 11]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('vendor/img/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/jquery-confirm.min.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('vendor/js/plugins/croppie/css/croppie.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}">


    @if (Utility::getsettings('rtl') == '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
        @if (Utility::getsettings('dark_mode') == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        @endif
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">
    @stack('style')

</head>

<body class="{{ $color }}">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Mobile header ] start -->
    <div class="dash-mob-header dash-header">
        <div class="pcm-logo">
            @if (setting('app_logo'))
                <img src="{{ asset('vendor/img/prime-white.png') }}"
                    alt="" class="logo logo-lg" />
            @else
                <a href="{{ route('home') }}">{{ config('app.name') }}</a>
            @endif
        </div>
        <div class="pcm-toolbar">
            <a href="#!" class="dash-head-link" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
                <!-- <i data-feather="menu"></i> -->
            </a>
            {{--  <a href="#!" class="dash-head-link" id="headerdrp-collapse">
                <i data-feather="align-right"></i>
            </a>  --}}
            <a href="#!" class="dash-head-link" id="header-collapse">
                <i data-feather="more-vertical"></i>
            </a>
        </div>
    </div>
    <!-- [ Mobile header ] End -->

    <!-- [ navigation menu ] start -->

    @include('layouts.sidebar')


    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    @include('include.header')

    <!-- Modal -->
    <div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <h6 class="mt-2">
                        <i data-feather="monitor" class="me-2"></i>{{ __('Desktop settings') }}
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                        <label class="form-check-label f-w-600 pl-1"
                            for="pcsetting1">{{ __('Allow desktop notification') }}</label>
                    </div>
                    <p class="text-muted ms-5">
                        {{ __('you get lettest content at a time when data will updated') }}
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting2" />
                        <label class="form-check-label f-w-600 pl-1"
                            for="pcsetting2">{{ __('Store Cookie') }}</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="save" class="me-2"></i>{{ __('Application settings') }}
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting3" />
                        <label class="form-check-label f-w-600 pl-1"
                            for="pcsetting3">{{ __('Backup Storage') }}</label>
                    </div>
                    <p class="text-muted mb-4 ms-5">
                        {{ __('Automaticaly take backup as par schedule') }}
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting4" />
                        <label class="form-check-label f-w-600 pl-1"
                            for="pcsetting4">{{ __('Allow guest to print file') }}</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="cpu" class="me-2"></i>{{ __('System settings') }}
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                        <label class="form-check-label f-w-600 pl-1"
                            for="pcsetting5">{{ __('View other user chat') }}</label>
                    </div>
                    <p class="text-muted ms-5">{{ __('Allow to show public user message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="button" class="btn btn-light-primary btn-sm">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Header ] end -->
</body>

<!-- [ Main Content ] start -->
<div class="dash-container">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        @yield('content')

        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted">&copy; 2022 </span><b><a
                    href="#">{{ __('Prime Laravel Form Builder') }}</a></b>
        </div>
        <div class="py-1">
        </div>
    </div>
</footer>

<div class="modal fade" role="dialog" id="common_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/modules/chocolat/dist/js/jquery.chocolat.min.js') }}  "></script>
<script src="{{ asset('vendor/modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/js/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/js/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('vendor/js/plugins/croppie/js/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/js/plugins/datatable/js/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/js/scripts.js') }}"></script>
<script src="{{ asset('vendor/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('vendor/js/custom.js') }}"></script>
<script src="{{asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>



@if (!empty(setting('gtag')))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('gtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ setting('gtag') }}');
    </script>
@endif


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

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>

@include('layouts.includes.alerts')
@stack('script')
</body>

</html>
