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
      ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
      ['type' => 'text', 'field' => 'street', 'desc' => 'улица'],
      ['type' => 'text', 'field' => 'house', 'desc' => 'дом'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    return [
      'pageParams' => Address::get(['id','city','street','house', 'active']),
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
      'city' => 'required|max:30',
      'street' => 'required|max:100',
      'house' => 'required|max:10',
      'active' => 'bool'
    ]);
    //if ($request->user()->hasRole(['address_rw','root'])) {
      $address = new Address([
        'city' => $request->city,
        'street' => $request->street,
        'house' => $request->house,
        'active' => $request->active
      ]);

      $address->save();
    // };
    //return redirect('/address');
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
