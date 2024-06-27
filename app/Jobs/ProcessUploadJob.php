<?php

namespace App\Jobs;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Contacts;
use App\Models\UploadStatus;
use App\Models\Groups;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = storage_path('app/public/' . $this->data['attachment']);
        $errors = [];

        if (!file_exists($filePath)) {
            // File does not exist
            dd("File does not exist at: " . $filePath);
        }

        $excelSpreadSheetData = Excel::toCollection(null, $filePath);
        
        $records = $excelSpreadSheetData[0]->toArray();

        collect($records)->skip(1)->each(function ($row, $index) use(&$countFailures, &$countSuccess, &$errors){
            $birthDate = null;
            $contactMobileNumberExists = null;
            $contactEmailExists = null;
            $countSuccess = 0;

            try { 
                if($row[5] != ''){
                    $contactMobileNumberExists = Contacts::where('mobile_no', $row[5])->first();
                    if(! is_null($contactMobileNumberExists)) $errors[$index]['mobile_no'] = $contactMobileNumberExists->mobile_no;
                    
                }
                
                if($row[4] != '') {
                    $contactEmailExists = Contacts::where('email', $row[4])->first();
                    if(! is_null($contactEmailExists)) $errors[$index]['email'] = $contactEmailExists->email;
                }

                if (!empty($row[2])) {
                    if (is_numeric($row[2])) {
                        $birthDate = Date::excelToDateTimeObject($row[2])->format('Y-m-d');
                    } else {
                        $errors[$index]['birth_date'] = $row[0];
                    }
                }

                if( is_null($contactEmailExists) && ( is_null($contactMobileNumberExists)) ) {
                    $refCode = $row[6] ?? 'CG-PATIENT';
                    $group = Groups::where('ref_code', $refCode)->first();
                    if(! $group)
                        $group = Groups::where('ref_code', 'CG-PATIENT')->first();

                    Contacts::create([
                        'name' => ucwords($row[0]) ?? 'John Doe',
                        'gender' => strtoupper(trim($row[1])) ?? 'M',
                        'birth_date' => $birthDate ?? null,
                        'address' => $row[3] ?? '',
                        'email' => $row[4] ?? '',
                        'mobile_no' => $row[5],
                        'contact_group_id' => $group->id,
                    ]);
                } else {
                    // do something here
                }
            } catch(\Exception $e) {
                // do something here

            }
        });

        $mobileNumbers = [];
        $emails = [];
        $birthDates = [];

        foreach ($errors as $key => $value) {
            if (isset($value['mobile_no'])) {
                $mobileNumbers[] = $value['mobile_no'];
            }
            if (isset($value['email'])) {
                $emails[] = $value['email'];
            }
            if (isset($value['birth_date'])) {
                $birthDates[] = $value['birth_date'];
            }
        }

        UploadStatus::create([
            'mobile_numbers' => implode(', ', $mobileNumbers),
            'email' => implode(', ', $emails),
            'birth_date' => implode(', ', $birthDates)
        ]);
        
    }
}
