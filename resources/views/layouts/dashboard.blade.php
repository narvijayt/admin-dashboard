<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        @include('layouts.includes.head')
        
        <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('css/dashboard-styles.css') }}>
        
    </head>
    <body class="sidebar-mini layout-fixed">
        <div class="wrapper">
		<div class="container-fluid">
            <div class="row">
                <div class="col-md-2 bg-dark px-0 sidebar-fix">
                    @include('layouts.includes.sidebar')
                </div>
                <div class="col-md-10 px-0 content-right">
                    @include('layouts.includes.header')

					<div class="content-wrapper vh-100 pb-5" >
						@yield('content')
					</div>
					
					@include('layouts.includes.footer')
                </div>
            </div>
        </div>
		</div>


        @include('layouts.includes.scripts')

      
    </body>
</html>
