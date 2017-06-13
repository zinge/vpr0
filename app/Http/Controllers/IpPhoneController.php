<?php

namespace App\Http\Controllers;

use App\IpPhone;
use Illuminate\Http\Request;

class IpPhoneController extends Controller
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
      ['type' => 'text', 'field' => 'macaddr', 'desc' => 'MAC адрес'],
      ['type' => 'endlist', 'field' => 'phone', 'desc' => 'телефон', 'data' => $this->createListData('Phone', ['number'], '')],
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? IpPhone::find([$id]) : IpPhone::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'macaddr' => $item->macaddr,
        'phone' => $id ? $item->phone_id : $item->phone->number,
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
    ->with('pageTitle', 'МАС адрес')
    ->with('pageHref', 'ipphone');
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
      'macaddr' => array('required', 'regex:/^(?:[0-9A-Fa-f]{2}[:|-]?){5}(?:[0-9A-Fa-f]{2}?)$/'),
      'phone' => 'required|numeric'
    ]);

    $ipphone = new IpPhone([
      'macaddr' => $request->macaddr
    ]);

    $ipphone->phone()->associate($request->phone);

    $ipphone->save();

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\IpPhone  $ipphone
  * @return \Illuminate\Http\Response
  */
  public function show(IpPhone $ipphone)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\IpPhone  $ipphone
  * @return \Illuminate\Http\Response
  */
  public function edit(IpPhone $ipphone)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createpageparams($ipphone->id))
    ->with('pageTitle', 'МАС адрес')
    ->with('pageHref', 'ipphone');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\IpPhone  $ipphone
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, IpPhone $ipphone)
  {
    //
    $this->validate($request, [
      'macaddr' => array('required', 'regex:/^(?:[0-9A-Fa-f]{2}[:|-]?){5}(?:[0-9A-Fa-f]{2}?)$/'),
      'phone' => 'required|numeric'
    ]);

    $ipphone->phone()->associate($request->phone);

    $ipphone->update([
      'macaddr' => $request->macaddr
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\IpPhone  $ipphone
  * @return \Illuminate\Http\Response
  */
  public function destroy(IpPhone $ipphone)
  {
    //
    $ipphone->delete();

    return redirect('/ipphone');
  }
}
