<?php

namespace App\Http\Controllers;

use App\Spravochnik;
use Illuminate\Http\Request;

class SpravochnikController extends Controller
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
      ['tabName' => 'адрес', 'tabHref' => 'address'],
      ['tabName' => 'подразделение', 'tabHref' => 'department'],
      ['tabName' => 'сотрудник', 'tabHref' => 'employee'],
      ['tabName' => 'оборудование', 'tabHref' => 'equip'],
      ['tabName' => 'телефон(городской)', 'tabHref' => 'phone'],
      ['tabName' => 'MAC адреса', 'tabHref' => 'ip-phone'],
      ['tabName' => 'телефон(мобильный)', 'tabHref' => 'mobile-phone'],
      ['tabName' => 'рабочее место', 'tabHref' => 'workplace'],
    ];

    return view('spravochnik.index')
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
  * @param  \App\Spravochnik  $spravochnik
  * @return \Illuminate\Http\Response
  */
  public function show(Spravochnik $spravochnik)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Spravochnik  $spravochnik
  * @return \Illuminate\Http\Response
  */
  public function edit(Spravochnik $spravochnik)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Spravochnik  $spravochnik
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Spravochnik $spravochnik)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Spravochnik  $spravochnik
  * @return \Illuminate\Http\Response
  */
  public function destroy(Spravochnik $spravochnik)
  {
    //
  }
}
