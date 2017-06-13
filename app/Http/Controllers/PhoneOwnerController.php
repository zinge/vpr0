<?php

namespace App\Http\Controllers;

use App\Phone;
use App\PhoneOwner;
use Illuminate\Http\Request;

class PhoneOwnerController extends Controller
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
    $pageStructure = [
      ['type' => 'endlist', 'field' => 'phone', 'desc' => 'номер', 'data' => $this->createListData('Phone', ['number'], '')],
      ['type' => 'endlist', 'field' => 'employee', 'desc' => 'сотрудник', 'data' => $this->createListData('Employee', ['firstname', 'patronymic', 'surname'], '')],
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? PhoneOwner::find([$id]) : PhoneOwner::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'phone' => $id ? $item->phone_id : $item->phone->number,
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
      'phone' => 'numeric'
    ]);

    $phone = Phone::find($request->phone);

    $phone->employees()->attach($request->employee);

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\PhoneOwner  $phoneowner
  * @return \Illuminate\Http\Response
  */
  public function show(PhoneOwner $phoneowner)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\PhoneOwner  $phoneowner
  * @return \Illuminate\Http\Response
  */
  public function edit(PhoneOwner $phoneowner)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createpageparams($phoneowner->id))
    ->with('pageTitle', 'телефон/владелец')
    ->with('pageHref', 'phoneowner');
    // return dd($this->createPageParams($phoneowner->id));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\PhoneOwner  $phoneowner
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, PhoneOwner $phoneowner)
  {
    //
    $this->validate($request, [
      'employee' => 'numeric',
      'phone' => 'numeric'
    ]);

    $phoneowner->phone()->associate($request->phone);
    $phoneowner->employee()->associate($phoneowner->employee);

    $phoneowner->update();

    return 0;
  }

  /**
  * Remove the specified resource from storagePhoneOwner
  *
  * @param  \App\PhoneOwner  $phoneowner
  * @return \Illuminate\Http\Response
  */
  public function destroy(PhoneOwner $phoneowner)
  {
    //
    $phone = Phone::find($phoneowner->phone_id);

    $phone->employees()->detach($phoneowner->employee_id);

    return redirect('/phoneowner');
  }
}
