@extends('layouts.app')

@section('content')
<div class="login-form">
	<h3 class="text-center mb-3 text-white">Admin Dashboard</h3>
	<div class="bg-white p-5 pt-4 border">
		
		<form action="{{ route('dologin') }}" method="post">
            @csrf
			<p class="text-center"><b>Sign in to start your session</b></p>
            <div class="form-group mb-3">
				<div class="input-group">
					<span class="input-group-text rounded-0 bg-white"><i class="icon-user"></i></span>
					<input type="text" class="form-control rounded-0" name="user_name" placeholder="Your Username *" value="{{ old('user_name') }}" />
				</div>
            </div>
            <div class="form-group mb-3">
				<div class="input-group ">
					<span class="input-group-text rounded-0 bg-white"><i class="icon-lock"></i></span>
					<input type="password" class="form-control rounded-0" name="user_password" placeholder="Your Password *" value="" />
				</div>
			</div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary w-100 btn-lg rounded-0" value="Login" />
            </div>
        </form>
    </div>
    <!----<div class="col-md-6 login-right-widget p-0">
        <img src="https://via.placeholder.com/570" />
    </div> --->
</div>
@endsection