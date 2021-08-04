@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . __('lang.register'))

@push('js')
    <script>
        $(document).ready(function () {
            $("form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        required: messages.required,
                        minlength: messages.min + ' 8 ' + messages.characters
                    },
                    email: {
                        required: messages.required,
                        email: messages.email
                    },
                    password_confirmation: {
                        equalTo: messages.equalTo
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="row p-10-m">
            <div class="auth panel">
                <div class="register">
                    <h2>{{ __('lang.register') }}</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="field-label">{{ __('lang.email') }}</label>
                            <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" data-validation="email">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="field {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="field-label">{{ __('lang.password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" data-validation="length" data-validation-length="min8">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="field {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="field-label">{{ __('lang.confirm_password') }}</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" data-validation="confirmation" data-validation-confirm="password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
                        </div>
                        <div class="field">
                            <button type="submit" class="btn btn-primary">{{ __('lang.register') }}</button>
                        </div>
                    </form>
                </div>
                <div class="login">
                    <h2>{{ __('lang.login') }}</h2>
                    <div class="field">
                        <p>{{ __('lang.already_have_account') }}, {{ __('lang.sign_in') }}</p>
                    </div>
                    <div class="field">
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('lang.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection