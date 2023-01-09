@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper vh-100" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $languages[$lang] }} Translations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right  mb-0 justify-content-end">
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
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Edit Assessment Translations</h5>
                        </div>
                        
                        <div class="card-body">
                            <form class="form">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="survey-version"><b>Version</b></label>
                                        <select class="form-control" id="survey-version" name="version">
                                        @for($versionLoop=1;$versionLoop<= $selfAssessmentSurvey['version'];$versionLoop++)
                                            <option value="{{$versionLoop}}" {{($versionLoop == $selfAssessmentSurvey['version']) ? "selected" : ""}} >{{$versionLoop}}</option>
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                            </form>

                            @if(isset($selfAssessmentSurvey['sections']) && !empty($selfAssessmentSurvey['sections']))
                                <form id="" class="mt-5" method="POST" action="{{ route('translations.save', ['editionId' => $editionId, 'lang' => $lang]) }}">
                                    <button type="submit" name="save-draft-self-choices" class="btn btn-success">Save Draft</button>
                                    <button type="submit" name="publish-self-choices" class="btn btn-success">Publish</button>
                                    @csrf
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
                                                                @php  $selfChoicesTranslations = !empty($choice['translations']) ? $choice['translations'] : []; @endphp
                                                                <input type="hidden" name="selfQuestionChoices[{{$question['id']}}][choice_id][]" value="{{ $choice['id'] }}" />
                                                                <div class="row border px-3">
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
                                                                    <input type="hidden" name="selfQuestionChoices[{{$question['id']}}][translations][]" value="{{ json_encode($selfChoicesTranslations) }}" />
                                                                </div>
                                                            @endforeach

                                                            @php $questionsIndex++; @endphp
                                                        @endforeach                    
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" name="save-draft-self-choices" class="btn btn-success">Save Draft</button>
                                    <button type="submit" name="publish-self-choices" class="btn btn-success">Publish</button>
                                </form>
                                {{-- Display Needs Assessment Transaltions Section --}}

                                @if(isset($needsAssessmentSurvey['choices']))
                                    <form id="needs-assesment-choices" class="mt-5" method="POST" action="{{ route('translations.save', ['editionId' => $editionId, 'lang' => $lang]) }}">
                                        <button type="submit" name="save-draft-needs-choices" class="btn btn-success">Save Draft</button>
                                        <button type="submit" name="publish-needs-choices" class="btn btn-success">Publish</button>
                                        @csrf
                                        <div class="accordion accordion-flush" id="selfAssessmentSectionAccordions">
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
                                                        @php $needsOldDetails = []; @endphp

                                                        @if(old('needsChoiceTitle'))
                                                            @php $needsOldDetails = old('needsChoiceTitle');  @endphp
                                                        @endif

                                                        @foreach($needsAssessmentSurvey['choices'] as $choiceIndex=>$choice)
                                                            @php 
                                                            $needsChoicesTranslations = !empty($choice['translations']) ? $choice['translations'] : [];
                                                            @endphp
                                                            <div class="row border py-3">
                                                                <div class="col-md-3"><h6>{{ $choice['title'] }}</h6></div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" name="needsChoiceTitle[]" value="{{ (!empty($needsOldDetails)) ? $needsOldDetails[$choiceIndex]  : ( (!empty($needsChoicesTranslations) && isset($needsChoicesTranslations[$lang]) ) ? $needsChoicesTranslations[$lang]['title'] : '') }}" required />
                                                                </div>
                                                                <input type="hidden" name="needsTranslations[]" value="{{ json_encode($needsChoicesTranslations) }}" />
                                                                <input type="hidden" name="needsChoicesId[]" value="{{ $choice['id'] }}" />
                                                            </div>
                                                        @endforeach  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="save-draft-needs-choices" class="btn btn-success">Save Draft</button>
                                        <button type="submit" name="publish-needs-choices" class="btn btn-success">Publish</button>
                                    </form>
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