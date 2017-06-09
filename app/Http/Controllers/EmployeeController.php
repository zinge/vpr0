<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
      ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
      ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
      ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
      ['type' => 'list', 'field' => 'department', 'desc' => 'подразделение', 'data' => $this->createListData('Department', ['name'])],
      ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес', 'data' => $this->createListData('Address', ['city', 'street', 'house'])],
      ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный?']
    ];

    return $pageStructure;
  }

  private function createListModalParams()
  {
    $modalParams = [
      'department' => [
        ['type'=>'text', 'field' => 'name', 'desc' => 'подразделение'],
        ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный ?']
      ],
      'address' => [
        ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
        ['type' => 'text', 'field' => 'street', 'desc' => 'улица'],
        ['type' => 'text', 'field' => 'house', 'desc' => 'дом'],
        ['type' => 'checkbox', 'field' => 'active', 'desc' => 'активный?']
      ]
    ];

    return $modalParams;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $employees = $id ? Employee::find([$id]) : Employee::get();

    foreach ($employees as $employee) {
      array_push($pageParams, [
        'id' => $employee->id,
        'firstname' => $employee->firstname,
        'patronymic' => $employee->patronymic,
        'surname' => $employee->surname,
        'department' => $id ? $employee->department_id : $employee->department->name,
        'address' => $id ? $employee->address_id : $employee->address->city.", ".$employee->address->street.", ".$employee->address->house,
        'active' => $employee->active
      ]);
    }

    return $pageParams;
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('employee.index')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams(''))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'сотрудник')
    ->with('pageHref', 'employee');

  //  return dd($this->createListModalParams());
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

      'department' => 'required|numeric', // department_id
      'address' => 'required|numeric', // address_id
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

    return 0;
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
    /**/
    return view('employee.edit')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams($employee->id))
    ->with('modalParams', $this->createListModalParams())
    ->with('pageTitle', 'сотрудник')
    ->with('pageHref', 'employee');
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
    $this->validate($request, [
      'firstname' => 'required|max:30',
      'patronymic' => 'required|max:30',
      'surname' => 'required|max:30',
      'department' => 'required|numeric', // department_id
      'address' => 'required|numeric', // address_id
      'active' => 'bool'
    ]);

    $employee->department()->associate($request->department);
    $employee->address()->associate($request->address);

    $employee->update([
      'firstname' => $request->firstname,
      'patronymic' => $request->patronymic,
      'surname' => $request->surname,
      'active' => $request->active,
    ]);

    return 0;
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

    $employee->delete();

    return redirect('/employee');
  }
}
