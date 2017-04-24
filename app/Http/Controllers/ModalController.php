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
  private function getList($class, $element_key)
  {

    $element_data = [];

    $class = 'App\\'.$class;
    $class = new $class();

    foreach ($class->get() as $element) {
      array_push($element_data, [
        'id' => $element->id,
        'val' => $element->$element_key
      ]);
    }

    return $element_data;
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
          //['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $department_data],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'адрес';
        break;

        case 'department':
        $pageSruture = [
          ['type' => 'text', 'field' => 'name', 'desc' => 'наименование'],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'подразделение';
        break;

        //Employee case
        case 'employee':
        $pageSruture = [
          ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
          ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
          ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
          //['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->getList('Department', 'name')],
          //['type' => 'list', 'field' => 'address' , 'desc' => 'адрес', 'data' => $this->getList('Address', 'city')],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'сотрудник';
        break;

        default:
        $pageSruture = [];
        break;
      }

      /*
      return view('modal.index')
      ->with('pageSruture', $pageSruture)
      ->with('pageTitle', $pageTitle);
      */

      return dd($this->getList('Address', 'name'));
      //$cName = new Department();



      //$objName = new $cName();
      //return dd($this->factory('Department')->get());

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
