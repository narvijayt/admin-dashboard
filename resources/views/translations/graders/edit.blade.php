@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $grader['title'].' '.$lang }} Translation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right  mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.index') }}">Translations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('translations.surveys', ['editionId' => $grader['editionId']]) }}">Edition</a></li>
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
                            <h5 class="mb-0">Edit {{ $grader['title'].' '.$lang }} Translation</h5>
                        </div>
                        
                        <div class="card-body">
							@if(isset($patterns['data']) && !empty($patterns['data']))
								<div class="full-row">
									<form id="" class="mt-0" method="POST" action="{{ route('translations.grader.save', ['graderId' => $grader['id'], 'lang' => $lang]) }}">
										<div class="row align-items-center pb-3">
											<div class="form-group col-md-3">
												<label for="grader-version"><b>Version</b></label>
												<select class="form-control" id="grader-version" name="graderVersion">
													@for($versionLoop=1;$versionLoop<= $grader['version'];$versionLoop++)
														<option value="{{$versionLoop}}" {{($versionLoop == $grader['version']) ? "selected" : ""}} >{{$versionLoop}}</option>
													@endfor
												</select>
											</div>
											<div class="form-group col-md-9">
												<div class="d-flex justify-content-end ">
													<button type="submit" name="save-draft-grader-patterns" class="btn btn-primary me-2" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
												</div>
											</div>
										</div>
										@csrf

                                        <div class="row bg-light bg-light mb-2 p-2 border">
                                            <div class="col-md-6"><h5 class="mb-0">English</h5></div>
                                            <div class="col-md-6"><h5  class="mb-0">{{ $languages[$lang]}} Translation</h5></div>
                                        </div>
										@foreach($patterns['data'] as $index=>$pattern)

                                            @php $patternOldDetails = []; @endphp

                                            @if(old('title'))
                                                @php $patternOldDetails = old('title');  @endphp
                                            @endif
											
                                            @php  $assessmentPatternTranslations = !empty($pattern['translations']) ? $pattern['translations'] : []; @endphp
                                            <div class="row border px-3 py-3">
                                                <div class="col-md-6"><h6>{{ $pattern['title'] }}</h6></div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control mb-2" name="title[]" value="{{ (!empty($patternOldDetails)) ? $patternOldDetails[$index]  : ( (!empty($assessmentPatternTranslations) && isset($assessmentPatternTranslations[$lang]) ) ? $assessmentPatternTranslations[$lang]['title'] : '') }}" />
                                                </div>
                                                
                                                <input type="hidden" name="patternsId[]" value="{{ $pattern['id'] }}" />
                                                <input type="hidden" name="patternTranslations[]" value="{{ json_encode($assessmentPatternTranslations) }}" />
                                            </div>																
										@endforeach
										

										<div class="d-flex justify-content-end mt-3">                                    
											<button type="submit" name="save-draft-self-choices" class="btn btn-primary me-2" value="save"> <i class="fa-solid fa-floppy-disk"></i> Save Draft</button>
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