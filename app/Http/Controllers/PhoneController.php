<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  private function createListData($className, $elementKeys)
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

  private function createPageStructure()
  {
    $pageStructure = [
      ['type' => 'text', 'field' => 'number', 'desc' => 'номер'],
      ['type' => 'list', 'field' => 'phonetype', 'desc' => 'тип', 'data' => $this->createListData('PhoneType', ['name'])],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'phonetype' => [
        ['type'=>'text', 'field' => 'name', 'desc' => 'тип'],
      ]
    ];

    return $modalParams;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? Phone::find([$id]) : Phone::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'number' => $item->number,
        'phonetype' => $id ? $item->phone_type_id : $item->phone_type->name,
        'active' => $item->active
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
    ->with('pageTitle', 'телефон')
    ->with('pageHref', 'phone');
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
      'active' => 'bool',
      'phonetype' => 'required|numeric'
    ]);

    $phone = new Phone([
      'number' => $request->number,
      'active' => $request->active
    ]);

    $phone->phone_type()->associate($request->phonetype);

    $phone->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Phone  $phone
  * @return \Illuminate\Http\Response
  */
  public function show(Phone $phone)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Phone  $phone
  * @return \Illuminate\Http\Response
  */
  public function edit(Phone $phone)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($phone->id))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'телефон')
    ->with('pageHref', 'phone');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Phone  $phone
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Phone $phone)
  {
    //
    $this->validate($request, [
      'number' => 'required|max:30',
      'active' => 'bool',
      'phonetype' => 'required|numeric'
    ]);

    $phone->phone_type()->associate($request->phonetype);

    $phone->update([
      'number' => $request->number,
      'active' => $request->active
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Phone  $phone
  * @return \Illuminate\Http\Response
  */
  public function destroy(Phone $phone)
  {
    //
    $phone->delete();

    return redirect('/phone');
  }
}
