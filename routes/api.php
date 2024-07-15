<?php

use Illuminate\Support\Facades\Route;


//route login
Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'index']);

//group route with middleware "auth"
Route::group(['middleware' => 'auth:api'], function () {

    //logout
    Route::post('/logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
});

//group route with prefix "admin"
Route::prefix('admin')->group(function () {
    //group route with middleware "auth:api"
    Route::group(['middleware' => 'auth:api'], function () {
        //dashboard
        Route::get('/dashboard', App\Http\Controllers\Api\Admin\DashboardController::class);

        //permissions
        Route::get('/permissions', [\App\Http\Controllers\Api\Admin\PermissionController::class, 'index'])
            ->middleware('permission:permissions.index');

        //permissions all
        Route::get('/permissions/all', [\App\Http\Controllers\Api\Admin\PermissionController::class, 'all'])
            ->middleware('permission:permissions.index');

        //roles all
        Route::get('/roles/all', [\App\Http\Controllers\Api\Admin\RoleController::class, 'all'])
            ->middleware('permission:roles.index');

        //roles
        Route::apiResource('/roles', App\Http\Controllers\Api\Admin\RoleController::class)
            ->middleware('permission:roles.index|roles.store|roles.update|roles.delete');

        //users
        Route::apiResource('/users', App\Http\Controllers\Api\Admin\UserController::class)
            ->middleware('permission:users.index|users.store|users.update|users.delete');

        //categories all
        Route::get('/categories/all', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'all'])
            ->middleware('permission:categories.index');

        //Categories
        Route::apiResource('/categories', App\Http\Controllers\Api\Admin\CategoryController::class)
            ->middleware('permission:categories.index|categories.store|categories.update|categories.delete');


        //Posts
        Route::apiResource('/posts', App\Http\Controllers\Api\Admin\PostController::class)
            ->middleware('permission:posts.index|posts.store|posts.update|posts.delete');


        //Photos
        Route::apiResource('/photos', App\Http\Controllers\Api\Admin\PhotoController::class, ['except' => ['create', 'show', 'update']])
            ->middleware('permission:photos.index|photos.store|photos.delete');

        //Sliders
        Route::apiResource('/sliders', App\Http\Controllers\Api\Admin\SliderController::class, ['except' => ['create', 'show', 'update']])
            ->middleware('permission:sliders.index|sliders.store|sliders.delete');

        //Events
        Route::apiResource('/events', App\Http\Controllers\Api\Admin\EventController::class)
            ->middleware('permission:events.index|events.store|events.update|events.delete');

        //events all
        Route::get('/events-all', [\App\Http\Controllers\Api\Admin\EventController::class, 'all'])
            ->middleware('permission:events.index');

        //Event Categories
        Route::apiResource('/event-categories', App\Http\Controllers\Api\Admin\EventCategoryController::class)
            ->middleware('permission:event_categories.index|event_categories.store|event_categories.update|event_categories.delete');

        //events Categories all
        Route::get('/event-categories-all', [\App\Http\Controllers\Api\Admin\EventCategoryController::class, 'all'])
            ->middleware('permission:event_categories.index');

        //Event Jerseys
        Route::apiResource('/event-jerseys', App\Http\Controllers\Api\Admin\EventJerseyController::class)
            ->middleware('permission:event_jerseys.index|event_jerseys.store|event_jerseys.update|event_jerseys.delete');

        //events Jerseys all
        Route::get('/event-jerseys-all', [\App\Http\Controllers\Api\Admin\EventJerseyController::class, 'all'])
            ->middleware('permission:event_jerseys.index');

        //Event Members
        Route::apiResource('/event-members', App\Http\Controllers\Api\Admin\EventMemberController::class)
            ->middleware('permission:event_members.index|event_members.store|event_members.update|event_members.delete');
    });
});

//group route with prefix "public"
Route::prefix('public')->group(function () {

    //index posts
    Route::get('/posts', [App\Http\Controllers\Api\Public\PostController::class, 'index']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\Public\PostController::class, 'show']);
    //index posts home
    Route::get('/posts_home', [App\Http\Controllers\Api\Public\PostController::class, 'homePage']);
    //index photos
    Route::get('/photos', [App\Http\Controllers\Api\Public\PhotoController::class, 'index']);
    //index sliders
    Route::get('/sliders', [App\Http\Controllers\Api\Public\SliderController::class, 'index']);
    //events all
    Route::get('/events-all', [\App\Http\Controllers\Api\Public\EventController::class, 'all']);
    //events Categories all
    Route::get('/event-categories-all', [\App\Http\Controllers\Api\Public\EventCategoryController::class, 'all']);
    //events Jerseys all
    Route::get('/event-jerseys-all', [\App\Http\Controllers\Api\Public\EventJerseyController::class, 'all']);
    //events store member
    Route::post('/event-members-store', [\App\Http\Controllers\Api\Public\EventMemberController::class, 'store']);
});
