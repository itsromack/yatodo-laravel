<?php
Route::group([
    'prefix' => 'api',
], function() {

    // TASKS
    Route::group([
        'prefix' => 'tasks'
    ], function() {
        Route::get('/', 'TasksController@fetchAll');
        Route::get('/{id}', 'TasksController@fetchOne');
        Route::get('/lists/{owner_id}', 'TasksController@fetchByOwner');
        Route::post('/', 'TasksController@saveTask');
        Route::post('/update', 'TasksController@updateTask');

        Route::group([
            'prefix' => 'complete'
        ], function() {
            Route::post('/', 'TasksController@completeTask');
            Route::post('/negate', 'TasksController@negateCompleteTask');
        });

        Route::group([
            'prefix' => 'delete'
        ], function() {
            Route::post('/', 'TasksController@removeTask');
        });
    });

    Route::group([
        'prefix' => 'network'
    ], function() {
        Route::get('all', 'NetworkController@all');
        Route::get('friends', 'NetworkController@friends');
    });
});
