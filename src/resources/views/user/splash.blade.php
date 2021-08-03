<html dir="rtl">
<head>
    <link rel="stylesheet" href="{{ @asset('fonts/Swissra/Swissra.css') }}">
    <script src="{{ @asset('js/jquery-3.4.1.min.js') }}"></script>
</head>
<body>
    <div class="logo">
        <span class="name">إسأل</span>
        <span class="com">.كوم</span>
    </div>
</body>


<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }
    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo {
        display: flex;
        align-items: center;
        flex: 1;
        justify-content: center;
        font-family: 'Swissra';
        font-size: 50px;
        font-weight: 500;
        transform: scale(0.9);
        animation: bounceIn 1s ease-in-out 1s infinite;
    }
    .logo:before {
        content: '';
        width: 90px;
        height: 77px;
        background: url('../images/splash.png') no-repeat;
        background-position: -0px 0px;
        margin-left: 5px;
    }
    .logo .name {
        color: #03A9F4;
    }
    .logo .com {
        color: #000;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.9);

        }
        50% {
            transform: scale(0.8);
        }
        100% {
            transform: scale(0.9);
        }
    }
</style>


</html>