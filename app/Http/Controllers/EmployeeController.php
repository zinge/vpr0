<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
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
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $pageStructure = [
      ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
      ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
      ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
      ['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->getList('Department', ['name'])],
      ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес', 'data' => $this->getList('Address', ['city', 'street', 'house'])],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
    ];

    $pageParams = [];

    foreach (Employee::get() as $employee) {
      array_push($pageParams, [
        'id' => $employee->id,
        'firstname' => $employee->firstname,
        'patronymic' => $employee->patronymic,
        'surname' => $employee->surname,
        'department' => $employee->department->name,
        'address' => $employee->address->city.", ".$employee->address->street.", ".$employee->address->house,
        'active' => $employee->active
      ]);
    }

    return view('employee.index')
    ->with('pageStructure', $pageStructure)
    ->with('pageParams', $pageParams)
    ->with('pageTitle', 'сотрудник')
    ->with('pageHref', 'employee');
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
      'firstname' => 'required|max:30',
      'patronymic' => 'required|max:30',
      'surname' => 'required|max:30',
      // department_id
      'department' => 'required|numeric',
      // address_id
      'address' => 'required|numeric',
      'active' => 'bool'
    ]);

    $employee = new Employee([
      'firstname' => $request->firstname,
      'patronymic' => $request->patronymic,
      'surname' => $request->surname,
      'active' => $request->active
    ]);

    $employee->department()->associate($request->department);
    $employee->address()->associate($request->address);

    $employee->save();

    return [true];
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Employee  $employee
  * @return \Illuminate\Http\Response
  */
  public function show(Employee $employee)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Employee  $employee
  * @return \Illuminate\Http\Response
  */
  public function edit(Employee $employee)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Employee  $employee
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Employee $employee)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Employee  $employee
  * @return \Illuminate\Http\Response
  */
  public function destroy(Employee $employee)
  {
    //
  }
}
