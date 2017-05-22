<?php

namespace App\Http\Controllers;

use App\IpPhone;
use Illuminate\Http\Request;

class IpPhoneController extends Controller
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
      ['type' => 'text', 'field' => 'macaddr', 'desc' => 'MAC адрес'],
      ['type' => 'list', 'field' => 'phone', 'desc' => 'телефон'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    $pageParams = [];

    foreach (IpPhone::get() as $ip_phone) {
      array_push($pageParams, [
        'id' => $ip_phone->id,
        'macaddr' => $ip_phone->macaddr,
        'phone' => $ip_phone->phone->number,
        'active' => $ip_phone->active,
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
  * @param  \App\IpPhone  $ipPhone
  * @return \Illuminate\Http\Response
  */
  public function show(IpPhone $ipPhone)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\IpPhone  $ipPhone
  * @return \Illuminate\Http\Response
  */
  public function edit(IpPhone $ipPhone)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\IpPhone  $ipPhone
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, IpPhone $ipPhone)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\IpPhone  $ipPhone
  * @return \Illuminate\Http\Response
  */
  public function destroy(IpPhone $ipPhone)
  {
    //
  }
}
