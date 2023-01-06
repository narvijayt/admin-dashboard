<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @include('layouts.includes.head')
        
        <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('css/dashboard-styles.css') }}>
        
    </head>
    <body class="sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="row">
                <div class="col-md-2 bg-dark px-0">
                    @include('layouts.includes.sidebar')
                </div>
                <div class="col-md-10 px-0">
                    @include('layouts.includes.header')


                    @yield('content')
                </div>
            </div>
        </div>


        @include('layouts.includes.scripts')

        @include('layouts.includes.footer')
    </body>
</html>
