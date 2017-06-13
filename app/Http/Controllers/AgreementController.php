<?php

namespace App\Http\Controllers;

use App\Agreement;
use Illuminate\Http\Request;

class AgreementController extends Controller
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
      ['type' => 'date', 'field' => 'initial_date', 'desc' => 'начало'],
      ['type' => 'date', 'field' => 'end_date', 'desc' => 'окончание'],
      ['type' => 'list', 'field' => 'contractor', 'desc' => 'подрядчик', 'data' => $this->createListData('Contractor', ['name'])]
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'contractor' => [
        ['type'=>'text', 'field' => 'name', 'desc' => 'подрядчик'],
      ]
    ];

    return $modalParams;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? Agreement::find([$id]) : Agreement::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'name' => $item->name,
        'initial_date' => $item->initial_date,
        'end_date' => $item->end_date,
        'contractor' => $id ? $item->contractor_id : $item->contractor->name
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
    ->with('pageTitle', 'доровор')
    ->with('pageHref', 'agreement');
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
      'initial_date' => 'required|date',
      'end_date' => 'required|date',
      'contractor' => 'required|numeric'
    ]);

    $agreement = new Agreement([
      'name' => $request->name,
      'initial_date' => $request->initial_date,
      'end_date' => $request->end_date
    ]);

    $agreement->contractor()->associate($request->contractor);

    $agreement->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Agreement  $agreement
  * @return \Illuminate\Http\Response
  */
  public function show(Agreement $agreement)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Agreement  $agreement
  * @return \Illuminate\Http\Response
  */
  public function edit(Agreement $agreement)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($agreement->id))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'доровор')
    ->with('pageHref', 'agreement');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Agreement  $agreement
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Agreement $agreement)
  {
    //
    $this->validate($request, [
      'name' => 'required|max:30',
      'initial_date' => 'required|date',
      'end_date' => 'required|date',
      'contractor' => 'required|numeric'
    ]);

    $agreement->contractor()->associate($request->contractor);

    $agreement->update([
      'name' => $request->name,
      'initial_date' => $request->initial_date,
      'end_date' => $request->end_date
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Agreement  $agreement
  * @return \Illuminate\Http\Response
  */
  public function destroy(Agreement $agreement)
  {
    //
    $agreement->delete();

    return redirect('/agreement');
  }
}
