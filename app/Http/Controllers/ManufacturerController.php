<?php

namespace App\Http\Controllers;

use App\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
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
      'pageParams' => Manufacturer::get(['id','name']),
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
    $this->validate($request, [
      'name' => 'required|max:100',
    ]);

    $manufacturer = new Manufacturer([
      'name' => $request->name,
    ]);

    $manufacturer->save();

  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Manufacturer  $manufacturer
  * @return \Illuminate\Http\Response
  */
  public function show(Manufacturer $manufacturer)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Manufacturer  $manufacturer
  * @return \Illuminate\Http\Response
  */
  public function edit(Manufacturer $manufacturer)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Manufacturer  $manufacturer
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Manufacturer $manufacturer)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Manufacturer  $manufacturer
  * @return \Illuminate\Http\Response
  */
  public function destroy(Manufacturer $manufacturer)
  {
    //
  }
}