<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
      ['type' => 'text', 'field' => 'code', 'desc' => 'код'],
      ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
      ['type' => 'text', 'field' => 'cost', 'desc' => 'расценка'],
      ['type' => 'list', 'field' => 'finposition', 'desc' => 'фин. позиция', 'data' => $this->createListData('Finposition', ['code', 'name'])]
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'finposition' => [
        ['type'=>'text', 'field' => 'name', 'desc' => 'наименование'],
        ['type'=>'text', 'field' => 'code', 'desc' => 'код'],
      ]
    ];

    return $modalParams;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? Service::find([$id]) : Service::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'code' => $item->code,
        'name' => $item->name,
        'cost' => $item->cost,
        'finposition' => $id ? $item->finposition_id : $item->finposition->code." (".$item->finposition->name.")",
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
    //
    return view('spravochnik.index')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams(''))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'сервис')
    ->with('pageHref', 'service');
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
      'code' => 'required|max:10',
      'name' => 'required|max:30',
      'cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/'],
      'finposition' => 'required|numeric',
    ]);

    $service = new Service([
      'code' => $request->code,
      'name' => $request->name,
      'cost' => $this->replCommas($request->cost),
    ]);

    $service->finposition()->associate($request->finposition);

    $service->save();

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Service  $service
  * @return \Illuminate\Http\Response
  */
  public function show(Service $service)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Service  $service
  * @return \Illuminate\Http\Response
  */
  public function edit(Service $service)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($service->id))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'сервис')
    ->with('pageHref', 'service');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Service  $service
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Service $service)
  {
    //
    $this->validate($request, [
      'code' => 'required|max:10',
      'name' => 'required|max:30',
      'cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/'],
      'finposition' => 'required|numeric',
    ]);

    $service->finposition()->associate($request->finposition);

    $service->update([
      'code' => $request->code,
      'name' => $request->name,
      'cost' => $this->replCommas($request->cost),
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Service  $service
  * @return \Illuminate\Http\Response
  */
  public function destroy(Service $service)
  {
    //
    $service->delete();

    return redirect('/service');
  }
}
