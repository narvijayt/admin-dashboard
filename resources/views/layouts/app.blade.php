<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('css/styles.css') }}>
	
        
        @include('layouts.includes.head')
    </head>
    <body>
		<div class="bg-dark vh-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-5 position-absolute top-50 start-50 translate-middle">
						@include('layouts.includes.notices')

						@yield('content')
					</div>
				</div>
			</div>
		</div>

        @include('layouts.includes.scripts')
    </body>
</html>
