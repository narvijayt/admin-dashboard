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
        $data['response'] =  $this->AssessmentEditions->_getAssessmentEditions();
        $data['languages'] = se_languages();
        // dd($data);
        return view('translations.index', $data );
    }

    protected function edit($editionId, $lang){
        $selfAssessmentSurveys =  $this->SelfAssessmentSurveys->_getSelfAssessmentSurveys(['editionId' => $editionId, "query_string" => ["limit" => 1, "sort" => ["version" => "DESC"]] ]);
        if(isset($selfAssessmentSurveys['data']) && !empty($selfAssessmentSurveys['data'])){
            foreach($selfAssessmentSurveys['data'] as $selfSurvey){
                if(empty($selfSurvey['publishedAt'])){
                    $data['selfAssessmentSurvey'] =  $this->SelfAssessmentSurveys->_getSelfAssessmentSurveys(["id" => $selfSurvey['id'] ]);
                    break;
                }              
            }

            if(!isset($data['selfAssessmentSurvey']) || empty($data['selfAssessmentSurvey'])){
                die("not Set");
                $newSelfAssessmentSurvey =  $this->SelfAssessmentSurveys->_createSelfAssessmentSurveys(["parentSurveyId" => $selfSurvey['id'] ]);
                if(isset($newSelfAssessmentSurvey['id'])){
                    $data['selfAssessmentSurvey'] =  $this->SelfAssessmentSurveys->_getSelfAssessmentSurveys(["id" => $newSelfAssessmentSurvey['id'] ]);
                }
            }
        }
        $needsAssessmentSurveys =  $this->NeedsAssessmentSurveys->_getNeedsAssessmentSurveys(['editionId' => $editionId]);
        if(isset($needsAssessmentSurveys['data']) && !empty($needsAssessmentSurveys['data'])){
            foreach($needsAssessmentSurveys['data'] as $needsSurvey){
                $data['needsAssessmentSurvey'] =  $this->NeedsAssessmentSurveys->_getNeedsAssessmentSurveys(["id" => $needsSurvey['id'] ]);
                break;
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
        
        // Update Needs Assessment Choices Translations
        $languages = se_languages();
        if($request->input('needsChoicesId')){
            foreach($request->input('needsChoicesId') as $choiceIndex=>$choiceId){
                $choiceArray = [
                    'id'    =>  $choiceId, 
                    'translations'  =>  $request->input('needsTranslations')[$choiceIndex]
                ];

                $choiceArray['translations']    =  [ 
                    $lang => [
                        "title" => $request->input('needsChoiceTitle')[$choiceIndex],
                        // "description" => $request->input('needsTranslations')[$choiceIndex],
                    ],
                ];
                // pr($choiceArray); die;
                $response = (new NeedsAssessmentChoices())->_updateNeedsAssessmentChoice($choiceArray);
                if(isset($response['message'])){
                    return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', $response['message']);
                }
            }
            return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->with('message', "Translations to ".$languages[$lang]. " has been updated successfully.");
        }

        // pr($request->input('selfQuestionChoices')); die;
        // Update Self Assessment Choices Translations
        if($request->input('selfQuestionChoices')){
            // return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', "Something went wrong. Please try again later.");

            foreach($request->input('selfQuestionChoices') as $questionId => $choiceDetails){
                foreach($choiceDetails['choice_id'] as $choiceIndex=>$choiceId){
                    
                    $choiceArray = [
                        'id'    =>  $choiceId, 
                        'translations'  =>  $choiceDetails['translations'][$choiceIndex]
                    ];

                    $choiceArray['translations']    =  [ 
                        $lang => [
                            "title" => $choiceDetails['choiceTitle'][$choiceIndex],
                            "description" => $choiceDetails['choiceDescription'][$choiceIndex],
                        ],
                    ];
                    
                    $response = (new SelfAssessmentChoices())->_updateSelfAssessmentChoice($choiceArray);
                    // pr($response); die;
                    if(isset($response['message'])){
                        return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->withInput()->with('error', $response['message']);
                    }
                }
            }
            return redirect()->route('translations.edit', ['editionId' => $editionId, 'lang' => $lang] )->with('message', "Translations to ".$languages[$lang]. " has been updated successfully.");
        }
    }
}
