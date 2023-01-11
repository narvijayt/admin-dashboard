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
    //
    protected $AssessmentEditions;
    protected $SelfAssessmentSurveys;
    protected $NeedsAssessmentSurveys;

    public function __construct(){
        $this->AssessmentEditions = new AssessmentEditions();
        $this->SelfAssessmentSurveys = new SelfAssessmentSurveys();
        $this->NeedsAssessmentSurveys = new NeedsAssessmentSurveys();
    }

    protected function index(){
        $data['response'] =  (new AssessmentEditions())->_getAssessmentEditions();
        $data['languages'] = se_languages();
        // dd($data);
        return view('translations.index', $data );
    }

    protected function edit($editionId, $lang){
        $selfAssessmentSurveys =  (new SelfAssessmentSurveys())->_getSelfAssessmentSurveys(['editionId' => $editionId, "query_string" => ["limit" => 1, "sort" => ["version" => "DESC"]] ]);
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

        $data['editionId'] = $editionId;
        $data['lang'] = $lang;

        $data['languages'] = se_languages();
        // pr($data); die;
        return view('translations.edit', $data );
    }
    
    /**
     * Store/Update Transaltion Details
     * 
     */
    protected function store(Request $request, $editionId, $lang){
        
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
                return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', $errors);
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
                        return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', $response['message']);
                    }
                }
            }
            return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->with('message', "Needs Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
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
                            return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', $response['message']);
                        }
                    }
                }
            }
            return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->with('message', "Self Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
        }
    }
}
