<?php

namespace App\Http\Controllers;

use App\Aktstring;
use Illuminate\Http\Request;

class AktstringController extends Controller
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
      ['type' => 'endlist', 'field' => 'akt', 'desc' => 'акт', 'data' => $this->createListData('Akt', ['name'])],
      ['type' => 'endlist', 'field' => 'service', 'desc' => 'сервис', 'data' => $this->createListData('Service', ['name', 'cost'])],
      ['type' => 'text', 'field' => 'physical', 'desc' => 'физ. объем'],
      ['type' => 'text', 'field' => 'summ_cost', 'desc' => 'итого'],
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? Aktstring::find([$id]) : Aktstring::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'akt' => $id ? $item->akt_id : $item->akt->name,
        'service' => $id ? $item->service_id : $item->service->name,
        'physical' => $item->physical,
        'summ_cost' => $item->summ_cost,
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
    ->with('pageTitle', 'строка акта')
    ->with('pageHref', 'aktstring');
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
      'akt' => 'required|numeric',
      'service' => 'required|numeric',
      'physical' => 'required|numeric',
      'summ_cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/']
    ]);

    $aktstring = new Aktstring([
      'physical' => $request->physical,
      'summ_cost' => $this->replCommas($request->summ_cost)
    ]);

    $aktstring->akt()->associate($request->akt);
    $aktstring->service()->associate($request->service);

    $aktstring->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Aktstring  $aktstring
  * @return \Illuminate\Http\Response
  */
  public function show(Aktstring $aktstring)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Aktstring  $aktstring
  * @return \Illuminate\Http\Response
  */
  public function edit(Aktstring $aktstring)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($aktstring->id))
    ->with('pageTitle', 'строка акта')
    ->with('pageHref', 'aktstring');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Aktstring  $aktstring
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Aktstring $aktstring)
  {
    //
    $this->validate($request, [
      'akt' => 'required|numeric',
      'service' => 'required|numeric',
      'physical' => 'required|numeric',
      'summ_cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/']
    ]);

    $aktstring->akt()->associate($request->akt);
    $aktstring->service()->associate($request->service);

    $aktstring->update([
      'physical' => $request->physical,
      'summ_cost' => $this->replCommas($request->summ_cost)
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Aktstring  $aktstring
  * @return \Illuminate\Http\Response
  */
  public function destroy(Aktstring $aktstring)
  {
    //
    $aktstring->delete();

    return redirect('aktstring');
  }
}
