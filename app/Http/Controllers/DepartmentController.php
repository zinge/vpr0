<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
    // $pageSruture = [
    //   ['type' => 'text', 'field' => 'name', 'desc' => 'наименование' ],
    //   ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный?']
    // ];
    //
    // return [
    //   'pageParams' => Department::get(['id','name','active']),
    //   'pageSruture' => $pageSruture
    // ];

    return $this->createListData('Department', ['name']);  
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
      'name' => 'required|max:100',
      'active' => 'bool'
    ]);

    $department = new Department([
      'name' => $request->name,
      'active' => $request->active
    ]);

    $department->save();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Department  $department
  * @return \Illuminate\Http\Response
  */
  public function show(Department $department)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Department  $department
  * @return \Illuminate\Http\Response
  */
  public function edit(Department $department)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Department  $department
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Department $department)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Department  $department
  * @return \Illuminate\Http\Response
  */
  public function destroy(Department $department)
  {
    //
  }
}
