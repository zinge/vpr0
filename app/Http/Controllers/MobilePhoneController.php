<?php

namespace App\Http\Controllers;

use App\MobilePhone;
use Illuminate\Http\Request;

class MobilePhoneController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  private function createListData($className, $elementKeys, $separator)
  {

    $elementData = [];
    $elementValues = '';

    $className = 'App\\'.$className;
    $className = new $className();

    foreach ($className->get() as $element) {

      foreach ($elementKeys as $key => $value) {
        $elementValues = $key ? $elementValues = $elementValues . $separator . " " . $element->$value : $elementValues = $element->$value;
      }

      array_push($elementData, [
        'id' => $element->id,
        'val' => $elementValues
      ]);
    }

    return $elementData;
  }

  private function createPageStructure()
  {
    $pageStructure = [];
    $pageStructure = [
      ['type' => 'text', 'field' => 'number', 'desc' => 'номер'],
      ['type' => 'list', 'field' => 'mobiletype', 'desc' => 'тип', 'data' => $this->createListData('MobileType', ['name'], '')],
      ['type' => 'list', 'field' => 'mobilelimit', 'desc' => 'лимит', 'data' => $this->createListData('MobileLimit', ['limit_cost'], '')],
      ['type' => 'endlist', 'field' => 'employee', 'desc' => 'сотрудник', 'data' => $this->createListData('Employee', ['firstname', 'patronymic', 'surname'], '')],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'mobiletype' => [
        ['type'=>'text', 'field'=>'name', 'desc'=>'тип связи']
      ],
      'mobilelimit' => [
        ['type'=>'text', 'field'=>'limit_cost', 'desc'=>'лимит']
      ],
    ];

    return $modalParams;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $mphones = $id ? MobilePhone::find([$id]) : MobilePhone::get();

    foreach ($mphones as $mphone) {
      array_push($pageParams, [
        'id' => $mphone->id,
        'number' => $mphone->number,
        'mobiletype' => $id ? $mphone->mobile_type_id : $mphone->mobile_type->name,
        'mobilelimit' => $id ? $mphone->mobile_limit_id : $mphone->mobile_limit->limit_cost,
        'employee' => $id ? $mphone->employee_id : $mphone->employee->firstname." ".$mphone->employee->patronymic." ".$mphone->employee->surname,
        'active' => $mphone->active,
      ]);
    }

    return $pageParams;
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    return view('spravochnik.index')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams(''))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'моб.телефон')
    ->with('pageHref', 'mobilephone');
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
      'number' => 'required|max:30',
      'mobiletype' => 'required|numeric',
      'mobilelimit' => 'required|numeric',
      'employee' => 'required|numeric',
      'active' => 'bool'
     ]);

    $mobilephone = new MobilePhone([
      'number' => $request->number,
      'active' => $request->active
    ]);

    $mobilephone->mobile_type()->associate($request->mobiletype);
    $mobilephone->mobile_limit()->associate($request->mobilelimit);
    $mobilephone->employee()->associate($request->employee);

    $mobilephone->save();

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\MobilePhone  $mobilephone
  * @return \Illuminate\Http\Response
  */
  public function show(MobilePhone $mobilephone)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobilePhone  $mobilephone
  * @return \Illuminate\Http\Response
  */
  public function edit(MobilePhone $mobilephone)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($mobilephone->id))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'моб.телефон')
    ->with('pageHref', 'mobilephone');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobilePhone  $mobilephone
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobilePhone $mobilephone)
  {
    //
    $this->validate($request, [
      'number' => 'required|max:30',
      'mobiletype' => 'required|numeric',
      'mobilelimit' => 'required|numeric',
      'employee' => 'required|numeric',
      'active' => 'bool'
     ]);

    $mobilephone->mobile_type()->associate($request->mobiletype);
    $mobilephone->mobile_limit()->associate($request->mobilelimit);
    $mobilephone->employee()->associate($request->employee);

    $mobilephone->update([
      'number' => $request->number,
      'active' => $request->active
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobilePhone  $mobilephone
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobilePhone $mobilephone)
  {
    //
    $mobilephone->delete();

    return redirect('/mobilephone');
  }
}
