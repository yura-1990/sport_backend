<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllDataController;
use App\Http\Controllers\AllScoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\CheckUserController;
use App\Http\Controllers\DirectionCategoryController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DistrictEducationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\FillialController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasportController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\PortfolioUserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StatisticUserController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPdfController;
use App\Http\Controllers\WorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware("localization")->group(function () {
    Route::controller(PasportController::class)->group(function () {
        Route::get('/pasport', 'pasport');
        Route::get('/pasport/{pasport}', 'showPasport');
        Route::post('/pasport', 'storePasport');
        Route::put('/pasport/{pasport}/update', 'updatePasport');
        Route::delete('/pasport/{pasport}/delete', 'destroyPasport');
    });
    Route::controller(DirectionController::class)->group(function () {
        Route::get('/direction', 'direction');
        Route::get('/direction/{direction}', 'showDirection');
        Route::post('/direction', 'storeDirection');
        Route::put('/direction/{direction}/update', 'updateDirection');
        Route::delete('/direction/{id}/delete', 'destroyDirection');
    });
    Route::controller(AvatarController::class)->group(function () {
        Route::get('/avatar', 'avatar');
        Route::get('/avatar/{avatar}', 'showAvatar');
        Route::get('/avatarByUserId/{user_id}', 'showAvatarByUserId');
        Route::post('/avatar', 'storeAvatar');
        Route::put('/avatar/{avatar}/update', 'updateAvatar');
        Route::delete('/avatar/{id}/delete', 'destroyAvatar');
    });
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });
    Route::controller(EducationController::class)->group(function () {
        Route::get('/education', 'education');
        Route::get('/education/{education}', 'showEducation');
        Route::post('/education', 'storeEducation');
        Route::put('/education/{education}/update', 'updateEducation');
        Route::delete('/education/{education}/delete', 'destroyEducation');
    });

    Route::controller(CheckController::class)->group(function () {
        Route::get('/check', 'check');
        Route::get('/check/{check}', 'showCheck');
        Route::get('downloadPdf/{check_id}', 'downloadPdf');
        Route::post('/check', 'storeCheck');
        Route::post('/check/{check}/update', 'updateCheck');
        Route::delete('/check/{check}/delete', 'destroyCheck');
    });

    Route::controller(FillialController::class)->group(function () {
        Route::get('filial', 'filials');
    });

    Route::controller(PersonalInfoController::class)->group(function () {
        Route::get('/personal', 'personal');
        Route::get('/personal/{personalInfo}', 'showPersonal');
        Route::post('/personal', 'storePersonal');
        Route::put('/personal/{personalInfo}/update', 'updatePersonal');
        Route::delete('/personal/{personalInfo}/delete', 'destroyPersonal');
    });

    Route::controller(RegionController::class)->group(function () {
        Route::get('region', 'region');
    });

    Route::controller(TrainingController::class)->group(function () {
        Route::get('/training', 'training');
        Route::post('/training', 'storeTraining');
        Route::get('/training/{training}', 'showTraining');
        Route::put('/training/{training}/update', 'updateTraining');
        Route::delete('/training/{training}/delete', 'destroyTraining');
    });

    Route::controller(WorkController::class)->group(function () {
        Route::get('work', 'work');
        Route::get('work/{work}', 'showWork');
        Route::post('work', 'storeWork');
        Route::put('work/{work}/update', 'updateWork');
        Route::delete('work/{work}/delete', 'destroyWork');
    });

    Route::controller(AvatarController::class)->group(function () {
        Route::get('/avatar', 'avatar');
        Route::get('/avatar/{avatar}', 'showAvatar');
        Route::post('/avatar', 'storeAvatar');
        Route::put('/avatar/{avatar}/update', 'updateAvatar');
        Route::delete('/avatar/{id}/delete', 'destroyAvatar');
    });

    Route::controller(DirectionCategoryController::class)->group(function () {
        Route::get('directionCategory', 'direction_category');
    });

    Route::controller(AllDataController::class)->group(function () {
        Route::get('/allData', 'allData');
        Route::get('/allData/{id}', 'showAllData');
    });

    Route::controller(UserPdfController::class)->group(function () {
        Route::get('userPdf', 'user_pdf');
        Route::get('userPdf/{userPdf}', 'showUserPdf');
        Route::post('userPdf', 'storeUserPdf');
        Route::put('userPdf/{userPdf}/update', 'updateUserPdf');
        Route::delete('userPdf/{id}/delete', 'destroyUserPdf');
    });
    Route::put('/forgot-password/{pnfl}', [AuthController::class, 'forgotPassword']);

    Route::get('/reset-password', [AuthController::class, 'resetPasswordLoad']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::controller(EvaluateController::class)->group(function () {
        Route::get('/evaluate/{user_id}', 'evaluate');
        Route::get('/direction_user/{direction_id}', 'countDirectionUser');
        Route::get('/direction_with_user/{direction_id}', 'directionWithUser');
        Route::get('/user_in_direction/{user_id}', 'userInDirection');
        Route::get('/downloadpdf/{user_id}', 'download');
        Route::get('/userInfo/{direction_id}/export', 'userInfoExport');
        Route::get('/oneUserInfo/{user_id}/export', 'oneUserInfo');
        Route::post('/evaluateCheck/{check_id}/update', 'updateEvaluateChecks');
    });

    Route::controller(AllScoreController::class)->group(function () {
        Route::get('allScore', 'allScore');
        Route::post('allScore', 'storeAllScore');
        Route::get('allScore/{allScore}', 'showAllScore');
        Route::put('allScore/{allScore}/update', 'updateAllScore');
        Route::delete('allScore/{allScore}/delete', 'destroyAllScore');
        Route::get('allScoreWithUserId/{user_id}', 'userScore');
    });
    Route::controller(CheckUserController::class)->group(function () {
        Route::get('/checkUser', 'checkUser');
        Route::get('/checkUser/{checkUser}', 'showCheckUser');
        Route::get('/checkUserById/{user_id}', 'getCheckUser');
        Route::post('/checkUser', 'storeCheckUser');
        Route::put('/checkUser/{checkUser}/update', 'updateCheckUser');
        Route::delete('/checkUser/{checkUser}/delete', 'destroyCheckUser');
    });

    Route::controller(StatisticUserController::class)->group(function () {
        Route::get('/statisticUser', 'statisticUser');
        Route::get('/statisticUser/{statisticUser}', 'showStatisticUser');
        Route::get('/statisticUserById/{user_id}', 'getStatisticUser');
        Route::post('/statisticUser', 'storeStatisticUser');
        Route::put('/statisticUser/{statisticUser}/update', 'updateStatisticUser');
        Route::delete('/statisticUser/{statisticUser}/delete', 'destroyStatisticUser');
    });

    Route::controller(\App\Http\Controllers\EducationNameController::class)->group(function (){
        Route::get('educationname', 'educationName');
    });

    Route::controller(\App\Http\Controllers\WorkPlaceController::class)->group(function (){
        Route::get('workplace', 'workPlace');
    });

    Route::controller(PortfolioUserController::class)->group(function () {
        Route::get('/portfolioUser', 'portfolioUser');
        Route::get('/portfolioUser/{portfolioUser}', 'showPortfolioUser');
        Route::get('/portfolioUserById/{user_id}', 'getPortfolioUser');
        Route::post('/portfolioUser', 'storePortfolioUser');
        Route::put('/portfolioUser/{portfolioUser}/update', 'updatePortfolioUser');
        Route::delete('/portfolioUser/{portfolioUser}/delete', 'destroyPortfolioUser');
    });
});

Route::controller(UniversityController::class)->group(function () {
    Route::get('/university', 'university');
    Route::get('/university/{university}', 'showUniversity');
    Route::post('/university', 'storeUniversity');
    Route::put('/university/{university}/update', 'updateUniversity');
    Route::delete('/university/{university}/delete', 'destroyUniversity');
});

Route::controller(DistrictEducationController::class)->group(function () {
    Route::get('/district', 'districtEducation');
    Route::get('/district/{districtEducation}', 'showDistrictEducation');
    Route::post('/district', 'storeDistrictEducation');
    Route::put('/district/{districtEducation}/update', 'updateDistrictEducation');
    Route::delete('/district/{districtEducation}/delete', 'destroyDistrictEducation');
});

Route::controller(AdminController::class)->prefix('admins')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'delete');
});

Route::controller(HomePageController::class)->prefix('home-pages')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{homePage}', 'show');
    Route::put('/{homePage}', 'update');
    Route::delete('/{homePage}', 'delete');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index');
    Route::get('/export', 'export');
    Route::post('/import', 'import');
});

Route::controller(NotificationController::class)->prefix('notifications')->group(function () {
    Route::get('/', 'index');
    Route::get('/all', 'all');
    Route::get('/{notification}', 'show');
});

