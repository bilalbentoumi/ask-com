@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . __('lang.settings'))

@section('content')
    <div class="body-wrapper">
        <div class="settings-grid row p-10-m">
            <div class="settings-sidebar">
                <div id="sticky" class="settings-nav">
                    <a class="nav-link @if(Route::is('settings.general')) active @endif" href="{{ route('settings.general') }}">
                        <i data-feather="settings"></i>
                        <span>{{ __('lang.general_settings') }}</span>
                    </a>
                    <a class="nav-link @if(Route::is('settings.profile')) active @endif" href="{{ route('settings.profile') }}">
                        <i data-feather="user"></i>
                        <span>{{ __('lang.profile_settings') }}</span>
                    </a>
                    <a class="nav-link @if(Route::is('settings.changepass')) active @endif" href="{{ route('settings.changepass') }}">
                        <i data-feather="lock"></i>
                        <span>{{ __('lang.password') }}</span>
                    </a>
                    <a class="nav-link @if(Route::is('settings.myquestions')) active @endif" href="{{ route('settings.myquestions') }}">
                        <i data-feather="help-circle"></i>
                        <span>{{ __('lang.myquestions') }}</span>
                    </a>
                </div>
            </div>
            <div class="settings-primary">
                @yield('settingcontent')
            </div>
        </div>
    </div>
@endsection