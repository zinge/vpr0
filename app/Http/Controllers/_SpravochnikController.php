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

  private function getList($className, $elementKeys)
  {

    $elementData = [];
    $elementValues = '';

    $className = 'App\\'.$className;
    $className = new $className();

    foreach ($className->get() as $element) {

      foreach ($elementKeys as $key => $value) {
        $elementValues = ($key ? $elementValues = $elementValues . ", " . $element->$value : $elementValues = $element->$value);
      }

      array_push($elementData, [
        'id' => $element->id,
        'val' => $elementValues
      ]);
    }

    return $elementData;
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
            ['tabName' => 'адрес', 'tabHref' => 'address', 'tabStruture' => [
              ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
              ['type' => 'text', 'field' => 'street', 'desc' => 'улица'],
              ['type' => 'text', 'field' => 'house', 'desc' => 'дом'],
              ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
            ]],
            ['tabName' => 'подразделение', 'tabHref' => 'department', 'tabStruture' => [
              ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
              ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
            ]],
            ['tabName' => 'сотрудник', 'tabHref' => 'employee', 'tabStruture' => [
              ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
              ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
              ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
              ['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->getList('Department', ['name'])],
              ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес', 'data' => $this->getList('Address', ['city', 'street', 'house'])],
              ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
            ]],
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
