<?php

namespace App\Http\Controllers;

use App\EquipType;
use Illuminate\Http\Request;

class EquipTypeController extends Controller
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
      ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
    ];

    return [
      'pageParams' => EquipType::get(['id','name']),
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
  * @param  \App\EquipType  $equipType
  * @return \Illuminate\Http\Response
  */
  public function show(EquipType $equipType)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\EquipType  $equipType
  * @return \Illuminate\Http\Response
  */
  public function edit(EquipType $equipType)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\EquipType  $equipType
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, EquipType $equipType)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\EquipType  $equipType
  * @return \Illuminate\Http\Response
  */
  public function destroy(EquipType $equipType)
  {
    //
  }
}
