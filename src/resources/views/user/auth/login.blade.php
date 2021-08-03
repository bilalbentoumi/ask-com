@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . __('lang.login'))

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
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $("form").submit(function () {
                $(this).find('.help-block').remove();
            });

            $("form input").keyup(function () {
                $(this).nearest('form').find('.help-block').remove();
            });
        });
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="row p-10-m">
            <div class="auth panel">
                <div class="login">
                    <h2>{{ __('lang.login') }}</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="field-label">{{ __('lang.email') }}</label>
                            <input id="email" name="email" value="{{ old('email') }}" data-validation="email">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            @if (Session::has('email'))
                                <span class="help-block">
                                    {{ Session::get('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="field {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="field-label">{{ __('lang.password') }}</label>
                            <input id="password" type="password" name="password" data-validation="length" data-validation-length="min8">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <span class="label">{{ __('lang.remember') }}</span>
                                <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="field">
                            <button type="submit" class="btn btn-primary">{{ __('lang.login') }}</button>
                        </div>
                    </form>
                </div>
                <div class="register">
                    <h2>{{ __('lang.register') }}</h2>
                    <div class="field">
                        <p>{{ __('lang.you_dont_have_and_account') }}</p>
                    </div>
                    <div class="field">
                        <a href="{{ route('register') }}" class="btn btn-primary">{{ __('lang.register') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection