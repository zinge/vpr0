<?php

namespace App\Http\Controllers;

use App\PhoneOwner;
use Illuminate\Http\Request;

use App\Phone;

class PhoneOwnerController extends Controller
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
      ['type' => 'endlist', 'field' => 'number', 'desc' => 'номер', 'data' => $this->createListData('Phone', ['number'], '')],
      ['type' => 'endlist', 'field' => 'employee', 'desc' => 'сотрудник', 'data' => $this->createListData('Employee', ['firstname', 'patronymic', 'surname'], '')],
    ];

    return $pageStructure;
  }

  // private function createListModalParams()
  // {
  //   $modalParams = [
  //     'phonetype' => [
  //       ['type'=>'text', 'field' => 'name', 'desc' => 'тип'],
  //     ]
  //   ];
  //
  //   return $modalParams;
  // }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? PhoneOwner::find([$id]) : PhoneOwner::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'number' => $id ? $item->phone_id : $item->phone->number,
        'employee' => $id ? $item->employee_id : $item->employee->firstname." ".$item->employee->patronymic." ".$item->employee->surname,
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
    ->with('pageTitle', 'телефон/владелец')
    ->with('pageHref', 'phoneowner');
    // return dd($this->createPageStructure());
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
      'employee' => 'numeric',
      'number' => 'numeric'
    ]);

    $phone = Phone::find($request->number);

    $phone->employees()->attach($request->employee);

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\PhoneOwner  $phoneOwner
  * @return \Illuminate\Http\Response
  */
  public function show(PhoneOwner $phoneOwner)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\PhoneOwner  $phoneOwner
  * @return \Illuminate\Http\Response
  */
  public function edit(PhoneOwner $phoneOwner)
  {
    //
    // return view('spravochnik.edit')
    // ->with('pageStructure', $this->createPageStructure())
    // ->with('pageParams', $this->createpageparams($phoneowner->id))
    // ->with('pageTitle', 'телефон/владелец')
    // ->with('pageHref', 'phoneowner');
    return dd($this->createPageParams($phoneOwner->id));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\PhoneOwner  $phoneOwner
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, PhoneOwner $phoneOwner)
  {
    //
    $this->validate($request, [
      'employee' => 'numeric',
      'phone' => 'numeric'
    ]);

    $phoneOwner->phone()->associate($request->phone);
    $phoneOwner->employee()->associate($phoneOwner->employee);

    $phoneOwner->update();

    return 0;
  }

  /**
  * Remove the specified resource from storagePhoneOwner
  *
  * @param  \App\PhoneOwner  $phoneOwner
  * @return \Illuminate\Http\Response
  */
  public function destroy(PhoneOwner $phoneOwner)
  {
    //
    $phone = Phone::find($phoneOwner->phone_id);

    $phone->employees()->detach($phoneOwner->employee_id);

    return redirect('/phoneowner');
  }
}
