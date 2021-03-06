<?php

namespace App\Http\Controllers;

use App\MobileLimit;
use Illuminate\Http\Request;

class MobileLimitController extends Controller
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
    return $this->createListData('MobileLimit', ['limit_cost'], '');
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
      'limit_cost' => array('required', 'regex:/^\d{1,10}((,|.)\d{2})?$/')
    ]);

    $mobilelimit = new MobileLimit([
      'limit_cost' => $this->replCommas($request->limit_cost)
    ]);

    $mobilelimit->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\MobileLimit  $mobilelimit
  * @return \Illuminate\Http\Response
  */
  public function show(MobileLimit $mobilelimit)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\MobileLimit  $mobilelimit
  * @return \Illuminate\Http\Response
  */
  public function edit(MobileLimit $mobilelimit)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\MobileLimit  $mobilelimit
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, MobileLimit $mobilelimit)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\MobileLimit  $mobilelimit
  * @return \Illuminate\Http\Response
  */
  public function destroy(MobileLimit $mobilelimit)
  {
    //
  }
}
