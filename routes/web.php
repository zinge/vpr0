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

Route::get('/home', 'HomeController@index');

Route::resource('/spravochnik', 'SpravochnikController');

Route::resource('/address', 'AddressController');
Route::resource('/department', 'DepartmentController');
Route::resource('/employee', 'EmployeeController');
Route::resource('/equip', 'EquipController');
Route::resource('/equip-model', 'EquipModelController');
Route::resource('/equip-type', 'EquipTypeController');
Route::resource('/ip-phone', 'IpPhoneController');
Route::resource('/manufacturer', 'MannufacturerController');
Route::resource('/mobile-limit', 'MobileLimitController');
Route::resource('/mobile-phone', 'MobilePhoneController');
Route::resource('/mobile-type', 'MobileTypeController');
Route::resource('/phone', 'PhoneController');
Route::resource('/phone-type', 'PhoneTypeController');
Route::resource('/workplace', 'WorkplaceController');

Route::resource('/modal', 'ModalController');

route::get('/p1', function (){
  return view('p1');
});
