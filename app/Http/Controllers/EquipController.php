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
      ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
      ['type' => 'list', 'field' => 'manufacturer', 'desc' => 'производитель', 'data' => $this->createListData('Manufacturer', ['name'],',')],
      ['type' => 'list', 'field' => 'equiptype', 'desc' => 'тип', 'data' => $this->createListData('EquipType', ['name'], ',')],
      ['type' => 'list', 'field' => 'equipmodel', 'desc' => 'модель', 'data' => $this->createListData('EquipModel', ['name'], ',')],
      ['type' => 'endlist', 'field' => 'employee', 'desc' => 'сотрудник', 'data' => $this->createListData('Employee', ['firstname', 'patronymic', 'surname'], '')],
      ['type' => 'date', 'field' => 'initial_date', 'desc' => 'дата ввода'],
      ['type' => 'text', 'field' => 'initial_cost', 'desc' => 'балансовая стоимость'],
      ['type' => 'text', 'field' => 'serial_number', 'desc' => 'серийный'],
      ['type' => 'text', 'field' => 'sap_number', 'desc' => 'SAP'],
      ['type' => 'text', 'field' => 'manufacturer_number', 'desc' => 'заводской'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'manufacturer' => [
        ['type'=>'text', 'field'=>'name', 'desc'=>'производитель']
      ],
      'equiptype' => [
        ['type'=>'text', 'field'=>'name', 'desc'=>'тип']
      ],
      'equipmodel' => [
        ['type'=>'text', 'field'=>'name', 'desc'=>'модель']
      ],
    ];

    return $modalParams;
  }


  private function createPageParams($id)
  {
    $pageParams = [];

    $equips = $id ? Equip::find([$id]) : Equip::get();

    foreach ($equips as $equip) {
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

    return $pageParams;
  }

  private function replCommas($decimalValue)
  {
    $pattern='/(^\d+)(?:,(\d{2}))$/';
    $pattern_empt='/(^\d+)$/';
    if (preg_match($pattern, $decimalValue)) {
      return preg_replace($pattern, '$1.$2', $decimalValue);
    } else {
      if (preg_match($pattern_empt, $decimalValue)) {
        return preg_replace($pattern, '$1.00', $decimalValue);
      }
      return $decimalValue;
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('equip.index')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams(''))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'оборудование')
    ->with('pageHref', 'equip');

    // return dd($this->createPageParams(''));
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
      'name' => 'max:256',
      'initial_date' => 'date',
      'initial_cost' => array('regex:/^\d{1,10}((,|.)\d{2})?$/'),
      'serial_number' => 'max:50',
      'sap_number' => 'max:50',
      'manufacturer_number' => 'max:50',
      'active' => 'bool',
      'manufacturer' => 'required|numeric',
      'equiptype' => 'required|numeric',
      'equipmodel' => 'required|numeric',
      'employee' => 'required|numeric'
    ]);

    $equip = new Equip([
      'name' => $request->name,
      'initial_date' => $request->initial_date,
      'initial_cost' => $this->replCommas($request->initial_cost),
      'serial_number' => $request->serial_number,
      'sap_number' => $request->sap_number,
      'manufacturer_number' => $request->manufacturer_number,
      'active' => $request->active
    ]);

    $equip->manufacturer()->associate($request->manufacturer);
    $equip->equip_type()->associate($request->equiptype);
    $equip->equip_model()->associate($request->equipmodel);
    $equip->employee()->associate($request->employee);

    $equip->save();

    return 0;
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
