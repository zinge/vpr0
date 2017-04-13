<?php

namespace App\Http\Controllers;

use App\MobilePhone;
use Illuminate\Http\Request;

class MobilePhoneController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    $pageSruture = [
      ['type' => 'text', 'field' => 'number', 'desc' => 'номер'],
      ['type' => 'list', 'field' => 'employee_id', 'desc' => 'сотрудник'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    $pageParams = [];

    foreach (MobilePhone::get() as $phone) {
      array_push($pageParams, [
        'id' => $phone->id,
        'number' => $phone->number,
        'employee_id' => $phone->employee_id,
        'active' => $phone->active,
      ]);
    }

    return [
      'pageParams' => $pageParams,
      'pageSruture' => $pageSruture
    ];
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\MobilePhone  $mobilePhone
  * @return \Illuminate\Http\Response
  */
  public function show(MobilePhone $mobilePhone)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobilePhone  $mobilePhone
  * @return \Illuminate\Http\Response
  */
  public function edit(MobilePhone $mobilePhone)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobilePhone  $mobilePhone
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobilePhone $mobilePhone)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobilePhone  $mobilePhone
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobilePhone $mobilePhone)
  {
    //
  }
}
