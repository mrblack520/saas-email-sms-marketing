<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="assets-path" content="{{ route('voyager.voyager_assets') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if ($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif



    <!-- App CSS -->
    {{-- <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}"> --}}
    @livewireStyles

    @yield('css')

{{--
    @if (!empty(config('voyager.additional_css')))
        <!-- Additional CSS -->
        @foreach (config('voyager.additional_css') as $css)<link rel="stylesheet" type="text/css" href="{{ asset($css) }}">
        @endforeach
    @endif --}}

    @yield('head')

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

      {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script> --}}
      <link href="https://vora.dexignlab.com/laravel/demo/vendor/chartist/css/chartist.min.css" rel="stylesheet" type="text/css"/>
      <link href="https://vora.dexignlab.com/laravel/demo/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet" type="text/css"/>
      <link href="https://vora.dexignlab.com/laravel/demo/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css"/>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <link href="https://vora.dexignlab.com/laravel/demo/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
      <link href="https://vora.dexignlab.com/laravel/demo/css/style.css" rel="stylesheet" type="text/css"/>
<style></style>

</head>

<body class="voyager @if (isset($dataType) && isset($dataType->slug)) {{ $dataType->slug }} @endif">

    {{-- <div id="voyager-loader">
        <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
        @if ($admin_loader_img == '')
            <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
        @else
            <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
        @endif
    </div> --}}

    <?php
    if (\Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'https://')) {
        $user_avatar = Auth::user()->avatar;
    } else {
        $user_avatar = Voyager::image(Auth::user()->avatar);
    }
    ?>

    <div class="app-container">
        <div class="fadetoblack visible-xs"></div>
        <div class="row content-container">

            @include('theme::layouts.test')
            {{-- @include('voyager::dashboard.navbar')

            @include('voyager::dashboard.sidebar') --}}
            {{-- @include('theme::partials.navbar') --}}
            {{-- @include('theme::partials.side-bar') --}}


            {{-- <script>
                (function() {
                    var appContainer = document.querySelector('.app-container'),
                        sidebar = appContainer.querySelector('.side-menu'),
                        navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                        loader = document.getElementById('voyager-loader'),
                        hamburgerMenu = document.querySelector('.hamburger'),
                        sidebarTransition = sidebar.style.transition,
                        navbarTransition = navbar.style.transition,
                        containerTransition = appContainer.style.transition;

                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                    if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] ==
                        'true') {
                        appContainer.className += ' expanded no-animation';
                        loader.style.left = (sidebar.clientWidth / 2) + 'px';
                        hamburgerMenu.className += ' is-active no-animation';
                    }

                    navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        containerTransition;
                })();
            </script> --}}
            <!-- Main Content -->
            <div class="container-fluid offset-md-2"  >
                <div class="side-body padding-top" style="margin-left: 35px;">
                    @yield('page_header')
                    <div id="voyager-notifications"></div>

                        <div class="row" style="margin-top: 6rem">
                            <div class="col-md-11 ">
                                @yield('content')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('voyager::partials.app-footer') --}}

    <!-- Javascript Libs -->
    <script>
        function displayFileName(input) {
            var fileNamePlaceholder = document.getElementById('fileNamePlaceholder');
            console.log("Number of files:", input.files.length);
            if (input.files.length > 0) {
                fileNamePlaceholder.innerText = input.files[0].name;
            } else {
                fileNamePlaceholder.innerText = '';
            }
        }
    </script>

    <script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>

    <script>
        @if (Session::has('alerts'))
            let alerts = {!! json_encode(Session::get('alerts')) !!};
            helpers.displayAlerts(alerts, toastr);
        @endif

        @if (Session::has('message'))

            // TODO: change Controllers to use AlertsMessages trait... then remove this
            var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
            var alertMessage = {!! json_encode(Session::get('message')) !!};
            var alerter = toastr[alertType];

            if (alerter) {
                alerter(alertMessage);
            } else {
                toastr.error("toastr alert-type " + alertType + " is unknown");
            }
        @endif
    </script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js">
    
    </script>
<script>
    multiUploadButton = document.getElementById("multi-upload-button");
    multiUploadInput = document.getElementById("multi-upload-input");
    multiUploadDisplayText = document.getElementById("multi-upload-text");
    multiUploadDeleteButton = document.getElementById("multi-upload-delete");

    multiUploadButton.onclick = function () {
        multiUploadInput.click();
    };

    multiUploadInput.addEventListener('change', function (event) {
        if (multiUploadInput.files) {
            let files = multiUploadInput.files;
            multiUploadDisplayText.innerHTML = files.length + ' files selected';
            multiUploadDeleteButton.classList.remove("hidden");

            // Display file names
            let fileNames = Array.from(files).map(file => file.name).join(', ');
            multiUploadDisplayText.innerHTML = fileNames;
        }
    });

    function removeMultiUpload() {
        multiUploadInput.value = '';
        multiUploadDisplayText.innerHTML = '';
        multiUploadDeleteButton.classList.add("hidden");
    }
</script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/global/global.min.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
                <script src="https://vora.dexignlab.com/laravel/demo/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/owl-carousel/owl.carousel.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/peity/jquery.peity.min.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/jquery-nice-select/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/vendor/apexchart/apexchart.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/js/dashboard/dashboard-1.js" type="text/javascript"></script>
                <script src="https://vora.dexignlab.com/laravel/demo/js/custom.min.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/js/dlabnav-init.js" type="text/javascript"></script>
<script src="https://vora.dexignlab.com/laravel/demo/js/demo.js" type="text/javascript"></script>
{{-- <script src="https://vora.dexignlab.com/laravel/demo/js/styleSwitcher.js" type="text/javascript"></script> --}}
    <script type="text/javascript">

        $(document).ready(function() {

           $('.ckeditor').ckeditor();

        });
        CKEDITOR.config.allowedContent = true;
    </script>
    {{-- @include('voyager::media.manager') --}}
    {{-- @yield('javascript') --}}
    {{-- @stack('javascript') --}}
    {{-- @if (!empty(config('voyager.additional_js')))<!-- Additional Javascript --> --}}
        {{-- @foreach (config('voyager.additional_js') as $js) --}}
            {{-- <script type="text/javascript" src="{{ asset($js) }}"></script> --}}
        {{-- @endforeach --}}
    {{-- @endif --}}
    {{-- @livewireScripts --}}
    <script>
        // Assuming your menu data is stored in a variable named 'menuData'
    const menuData = {{menu('admin', '_json')}};
    
    // Find the item with name 'mae'
    const maeItem = menuData.find(item => item.name === 'mae');
    
    // Now you can use 'maeItem' as needed in your component or template
    console.log('this is working',maeItem);
    </script>
</body>

</html>
