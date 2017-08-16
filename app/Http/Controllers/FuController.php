<?php

namespace App\Http\Controllers;

use App\Fu;
use Illuminate\Http\Request;

use Storage;

class FuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function createPageStructure()
    {
        $pageStructure = [
        ['type' => 'file', 'field' => 'file_name', 'desc' => 'имя файла'],
        ['type' => 'none', 'field' => 'mime_type', 'desc' => 'тип файла'],
        ['type' => 'none', 'field' => 'original_filename', 'desc' => 'оригинальное имя файла'],
        ];

        return $pageStructure;
    }

    private function uploadTables()
    {
        // $tableStructure = [
        //     ['name' => 'employee', 'desc' => 'сотрудник', 'fields' => [
        //         'firstname' => 'имя',
        //         'patronymic' => 'отчество',
        //         'surname' => 'фамилия',
        //         'department' => 'отдел',
        //         'address' => 'адрес'
        //     ]],
        //     ['name' => 'equip', 'desc' => 'оборудование','fields' => [
        //         'name' => 'наименование',
        //         'manufacturer' => 'производитель',
        //         'equip_type' => 'тип',
        //         'equip_model' => 'модель',
        //         'employee' => 'сотрудник',
        //         'initial_date' => 'дата ввода',
        //         'initial_cost' => 'балансовая стоимость',
        //         'serial_number' => 'серийный',
        //         'sap_number' => 'SAP',
        //         'manufacturer_number' => 'заводской'
        //     ]],
        //     ['name' => 'phone', 'desc' => 'телефон', 'fields' => [
        //         'number' => 'номер',
        //         'phone_type' => 'тип',
        //         'employee' => 'сотрудник',
        //         'macaddr' => 'MAC'
        //     ]],
        //     ['name' => 'mobile_phone', 'desc' => 'мобильный телефон', 'fields' => [
        //         'number' => 'номер',
        //         'mobile_type' => 'тип',
        //         'mobile_limit' => 'лимит',
        //         'employee' => 'сотрудник'
        //     ]],
        //     ['name' => 'service', 'desc' => 'сервис', 'fields' => [
        //         'name' => 'наименование',
        //         'agreement' => 'договор',
        //         'initial_date' => 'дата ввода',
        //         'end_date' => 'дата окончания',
        //         'contractor' => 'подрядчик',
        //         'cost' => 'расценка сервиса',
        //         'finposition' => 'финпозиция сервиса',
        //         'physical' => 'физ. обьем',
        //         'summ_cost' => 'итого по сервису',
        //         'department' => 'МВЗ'
        //     ]],
        //     ['name' => 'aktstring', 'desc' => 'актирование', 'fields' => [
        //         'akt' => 'наименование акта',
        //         'billing_date' => 'дата акта',
        //         'billing_month' => 'расчетный месяц',
        //         'agreement' => 'договор',
        //         'service' => 'сервис',
        //         'physical' => 'физ. обьем',
        //         'summ_cost' => 'итого по сервису'
        //     ]]
        // ];

        $tableStructure = [
            ['name' => 'employee', 'desc' => 'сотрудник', 'fields' => [
                0 => 'имя',//'firstname'
                1 => 'отчество',//'patronymic'
                2 => 'фамилия',//'surname'
                3 => 'отдел',//'department'
                4 => 'адрес'//'address'
            ]],
            ['name' => 'equip', 'desc' => 'оборудование','fields' => [
                0 => 'наименование',//'name'
                1 => 'производитель',//'manufacturer'
                2 => 'тип',//'equip_type'
                3 => 'модель',//'equip_model'
                4 => 'сотрудник',//'employee'
                5 => 'дата ввода',//'initial_date'
                6 => 'балансовая стоимость',//'initial_cost'
                7 => 'серийный',//'serial_number'
                8 => 'SAP',//'sap_number'
                9 => 'заводской'//'manufacturer_number'
            ]],
            ['name' => 'phone', 'desc' => 'телефон', 'fields' => [
                0 => 'номер',//'number'
                1 => 'тип',//'phone_type'
                2 => 'сотрудник',//'employee'
                3 => 'MAC'//'macaddr'
            ]],
            ['name' => 'mobile_phone', 'desc' => 'мобильный телефон', 'fields' => [
                0 => 'номер',//'number'
                1 => 'тип',//'mobile_type'
                2 => 'лимит',//'mobile_limit'
                3 => 'сотрудник'//'employee'
            ]],
            ['name' => 'service', 'desc' => 'сервис', 'fields' => [
                0 => 'наименование',//'name'
                1 => 'договор',//'agreement'
                2 => 'дата ввода',//'initial_date'
                3 => 'дата окончания',//'end_date'
                4 => 'подрядчик',//'contractor'
                5 => 'расценка сервиса',//'cost'
                6 => 'финпозиция сервиса',//'finposition'
                7 => 'физ. обьем',//'physical'
                8 => 'итого по сервису',//'summ_cost'
                9 => 'МВЗ'//'department'
            ]],
            ['name' => 'aktstring', 'desc' => 'актирование', 'fields' => [
                0 => 'наименование акта', //'akt'
                1 => 'дата акта', //'billing_date'
                2 => 'расчетный месяц',//'billing_month'
                3 => 'договор',//'agreement'
                4 => 'сервис',//'service'
                5 => 'физ. обьем',//'physical'
                6 => 'итого по сервису'//'summ_cost'
            ]]
        ];

        return $tableStructure;
    }

    /**
     * Create main table in page params
     *
     * @return $pageParams[]
     */
    private function createPageParams($id)
    {
        $pageParams = [];

        $files = $id ? Fu::find([$id]) : Fu::get();

        foreach ($files as $file) {
            array_push($pageParams, [
            'id' => $file->id,
            'file_name' => $file->file_name,
            'mime_type' => $file->mime_type,
            'original_filename' => $file->original_filename,
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
        //
        return view('fileupload.index')
        ->with('pageStructure', $this->createPageStructure())
        ->with('pageParams', $this->createPageParams(''))
        ->with('pageTitle', 'файл')
        ->with('pageHref', 'fu');
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
        'file_name' => ['file', 'mimes:csv,txt', 'mimetypes:text/csv,text/plain']
        ]);

        $file = $request->file('file_name');
        $fileExt = $file->getClientOriginalExtension();
        Storage::disk('local')->put(
            'files/'.$file->getFilename().'.'.$fileExt,
            file_get_contents($file->getRealPath())
        );
        Fu::create([
        'mime_type' => $file->getClientMimeType(),
        'original_filename' => $file->getClientOriginalName(),
        'file_name' => 'files/'.$file->getFilename().'.'.$fileExt,
        ]);
        return redirect('/fu');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Fu  $fu
    * @return \Illuminate\Http\Response
    */
    public function show(Fu $fu)
    {
        //
        if (($handle = Storage::disk('local')->get($fu->file_name)) !== false) {
            $csvData = array_map('str_getcsv', str_getcsv($handle, "\n"));
        }
        return view('fileupload.show')
        ->with('tableData', count($csvData) > 3 ? array_slice($csvData, 0, 3) : $csvData)
        ->with('uploadTables', $this->uploadTables())
        ->with('pageHref', 'fu')
        ->with('pageTitle', $fu->file_name)
        ->with('pageParams', $this->createPageParams($fu->id));
        // dd($this->uploadTables());
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Fu  $fu
    * @return \Illuminate\Http\Response
    * @return \Illuminate\Http\Response
    */
    public function edit(Fu $fu)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Fu  $fu
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Fu $fu)
    {
        //
        dd($fu);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Fu  $fu
    * @return \Illuminate\Http\Response
    */
    public function destroy(Fu $fu)
    {
        //
        Storage::delete($fu->file_name);

        $fu->delete();

        return redirect('/fu');
    }
}
