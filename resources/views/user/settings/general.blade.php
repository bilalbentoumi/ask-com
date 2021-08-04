@extends('user.layouts.settings')

@section('title', Settings::get('sitename') . ' - ' . __('lang.general_settings'))

@section('settingcontent')
    <div class="panel">
        <div class="panel-header">
            <h2>{{ __('lang.general_settings') }}</h2>
        </div>
        <form method="POST" action="{{ route('settings.general.update') }}">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="panel-body row-flex">
                <div class="field col-50 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name" class="field-label">{{ __('lang.first_name') }}</label>
                    <div class="control">
                        <input name="first_name" type="text" id="first_name" value="{{ old('first_name', Auth::user()->first_name) }}">
                        @if ($errors->has('first_name'))
                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field col-50 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.last_name') }}</label>
                    <div class="control">
                        <input name="last_name" type="text" value="{{ old('last_name', Auth::user()->last_name) }}">
                        @if ($errors->has('last_name'))
                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.email') }}</label>
                    <div class="control">
                        <input name="email" type="email" value="{{ old('email', Auth::user()->email) }}">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field col-100">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                </div>
            </div>
        </form>
    </div>
    <style>
        .footer {
            margin-top: 170px;
        }
    </style>
@endsection