<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json([
        'Creator' => [
            'Programmer' => 'Mice Ganda'
        ]
    ]);
});

Route::get('/testSms', 'MemberController@testSms');
Route::resource('Branch', 'BranchController');
Route::resource('Member', 'MemberController');
Route::get('getCountries', 'BranchController@getCountries');
Route::get('getCities', 'BranchController@getCities');
Route::get('getBarangays', 'BranchController@getBarangays');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::resource('Member', 'MemberController');
    Route::resource('Employee', 'EmployeeController');
    Route::resource('User', 'UserController');


    Route::get('member/subIndex/{branch_id}', 'MemberController@subIndex');

    Route::get('member/counter/{branch_id}', 'MemberController@counter');
    Route::post('member/accept', 'MemberController@approve');
    Route::post('member/reject', 'MemberController@reject');
    Route::get('member/getApprove/{branch_id}', 'MemberController@getApprove');
    Route::get('member/getRejected/{branch_id}', 'MemberController@getRejected');
    Route::get('member/getPending/{branch_id}', 'MemberController@getPending');



    Route::post('user/updateRoles', 'EmployeeController@updateRoles');
    Route::post('user/multipleFilter', 'EmployeeController@multipleFilter');

    Route::get('user/getRole/{id}', 'UserController@getRole');
    Route::post('user/ResetPassword', 'UserController@ResetPassword');

    Route::get('user/getUser/{email}', 'UserController@getUser');
    Route::get('getApplication/{type}/{approve_id}', 'UserController@getApplication');

    Route::post('UpdateBranch', 'BranchController@UpdateBranch');
    Route::post('UpdateMember', 'MemberController@UpdateMember');
    Route::post('UpdateUser', 'UserController@UpdateUser');
    Route::post('UpdateEmployee', 'EmployeeController@UpdateEmployee');
    Route::get('test', 'MemberController@testMail');


});
