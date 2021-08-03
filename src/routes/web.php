<?php

use Illuminate\Support\Facades\Auth;

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    //Auth::routes();

    Route::get('login', [
        'as' => 'login',
        'uses' => 'Auth\LoginController@showLoginForm'
    ]);
    Route::post('login', [
        'as' => '',
        'uses' => 'Auth\LoginController@login',
        'middleware'    => 'checkstatus',
    ]);
    Route::post('logout', [
        'as' => 'logout',
        'uses' => 'Auth\LoginController@logout'
    ]);

    Route::get('register', [
        'as' => 'register',
        'uses' => 'Auth\RegisterController@showRegistrationForm'
    ]);
    Route::post('register', [
        'as' => '',
        'uses' => 'Auth\RegisterController@register'
    ]);

});


/* Admin Routes */
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/login', 'Auth\AdminLoginController@login')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@loginAdmin')->name('admin.loginAdmin');
        Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

        Route::group(['namespace' => 'Admin'], function () {
            Route::get('register', 'HomeController@create')->name('admin.register');
            Route::post('register', 'HomeController@store')->name('admin.register.store');
            Route::get('/', 'HomeController@index')->name('admin.home');
            Route::resource('/answers', 'AnswersController');
            Route::resource('/admins', 'AdminsController');
            Route::resource('/users', 'UsersController');
            Route::resource('/categories', 'CategoriesController');
            Route::resource('/questions', 'QuestionsController');
            Route::get('/search', 'HomeController@search')->name('admin.search');

            Route::get('/settings', 'SettingsController@index')->name('admin.settings');
            Route::put('/settings/update', 'SettingsController@update')->name('admin.settings.update');

            Route::get('/reports', 'ReportsController@index')->name('reports.index');
            Route::get('/reports/{id}', 'ReportsController@show')->name('reports.show');
            Route::get('/reports/{id}/edit', 'ReportsController@edit')->name('reports.edit');
            Route::get('/reports/{id}/delete/{user?}', 'ReportsController@delete')->name('reports.delete');
            Route::delete('/reports/{id}/deleteReport', 'ReportsController@deleteReport')->name('reports.deleteReport');
        });

    });
});

/* User Routes */
Route::group(['namespace' => 'User', 'prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/', 'HomeController@index')->name('home');

    /* Question */
    Route::get('/questions/show/{id}/{title?}', 'QuestionsController@show')->name('question.show');
    Route::get('/ask', 'QuestionsController@create')->name('user.questions.create');
    Route::post('/questions/store', 'QuestionsController@store')->name('user.questions.store');
    Route::get('/questions/{id}/edit', 'QuestionsController@edit')->name('user.questions.edit');
    Route::put('/questions/{id}/update', 'QuestionsController@update')->name('user.questions.update');
    Route::delete('/questions/{id}', 'QuestionsController@destroy')->name('user.questions.destroy');

    /* Questions */
    Route::get('/questions', 'QuestionsController@latest')->name('questions');

    /* All Newest */
    Route::get('/questions/newest', 'HomeController@newest')->name('questions.newest');
    Route::get('/questions/newest/data', 'HomeController@newestData')->name('questions.newest.data');

    /* By Interests */
    Route::get('/questions/interested', 'HomeController@interested')->name('questions.interested');
    Route::get('/questions/interested/data', 'HomeController@interestedData')->name('questions.interested.data');

    /* Category */
    Route::get('/categories', 'CategoriesController@index')->name('categories');
    Route::get('/questions/{slug}', 'CategoriesController@questions')->name('questions.category');
    Route::get('/questions/category/data', 'CategoriesController@questionsData')->name('questions.category.data');

    /* Tags */
    Route::get('/tags', 'TagsController@index')->name('tags');
    Route::get('/tags/{name}', 'TagsController@questions')->name('questions.tag');
    Route::get('/tags/category/data', 'TagsController@questionsData')->name('questions.tag.data');

    /* Answers */
    Route::post('/answers/store', 'AnswersController@store')->name('answers.store');
    Route::post('/answers/best', 'AnswersController@best')->name('answers.best');
    Route::post('/makeVote', 'AnswersController@makeVote')->name('makeVote');
    Route::post('/loadVotes', 'AnswersController@loadVotes')->name('loadVotes');
    Route::put('/answers/{id}/update', 'AnswersController@update')->name('user.answers.update');
    Route::delete('/answers/{id}', 'AnswersController@destroy')->name('user.answers.destroy');

    /* Comments */
    Route::post('/comments/store', 'CommentsController@store')->name('user.comments.store');
    Route::put('/comments/{id}/update', 'CommentsController@update')->name('user.comments.update');
    Route::delete('/comments/{id}', 'CommentsController@destroy')->name('user.comments.destroy');

    /* Settings */
    Route::get('/settings', 'SettingsController@general')->name('settings.general');
    Route::put('/settings/general/update', 'SettingsController@update_general')->name('settings.general.update');
    Route::get('/settings/changepass', 'SettingsController@changepass')->name('settings.changepass');
    Route::put('/settings/changepass/update', 'SettingsController@update_password')->name('settings.password.update');
    Route::get('/settings/profile', 'SettingsController@profile')->name('settings.profile');
    Route::put('/settings/profile/update', 'SettingsController@update_profile')->name('settings.profile.update');
    Route::get('/settings/myquestions', 'SettingsController@myquestions')->name('settings.myquestions');

    /* Wizard */
    Route::get('/wizard/step1', 'WizardController@step1')->name('wizard.step1');
    Route::get('/wizard/step2', 'WizardController@step2')->name('wizard.step2');
    Route::get('/wizard/step3', 'WizardController@step3')->name('wizard.step3');
    Route::post('/wizard/step1/store', 'WizardController@step1_store')->name('wizard.step1.store');
    Route::post('/wizard/step2/store', 'WizardController@step2_store')->name('wizard.step2.store');
    Route::post('/wizard/step3/store', 'WizardController@step3_store')->name('wizard.step3.store');


    /* Profile */
    Route::get('/profile/{user_id}', 'ProfileController@index')->name('profile');
    Route::post('/profile/uploadPicture', 'ProfileController@uploadPicture')->name('profile.picture');
    Route::post('/profile/uploadCover', 'ProfileController@uploadCover')->name('profile.cover');

    /* Notifications */
    Route::get('/notifications/get', 'NotificationsController@get')->name('notifications.get');
    Route::post('/notifications/read', 'NotificationsController@read')->name('notifications.read');

    /* Sidebar */
    Route::get('/sidebar/topusers', 'SidebarController@topUsers')->name('sidebar.topusers');

    /* Search */
    Route::get('/search', 'HomeController@search')->name('user.search');

    /* Report */
    Route::post('/report/question', 'ReportsController@reportQuestion')->name('report.question');



    Route::get('/splash', 'HomeController@splash')->name('home.splash');

});


