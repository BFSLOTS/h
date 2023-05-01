@php
$users = \Auth::user();
$currantLang = $users->currentLanguage();
$languages = Utility::languages();
// $profile = asset(Storage::url('uploads/avatar/'));
@endphp
<header class="dash-header transprent-bg">
    <div class="header-wrapper">

        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link custom-headers dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-world nocolor pr-1"></i>
                        <span class="drp-text hide-mob pr-1">{{ Str::upper($currantLang) }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                        @foreach ($languages as $language)
                            <a class="dropdown-item @if ($language == $currantLang) text-danger @endif"
                                href="{{ route('change.language', $language) }}">{{ Str::upper($language) }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="dropdown dash-h-item">
                    <a class="dash-head-link custom-headers dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        @if (empty(Auth::user()->avatar))
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="user-avtar ms-2">
                                @else
                                <img alt="image" src="{{ Storage::url(Auth::user()->avatar) }}" class="user-avtar ms-2">
                                @endif

                        <span>
                            <h6 class="f-w-500 fs-6 d-inline-flex mb-0">{{ Auth::user()->name }}</h6>
                        </span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>

                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{ route('profile.index', Auth::user()->id) }}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
