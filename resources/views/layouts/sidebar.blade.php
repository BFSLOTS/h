@php
use App\Models\Form;
$users = \Auth::user();
$currantLang = $users->currentLanguage();
$languages = Utility::languages();
$role_id = $users->roles->first()->id;
if (Auth::user()->type == 'Admin') {
    $forms = Form::all();
} else {
    $forms = Form::select(['forms.*'])
        ->leftJoin('users', 'users.id', 'forms.created_by')
        ->whereIn('forms.id', function ($query) use ($role_id) {
            $query
                ->select('form_id')
                ->from('user_forms')
                ->where('role_id', $role_id);
        })
        ->get();
}
@endphp

<nav class="dash-sidebar light-sidebar transprent-bg">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="b-brand text-center">
                <!-- ========   change your logo hear   ============ -->
                @if (Utility::getsettings('dark_mode') == 'on')
                <img src="{{ Utility::getsettings('app_logo') ? Storage::url('uploads/appLogo/app-logo.png') : '' }}"
                class="app-logo w-75">
                @else
                <img src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('uploads/appLogo/app-dark-logo.png') : '' }}"
                        class="app-logo w-75">
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar" style="display: block;">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
                </li>

                @can('manage-user')
                    <li class="dash-item dash-hasmenu">
                        <a class="dash-link" href="{{ route('users.index') }}"><span class="dash-micon">
                                <i class="ti ti-user"></i></span>
                            <span class="dash-mtext">{{ __('Users') }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage-role')
                    <li class="dash-item dash-hasmenu {{ request()->is('roles*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('roles.index') }}"><span class="dash-micon">
                                <i class="ti ti-key"></i></span>
                            <span class="dash-mtext">{{ __('Roles') }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage-setting')
                    <li class="dash-item dash-hasmenu">
                        <a class="dash-link" href="{{ route('settings') }}"><span class="dash-micon">
                                <i class="ti ti-settings"></i></span>
                            <span class="dash-mtext">{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage-form')
                    <li class="dash-item dash-hasmenu {{ request()->is('forms*','design*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('forms.index') }}"><span class="dash-micon">
                                <i class="ti ti-forms"></i></span>
                            <span class="dash-mtext">{{ __('Forms') }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage-submitted-form')

                    <li class="dash-item dash-hasmenu {{ request()->is('formvalues*') ? 'active' : '' }}">
                        <a href="#" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-list"></i></span><span
                                class="dash-mtext">{{ __('Submitted Forms') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul
                            class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                            @foreach ($forms as $form)
                                <li class="dash-item">
                                    <a class="dash-link {{ Request::route()->getName() == 'view.form.values' ? 'show' : '' }}"
                                        href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endcan
                @can('manage-chat')
                    @if (setting('pusher_status') == '1')
                        <li class="dash-item dash-hasmenu {{ request()->is('chat*') ? 'active' : '' }}">

                            <a class="dash-link" href="{{ route('chat') }}"><span class="dash-micon">
                                    <i class="ti ti-brand-hipchat"></i></span>
                                <span class="dash-mtext">{{ __('Chat') }}</span>
                            </a>
                        </li>
                    @endif
                @endcan
                @can('manage-language')
                    <li class="dash-item dash-hasmenu {{ request()->is('lang*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('manage.language', [$currantLang]) }}"><span
                                class="dash-micon">
                                <i class="ti ti-world"></i></span>
                            <span class="dash-mtext">{{ __('Manage Language') }}</span>
                        </a>
                    </li>
                @endcan
            </ul>

        </div>
</nav>
