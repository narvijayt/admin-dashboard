<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>        
        
        @include('layouts.includes.apphead')
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
        
    </body>
</html>
