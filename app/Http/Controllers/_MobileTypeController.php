<?php

namespace App\Http\Controllers;

use App\MobileType;
use Illuminate\Http\Request;

class MobileTypeController extends Controller
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
      ['type' => 'text', 'field' => 'name', 'desc' => 'тип'],
    ];

    return [
      'pageParams' => MobileType::get(['id','name']),
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
  * @param  \App\MobileType  $mobileType
  * @return \Illuminate\Http\Response
  */
  public function show(MobileType $mobileType)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobileType  $mobileType
  * @return \Illuminate\Http\Response
  */
  public function edit(MobileType $mobileType)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobileType  $mobileType
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobileType $mobileType)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobileType  $mobileType
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobileType $mobileType)
  {
    //
  }
}
