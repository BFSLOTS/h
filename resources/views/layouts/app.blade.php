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

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('vendor/img/favicon.png') }}" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    @if (Utility::getsettings('rtl') == '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
        @if (Utility::getsettings('dark_mode') == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        @endif
    @endif

</head>

<body class="{{ $color }}">
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v1">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">

            @yield('content')

            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row" style="display: flex;align-items: center;">
                        <div class="col-6">
                            @if (Utility::getsettings('dark_mode') == 'on')
                            <img src="{{ Storage::url(setting('app_logo')) ? Storage::url('uploads/appLogo/app-logo.png') : '' }}"  class="app-logo" style="width: 24%" />
                        @else
                            <img src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('uploads/appLogo/app-dark-logo.png') : '' }}"  class="app-logo" style="width: 24%" />
                        @endif
                        </div>
                        <div class="col-6 text-end">
                            &copy; {{ date('Y') }} <a href="#" class="font-weight-bold ml-1"
                                target="_blank">{{ config('app.name') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        feather.replace();
    </script>
    <div class="pct-customizer">
        <div class="pct-c-btn">
            <button class="btn btn-primary" id="pct-toggler">
                <i data-feather="settings"></i>
            </button>
        </div>
        <div class="pct-c-content">
            <div class="pct-header bg-primary">
                <h5 class="mb-0 text-white f-w-500">Theme Customizer</h5>
            </div>
            <div class="pct-body">
                <h6 class="mt-2">
                    <i data-feather="credit-card" class="me-2"></i>Primary color settings
                </h6>
                <hr class="my-2" />
                <div class="theme-color themes-color">
                    <a href="#!" class="" data-value="theme-1"></a>
                    <a href="#!" class="" data-value="theme-2"></a>
                    <a href="#!" class="" data-value="theme-3"></a>
                    <a href="#!" class="" data-value="theme-4"></a>
                </div>

                <h6 class="mt-4">
                    <i data-feather="layout" class="me-2"></i>Sidebar settings
                </h6>
                <hr class="my-2" />
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="cust-theme-bg" checked />
                    <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">Transparent layout</label>
                </div>

                <h6 class="mt-4">
                    <i data-feather="sun" class="me-2"></i>Layout settings
                </h6>
                <hr class="my-2" />
                <div class="form-check form-switch mt-2">
                    <input type="checkbox" class="form-check-input" id="cust-darklayout" />
                    <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">Dark Layout</label>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    @include('layouts.includes.alerts')
    @if (setting('rtl') == '1')
    @endif
    <script>
        @if (session('failed'))
            notifier.show('Failed!', '{{ session('failed') }}', 'danger',
            '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
        @endif

        @if (session('errors'))
            notifier.show('Error!', '{{ session('errors') }}', 'danger',
            '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
        @endif

        @if (session('successful'))
            notifier.show('SuccessfulLY!', '{{ session('successful') }}', 'success',
            '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        @endif

        @if (session('success'))
            notifier.show('Done!', '{{ session('success') }}', 'success',
            '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        @endif
        @if (session('warning'))
            notifier.show('Warning!', '{{ session('warning') }}', 'warning',
            '{{ asset('assets/images/notification/medium_priority-48.png') }}', 4000);
        @endif
    </script>
    <script>
        @if (session('status'))
            notifier.show('Great!', '{{ session('status') }}', 'info',
            '{{ asset('assets/images/notification/survey-48.png') }}', 4000);
        @endif
    </script>
    <script>
        $(document).on('click', '.delete-action', function() {
            var form_id = $(this).attr('data-form-id')
            $.confirm({
                title: '{{ __('Alert !') }}',
                content: '{{ __('Are You sure ?') }}',
                buttons: {
                    confirm: function() {
                        $("#" + form_id).submit();
                    },
                    cancel: function() {}
                }
            });
        });
    </script>
    @stack('script')
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


</body>

</html>
