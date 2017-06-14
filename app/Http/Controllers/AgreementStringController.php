<?php

namespace App\Http\Controllers;

use App\AgreementString;
use Illuminate\Http\Request;

class AgreementStringController extends Controller
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
      ['type' => 'endlist', 'field' => 'agreement', 'desc' => 'договор', 'data' => $this->createListData('Agreement', ['name'])],
      ['type' => 'endlist', 'field' => 'service', 'desc' => 'сервис', 'data' => $this->createListData('Service', ['name', 'cost'])],
      ['type' => 'text', 'field' => 'physical', 'desc' => 'физ. объем'],
      ['type' => 'text', 'field' => 'months', 'desc' => 'период, месяцев'],
      ['type' => 'text', 'field' => 'summ_cost', 'desc' => 'итого'],
      ['type' => 'endlist', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->createListData('Department', ['name'])],
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $pageItems = $id ? AgreementString::find([$id]) : AgreementString::get();

    foreach ($pageItems as $item) {
      array_push($pageParams, [
        'id' => $item->id,
        'agreement' => $id ? $item->agreement_id : $item->agreement->name,
        'service' => $id ? $item->service_id : $item->service->name,
        'physical' => $item->physical,
        'months' => $item->months,
        'summ_cost' => $item->summ_cost,
        'department' => $id ? $item->department_id : $item->department->name
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
    ->with('pageTitle', 'строка договора')
    ->with('pageHref', 'agreementstring');
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
      'agreement' => 'required|numeric',
      'service' => 'required|numeric',
      'physical' => 'required|numeric',
      'months' => 'required|numeric',
      'summ_cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/'],
      'department' => 'required|numeric'
    ]);

    $agreementstring = new AgreementString([
      'physical' => $request->physical,
      'months' => $request->months,
      'summ_cost' => $this->replCommas($request->summ_cost)
    ]);

    $agreementstring->agreement()->associate($request->agreement);
    $agreementstring->service()->associate($request->service);
    $agreementstring->department()->associate($request->department);

    $agreementstring->save();

    return 0;
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\AgreementString  $agreementstring
  * @return \Illuminate\Http\Response
  */
  public function show(AgreementString $agreementstring)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\AgreementString  $agreementstring
  * @return \Illuminate\Http\Response
  */
  public function edit(AgreementString $agreementstring)
  {
    //
    return view('spravochnik.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($agreementstring->id))
    ->with('pageTitle', 'строка договора')
    ->with('pageHref', 'agreementstring');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\AgreementString  $agreementstring
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, AgreementString $agreementstring)
  {
    //
    $this->validate($request, [
      'agreement' => 'required|numeric',
      'service' => 'required|numeric',
      'physical' => 'required|numeric',
      'months' => 'required|numeric',
      'summ_cost' => ['required', 'regex:/^\d{1,10}((,|.)\d{2})?$/'],
      'department' => 'required|numeric'
    ]);

    $agreementstring->agreement()->associate($request->agreement);
    $agreementstring->service()->associate($request->service);
    $agreementstring->department()->associate($request->department);

    $agreementstring->update([
      'physical' => $request->physical,
      'months' => $request->months,
      'summ_cost' => $this->replCommas($request->summ_cost)
    ]);

    return 0;
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\AgreementString  $agreementstring
  * @return \Illuminate\Http\Response
  */
  public function destroy(AgreementString $agreementstring)
  {
    //
    $agreementstring->delete();

    return redirect('/agreementstring');
  }
}
