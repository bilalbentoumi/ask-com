@extends('user.layouts.settings')

@section('title', Settings::get('sitename') . ' - ' . __('lang.change_password'))

@section('settingcontent')
    <div class="panel">
        <div class="panel-header">
            <h2>{{ __('lang.change_password') }}</h2>
        </div>
        <form method="POST" action="{{ route('settings.password.update') }}">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="panel-body row-flex">
                <div class="field col-100 {{ $errors->has('current_password') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.current_password') }}</label>
                    <div class="control">
                        <input name="current_password" type="password" value="{{ old('current_password') }}">
                        @if ($errors->has('current_password'))
                            <span class="help-block">{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.new_password') }}</label>
                    <div class="control">
                        <input name="new_password" type="password" value="{{ old('new_password') }}">
                        @if ($errors->has('new_password'))
                            <span class="help-block">{{ $errors->first('new_password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.confirm_password') }}</label>
                    <div class="control">
                        <input name="confirm_password" type="password" value="">
                        @if ($errors->has('confirm_password'))
                            <span class="help-block">{{ $errors->first('confirm_password') }}</span>
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