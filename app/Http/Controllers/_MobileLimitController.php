<?php

namespace App\Http\Controllers;

use App\MobileLimit;
use Illuminate\Http\Request;

class MobileLimitController extends Controller
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
      ['type' => 'text', 'field' => 'limit_cost', 'desc' => 'лимит'],
    ];

    return [
      'pageParams' => MobileLimit::get(['id','limit_cost']),
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
  * @param  \App\MobileLimit  $mobileLimit
  * @return \Illuminate\Http\Response
  */
  public function show(MobileLimit $mobileLimit)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobileLimit  $mobileLimit
  * @return \Illuminate\Http\Response
  */
  public function edit(MobileLimit $mobileLimit)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobileLimit  $mobileLimit
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobileLimit $mobileLimit)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobileLimit  $mobileLimit
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobileLimit $mobileLimit)
  {
    //
  }
}
