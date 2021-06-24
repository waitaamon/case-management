<?php

use Illuminate\Support\Facades\Route;

Route::get('test', fn() => \App\Jobs\GenerateSystemEvents::dispatch());

Route::get('/', fn () =>  redirect('login'));

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::resource('cases', \App\Http\Controllers\CaseController::class)->only('index', 'show');
    Route::resource('users', \App\Http\Controllers\UserController::class)->only('index', 'show', 'update');

    //API
    Route::group(['prefix' => 'api'], function() {

        Route::get('cases-prerequisites', [\App\Http\Controllers\Api\CasesController::class, 'prerequisites']);
        Route::apiResource('legal-cases', \App\Http\Controllers\Api\CasesController::class)->except('destroy');

        Route::post('publish-cases', \App\Http\Controllers\PublishCaseController::class);
        Route::post('assign-judicial-officer', \App\Http\Controllers\AssignJudicialOfficerController::class);
    });
});

require __DIR__.'/auth.php';
