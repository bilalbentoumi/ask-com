<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ {
    AdminLoginController,
    LoginController,
    RegisterController
};

use App\Http\Controllers\Admin\ {
    AdminsController,
    AnswersController,
    CategoriesController as AdminCategoriesController,
    HomeController as AdminHomeController,
    QuestionsController as AdminQuestionsController,
    ReportsController as AdminReportsController,
    SettingsController as AdminSettingsController,
    UsersController as AdminUsersController,
};

use App\Http\Controllers\User\ {
    CategoriesController,
    CommentsController,
    HomeController,
    NotificationsController,
    ProfileController,
    QuestionsController,
    ReportsController,
    SettingsController,
    SidebarController,
    TagsController,
    WizardController
};

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

Route::get('/', function () {
    return view('welcome');
});

/* Auth Routes */
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->middleware('status.check');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

});

/* Admin Routes */
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/login', [AdminLoginController::class, 'login'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'loginAdmin'])->name('admin.loginAdmin');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        Route::get('register', [AdminHomeController::class, 'create'])->name('admin.register');
        Route::post('register', [AdminHomeController::class, 'store'])->name('admin.register.store');
        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');
        Route::resource('/answers', AdminAnswersController::class);
        Route::resource('/admins', AdminsController::class);
        Route::resource('/users', AdminUsersController::class);
        Route::resource('/categories', AdminCategoriesController::class);
        Route::resource('/questions', AdminQuestionsController::class);
        Route::get('/search', [AdminHomeController::class, 'search'])->name('admin.search');

        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
        Route::put('/settings/update', [AdminSettingsController::class, 'update'])->name('admin.settings.update');

        Route::get('/reports', [AdminReportsController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}', [AdminReportsController::class, 'show'])->name('reports.show');
        Route::get('/reports/{id}/edit', [AdminReportsController::class, 'edit'])->name('reports.edit');
        Route::get('/reports/{id}/delete/{user?}', [AdminReportsController::class, 'delete'])->name('reports.delete');
        Route::delete('/reports/{id}/deleteReport', [AdminReportsController::class, 'deleteReport'])
            ->name('reports.deleteReport');

    });
});

/* User Routes */
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    /* Question */
    Route::get('/questions/show/{id}/{title?}', [QuestionsController::class, 'show'])->name('question.show');
    Route::get('/ask', [QuestionsController::class, 'create'])->name('user.questions.create');
    Route::post('/questions/store', [QuestionsController::class, 'store'])->name('user.questions.store');
    Route::get('/questions/{id}/edit', [QuestionsController::class, 'edit'])->name('user.questions.edit');
    Route::put('/questions/{id}/update', [QuestionsController::class, 'update'])->name('user.questions.update');
    Route::delete('/questions/{id}', [QuestionsController::class, 'destroy'])->name('user.questions.destroy');

    /* Questions */
    Route::get('/questions', [QuestionsController::class, 'latest'])->name('questions');

    /* All Newest */
    Route::get('/questions/newest', [HomeController::class, 'newest'])->name('questions.newest');
    Route::get('/questions/newest/data', [HomeController::class, 'newestData'])->name('questions.newest.data');

    /* By Interests */
    Route::get('/questions/interested', [HomeController::class, 'interested'])->name('questions.interested');
    Route::get('/questions/interested/data', [HomeController::class, 'interestedData'])
        ->name('questions.interested.data');

    /* Category */
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('/questions/{slug}', [CategoriesController::class, 'questions'])->name('questions.category');
    Route::get('/questions/category/data', [CategoriesController::class, 'questionsData'])
        ->name('questions.category.data');

    /* Tags */
    Route::get('/tags', [TagsController::class, 'index'])->name('tags');
    Route::get('/tags/{name}', [TagsController::class, 'questions'])->name('questions.tag');
    Route::get('/tags/category/data', [TagsController::class, 'questionsData'])->name('questions.tag.data');

    /* Answers */
    Route::post('/answers/store', [AnswersController::class, 'store'])->name('answers.store');
    Route::post('/answers/best', [AnswersController::class, 'best'])->name('answers.best');
    Route::post('/makeVote', [AnswersController::class, 'makeVote'])->name('makeVote');
    Route::post('/loadVotes', [AnswersController::class, 'loadVotes'])->name('loadVotes');
    Route::put('/answers/{id}/update', [AnswersController::class, 'update'])->name('user.answers.update');
    Route::delete('/answers/{id}', [AnswersController::class, 'destroy'])->name('user.answers.destroy');

    /* Comments */
    Route::post('/comments/store', [CommentsController::class, 'store'])->name('user.comments.store');
    Route::put('/comments/{id}/update', [CommentsController::class, 'update'])->name('user.comments.update');
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy'])->name('user.comments.destroy');

    /* Settings */
    Route::get('/settings', [SettingsController::class, 'general'])->name('settings.general');
    Route::put('/settings/general/update', [SettingsController::class, 'update_general'])
        ->name('settings.general.update');
    Route::get('/settings/changepass', [SettingsController::class, 'changepass'])->name('settings.changepass');
    Route::put('/settings/changepass/update', [SettingsController::class, 'update_password'])
        ->name('settings.password.update');
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile/update', [SettingsController::class, 'update_profile'])
        ->name('settings.profile.update');
    Route::get('/settings/myquestions', [SettingsController::class, 'myquestions'])->name('settings.myquestions');

    /* Wizard */
    Route::get('/wizard/step1', [WizardController::class, 'step1'])->name('wizard.step1');
    Route::get('/wizard/step2', [WizardController::class, 'step2'])->name('wizard.step2');
    Route::get('/wizard/step3', [WizardController::class, 'step3'])->name('wizard.step3');
    Route::post('/wizard/step1/store', [WizardController::class, 'step1_store'])->name('wizard.step1.store');
    Route::post('/wizard/step2/store', [WizardController::class, 'step2_store'])->name('wizard.step2.store');
    Route::post('/wizard/step3/store', [WizardController::class, 'step3_store'])->name('wizard.step3.store');


    /* Profile */
    Route::get('/profile/{user_id}', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/uploadPicture', [ProfileController::class, 'uploadPicture'])->name('profile.picture');
    Route::post('/profile/uploadCover', [ProfileController::class, 'uploadCover'])->name('profile.cover');

    /* Notifications */
    Route::get('/notifications/get', [NotificationsController::class, 'get'])->name('notifications.get');
    Route::post('/notifications/read', [NotificationsController::class, 'read'])->name('notifications.read');

    /* Sidebar */
    Route::get('/sidebar/topusers', [SidebarController::class, 'topUsers'])->name('sidebar.topusers');

    /* Search */
    Route::get('/search', [HomeController::class, 'search'])->name('user.search');

    /* Report */
    Route::post('/report/question', [ReportsController::class, 'reportQuestion'])->name('report.question');

    Route::get('/splash', [HomeController::class, 'splash'])->name('home.splash');

});
