@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Translations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Translations </li>
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
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <h5 class="mb-0">Assessment Editions</h5>
                        </div>

                        <div class="card-body">
						
                            @if(isset($response['data']) && !empty($response['data']))
								<div class="row">
							<div class="col-sm-12">
                                <table id="basic-datatable" class="table table-bordered dataTable"  width="100%" cellspacing="0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Version</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($response['data'] as $edition)
                                        <tr>
                                            <td>{{ $edition['title'] }}</td>
                                            <td>{{ $edition['description'] }}</td>
                                            <td>
                                                {{--
                                                    @foreach($languages as $langKey=>$langLabel)
                                                        <a href="{{ route('translations.edit', ['editionId' => $edition['id'], 'lang' => $langKey ]) }}" class=" btn-sm  btn btn-primary"> <i class="icon-pencil me-1"></i> {{$langLabel}} </a>
                                                    @endforeach
                                                --}}
                                                <a href="{{ route('translations.surveys', ['editionId' => $edition['id'] ]) }}" class=" btn-sm btn btn-primary"> <i class="icon-pencil me-1"></i> Manage </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>description</th>
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