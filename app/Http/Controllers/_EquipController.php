<?php

namespace App\Http\Controllers;

use App\Equip;
use Illuminate\Http\Request;

class EquipController extends Controller
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
      ['type' => 'list', 'field' => 'manufacturer', 'desc' => 'производитель'],
      ['type' => 'list', 'field' => 'equip_type', 'desc' => 'тип'],
      ['type' => 'list', 'field' => 'equip_model', 'desc' => 'модель'],
      ['type' => 'list', 'field' => 'employee', 'desc' => 'сотрудник'],
      ['type' => 'date', 'field' => 'initial_date', 'desc' => 'дата ввода'],
      ['type' => 'text', 'field' => 'initial_cost', 'desc' => 'балансовая стоимость'],
      ['type' => 'text', 'field' => 'serial_number', 'desc' => 'серийный'],
      ['type' => 'text', 'field' => 'sap_number', 'desc' => 'SAP'],
      ['type' => 'text', 'field' => 'manufacturer_number', 'desc' => 'заводской'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    $pageParams = [];

    foreach (Equip::get() as $equip) {
      array_push($pageParams, [
        'id' => $equip->id,
        'name' => $equip->name,
        'manufacturer' => $equip->manufacturer->name,
        'equip_type' => $equip->equip_type->name,
        'equip_model' => $equip->equip_model->name,
        'employee' => $equip->employee->firstname." ".$equip->employee->patronymic." ".$equip->employee->surname,
        'initial_date' => $equip->initial_date,
        'initial_cost' => $equip->initial_cost,
        'serial_number' => $equip->serial_number,
        'sap_number' => $equip->sap_number,
        'manufacturer_number' => $equip->manufacturer_number,
        'active' => $equip->active,
      ]);
    }

    return [
      'pageParams' => $pageParams,
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
  * @param  \App\Equip  $equip
  * @return \Illuminate\Http\Response
  */
  public function show(Equip $equip)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Equip  $equip
  * @return \Illuminate\Http\Response
  */
  public function edit(Equip $equip)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Equip  $equip
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Equip $equip)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Equip  $equip
  * @return \Illuminate\Http\Response
  */
  public function destroy(Equip $equip)
  {
    //
  }
}
