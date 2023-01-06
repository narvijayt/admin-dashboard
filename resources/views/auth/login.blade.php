@extends('layouts.app')

@section('content')
<div class="row login-container">
    <div class="col-md-6 login-form">
        <h3>Login Now!</h3>
        <form action="{{ route('dologin') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="user_name" placeholder="Your Username *" value="{{ old('user_name') }}" />
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="user_password" placeholder="Your Password *" value="" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Login" />
            </div>
        </form>
    </div>
    <div class="col-md-6 login-right-widget p-0">
        <img src="https://via.placeholder.com/570" />
    </div>
</div>
@endsection