<?php

Route::group([
    'prefix' => '',
    'namespace' => 'Cms\Modules\Core\Controllers',
    'middleware' => 'web',
], function() {
    Route::get('/', 'CoreController@welcome')->name('core.welcome');

    Route::group([
        'middleware' => ['auth', 'cms.verified']
    ], function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });

    Route::group([
        'namespace' => 'Auth',
    ], function () {
        Route::group([
            'middleware' => 'cms.guest',
        ], function () {
            Route::get('login', 'LoginController@showLoginForm')->name('login');
            Route::post('login', 'LoginController@login');

            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');

            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        });
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
        Route::group(['middleware' => ['auth']], function () {
            //ACCOUNT
            Route::group(['prefix' => 'account'], function () {
                Route::get('/', 'AccountController@index')->name('admin.account.index');
                Route::get('create', 'AccountController@create')->name('admin.account.create')->middleware(['role:manager']);;
                Route::post('create', 'AccountController@store')->name('admin.account.store');
                Route::get('edit/{id}', 'AccountController@edit')->name('admin.account.edit');
                Route::put('update/{id}', 'AccountController@update')->name('admin.account.update');
                Route::delete('delete/{id}', 'AccountController@delete')->name('admin.account.delete')->middleware(['role' => 'admin']);
            });

            //ORDER
            Route::group(['prefix' => 'order'], function () {
                Route::get('/', 'OrderController@index')->name('admin.order.index');
                Route::get('create', 'OrderController@create')->name('admin.order.create')->middleware(['role:manager']);
                Route::post('create', 'OrderController@store')->name('admin.order.store');
                Route::get('edit/{id}', 'OrderController@edit')->name('admin.order.edit');
                Route::put('update/{id}', 'OrderController@update')->name('admin.order.update');
                Route::delete('delete/{id}', 'OrderController@delete')->name('admin.order.delete')->middleware(['role' => 'admin']);
            });

            //USER
            Route::group(['prefix' => 'user', 'middleware' => ['role:admin']], function () {
                Route::get('/', 'UserController@index')->name('admin.user.index');
                Route::get('create', 'UserController@create')->name('admin.user.create');
                Route::post('create', 'UserController@store')->name('admin.user.store');
                Route::get('edit/{id}', 'UserController@edit')->name('admin.user.edit');
                Route::put('update/{id}', 'UserController@update')->name('admin.user.update');
                Route::delete('delete/{id}', 'UserController@delete')->name('admin.user.delete');
            });
        });
    });
});
