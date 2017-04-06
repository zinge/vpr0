<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
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
      ['type' => 'text', 'desc' => 'city'],
      ['type' => 'text', 'desc' => 'street'],
      ['type' => 'text', 'desc' => 'house'],
      ['type' => 'checkbox', 'desc' => 'active'],
    ];

    return response()
    ->with('pageSruture', $pageSruture);

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
  * @param  \App\Address  $address
  * @return \Illuminate\Http\Response
  */
  public function show(Address $address)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Address  $address
  * @return \Illuminate\Http\Response
  */
  public function edit(Address $address)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Address  $address
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Address $address)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Address  $address
  * @return \Illuminate\Http\Response
  */
  public function destroy(Address $address)
  {
    //
  }
}
