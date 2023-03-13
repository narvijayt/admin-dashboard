@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create New User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @include('layouts.includes.notices')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-8 offset-md-2 bg-white p-3 rounded shadow">
                    <form method="POST" class="create-user-form" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="accountType">Account Type</label></div>
                            <div class="col-md-7">
                                <select type="text" class="form-control" name="accountType" id="accountType">
                                    <option value=""> Select Account Type</option>
                                    @foreach($accountTypes as $type)
                                        <option value="{{ $type }}" {{ (old('accountType') == $type) ? "selected" : ""}} > {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="firstName">First Name</label></div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="firstName" id="firstName" value="{{ old('firstName') }}" />
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="lastName">Last Name</label></div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="lastName" id="lastName" value="{{ old('lastName') }}" />
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="email">Email</label></div>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" />
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="password">Password</label></div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password" id="password" value="" />
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5"><label for="password_confirmation">Confirm Password</label></div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" />
                            </div>
                        </div>
                        <div class="row form-group mb-3 pt-3 border-top">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-success"> <i class="fa-solid fa-floppy-disk"></i> Save</button>
                                <a href="{{ route('users.index') }}" class="btn btn-danger"> <i class="fa-solid fa-xmark"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection