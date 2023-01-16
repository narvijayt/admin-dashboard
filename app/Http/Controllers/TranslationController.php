<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resources\AssessmentEditions;
use App\Resources\SelfAssessmentSurveys;
use App\Resources\SelfAssessmentChoices;
use App\Resources\NeedsAssessmentSurveys;
use App\Resources\NeedsAssessmentChoices;

class TranslationController extends Controller
{
    
    public function __construct(){
        
    }

    protected function index(){
        $data['response'] =  (new AssessmentEditions())->_getAssessmentEditions();
        // $data['languages'] = se_languages();
        // dd($data);
        return view('translations.index', $data );
    }
    
    protected function EditionSurveys($editionId = ''){
        $data['edition'] =  (new AssessmentEditions())->_getAssessmentEditions(['id' => $editionId]);
        $data['selfAssessmentSurveys'] =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(['editionId' => $editionId, "query_string" => ["sort" => ["version" => "DESC"]] ]);
        $data['needsAssessmentSurveys'] =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(['editionId' => $editionId]);
        $data['languages'] = se_languages();
        // dd($data);
        return view('translations.surveys', $data );
    }
    
    protected function DuplicateSurvey($editionId = '', $surveyId = '', $surveyType = ''){
        if(empty($surveyId) || empty($surveyType)){
            if(!empty($editionId)){
                return redirect()->route('translations.surveys', ['editionId' => $editionId])->with("error", "Invalid Request.");
            }else{
                return redirect()->route('translations')->with("error", "Invalid Request.");
            }
        }
        
        if($surveyType == "self"){
            $selfAssessmentSurvey =  (new SelfAssessmentSurveys())->_createSelfAssessmentSurveys(["parentSurveyId" => $surveyId ]);
        }else if($surveyType == "needs"){
            $needsAssessmentSurvey =  (new NeedsAssessmentSurveys())->_createNeedsAssessmentSurveys(["parentSurveyId" => $surveyId ]);
        }
        
        return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('message', "New ".ucfirst($surveyType).' Assessment Survey has been created successfully.');
    }

    protected function view($surveyId, $surveyType){
        if($surveyType == "self"){
            $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['selfAssessmentSurvey']['editionId'];
        }else if($surveyType == "needs"){
            $data['needsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['needsAssessmentSurvey']['editionId'];
        }

        $data['surveyType'] = $surveyType;
        $data['surveyId'] = $surveyId;
        $data['languages'] = se_languages();
        // pr($data); die;
        return view('translations.view', $data);
    }


    protected function edit($surveyId, $lang, $surveyType){
        /*$selfAssessmentSurveys =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(['editionId' => $editionId, "query_string" => ["limit" => 1, "sort" => ["version" => "DESC"]] ]);
        if(isset($selfAssessmentSurveys['data']) && !empty($selfAssessmentSurveys['data'])){
            foreach($selfAssessmentSurveys['data'] as $selfSurvey){
                if(empty($selfSurvey['versionLocked'])){
                    $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(["id" => $selfSurvey['id'] ]);
                    break;
                }              
            }

            if(!isset($data['selfAssessmentSurvey']) || empty($data['selfAssessmentSurvey'])){
                $newSelfAssessmentSurvey =  (new SelfAssessmentSurveys())->_createSelfAssessmentSurveys(["parentSurveyId" => $selfSurvey['id'] ]);
                if(isset($newSelfAssessmentSurvey['id'])){
                    $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(["id" => $newSelfAssessmentSurvey['id'] ]);
                }
            }
        }

        $needsAssessmentSurveys =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(['editionId' => $editionId]);
        if(isset($needsAssessmentSurveys['data']) && !empty($needsAssessmentSurveys['data'])){
            foreach($needsAssessmentSurveys['data'] as $needsSurvey){
                if(empty($needsSurvey['versionLocked'])){
                    $data['needsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(["id" => $needsSurvey['id'] ]);
                    break;
                }
            }

            if(!isset($data['needsAssessmentSurvey']) || empty($data['needsAssessmentSurvey'])){
                $newNeedsAssessmentSurvey =  (new NeedsAssessmentSurveys())->_createNeedsAssessmentSurveys(["parentSurveyId" => $needsSurvey['id'] ]);
                if(isset($newNeedsAssessmentSurvey['id'])){
                    $data['NeedsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(["id" => $newNeedsAssessmentSurvey['id'] ]);
                }
            }
        }
        */

        if($surveyType == "self"){
            $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(["id" => $surveyId ]);
        }else if($surveyType == "needs"){
            $data['needsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getNeedsAssessmentSurveys(["id" => $surveyId ]);
        }
        $data['surveyId'] = $surveyId;
        $data['lang'] = $lang;
        $data['surveyType'] = $surveyType;

        $data['languages'] = se_languages();
        // pr($data); die;
        return view('translations.edit', $data );
    }
    
    /**
     * Store/Update Transaltion Details
     * 
     */
    protected function store(Request $request, $surveyId, $lang, $surveyType){
        
        if($request->input('save-draft-self-choices')){
            $errors = [];
            foreach($request->input('selfQuestionChoices') as $questionId => $choiceDetails){
                foreach($choiceDetails['choice_id'] as $choiceIndex=>$choiceId){
                    if(!empty($choiceDetails['choiceTitle'][$choiceIndex]) && empty($choiceDetails['choiceDescription'][$choiceIndex])){
                        $errors["invalid_".str_replace("-","_", $choiceId)."_data"] = "Choice Description is required to update the translations.";
                    }
                    if(empty($choiceDetails['choiceTitle'][$choiceIndex]) && !empty($choiceDetails['choiceDescription'][$choiceIndex])){
                        $errors["invalid_".str_replace("-","_", $choiceId)."_data"] = "Choice Title is required to update the translations.";
                    }
                }
            }

            if(!empty($errors)){
                return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->withInput()->with('error', $errors);
            }
        }
        // Update Needs Assessment Choices Translations
        $languages = se_languages();
        // pr($request->all()); die;

        if($request->input('needsChoicesId')){            
            foreach($request->input('needsChoicesId') as $choiceIndex=>$choiceId){
                if(!empty($request->input('needsChoiceTitle')[$choiceIndex])){
                    $choiceArray = [
                        'id'    =>  $choiceId, 
                        'translations'  =>  (array) json_decode($request->input('needsTranslations')[$choiceIndex])
                    ];
                    
                    $choiceArray['translations'][$lang]    =   [
                        "title" => $request->input('needsChoiceTitle')[$choiceIndex],
                        // "description" => $request->input('needsTranslations')[$choiceIndex],
                    ];
                    // pr($choiceArray); die;
                    $response = (new NeedsAssessmentChoices())->_updateNeedsAssessmentChoice($choiceArray);
                    if(isset($response['message'])){
                        return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->withInput()->with('error', $response['message']);
                    }
                }
            }
            return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('message', "Needs Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
        }

        // pr($request->input('selfQuestionChoices')); die;
        // Update Self Assessment Choices Translations
        if($request->input('selfQuestionChoices')){
            foreach($request->input('selfQuestionChoices') as $questionId => $choiceDetails){
                foreach($choiceDetails['choice_id'] as $choiceIndex=>$choiceId){
                    if(!empty($choiceDetails['choiceTitle'][$choiceIndex]) && !empty($choiceDetails['choiceDescription'][$choiceIndex])){
                        $choiceArray = [
                            'id'    =>  $choiceId, 
                            'translations'  =>  (array) json_decode($choiceDetails['translations'][$choiceIndex])
                        ];
                        
                        $choiceArray['translations'][$lang]    =  [
                            "title" => $choiceDetails['choiceTitle'][$choiceIndex],
                            "description" => $choiceDetails['choiceDescription'][$choiceIndex],
                        ];
                        
                        $response = (new SelfAssessmentChoices())->_updateSelfAssessmentChoice($choiceArray);
                        // pr($response); die;
                        if(isset($response['message'])){
                            return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->withInput()->with('error', $response['message']);
                        }
                    }
                }
            }
            return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('message', "Self Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
        }
    }
}
