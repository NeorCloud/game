<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', 'CRM')">
    <meta name="author" content="@yield('meta_author', 'Mohammad Salmani')">
    <meta name="email" content="@yield('meta_author', 'mohammadsalmani28@gmail.com')">
    <meta name="keyword" content="Panel">
    <title>{{config('app.name') . ' | ' . __('Login')}}</title>
    <meta name="theme-color" content="#ffffff">
    <link href="{{ url('/css/login/style.css') }}" rel="stylesheet">
    <link href="{{ url('/css/login/pace.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/icons.css') }}" rel="stylesheet">
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-118965717-3');
        gtag('config', 'UA-118965717-5');
    </script>
    <style>
        @font-face {
            font-family: IRANSans;
            font-style: normal;
            font-weight: normal;
            src: url('/fonts/IRANSansWeb.eot');
            src: url('/fonts/IRANSansWeb.eot?#iefix') format('embedded-opentype'), /* IE6-8 */ url('/fonts/IRANSansWeb.woff2') format('woff2'), /* FF39+,Chrome36+, Opera24+*/ url('/fonts/IRANSansWeb.woff') format('woff'), /* FF3.6+, IE9, Chrome6+, Saf5.1+*/ url('/fonts/IRANSansWeb.ttf') format('truetype');
        }
    </style>
</head>
<body class="c-app flex-row align-items-center" style="font-family: IRANSans,Tahoma">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.partials.messages')
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group" dir="ltr">
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
{{--                            <h2>@lang('auth.sign_up')</h2>--}}
{{--                            <p>@lang('strings.register_string')</p>--}}
                            <div class="row justify-content-center">
                                <img class="col-md-8" src="{{ optional(\App\Domains\Files\Models\File::find(optional(\App\Domains\Settings\Models\Setting::find(2))->value))->src    }}" alt="Logo">
                            </div>
{{--                            <a href="{{route('frontend.auth.register')}}" class="btn btn-primary active mt-3"--}}
{{--                               type="button">@lang('navs.frontend.register')</a>--}}
                        </div>
                    </div>
                </div>
                <div class="card p-4">
                    <div class="card-body" dir="rtl">
                        <h1>@lang('Login')</h1>
                        <p class="text-muted">@lang('sign_in')</p>
                        <form method="POST" action="{{ route('frontend.auth.login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" placeholder="{{ __('E-mail Address') }}"
                                       name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input class="form-control col-md-10" type="password" id="password"
                                       placeholder="{{ __('Password') }}" name="password" required>
                                <button onclick="eye()" type="button" class="form-control col-md-2 content-center border-right-0">
                                    <i class="fas fa-eye" id="eye"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                                </div>
                                <div class="col-9 text-right">
                                    <a href="{{ route('frontend.auth.password.request') }}" class="btn btn-link px-0"
                                       type="button">{{ __('Forgot Your Password?') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('/js/login/pace.min.js') }}"></script>
<script src="{{ url('/js/login/coreui.bundle.min.js') }}"></script>
<script>
    function eye() {
        var x = document.getElementById("password");
        var y = document.getElementById("eye");
        if (x.type === "password") {
            y.className = "fas fa-eye-slash";
            x.type = "text";
        } else {
            y.className = "fas fa-eye";
            x.type = "password";
        }

    }
</script>
</body>
</html>

