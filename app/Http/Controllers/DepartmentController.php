<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    $pageSruture = [
      ['type' => 'text', 'field' => 'name', 'desc' => 'наименование' ],
      ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес'],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный?']
    ];

    $pageParams = [];

    foreach (Department::get() as $department) {
      array_push($pageParams, [
        'id' => $department->id,
        'name' => $department->name,
        'active' => $department->active,
        'address' => $department->address->city.", ".$department->address->street.", ".$department->address->house
      ]);
    }

    return [
      'pageParams' => $pageParams,
      'pageSruture' => $pageSruture
    ];

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
