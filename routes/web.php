<?php

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

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group([
    'middleware' => 'auth'
], function () {
Route::get('home', 'HomeController@index')->name('home');

/* -------------   Division Controller --------------- */
Route::get('divisions', 'DivisionController@index');
Route::get('add_division', 'DivisionController@add');
Route::post('add_division', 'DivisionController@insert');
Route::get('get_states', 'DivisionController@get_states');


/* -------------   User Controller --------------- */
Route::match(array('GET', 'POST'),'employees', 'UserController@index');
Route::get('add_employee', 'UserController@add');
Route::post('add_employee', 'UserController@insert_employee');
Route::get('get_employee_from_code', 'UserController@get_employee_from_code');
Route::get('set_skill_rating/{id}', 'UserController@set_skill_rating');
Route::get('save_skill_rating', 'UserController@save_skill_rating');
Route::get('edit_employee/{id}', 'UserController@edit');
Route::post('update_employee', 'UserController@update');
Route::match(array('GET', 'POST'),'monthly_contribtuion/{id}', 'UserController@add_contribtuion');
Route::get('save_contri_data', 'UserController@save_contri_data');
Route::get('save_roi_data', 'UserController@save_roi_data');
Route::get('get_open_bal', 'UserController@get_opening_bal');
Route::get('check_account_no', 'UserController@check_account_no');
Route::match(array('GET', 'POST'),'individual_report', 'UserController@indi_report');
Route::get('print_indi_view/{user_id}/{year}', 'UserController@print_indi_view');
Route::match(array('GET', 'POST'),'proof_sheet', 'UserController@proof_sheet');
Route::get('print_proof_sheet/{division_id}/{year}', 'UserController@print_proof_sheet');

});
