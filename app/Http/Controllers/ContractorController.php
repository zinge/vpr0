<?php

namespace App\Http\Controllers;

use App\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
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
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    return $this->createListData('Contractor', ['name']);
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

    $contractor = new Contractor([
      'name' => $request->name
    ]);

    $contractor->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Contractor  $contractor
  * @return \Illuminate\Http\Response
  */
  public function show(Contractor $contractor)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Contractor  $contractor
  * @return \Illuminate\Http\Response
  */
  public function edit(Contractor $contractor)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Contractor  $contractor
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Contractor $contractor)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Contractor  $contractor
  * @return \Illuminate\Http\Response
  */
  public function destroy(Contractor $contractor)
  {
    //
  }
}
