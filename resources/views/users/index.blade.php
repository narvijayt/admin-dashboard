@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                <div class="col-md-12">
                    <div class="card card-white rounded-0  ">
                        
                        <div class="card-header bg-white py-3 ">
                            <h5 class="mb-0">Manage Users</h5>
                        </div>

                        <div class="card-body">
						@if(isset($response['data']) && !empty($response['data']))
								<div class="row">
							<div class="col-sm-12">
                                <table id="basic-datatable" class="table table-bordered dataTable"  width="100%" cellspacing="0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Account Type</th>
                                            <th>Registered</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($response['data'] as $user)
                                        <tr>
                                            <td>{{ $user['firstName'].' '.$user['lastName'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ $user['accountType'] }}</td>
                                            <td>{{ date("m/d/Y", strtotime($user['createdAt']) ) }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', ['userId' => $user['id'] ]) }}" class=" btn-sm btn btn-primary"> <i class="fa-solid fa-pen-to-square"></i> Edit </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Account Type</th>
                                            <th>Registered</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
						  </div>
						  </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection