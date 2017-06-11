<?php

namespace App\Http\Controllers;

use App\PhoneType;
use Illuminate\Http\Request;

class PhoneTypeController extends Controller
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
    return [
      'pageParams' => PhoneType::get(['id', 'name'])
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

    $phone_type = new PhoneType([
      'name' => $request->name,
    ]);

    $phone_type->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\PhoneType  $phoneType
  * @return \Illuminate\Http\Response
  */
  public function show(PhoneType $phoneType)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\PhoneType  $phoneType
  * @return \Illuminate\Http\Response
  */
  public function edit(PhoneType $phoneType)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\PhoneType  $phoneType
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, PhoneType $phoneType)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\PhoneType  $phoneType
  * @return \Illuminate\Http\Response
  */
  public function destroy(PhoneType $phoneType)
  {
    //
  }
}
