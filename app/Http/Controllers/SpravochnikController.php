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
  public function index(Request $request)
  {
    //
    if (isset($request['q'])) {
      switch ($request->q) {
        case 'ostr':
          $pageSruture = [
            ['tabName' => 'адрес', 'tabHref' => 'address', 'formFields' => ['city', 'street', 'house', 'active']],
            ['tabName' => 'подразделение', 'tabHref' => 'department', 'formFields' => ['name', 'active']],
            ['tabName' => 'сотрудник', 'tabHref' => 'employee', 'formFields' => [
                                          'firstname', 'patronymic', 'surname', 'department', 'address' , 'active']],
          ];
        break;
        case 'equip':
          $pageSruture = [
            ['tabName' => 'тип', 'tabHref' => 'equip-type'],
            ['tabName' => 'производитель', 'tabHref' => 'manufacturer'],
            ['tabName' => 'модель', 'tabHref' => 'equip-model'],
            ['tabName' => 'оборудование', 'tabHref' => 'equip'],
          ];
        break;
        case 'tg':
          $pageSruture = [
            ['tabName' => 'телефон(городской)', 'tabHref' => 'phone'],
            ['tabName' => 'MAC адрес', 'tabHref' => 'ip-phone'],
          ];
        break;
        case 'tm':
          $pageSruture = [
            ['tabName' => 'лимит', 'tabHref' => 'mobile-limit'],
            ['tabName' => 'тип', 'tabHref' => 'mobile-type'],
            ['tabName' => 'телефон(мобильный)', 'tabHref' => 'mobile-phone'],
          ];
        break;
        case 'wpls':
          $pageSruture = [
            ['tabName' => 'рабочее место', 'tabHref' => 'workplace']
          ];
        break;
        default:
          $pageSruture = [];
        break;
      }
    }else{
      return redirect('/spravochnik?q=');
    }

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
