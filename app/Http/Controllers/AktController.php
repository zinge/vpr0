<?php

namespace App\Http\Controllers;

use App\Akt;
use Illuminate\Http\Request;

class AktController extends Controller
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
      ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
      ['type' => 'date', 'field' => 'billing_date', 'desc' => 'дата акта'],
      ['type' => 'text', 'field' => 'billing_month', 'desc' => 'расчетный месяц'],
      ['type' => 'endlist', 'field' => 'agreement', 'desc' => 'договор', 'data' => $this->createListData('Agreement', ['name'])]
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? Akt::find([$id]) : Akt::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'name' => $item->name,
        'billing_date' => $item->billing_date,
        'billing_month' => $item->billing_month,
        'agreement' => $id ? $item->agreement_id : $item->agreement->name
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
    ->with('pageTitle', 'акт')
    ->with('pageHref', 'akt');
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
      'name' => 'required|max:30',
      'billing_date' => 'required|date',
      'billing_month' => 'required|numeric',
      'agreement' => 'required|numeric'
    ]);

    $akt = new Akt([
      'name' => $request->name,
      'billing_date' => $request->billing_date,
      'billing_month' => $request->billing_month
    ]);

    $akt->agreement()->associate($request->agreement);

    $akt->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Akt  $akt
  * @return \Illuminate\Http\Response
  */
  public function show(Akt $akt)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Akt  $akt
  * @return \Illuminate\Http\Response
  */
  public function edit(Akt $akt)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($akt->id))
    ->with('pageTitle', 'акт')
    ->with('pageHref', 'akt');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Akt  $akt
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Akt $akt)
  {
    //
    $this->validate($request, [
      'name' => 'required|max:30',
      'billing_date' => 'required|date',
      'billing_month' => 'required|numeric',
      'agreement' => 'required|numeric'
    ]);

    $akt->agreement()->associate($request->agreement);

    $akt->update([
      'name' => $request->name,
      'billing_date' => $request->billing_date,
      'billing_month' => $request->billing_month
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Akt  $akt
  * @return \Illuminate\Http\Response
  */
  public function destroy(Akt $akt)
  {
    //
    $akt->delete();

    return redirect('/akt');  
  }
}
