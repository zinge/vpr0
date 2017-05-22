<?php

namespace App\Http\Controllers;

use App\Modal;
use Illuminate\Http\Request;

use App\Department;
use App\Address;

class ModalController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  private function getList($className, $elementKeys)
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

  public function index(Request $request)
  {
    //

    if (isset($request['m'])) {
      switch ($request->m) {

        case 'address':
        $pageSruture = [
          ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
          ['type' => 'text', 'field' => 'street', 'desc' => 'улица'],
          ['type' => 'text', 'field' => 'house', 'desc' => 'дом'],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'адрес';
        $formHref = 'address';
        break;

        case 'department':
        $pageSruture = [
          ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'подразделение';
        $formHref = 'department';
        break;

        //Employee case
        case 'employee':
        $pageSruture = [
          ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
          ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
          ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
          ['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->getList('Department', ['name'])],
          ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес', 'data' => $this->getList('Address', ['city', 'street', 'house'])],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'сотрудник';
        $formHref = 'employee';
        break;

        default:
        $pageSruture = [];
        $pageTitle = '';
        $formHref = '';
        break;
      }

      return view('modal.index')
      ->with('pageSruture', $pageSruture)
      ->with('pageTitle', $pageTitle)
      ->with('formHref', $formHref);

    }else{
      return redirect('/modal?m=');
    }

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
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Modal  $modal
  * @return \Illuminate\Http\Response
  */
  public function show(Modal $modal)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Modal  $modal
  * @return \Illuminate\Http\Response
  */
  public function edit(Modal $modal)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Modal  $modal
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Modal $modal)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Modal  $modal
  * @return \Illuminate\Http\Response
  */
  public function destroy(Modal $modal)
  {
    //
  }
}
