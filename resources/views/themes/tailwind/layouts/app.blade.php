<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @if(isset($seo->title))
        <title>{{ $seo->title }}</title>
    @else
        <title>{{ setting('site.title', 'Product Reminder') . ' - ' . setting('site.description') }}</title>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">


    <link rel="icon" href="{{ Voyager::image(setting('site.favicon', '/wave/favicon.png')) }}" type="image/x-icon">

    {{-- Social Share Open Graph Meta Tags --}}
    @if(isset($seo->title) && isset($seo->description) && isset($seo->image))
        <meta property="og:title" content="{{ $seo->title }}">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:image" content="{{ $seo->image }}">
        <meta property="og:type" content="@if(isset($seo->type)){{ $seo->type }}@else{{ 'article' }}@endif">
        <meta property="og:description" content="{{ $seo->description }}">
        <meta property="og:site_name" content="{{ setting('site.title') }}">

        <meta itemprop="name" content="{{ $seo->title }}">
        <meta itemprop="description" content="{{ $seo->description }}">
        <meta itemprop="image" content="{{ $seo->image }}">

        @if(isset($seo->image_w) && isset($seo->image_h))
            <meta property="og:image:width" content="{{ $seo->image_w }}">
            <meta property="og:image:height" content="{{ $seo->image_h }}">
        @endif
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">

    @if(isset($seo->description))
        <meta name="description" content="{{ $seo->description }}">
    @endif

    <!-- Styles -->
    <link href="{{ asset('themes/' . $theme->folder . '/css/app.css') }}" rel="stylesheet">

    <style>

        #card-element {
            background-color: #fff;
            border: 1px solid #d2d6dc;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .StripeElement {
            /* display: block; */
            margin: 10px 0 20px 0;
            max-width: 100%;
            padding: 10px 14px;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .StripeElement--focus {
            border-color: #3f83f8;
            box-shadow: 0 0 0 0.2rem rgba(63, 131, 248, 0.25);
        }

        .StripeElement--invalid {
            border-color: #ff3860;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

    </style>
    @yield("style")
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body class="flex flex-col min-h-screen @if(Request::is('/')){{ 'bg-white' }}@else{{ 'bg-gray-50' }}@endif @if(config('wave.dev_bar')){{ 'pb-10' }}@endif">

    @if(config('wave.demo') && Request::is('/'))
        @include('theme::partials.demo-header')
    @endif

    @include('theme::partials.header')

    <main class="flex-grow overflow-x-hidden">
        @yield('content')
    </main>



    @include('theme::partials.footer')

    @if(config('wave.dev_bar'))
        @include('theme::partials.dev_bar')
    @endif

    <!-- Full Screen Loader -->
    <div id="fullscreenLoader" class="fixed inset-0 top-0 left-0 z-50 flex flex-col items-center justify-center hidden w-full h-full bg-gray-900 opacity-50">
        <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p id="fullscreenLoaderMessage" class="mt-4 text-sm font-medium text-white uppercase"></p>
    </div>
    <!-- End Full Loader -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('openModal', false);
        });
    </script>

    @include('theme::partials.toast')
    @if(session('message'))
        <script>setTimeout(function(){ popToast("{{ session('message_type') }}", "{{ session('message') }}"); }, 10);</script>
    @endif
    @waveCheckout
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://js.stripe.com/v3/"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
    var pubKey = 'pk_test_51NvElWDsAglUhVjemuUk1PtrsshG5cnBjeoJQiuVW65tEHa0sU05HtCquN93jnlOev9TG3ViN5VJTnj2fMe5pVee005OEExvMI';
    var stripe = Stripe(pubKey);
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        console.log('Button clicked');
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function (result) {
            if (typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }

            /* creating token success */
            if (typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }

    // Trigger createToken when needed, for example, on a button click
    document.getElementById("pay-btn").addEventListener("click", createToken);
});


    </script>

    <script>
        $(document).ready(function(){
            $('#country').on('change', function(){
                var country_id = $(this).val();

                if (country_id) {
                    $.ajax({

                        url: "{{url('/getStates')}}/" + country_id,
                        type: "GET",
                        dataType: "json",
                        success: function(response){
                            console.log(response.states);
                            $('select[name="state_id"]').empty();
                            $.each(response.states, function(i, state){
                                console.log(state.state_id);
                                $('select[name="state_id"]').append('<option value="'+state.state_id+'">'+state.state_name+'</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="state_id"]').empty();
                    $('select[name="city_id"]').empty();
                }
            });

            $('#state').on('change', function(){
                var state_id = $(this).val();
                if (state_id) {
                    $.ajax({
                        url: "{{url('/getCities')}}/" + state_id,
                        type: "GET",
                        dataType: "json",
                        success: function(response){
                            console.log(response.cities);
                            $('select[name="city_id"]').empty();
                            $.each(response.cities, function(i, city){
                                console.log(city.city_id);
                                $('select[name="city_id"]').append('<option value="'+city.city_id+'">'+city.city_name+'</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_id"]').empty();
                }
            });
        });
    </script>

</body>
</html>
