<?php

namespace App\Http\Controllers;

use App\Fu;
use Illuminate\Http\Request;

use Storage;
// use Schema;

use App\Employee;
use App\Department;
use App\Address;

use App\Phone;
use App\PhoneType;
use App\IpPhone;

use App\MobilePhone;
use App\MobileType;
use App\MobileLimit;

use App\Equip;
use App\Manufacturer;
use App\EquipType;
use App\EquipModel;
use App\Holder;

use App\Service;
use App\Finposition;
use App\Contractor;
use App\AgreementString;
use App\Agreement;

use App\Akt;
use App\Aktstring;

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
                'holder' => 'балансодержатель',
                'initial_date' => 'дата ввода',
                'initial_cost' => 'балансовая стоимость',
                'serial_number' => 'инвентарный',
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
            ['name' => 'agreement', 'desc' => 'договор', 'fields' => [
              'name' => 'наименование',
              'initial_date' => 'дата ввода',
              'end_date' => 'дата окончания',
              'contractor' => 'подрядчик'
            ]],
            ['name' => 'agreementstring', 'desc' => 'строки договора', 'fields' => [
                'service' => 'сервис',
                'agreement' => 'договор',
                'department' => 'МВЗ',
                'physical' => 'физ. обьем',
                'months' => 'период, месяцев',
                'summ_cost' => 'итого по сервису',
            ]],
            ['name' => 'service', 'desc' => 'сервис', 'fields' => [
                'code' => 'код',
                'name' => 'наименование',
                'cost' => 'расценка сервиса',
                'finposition' => 'финпозиция сервиса',
            ]],
            ['name' => 'aktstring', 'desc' => 'актирование', 'fields' => [
                'akt' => 'наименование акта',
                'agreement' => 'договор',
                'service' => 'сервис',
                'physical' => 'физ. обьем',
                'summ_cost' => 'итого по сервису'
            ]],
            ['name' => 'akt', 'desc' => 'акт', 'fields' => [
                'name' => 'наименование акта',
                'billing_date' => 'дата акта',
                'billing_month' => 'расчетный месяц'
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

    private function csvToArray($file)
    {
        if (($handle = Storage::disk('local')->get($file->file_name)) !== false) {
            $data = array_map('str_getcsv', str_getcsv($handle, "\n"));
        }
        return $data;
    }

    private function replCommas($decimalValue)
    {
        $pattern='/(^\d+)(?:,(\d{2}))$/';
        $pattern_empt='/(^\d+)$/';
        if (preg_match($pattern, $decimalValue)) {
            return preg_replace($pattern, '$1.$2', $decimalValue);
        } else {
            if (preg_match($pattern_empt, $decimalValue)) {
                return preg_replace($pattern, '$1.00', $decimalValue);
            }
            return $decimalValue;
        }
    }

    private function returnId($action, $className, $fileCellValue, $classFieldName, $sepatator)
    {
        if (is_int($fileCellValue)) {
            return $fileCellValue;
        } else {
            $existingId = new $className;

            if (!is_array($classFieldName)) {
                if ($action == 'create') {
                    return $existingId->firstOrCreate(
                        [$classFieldName => trim($fileCellValue)]
                    );
                } else {
                    return $existingId->where(
                        [$classFieldName => trim($fileCellValue)]
                    )->first();
                }
            } else {
                $queryArray = [];
                $classFieldsCount = count($classFieldName);
                $classFieldValues = explode($sepatator, $fileCellValue);

                if ($action == 'create') {
                    for ($i=0; $i < $classFieldsCount; $i++) {
                        if (preg_match('/cost/', $classFieldName[$i])) {
                            $queryArray = array_merge($queryArray, [$classFieldName[$i] => $this->replCommas(trim($classFieldValues[$i]))]);
                        } else {
                            $queryArray = array_merge($queryArray, [$classFieldName[$i] => trim($classFieldValues[$i])]);
                        }
                    }

                    return $existingId->firstOrCreate($queryArray);
                } else {
                    for ($i=0; $i < $classFieldsCount; $i++) {
                        if (preg_match('/cost/', $classFieldName[$i])) {
                            $queryArray = array_merge($queryArray, [$classFieldName[$i] => $this->replCommas(trim($classFieldValues[$i]))]);
                        } else {
                            $queryArray = array_merge($queryArray, [$classFieldName[$i] => trim($classFieldValues[$i])]);
                        }
                    }

                    return $existingId->where($queryArray)->first();
                }
            }
        }
    }

    private function loadInAgreementStrings($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $agreementstring = new AgreementString;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'service':
                        $service = $this->returnId('where', 'App\Service', $cellValue, ['code', 'name'], ',');

                        $agreementstring->service()->associate($service);
                        break;

                    case 'agreement':
                        $agreement = $this->returnId('where', 'App\Agreement', $cellValue, 'name', '');

                        $agreementstring->agreement()->associate($agreement);
                        break;

                    case 'department':
                        $department = $this->returnId('where', 'App\Department', $cellValue, 'name', '');

                        $agreementstring->department()->associate($department);
                        break;

                    case 'summ_cost':
                        $agreementstring->$value = $this->replCommas($cellValue);
                        break;

                    default:
                        $agreementstring->$value = $cellValue;
                        break;
                }
            }

            $agreementstring->save();
        }
    }
    private function loadInServices($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $service = new Service;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'finposition':
                        $finposition = $this->returnId('create', 'App\Finposition', $cellValue, ['name', 'code'], ',');

                        $service->finposition()->associate($finposition);
                        break;

                    case 'cost':
                        $service->$value = $this->replCommas($cellValue);
                        break;

                    default:
                        $service->$value = $cellValue;
                        break;
                }
            }

            $service->save();
        }
    }

    private function loadInAgreements($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $agreement = new Agreement;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'contractor':
                        $contractor = $this->returnId('create', 'App\Contractor', $cellValue, 'name', '');

                        $agreement->contractor()->associate($contractor);
                        break;

                    default:
                        $agreement->$value = $cellValue;
                        break;
                }
            }

            $agreement->save();
        }
    }

    private function loadInEmployees($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $employee = new Employee;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'department':
                        $department = $this->returnId('create', 'App\Department', $cellValue, 'name', ',');

                        $employee->department()->associate($department);
                        break;

                    case 'address':
                        $address = $this->returnId('create', 'App\Address', $cellValue, ['city', 'street', 'house'], ',');

                        $employee->address()->associate($address);
                        break;

                    default:
                        $employee->$value = $cellValue;
                        break;
                }
            }

            $employee->save();
        }
    }

    private function loadInPhones($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $phone = new Phone;
            $haveEmployee = $haveMacaddr = "";

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'phone_type':
                        $phone_type = $this->returnId('create', 'App\PhoneType', $cellValue, 'name', '');

                        $phone->phone_type()->associate($phone_type);
                        break;

                    case 'employee':
                        if (!empty($cellValue)) {
                            $haveEmployee = $cellValue;
                        }
                        break;

                    case 'macaddr':
                        if (!empty($cellValue)) {
                            $haveMacaddr = $cellValue;
                        }
                        break;

                    default:
                        $phone->$value = $cellValue;
                        break;
                }
            }

            $phone->save();

            if ($haveMacaddr) {
                $ipphone = new IpPhone([
                'macaddr' => $haveMacaddr
                ]);

                $ipphone->phone()->associate($phone);

                $ipphone->save();
            }

            if ($haveEmployee) {
                $employee = $this->returnId('where', 'App\Employee', $haveEmployee, ['firstname', 'patronymic', 'surname'], ' ');

                $phone->employees()->attach($employee);
            }
        }
    }

    private function loadInMobilePhones($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $mobilephone = new MobilePhone;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'mobile_type':
                        $mobile_type = $this->returnId('create', 'App\MobileType', $cellValue, 'name', '');

                        $mobilephone->mobile_type()->associate($mobile_type);
                        break;

                    case 'mobile_limit':
                        $mobile_limit = $this->returnId('create', 'App\MobileLimit', $cellValue, 'limit_cost', '');

                        $mobilephone->mobile_limit()->associate($mobile_limit);
                        break;

                    case 'employee':
                        $employee = $this->returnId('where', 'App\Employee', $cellValue, ['firstname', 'patronymic', 'surname'], ' ');

                        $mobilephone->employee()->associate($employee);
                        break;

                    default:
                        $mobilephone->$value = $cellValue;
                        break;
                }
            }

            $mobilephone->save();
        }
    }

    private function loadInEquips($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $equip = new Equip;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'manufacturer':
                        $manufacturer = $this->returnId('create', 'App\Manufacturer', $cellValue, 'name', '');

                        $equip->manufacturer()->associate($manufacturer);
                        break;

                    case 'equip_type':
                        $equip_type = $this->returnId('create', 'App\EquipType', $cellValue, 'name', '');

                        $equip->equip_type()->associate($equip_type);
                        break;

                    case 'equip_model':
                        $equip_model = $this->returnId('create', 'App\EquipModel', $cellValue, 'name', '');

                        $equip->equip_model()->associate($equip_model);
                        break;

                    case 'holder':
                        $holder = $this->returnId('create', 'App\Holder', $cellValue, 'name', '');

                        $equip->holder()->associate($holder);
                        break;

                    case 'employee':
                        $employee = $this->returnId('where', 'App\Employee', $cellValue, ['firstname', 'patronymic', 'surname'], ' ');

                        $equip->employee()->associate($employee);
                        break;

                    case 'initial_cost':
                        $equip->$value = $this->replCommas($cellValue);
                        break;

                    default:
                        $equip->$value = $cellValue;
                        break;
                }
            }

            $equip->save();
        }
    }

    private function loadInAkts($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $akt = new Akt;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$key];

                switch ($value) {
                    case 'agreement':
                        $agreement = $this->returnId('where', 'App\Agreement', $cellValue, 'name', '');

                        $akt->agreement()->associate($agreement);
                        break;

                    default:
                        $akt->$value = $cellValue;
                        break;
                }
            }

            $akt->save();
        }
    }

    private function loadInAktStrings($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $aktstring = new Aktstring;

            foreach ($params as $key => $value) {
                switch (variable) {
                    case 'service':
                        $service = $this->returnId('where', 'App\Service', $cellValue, ['code', 'name'], ',');

                        $aktstring->service()->associate($service);
                        break;

                    case 'akt':
                        $akt = $this->returnId('where', 'App\Akt', $cellValue, 'name', '');

                        $aktstring->akt()->associate($akt);
                        break;

                    case 'summ_cost':
                        $aktstring->$value = $this->replCommas($cellValue);
                        break;

                    default:
                        $aktstring->$value = $cellValue;
                        break;
                }
            }

            $aktstring->save();
        }
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
        $csvData = $this->csvToArray($fu);

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
        $loadAssociativeParams = $request->except('_token', '_method');
        if (array_key_exists('tabName', $loadAssociativeParams)) {
            $tabName = $loadAssociativeParams['tabName'];

            unset($loadAssociativeParams['tabName']);

            // dd($loadAssociativeParams);
            switch ($tabName) {
                case 'employee':
                    $this->loadInEmployees($fu, $loadAssociativeParams);
                    break;

                case 'phone':
                    $this->loadInPhones($fu, $loadAssociativeParams);
                    break;

                case 'mobile_phone':
                    $this->loadInMobilePhones($fu, $loadAssociativeParams);
                    break;

                case 'equip':
                    $this->loadInEquips($fu, $loadAssociativeParams);
                    break;

                case 'service':
                    $this->loadInServices($fu, $loadAssociativeParams);
                    break;

                case 'agreement':
                    $this->loadInAgreements($fu, $loadAssociativeParams);
                    break;

                case 'agreementstring':
                    $this->loadInAgreementStrings($fu, $loadAssociativeParams);
                    break;

                case 'akt':
                    $this->loadInAkts($fu, $loadAssociativeParams);
                    break;

                case 'aktstring':
                    $this->loadInAktStrings($fu, $loadAssociativeParams);
                    break;

                default:
                  # code...
                    break;
            }
        }

        return redirect('/fu');
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
