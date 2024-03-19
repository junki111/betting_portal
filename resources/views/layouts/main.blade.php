<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>@yield('title', ''){{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    @include('layouts.shared.head')

</head>

@if (isset($isScrollable) && $isScrollable)

    <body class="scrollable-layout">
    @elseif(isset($isBoxed) && $isBoxed)

        <body class="left-side-menu-condensed boxed-layout" data-left-keep-condensed="true">
        @elseif(isset($isDarkSidebar) && $isDarkSidebar)

            <body class="left-side-menu-dark">
            @elseif(isset($isCondensedSidebar) && $isCondensedSidebar)

                <body class="left-side-menu-condensed" data-left-keep-condensed="true">
                @else

                    <body>
@endif

@if (isset($withLoader) && $withLoader)
    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->
@endif

<div id="wrapper">

    @include('layouts.shared.header')
    @include('layouts.shared.sidebar')

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                @yield('breadcrumb')
                @yield('content')
            </div>
        </div>

        @include('layouts.shared.footer')
    </div>
</div>

@include('layouts.shared.rightbar')

@include('layouts.shared.footer-script')

@if (getenv('APP_ENV') === 'local')
    <script id="__bs_script__">
        //<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.7'><\/script>"
            .replace("HOST", location.hostname));
        //]]>
    </script>
@endif
<script>
    $(document).ready(function() {
        $(".alert").delay(3000).slideUp(300);
    });
</script>
</body>

</html>
