<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ appName() }}</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .bottom-right {
            position: absolute;
            right: 25px;
            bottom: 18px;
        }

        .content {
            text-align: center;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    @stack('after-styles')
</head>
<body>
@include('includes.partials.read-only')
@include('includes.partials.logged-in-as')

<div id="app" class="flex-center position-ref full-height">
    <div class="top-right links">
        @auth
            @if ($logged_in_user->isUser())
                <a href="{{ route('frontend.user.dashboard') }}">@lang('Dashboard')</a>
            @endif

            <a href="{{ route('frontend.user.account') }}">@lang('Account')</a>
        @else
            <a href="{{ route('frontend.auth.login') }}">@lang('Login')</a>

            @if (config('boilerplate.access.user.registration'))
                <a href="{{ route('frontend.auth.register') }}">@lang('Register')</a>
            @endif
        @endauth
    </div><!--top-right-->

    <div class="content">
        @include('includes.partials.messages')

        <ul>
            @foreach ($games as $game)
                <li><a href="{{route('frontend.games.run',$game->id)}}"
                       style="color: #636b6f; text-transform: uppercase">{{$game->title}}</a></li>
            @endforeach
        </ul><!--links-->
    </div><!--content-->

    <div class="bottom-right links">
        <div id="appVersion"></div>
    </div>
</div><!--app-->

@stack('before-scripts')
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/frontend.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: "get",
            url: '{{ url('/api/appVersion') }}',
            success: function (res) {
                if (res) {
                    $('#appVersion').append(res);
                }
            }
        });
    });
</script>
@stack('after-scripts')
</body>
</html>
