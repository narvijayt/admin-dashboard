@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $languages[$lang] }} Translations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right  mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.index') }}">Translations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.surveys', ['editionId' => $editionId]) }}">Edition Surveys</a></li>
                        <li class="breadcrumb-item active">Edit </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        
        </div><!-- /.container-fluid -->
    </div>
	
    <!-- /.content-header -->

    @include('layouts.includes.notices')

	@php $scoringEngineTemperaments = scoringEngineTemperaments(); @endphp
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">		
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Edit {{ ucfirst($surveyType) }} Assessment Translations</h5>
                        </div>
                        
                        <div class="card-body">
							@if(isset($selfAssessmentSurvey['sections']) && !empty($selfAssessmentSurvey['sections']))
								<!-- <h5 class="text-primary mt-2">{{ $selfAssessmentSurvey['title'] }}</h5> -->
								<div class="full-row">
									<form id="" class="mt-0" method="POST" action="{{ route('translations.save', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType]) }}">
										<div class="row align-items-center pb-3">
											<div class="form-group col-md-3">
												<label for="self-survey-version"><b>Version</b></label>
												<select class="form-control" id="self-survey-version" name="selfAssessmentVersion">
													@for($versionLoop=1;$versionLoop<= $selfAssessmentSurvey['version'];$versionLoop++)
														<option value="{{$versionLoop}}" {{($versionLoop == $selfAssessmentSurvey['version']) ? "selected" : ""}} >{{$versionLoop}}</option>
													@endfor
												</select>
											</div>
											<div class="form-group col-md-9">
												<div class="d-flex justify-content-end ">
													<button type="submit" name="save-draft-self-choices" class="btn btn-primary me-2" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
													<!-- <button type="submit" name="publish-self-choices" class="btn btn-success" value="publish"> <i class="fa-solid fa-floppy-disk"></i> Publish</button> -->
												</div>
											</div>
										</div>
										@csrf
										<div class="accordion" id="selfAssessmentSectionAccordions">
											@php $questionsIndex = 1; @endphp
											@foreach($selfAssessmentSurvey['sections'] as $sectionIndex=>$section)
												<div class="accordion-item">
													<h2 class="accordion-header" id="flush-sectionheading_{{$section['id']}}">
														<button class="accordion-button {{ $sectionIndex == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSection{{$section['id']}}" aria-expanded="{{ $sectionIndex == 0 ? 'true' : 'false' }}" aria-controls="flush-collapseSection{{$section['id']}}">
															{{ $section['title'] }}
														</button>
													</h2>
													<div id="flush-collapseSection{{$section['id']}}" class="accordion-collapse collapse {{ $sectionIndex == 0 ? 'show' : '' }}" aria-labelledby="flush-sectionheading_{{$section['id']}}" data-bs-parent="#selfAssessmentSectionAccordions">
														<div class="accordion-body px-5">
															<div class="row bg-light bg-light mb-2 p-2 border">
																<div class="col-md-3"><h5 class="mb-0">Temperament Type</h5></div>
																<div class="col-md-3"><h5 class="mb-0">English</h5></div>
																<div class="col-md-6"><h5  class="mb-0">{{ $languages[$lang]}} Translation</h5></div>
															</div>

															@php $questionsOldDetails = []; @endphp

															@if(old('selfQuestionChoices'))
																@php $questionsOldDetails = old('selfQuestionChoices');  @endphp
															@endif
															

															@foreach($section['questions'] as $question)
																<input type="hidden" name="question_id[]" value="{{ $question['id'] }}" />
																<div class="row bg-primary py-3">
																	<div class="col-md-12"><h5 class="mb-0 text-white">Question {{ $questionsIndex }}</h5></div>
																</div>
																
																@foreach($question['choices'] as $selfChoiceIndex=>$choice)
																	@php  $selfChoicesTranslations = !empty($choice['translations']) ? $choice['translations'] : []; @endphp
																	<input type="hidden" name="selfQuestionChoices[{{$question['id']}}][choice_id][]" value="{{ $choice['id'] }}" />
																	<div class="row border px-3 py-3">
																		<div class="col-md-3"><h6>{{ ucfirst(strtolower($choice['temperament']))." (".$scoringEngineTemperaments[$choice['temperament']].")" }}</h6></div>
																		<div class="col-md-3"><h6>{{ $choice['title'] }}</h6></div>
																		<div class="col-md-6">
																			<input type="text" class="form-control mb-2" name="selfQuestionChoices[{{$question['id']}}][choiceTitle][]" value="{{  (!empty($questionsOldDetails) && isset($questionsOldDetails[$question['id']])) ? $questionsOldDetails[$question['id']]['choiceTitle'][$selfChoiceIndex]  : ( (!empty($selfChoicesTranslations) && isset($selfChoicesTranslations[$lang]) ) ? $selfChoicesTranslations[$lang]['title'] : '') }}" />
																		</div>

																		<div class="col-md-3">&nbsp;</div>
																		<div class="col-md-3">
																			<strong>Description: </strong> 
																			<p class="mb-0">{{ $choice['description'] }}</p>
																		</div>
																		<div class="col-md-6">
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

										<div class="d-flex justify-content-end mt-3">                                    
											<button type="submit" name="save-draft-self-choices" class="btn btn-primary me-2" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
											<!-- <button type="submit" name="publish-self-choices" class="btn btn-success" value="publish"> <i class="fa-solid fa-floppy-disk"></i> Publish</button> -->
										</div>
									</form>
								</div>
							@endif	

							{{-- Display Needs Assessment Transaltions Section --}}
							@if(isset($needsAssessmentSurvey['choices']))
								<!-- <h5 class="text-primary mt-2">Needs Assessment Choices</h5> -->
								<div class="full-row">
									<form id="needs-assesment-choices" class="mt-0" method="POST" action="{{ route('translations.save', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType]) }}">
											
										<div class="row align-items-center pb-3">
											<div class="form-group col-md-3">
												<label for="needs-survey-version"><b>Version</b></label>
												<select class="form-control" id="needs-survey-version" name="needsAssessmentVersion">
													@for($versionLoop=1;$versionLoop<= $needsAssessmentSurvey['version'];$versionLoop++)
														<option value="{{$versionLoop}}" {{($versionLoop == $needsAssessmentSurvey['version']) ? "selected" : ""}} >{{$versionLoop}}</option>
													@endfor
												</select>
											</div>
											<div class="form-group col-md-9">
												<div class="d-flex justify-content-end mb-2">
													<button type="submit" name="save-draft-needs-choices" class="btn btn-primary me-2" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
													<!-- <button type="submit" name="publish-needs-choices" class="btn btn-success" value="publish"> <i class="fa-solid fa-floppy-disk"></i> Publish</button> -->
												</div>
											</div>
										</div>
										@csrf
										<div class="accordion " id="selfAssessmentSectionAccordions">
											<div class="accordion-item">
												<h2 class="accordion-header" id="flush-sectionheading_{{$needsAssessmentSurvey['id']}}">
													<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSection{{$needsAssessmentSurvey['id']}}" aria-expanded="true" aria-controls="flush-collapseSection{{$needsAssessmentSurvey['id']}}">
														{{ $needsAssessmentSurvey['title'] }}
													</button>
												</h2>
												<div id="flush-collapseSection{{$needsAssessmentSurvey['id']}}" class="accordion-collapse collapse show" aria-labelledby="flush-sectionheading_{{$needsAssessmentSurvey['id']}}" data-bs-parent="#selfAssessmentSectionAccordions">
													<div class="accordion-body px-5">
														<div class="row bg-light mb-2 p-2 border">
															<div class="col-md-3"><h5 class="mb-0">Temperament Type</h5></div>
															<div class="col-md-3"><h5>English</h5></div>
															<div class="col-md-6"><h5>{{ $languages[$lang]}} Translation</h5></div>
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
																<div class="col-md-3"><h6>{{ ucfirst(strtolower($choice['temperament']))." (".$scoringEngineTemperaments[$choice['temperament']].")" }}</h6></div>
																<div class="col-md-3"><h6>{{ $choice['title'] }}</h6></div>
																<div class="col-md-6">
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
										<div class="d-flex justify-content-end mb-2 mt-3">
											<button type="submit" name="save-draft-needs-choices" class="btn btn-primary me-2 save-draft-needs-choices" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
											<!-- <button type="submit" name="publish-needs-choices" class="btn btn-success publish-needs-choices" value="publish"> <i class="fa-solid fa-floppy-disk"></i> Publish</button> -->
										</div>
									</form>
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