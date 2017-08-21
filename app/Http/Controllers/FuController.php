<?php

namespace App\Http\Controllers;

use App\Fu;
use Illuminate\Http\Request;

use Storage;
use Schema;

use App\Employee;

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
        $tableStructure = [
            ['name' => 'employee', 'desc' => 'сотрудник', 'fields' => [
                'firstname' => 'имя',
                'patronymic' => 'отчество',
                'surname' => 'фамилия',
                'department' => 'отдел',
                'address' => 'адрес'
            ]],
            ['name' => 'equip', 'desc' => 'оборудование','fields' => [
                'name' => 'наименование',
                'manufacturer' => 'производитель',
                'equip_type' => 'тип',
                'equip_model' => 'модель',
                'employee' => 'сотрудник',
                'initial_date' => 'дата ввода',
                'initial_cost' => 'балансовая стоимость',
                'serial_number' => 'серийный',
                'sap_number' => 'SAP',
                'manufacturer_number' => 'заводской'
            ]],
            ['name' => 'phone', 'desc' => 'телефон', 'fields' => [
                'number' => 'номер',
                'phone_type' => 'тип',
                'employee' => 'сотрудник',
                'macaddr' => 'MAC'
            ]],
            ['name' => 'mobile_phone', 'desc' => 'мобильный телефон', 'fields' => [
                'number' => 'номер',
                'mobile_type' => 'тип',
                'mobile_limit' => 'лимит',
                'employee' => 'сотрудник'
            ]],
            ['name' => 'service', 'desc' => 'сервис', 'fields' => [
                'name' => 'наименование',
                'agreement' => 'договор',
                'initial_date' => 'дата ввода',
                'end_date' => 'дата окончания',
                'contractor' => 'подрядчик',
                'cost' => 'расценка сервиса',
                'finposition' => 'финпозиция сервиса',
                'physical' => 'физ. обьем',
                'summ_cost' => 'итого по сервису',
                'department' => 'МВЗ'
            ]],
            ['name' => 'aktstring', 'desc' => 'актирование', 'fields' => [
                'akt' => 'наименование акта',
                'billing_date' => 'дата акта',
                'billing_month' => 'расчетный месяц',
                'agreement' => 'договор',
                'service' => 'сервис',
                'physical' => 'физ. обьем',
                'summ_cost' => 'итого по сервису'
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

    private function loadInEmployees($file, $params)
    {
      if (($handle = Storage::disk('local')->get($file->file_name)) !== false) {
          $csvData = array_map('str_getcsv', str_getcsv($handle, "\n"));
      }

      $stringsInFile = count($csvData);

      for ($i=0; $i < $stringsInFile; $i++) {
        $elementsInString = count($csvData[$i]);

        for ($j=0; $j < $elementsInString; $j++) {
          // print "j= ".$j.", val = ".$csvData[$i][$j];


        }
      }

      // foreach ($csvData as $fileString) {
      //   print $n;
      //   foreach ($fileString as $key => $value) {
      //     print $key . " = " . $value;
      //   }
      //   $n++;
      // }
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
        ->with('pageParams', ['id' => $fu->id, 'file_name' => $fu->file_name]);
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
        $params = $request->except('_token', '_method');
          if (array_key_exists('tabName', $params)) {
            $tabName = $params['tabName'];

            unset($params['tabName']);

            switch ($tabName) {
              case 'employee':
                  $this->loadInEmployees($fu, $params);
                break;

              default:
                # code...
                break;
            }
          }

          // return redirect('/fu');
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
