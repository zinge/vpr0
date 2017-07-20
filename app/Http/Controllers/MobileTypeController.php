<?php

namespace App\Http\Controllers;

use App\MobileType;
use Illuminate\Http\Request;

class MobileTypeController extends Controller
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
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return $this->createListData('MobileType', ['name'], '');
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
      'name' => 'required|max:30'
    ]);

    $mobiletype = new MobileType([
      'name' => $request->name
    ]);

    $mobiletype->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\MobileType  $mobiletype
  * @return \Illuminate\Http\Response
  */
  public function show(MobileType $mobiletype)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobileType  $mobiletype
  * @return \Illuminate\Http\Response
  */
  public function edit(MobileType $mobiletype)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobileType  $mobiletype
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobileType $mobiletype)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobileType  $mobiletype
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobileType $mobiletype)
  {
    //
  }
}
