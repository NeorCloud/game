<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Mohammad Salmani')">
    @yield('meta')

    @stack('before-styles')
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <link href="{{url('/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/css/responsive.dataTables.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/css/persianDatepicker.css')}}" rel="stylesheet" type="text/css">
    <livewire:styles />
    @stack('after-styles')
    <style>
        @font-face {
            font-family: IRANSans;
            font-style: normal;
            font-weight: normal;
            src: url('/fonts/IRANSansWeb.eot');
            src: url('/fonts/IRANSansWeb.eot?#iefix') format('embedded-opentype'), /* IE6-8 */ url('/fonts/IRANSansWeb.woff2') format('woff2'), /* FF39+,Chrome36+, Opera24+*/ url('/fonts/IRANSansWeb.woff') format('woff'), /* FF3.6+, IE9, Chrome6+, Saf5.1+*/ url('/fonts/IRANSansWeb.ttf') format('truetype');
        }
    </style>
    @yield('extra')
</head>
<body class="c-app" style="font-family: IRANSans,Tahoma">
    @include('backend.includes.sidebar')

    <div class="c-wrapper c-fixed-components">
        @include('backend.includes.header')
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        @include('includes.partials.announcements')

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @include('includes.partials.messages')
                        @yield('content')
                    </div><!--fade-in-->
                </div><!--container-fluid-->
            </main>
        </div><!--c-body-->

        @include('backend.includes.footer')
    </div><!--c-wrapper-->

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
{{--    <script src="{{url('/js/jquery.form.js')}}" type="text/javascript"></script>--}}
    <script type="text/javascript">
        $.ajax({
            type: "get",
            url: '{{ url('/api/appVersion') }}',
            success: function (res) {
                if (res) {
                    $('#appVersion').append(res);
                }
            }
        });
    </script>
    <script src="{{url('/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/persianDatepicker.min.js')}}" type="text/javascript"></script>
    <livewire:scripts />
    @stack('after-scripts')
    @yield('add-field')
</body>
</html>
