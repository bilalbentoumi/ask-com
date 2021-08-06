<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <title>{{ __('admin.dashboard') . ' - ' . __('lang.login') }}</title>
    <link rel="icon" type="image/svg" href="{{ @asset('favicon.svg') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ @asset('fonts/Swissra/Swissra.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/Nunito/Nunito.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/framework.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/Nunito/Nunito.css') }}">

    <!-- SCRIPTS -->
    <script src="{{ @asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ @asset('js/jquery-ui.js') }}"></script>
    <script src="{{ @asset('js/validation.' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
</head>

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
    });
</script>

<body>
    <div class="login">
        <a href="{{ route('admin.home') }}" class="logo">
            <div class="icon"></div>
            <div class="text">
                <span class="name">
                    @if(LaravelLocalization::getCurrentLocale() == 'en')
                        <span class="es2al">Es2al</span>
                        <span class="com">.com</span>
                    @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
                        <span class="es2al">إسأل</span>
                        <span class="com">.كوم</span>
                    @endif
                </span>
                <span class="slug">{{ __('admin.dashboard') }}</span>
            </div>
        </a>
        <div class="login-box">
            <h2>{{ __('admin.welcome_back') }}</h2>
            <form action="{{ route('admin.login') }}" method="post">
                {{ csrf_field() }}
                <div class="flex-row">
                    <div class="field col-100 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="field-label">{{ __('admin.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="field col-100 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label class="field-label">{{ __('admin.password') }}</label>
                        <input type="password" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="field col-100 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label class="checkbox">
                            <span class="label">{{ __('lang.remember') }}</span>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <button class="btn btn-primary">{{ __('lang.login') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="copyright">
        <span>© Es2al.com™ 2019 - All rights reserved</span>
    </div>
</body>
</html>
