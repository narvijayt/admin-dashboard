@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $grader['title'] }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.index') }}">Translations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.surveys', ['editionId' => $grader['editionId'] ]) }}">Edition</a></li>
                        <li class="breadcrumb-item active">View Graders</li>
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
                            <h5 class="mb-0">{{ $grader['title'] }} Translations</h5>
                        </div>

                        <div class="card-body">
                            @if(isset($patterns['data']) && !empty($patterns['data']))
								<div class="full-row">									
                                    
                                    <div class="full-row">
                                        <div class="row bg-light mb-2 p-2 border">
                                            <div class="col-md-4"><h5 class="mb-0">English</h5></div>
                                            @foreach($languages as $key=>$label)
                                                <div class="col-md-4"><h5 class="mb-0">{{ $label }}</h5></div>
                                            @endforeach
                                        </div>
                                        
                                        @foreach($patterns['data'] as $choiceIndex=>$pattern)
                                            @php 
                                            $patternTranslations = !empty($pattern['translations']) ? $pattern['translations'] : [];
                                            @endphp
                                            <div class="row border py-3">
                                                <div class="col-md-4"><h6>{{ $pattern['title'] }}</h6></div>

                                                @foreach($languages as $key=>$label)
                                                    <div class="col-md-4"><h6>{{ ( (!empty($patternTranslations) && isset($patternTranslations[$key]) ) ? $patternTranslations[$key]['title'] : '') }}</h6></div>
                                                @endforeach
                                            </div>
                                        @endforeach  
								    </div>
								</div>
							@endif

                        </div>
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection