<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

            Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

                //main dashboard route
                Route::get('/','WelcomeController@index')->name('welcome');

                //users route
                Route::resource('users','UserController')->except('show');

                //categories route
                Route::resource('categories','CategoryController')->except('show');

                //products route
                Route::resource('products','ProductController')->except('show');

                //clients route
                Route::resource('clients','ClientController')->except('show');

                //clients order route
                Route::resource('clients.order','Client\OrderController')->except('show');

                //orders route
                Route::resource('orders','OrderController')->except('show');

        });//end of dashboard routes

});


