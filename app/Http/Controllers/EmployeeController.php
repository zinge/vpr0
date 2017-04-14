<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
          ['type' => 'text', 'field' => 'firstname', 'desc' => 'имя'],
          ['type' => 'text', 'field' => 'patronymic', 'desc' => 'отчество'],
          ['type' => 'text', 'field' => 'surname', 'desc' => 'фамилия'],
          ['type' => 'list', 'field' => 'department', 'desc' => 'подразделение'],
          ['type' => 'list', 'field' => 'address' , 'desc' => 'адрес'],
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
            'address' => $department->address->city.", ".$department->address->street.", ".$department->address->house,
            'active' => $employee->active]);
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
