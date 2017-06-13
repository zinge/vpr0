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

// Route::resource('/spravochnik', 'SpravochnikController');

Route::resource('/address', 'AddressController');
Route::resource('/department', 'DepartmentController');
Route::resource('/employee', 'EmployeeController');
Route::resource('/equip', 'EquipController');
Route::resource('/equipmodel', 'EquipModelController');
Route::resource('/equiptype', 'EquipTypeController');
Route::resource('/manufacturer', 'ManufacturerController');
Route::resource('/ipphone', 'IpPhoneController');
Route::resource('/mobilelimit', 'MobileLimitController');
Route::resource('/mobilephone', 'MobilePhoneController');
Route::resource('/mobiletype', 'MobileTypeController');
Route::resource('/phone', 'PhoneController');
Route::resource('/phonetype', 'PhoneTypeController');
Route::resource('/phoneowner', 'PhoneOwnerController');
Route::resource('/workplace', 'WorkplaceController');

// Route::resource('/modal', 'ModalController');
Route::resource('/finposition', 'FinpositionController');
Route::resource('/service', 'ServiceController');
Route::resource('/agreement', 'AgreementController');
Route::resource('/contractor', 'ContractorController');
