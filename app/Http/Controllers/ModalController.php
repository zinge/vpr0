<?php

namespace App\Http\Controllers;

use App\Modal;
use Illuminate\Http\Request;

use App\Department;

class ModalController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    //

    if (isset($request['m'])) {
      switch ($request->m) {
        case 'address':
        $department_data = [];

        foreach (Department::get() as $department) {
          array_push($department_data, [
            'id' => $department->id,
            'val' => $department->name
          ]);
        }
        $pageSruture = [
          ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
          ['type' => 'text', 'field' => 'street', 'desc' => 'улица'],
          ['type' => 'text', 'field' => 'house', 'desc' => 'дом'],
          //['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $department_data],
          ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
        ];
        $pageTitle = 'адрес';
        break;

        default:
        $pageSruture = [];
        break;
      }

      return view('modal.index')
      ->with('pageSruture', $pageSruture)
      ->with('pageTitle', $pageTitle);

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
