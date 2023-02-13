<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resources\AssessmentEditions;
use App\Resources\SelfAssessmentSurveys;
use App\Resources\SelfAssessmentChoices;
use App\Resources\NeedsAssessmentSurveys;
use App\Resources\NeedsAssessmentChoices;
use App\Resources\Batch;

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
        $data['selfAssessmentSurveys'] =  (new SelfAssessmentSurveys())->_getAssessmentSurveys(['editionId' => $editionId, "query_string" => ["sort" => ["version" => "DESC"]] ]);
        $data['needsAssessmentSurveys'] =  (new NeedsAssessmentSurveys())->_getAssessmentSurveys(['editionId' => $editionId]);
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
            $editionSurvey =  new SelfAssessmentSurveys();
        }else{
            $editionSurvey =  new NeedsAssessmentSurveys();
        }

        $response =  $editionSurvey->_createAssessmentSurveys(["parentSurveyId" => $surveyId ]);
        if(isset($response['message'])){
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('error', $response['message']);    
        }
        
        return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('message', "New ".ucfirst($surveyType).' Assessment Survey has been created successfully.');
    }

    protected function view($surveyId, $surveyType){
        if($surveyType == "self"){
            $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['selfAssessmentSurvey']['editionId'];
        }else if($surveyType == "needs"){
            $data['needsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['needsAssessmentSurvey']['editionId'];
        }

        $data['surveyType'] = $surveyType;
        $data['surveyId'] = $surveyId;
        $data['languages'] = se_languages();
        // pr($data); die;
        return view('translations.view', $data);
    }


    protected function edit($surveyId, $lang, $surveyType){

        if($surveyType == "self"){
            $data['selfAssessmentSurvey'] =  (new SelfAssessmentSurveys())->_getAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['selfAssessmentSurvey']['editionId'];
        }else if($surveyType == "needs"){
            $data['needsAssessmentSurvey'] =  (new NeedsAssessmentSurveys())->_getAssessmentSurveys(["id" => $surveyId ]);
            $data['editionId'] = $data['needsAssessmentSurvey']['editionId'];
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
            $batchObject = [];
            foreach($request->input('needsChoicesId') as $choiceIndex=>$choiceId){
                if(!empty($request->input('needsChoiceTitle')[$choiceIndex])){

                    $translations = (array) json_decode($request->input('needsTranslations')[$choiceIndex]);
                    $translations[$lang] = [
                        "title" => $request->input('needsChoiceTitle')[$choiceIndex],
                    ];

                    $batchObject[] = [
                        'method'    =>  'update',
                        'route'    =>  'needsAssessmentChoicess',
                        'id'    =>  $choiceId,
                        'query'    =>  [
                            'translations'  =>  $translations
                        ],
                    ];
                }
            }

            $updateCounter = $errorCounter = '';
            if(!empty($batchObject)){
                $data['calls'] = $batchObject;
                $response = (new Batch())->_batchRequest($data);
                if(!empty($response)){
                    foreach($response as $row){
                        if($row['status'] == "fulfilled"){
                            $updateCounter++;
                        }else if($row['status'] == "rejected"){
                            $errorCounter++;
                            $responseData['errors'][] = $row['reason']['message'];
                        }
                    }
                }
            }
            if(!empty($errorCounter)){
                return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('error', $responseData['errors']);
            }else{
                return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('message', "Needs Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
            }
        }

        // pr($request->input('selfQuestionChoices')); die;
        // Update Self Assessment Choices Translations
        if($request->input('selfQuestionChoices')){
            foreach($request->input('selfQuestionChoices') as $questionId => $choiceDetails){
                foreach($choiceDetails['choice_id'] as $choiceIndex=>$choiceId){
                    if(!empty($choiceDetails['choiceTitle'][$choiceIndex]) && !empty($choiceDetails['choiceDescription'][$choiceIndex])){
                        
                        $translations = (array) json_decode($choiceDetails['translations'][$choiceIndex]);
                        $translations[$lang] = [
                            "title" => $choiceDetails['choiceTitle'][$choiceIndex],
                            "description" => $choiceDetails['choiceDescription'][$choiceIndex],
                        ];

                        $batchObject[] = [
                            'method'    =>  'update',
                            'route'    =>  'selfAssessmentChoices',
                            'id'    =>  $choiceId,
                            'query'    =>  [
                                'translations'  =>  $translations
                            ],
                        ];
                    }
                }
            }

            $updateCounter = $errorCounter = '';
            if(!empty($batchObject)){
                $data['calls'] = $batchObject;
                $response = (new Batch())->_batchRequest($data);
                if(!empty($response)){
                    foreach($response as $row){
                        if($row['status'] == "fulfilled"){
                            $updateCounter++;
                        }else if($row['status'] == "rejected"){
                            $errorCounter++;
                            $responseData['errors'][] = $row['reason']['message'];
                        }
                    }
                }
            }

            if(!empty($errorCounter)){
                return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('error', $responseData['errors']);
            }else{
                return redirect()->route('translations.edit', ['surveyId' => $surveyId, 'lang' => $lang, 'surveyType' => $surveyType] )->with('message', "Self Assessment Choices Translations has been updated to ".$languages[$lang]. " language successfully.");
            }
        }
    }


    protected function DeleteSurvey($editionId = '', $surveyId = '', $surveyType = ''){
        if(empty($surveyId) || empty($surveyType)){
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('error', "Invalid Request! Please try again.");
        }
        

        if($surveyType == "self"){
            $editionSurvey =  new SelfAssessmentSurveys();
        }else{
            $editionSurvey =  new NeedsAssessmentSurveys();
        }
        
        $response =  $editionSurvey->_deleteAssessmentSurveys(["id" => $surveyId ]);
        if(isset($response['message'])){
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('error', $response['message']);
        }else{
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('message', ucfirst($surveyType)." Assessment Survey has been removed successfully.");
        }
    }
    
    protected function PublishSurvey($editionId = '', $surveyId = '', $surveyType = ''){
        if(empty($surveyId) || empty($surveyType)){
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('error', "Invalid Request! Please try again.");
        }
        
        if($surveyType == "self"){
            $editionSurvey =  new SelfAssessmentSurveys();
        }else{
            $editionSurvey =  new NeedsAssessmentSurveys();
        }

        $response =  $editionSurvey->_updateAssessmentSurveys(["id" => $surveyId, 'versionLocked' => 1, 'publishedAt' => date("c") ]);
        if(isset($response['message'])){
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('error', $response['message']);
        }else{
            return redirect()->route('translations.surveys', ['editionId' => $editionId])->with('message', ucfirst($surveyType)." Assessment Survey has been published successfully.");
        }
    }
}
