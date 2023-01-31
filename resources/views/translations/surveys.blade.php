@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $edition['title'] }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations') }}">Translations</a></li>
                        <li class="breadcrumb-item active">{{ $edition['title'] }} </li>
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
                            <h5 class="mb-0">{{ $edition['title'] }} Surveys</h5>
                        </div>

                        <div class="card-body">
						
                            @if(isset($selfAssessmentSurveys['data']) && !empty($selfAssessmentSurveys['data']))
                                <div class="pb-5">
                                    <h5 class="text-primary mt-2">Self Assessment Surveys</h5>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="basic-datatable" class="table table-bordered dataTable"  width="100%" cellspacing="0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Edition</th>
                                                        <th>Survey</th>
                                                        <th>Version</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $isDraftMode = false; @endphp
                                                    @foreach(array_reverse($selfAssessmentSurveys['data']) as $survey)
                                                    <tr>
                                                        <td>{{ $edition['title'] }}</td>
                                                        <td>{{ $survey['title'] }}</td>
                                                        <td>{{ $survey['version'] }}</td>
                                                        <td>
                                                            
                                                            <a href="{{ route('translations.view', ['surveyId' => $survey['id'], 'surveyType' => 'self' ]) }}" class="btn-sm btn btn-info"> <i class="fa-solid fa-eye"></i> View </a>    

                                                            @if($survey['versionLocked'] != 1)
                                                                @php $isDraftMode = true; @endphp
                                                                @foreach($languages as $langKey=>$langLabel)
                                                                    <a href="{{ route('translations.edit', ['surveyId' => $survey['id'], 'lang' => $langKey, 'surveyType' => 'self' ]) }}" class="btn-sm btn btn-primary"> <i class="fa-solid fa-pen-to-square"></i> {{ $langLabel }} </a>
                                                                @endforeach

                                                                @if(session()->get('user')['accountType'] == "ADMIN")
                                                                    <a href="javascript:;" data-href="{{ route('translations.publishSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'self' ]) }}" class="btn-sm btn btn-success publish-survey"> <i class="fa-solid fa-floppy-disk"></i> Publish </a>
                                                                    <a href="javascript:;" data-href="{{ route('translations.deleteSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'self' ]) }}" class="btn-sm btn btn-danger delete-survey"> <i class="fa-solid fa-trash"></i> Delete </a>
                                                                @endif
                                                            @endif

                                                            @if($survey['versionLocked'] == 1 && $isDraftMode == false)
                                                                <a href="javascript:;" data-href="{{ route('translations.duplicateSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'self' ]) }}" class="btn-sm btn btn-primary duplicate-survey"> <i class="fa-solid fa-clone"></i> Duplicate </a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Edition</th>
                                                        <th>Survey</th>
                                                        <th>Version</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($needsAssessmentSurveys['data']) && !empty($needsAssessmentSurveys['data']))
                                <div class="pb-5">
                                    <h5 class="text-primary mt-2">Needs Assessment Surveys</h5>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="basic-datatable" class="table table-bordered dataTable"  width="100%" cellspacing="0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Edition</th>
                                                        <th>Survey</th>
                                                        <th>Version</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $isDraftMode = false; @endphp
                                                    @foreach(array_reverse($needsAssessmentSurveys['data']) as $survey)
                                                    <tr>
                                                        <td>{{ $edition['title'] }}</td>
                                                        <td>{{ $survey['title'] }}</td>
                                                        <td>{{ $survey['version'] }}</td>
                                                        <td>
                                                            <a href="{{ route('translations.view', ['surveyId' => $survey['id'], 'surveyType' => 'needs' ]) }}" class="btn-sm btn btn-info"> <i class="fa-solid fa-eye"></i> View </a>
                                                            
                                                            @if($survey['versionLocked'] != 1)
                                                                @php $isDraftMode = true; @endphp
                                                                @foreach($languages as $langKey=>$langLabel)
                                                                    <a href="{{ route('translations.edit', ['surveyId' => $survey['id'], 'lang' => $langKey, 'surveyType' => 'needs' ]) }}" class="btn-sm btn btn-primary"> <i class="fa-solid fa-pen-to-square"></i> {{ $langLabel }} </a>
                                                                @endforeach
                                                                
                                                                @if(session()->get('user')['accountType'] == "ADMIN")
                                                                    <a href="javascript:;" data-href="{{ route('translations.publishSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'needs' ]) }}" class="btn-sm btn btn-success publish-survey"> <i class="fa-solid fa-floppy-disk"></i> Publish </a>
                                                                    <a href="javascript:;" data-href="{{ route('translations.deleteSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'needs' ]) }}" class="btn-sm btn btn-danger delete-survey"> <i class="fa-solid fa-trash"></i> Delete </a>
                                                                @endif
                                                            @endif 

                                                            @if($survey['versionLocked'] == 1 && $isDraftMode == false)
                                                                <a href="javascript:;" data-href="{{ route('translations.duplicateSurvey', ['editionId' => $edition['id'], 'surveyId' => $survey['id'], 'surveyType' => 'needs' ]) }}" class="btn-sm btn btn-primary duplicate-survey"> <i class="fa-solid fa-clone"></i> Duplicate </a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Edition</th>
                                                        <th>Survey</th>
                                                        <th>Version</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
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