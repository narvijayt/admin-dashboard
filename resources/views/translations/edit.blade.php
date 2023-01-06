@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper" style="min-height: 230px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $languages[$lang] }} Translations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Translations </li>
                        <li class="breadcrumb-item active">Edit </li>
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
                    <div class="card card-white">
                        
                        <div class="card-header">
                            <h4>Edit Assessment Translations</h4>
                        </div>
                        
                        <div class="card-body">
                            <form class="form">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="survey-version">Version</label>
                                        <select class="form-control" id="survey-version" name="version">
                                        @for($versionLoop=1;$versionLoop<=4;$versionLoop++)
                                            <option value="{{$versionLoop}}">{{$versionLoop}}</option>
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                            </form>

                            @if(isset($selfAssessmentSurvey['sections']) && !empty($selfAssessmentSurvey['sections']))
                                <div class="accordion accordion-flush" id="selfAssessmentSectionAccordions">
                                @php $questionsIndex = 1; @endphp
                                @foreach($selfAssessmentSurvey['sections'] as $section)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-sectionheading_{{$section['id']}}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSection{{$section['id']}}" aria-expanded="false" aria-controls="flush-collapseSection{{$section['id']}}">
                                                {{ $section['title'] }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSection{{$section['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-sectionheading_{{$section['id']}}" data-bs-parent="#selfAssessmentSectionAccordions">
                                            <div class="accordion-body">
                                                <div class="row bg-light">
                                                    <div class="col-md-3"><h4>English</h4></div>
                                                    <div class="col-md-9"><h4>{{ $languages[$lang]}} Translation</h4></div>
                                                </div>
                                                <form id="" class="" method="POST" action="{{ route('translations.save', ['editionId' => $editionId, 'lang' => $lang]) }}">
                                                    <button type="submit" name="save-form" class="btn btn-success">Save</button>
                                                    @csrf

                                                    @php $questionsOldDetails = []; @endphp

                                                    @if(old('selfQuestionChoices'))
                                                        @php $questionsOldDetails = old('selfQuestionChoices');  @endphp
                                                    @endif
                                                    

                                                    @foreach($section['questions'] as $question)
                                                        <input type="hidden" name="question_id[]" value="{{ $question['id'] }}" />
                                                        <div class="row bg-primary">
                                                            <div class="col-md-12"><h4>Question {{ $questionsIndex }}</h4></div>
                                                        </div>
                                                        
                                                        @foreach($question['choices'] as $selfChoiceIndex=>$choice)
                                                            @php  $selfChoicesTranslations = json_decode($choice['translations']); @endphp
                                                            <input type="hidden" name="selfQuestionChoices[{{$question['id']}}][choice_id][]" value="{{ $choice['id'] }}" />
                                                            <div class="row border">
                                                                <div class="col-md-3"><h6>{{ $choice['title'] }}</h6></div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" name="selfQuestionChoices[{{$question['id']}}][choiceTitle][]" value="{{  (!empty($questionsOldDetails) && isset($questionsOldDetails[$question['id']])) ? $questionsOldDetails[$question['id']]['choiceTitle'][$selfChoiceIndex]  : ( (!empty($selfChoicesTranslations) && isset($selfChoicesTranslations[$lang]) ) ? $selfChoicesTranslations[$lang]['title'] : '') }}" />
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <strong>Description: </strong> 
                                                                    <p>{{ $choice['description'] }}</p>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" name="selfQuestionChoices[{{$question['id']}}][choiceDescription][]" value="{{ (!empty($questionsOldDetails) && isset($questionsOldDetails[$question['id']]) ) ? $questionsOldDetails[$question['id']]['choiceDescription'][$selfChoiceIndex] : ( (!empty($selfChoicesTranslations) && isset($selfChoicesTranslations[$lang])) ? $selfChoicesTranslations[$lang]['description'] : '') }}" />
                                                                </div>
                                                                <input type="hidden" class="form-control" name="selfQuestionChoices[{{$question['id']}}][translations][]" value="{{ $selfChoicesTranslations }}" />
                                                            </div>
                                                        @endforeach

                                                        @php $questionsIndex++; @endphp
                                                    @endforeach                    
                                                    <button type="submit" name="save-form" class="btn btn-success">Save Bottom</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Display Needs Assessment Transaltions Section --}}

                                @if(isset($needsAssessmentSurvey['choices']))
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-sectionheading_{{$needsAssessmentSurvey['id']}}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSection{{$needsAssessmentSurvey['id']}}" aria-expanded="false" aria-controls="flush-collapseSection{{$needsAssessmentSurvey['id']}}">
                                                {{ $needsAssessmentSurvey['title'] }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSection{{$needsAssessmentSurvey['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-sectionheading_{{$needsAssessmentSurvey['id']}}" data-bs-parent="#selfAssessmentSectionAccordions">
                                            <div class="accordion-body">
                                                <div class="row bg-light">
                                                    <div class="col-md-3"><h4>English</h4></div>
                                                    <div class="col-md-9"><h4>{{ $languages[$lang]}} Translation</h4></div>
                                                </div>
                                                <form id="" class="" method="POST" action="{{ route('translations.save', ['editionId' => $editionId, 'lang' => $lang]) }}">
                                                    <button type="submit" name="save-form" class="btn btn-success">Save</button>
                                                    @csrf
                                                    @foreach($needsAssessmentSurvey['choices'] as $choiceIndex=>$choice)
                                                        @php 
                                                        $needsChoicesTranslations = json_decode($choice['translations']);
                                                        @endphp
                                                        <div class="row border py-3">
                                                            <div class="col-md-3"><h6>{{ $choice['title'] }}</h6></div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="needsChoiceTitle[]" value="{{ ( (!empty($needsChoicesTranslations) && isset($needsChoicesTranslations[$lang]) ) ? $needsChoicesTranslations[$lang]['title'] : '') }}" />
                                                            </div>
                                                            <input type="hidden" class="form-control" name="needsTranslations[]" value="{{ $needsChoicesTranslations }}" />
                                                            <input type="hidden" class="form-control" name="needsChoicesId[]" value="{{ $choice['id'] }}" />
                                                        </div>
                                                    @endforeach                   
                                                    <button type="submit" name="save-form" class="btn btn-success">Save Bottom</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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