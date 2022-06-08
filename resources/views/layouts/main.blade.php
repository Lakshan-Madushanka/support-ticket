<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .navbar {
            background-color: yellow !important;
        }

        .main-title {
            letter-spacing: 15px;
        }

    </style>

    @stack('css')

</head>
<body>

<div class="container" id="main-wrapper">
    @include('partials.navbar')

    <div class="container mt-4 mb-4 text-center">
        <h1 class="mx-auto main-title">@yield('header')</h1>
        @if(session('status'))
            <div class="alert alert-{{session('status.type')}} mb-2 mt-2 text-center">
                {{session('status.message')}}
            </div>
        @endif
    </div>

    <div class="container" id="main">
        @if($errors->any())
            <div class="alert alert-danger text-center"> One or more Validation errors occurred !</div>
        @endif
        @yield('main')
    </div>

    @stack('script')

</div>
</body>
</html>
