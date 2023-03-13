<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'dashboard', 'middleware' => 'hasAccessToken'], function () {

    // Manage Dashboard based URL Routes
    Route::group(['controller' => App\Http\Controllers\DashboardController::class], function () {
        Route::get('/blank', 'blank')->name('blank');
        Route::get('', 'index')->name('dashboard');
    });

    // Manage Translation rleated URL Routes
    Route::group(['prefix' => 'translations', 'controller' => App\Http\Controllers\TranslationController::class, 'as' => 'translations.'], function () {
        Route::get('', 'index')->name('index');
        Route::get('/surveys/{editionId}', 'EditionSurveys')->name('surveys');

        // Self and Needs Assessment Translations Routes
        Route::get('/create-survey/{editionId}/{surveyId}/{surveyType}', 'DuplicateSurvey')->name('duplicateSurvey');
        Route::get('/delete-survey/{editionId}/{surveyId}/{surveyType}', 'DeleteSurvey')->name('deleteSurvey');
        Route::get('/publish-survey/{editionId}/{surveyId}/{surveyType}', 'PublishSurvey')->name('publishSurvey');
        Route::get('/view/{surveyId}/{surveyType}', 'view')->name('view');
        Route::get('/edit/{surveyId}/{lang}/{surveyType}', 'edit')->name('edit');
        Route::post('/edit/{surveyId}/{lang}/{surveyType}', 'store')->name('save');


        // Graders Translation Routes
        Route::group(['prefix' => 'graders', 'as' => 'grader.'], function () {
            Route::get('/duplicate/{graderId}', 'graderDuplicate')->name('duplicate');
            Route::get('/publish/{graderId}', 'graderPublish')->name('publish');
            Route::get('/delete/{graderId}', 'graderDelete')->name('delete');
            Route::get('/view/{graderId}', 'graderView')->name('view');
            Route::get('/edit/{graderId}/{lang}', 'graderEdit')->name('edit');
            Route::post('/edit/{graderId}/{lang}', 'graderStore')->name('save');
        });
    });

    // Only Accessible to Admin Users
    Route::middleware(['admin'])->group(function () {
        // Users Routes
        Route::group(['prefix' => 'users', 'controller' => App\Http\Controllers\UsersController::class, 'as' => 'users.'], function () {
            Route::get('', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store')->name('store');
            Route::get('/edit/{userId}', 'edit')->name('edit');
        });

        // Participants Routes
        Route::group(['prefix' => 'participants', 'as' => 'participants.'], function () {
            Route::get('', [App\Http\Controllers\DashboardController::class, 'index'])->name('index');
        });
    });
});

// Guest Routes
Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::post('/', [App\Http\Controllers\Auth\AuthController::class, 'doLogin'])->name('dologin');
Route::get('logout', [App\Http\Controllers\Auth\AuthController::class,'logout'])->name('logout');
