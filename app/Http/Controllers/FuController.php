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

    private function loadInEmployees($file, $params)
    {
        $csvData = $this->csvToArray($file);

        $stringsInFile = count($csvData);

        for ($i=0; $i < $stringsInFile; $i++) {
            $employee = new Employee;

            foreach ($params as $key => $value) {
                $cellValue = $csvData[$i][$value-1];

                switch ($key) {
                    case 'department':
                        if (is_int($cellValue)) {
                            $department = $cellValue;
                        } else {
                            $department = Department::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

                        $employee->department()->associate($department);
                        break;

                    case 'address':
                        if (is_int($cellValue)) {
                            $address = $cellValue;
                        } else {
                            $addressValues = explode(",", $cellValue);

                            $address = Address::firstOrCreate([
                            'city' => trim($addressValues[0]),
                            'street' => trim($addressValues[1]),
                            'house' => trim($addressValues[2])
                            ]);
                        }

                        $employee->address()->associate($address);
                        break;

                    default:
                        $employee->$key = $cellValue;
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
                $cellValue = $csvData[$i][$value-1];

                switch ($key) {
                    case 'phone_type':
                        if (is_int($cellValue)) {
                            $phone_type = $cellValue;
                        } else {
                            $phone_type = PhoneType::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

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
                        $phone->$key = $cellValue;
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
                if (is_int($haveEmployee)) {
                    $employee = $haveEmployee;
                } else {
                    $employeeValues = explode(" ", $haveEmployee);

                    $employee = Employee::where('firstname', trim($employeeValues[0]))
                    ->where('patronymic', trim($employeeValues[1]))
                    ->where('surname', trim($employeeValues[2]))
                    ->first();
                }

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
                $cellValue = $csvData[$i][$value-1];

                switch ($key) {
                    case 'mobile_type':
                        if (is_int($cellValue)) {
                            $mobile_type = $cellValue;
                        } else {
                            $mobile_type = MobileType::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

                        $mobilephone->mobile_type()->associate($mobile_type);
                        break;

                    case 'mobile_limit':
                        if (is_int($cellValue)) {
                            $mobile_limit = $cellValue;
                        } else {
                            $mobile_limit = MobileLimit::firstOrCreate(
                                ['limit_cost' => $this->replCommas($cellValue)]
                            );
                        }
                        
                        $mobilephone->mobile_limit()->associate($mobile_limit);
                        break;

                    case 'employee':
                        if (is_int($cellValue)) {
                            $employee = $cellValue;
                        } else {
                            $employeeValues = explode(" ", $cellValue);

                            $employee = Employee::where('firstname', trim($employeeValues[0]))
                            ->where('patronymic', trim($employeeValues[1]))
                            ->where('surname', trim($employeeValues[2]))
                            ->first();
                        }
                        
                        $mobilephone->employee()->associate($employee);
                        break;
                    
                    default:
                        $mobilephone->$key = $cellValue;
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
                $cellValue = $csvData[$i][$value-1];

                switch ($key) {
                    case 'manufacturer':
                        if (is_int($cellValue)) {
                            $manufacturer = $cellValue;
                        } else {
                            $manufacturer = Manufacturer::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

                        $equip->manufacturer()->associate($manufacturer);
                        break;
                    
                    case 'equip_type':
                        if (is_int($cellValue)) {
                            $equip_type = $cellValue;
                        } else {
                            $equip_type = EquipType::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

                        $equip->equip_type()->associate($equip_type);
                        break;

                    case 'equip_model':
                        if (is_int($cellValue)) {
                            $equip_model = $cellValue;
                        } else {
                            $equip_model = EquipModel::firstOrCreate(
                                ['name' => $cellValue]
                            );
                        }

                        $equip->equip_model()->associate($equip_model);
                        break;

                    case 'employee':
                        if (is_int($cellValue)) {
                            $employee = $cellValue;
                        } else {
                            $employeeValues = explode(" ", $cellValue);

                            $employee = Employee::where('firstname', trim($employeeValues[0]))
                            ->where('patronymic', trim($employeeValues[1]))
                            ->where('surname', trim($employeeValues[2]))
                            ->first();
                        }
                        
                        $equip->employee()->associate($employee);
                        break;

                    default:
                        if ($key = 'initial_cost') {
                            $cellValue = $this->replCommas($cellValue);
                        }
                        
                        $equip->$key = $cellValue;
                        break;
                }
            }

            $equip->save();
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
