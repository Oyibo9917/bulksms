<?php

namespace App\Imports;

use App\Models\Contacts;
use App\Models\Groups;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use PhpOffice\PhpSpreadsheet\Shared\Date;

//class ContactsImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnError
class ContactsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model(Contacts)|null
    */
    public function model(array $row)
    {
		try{		
			if($row['email'] != ''){
				$contactExists = Contacts::whereMobileNo($row['mobile_no'])
										->orWhere(['email' => $row['email']])
										->first();
			}else{
				$contactExists = Contacts::whereMobileNo($row['mobile_no'])->first();	
			}
			
			if(!$contactExists){
				$group = false;
				if($row['group_code'] != '')
					$group = Groups::whereRefCode(strtoupper($row['group_code']))->first();
				if($row['name'] == '')
					$row['name'] = null;
				if($row['gender'] == '')
					$row['gender'] = null;
				if($row['gender'] == 'M' || $row['gender'] == 'm' || $row['gender'] == 1)
					$row['gender'] = 1;
				if($row['gender'] == 'F' || $row['gender'] == 'f' || $row['gender'] == 2)
					$row['gender'] = 2;
				$row['birth_date'];
				if($row['birth_date'] == '' || strlen($row['birth_date']) == ''){
					$row['birth_date'] = null;
				}else{
					$bd = (array)Date::excelToDateTimeObject($row['birth_date']); //Date::dateTimeToExcel($row['birth_date']) for export
					$row['birth_date'] = date('Y-m-d', strtotime($bd['date']));
				}
				if($row['address'] == '')
					$row['address'] = null;
				if($row['email'] == '')
					$row['email'] = null;
				
				//header('HTTP/1.1 500 Company Name: '.$row['gender']);
				//exit();
				
				return new Contacts([
					'name'     => $row['name'],
					'gender'    => $row['gender'], 
					'birth_date' => $row['birth_date'],
					'address'    => $row['address'], 
					'email' => $row['email'],
					'mobile_no'    => $row['mobile_no'], 
					'contact_group_id' => ($row['group_code'] != '' && $group) ? $group->id : null
				]);
			}
			
			return null;
		}catch(\Exception $e){
			exit();
		}
    }
}
