<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Models\Contacts;
use App\Models\SmsHistory;
use App\Models\Groups;
use App\Traits\NotificationHelper;
use Carbon\Carbon;

trait SMSManager
{
    use NotificationHelper;
    
    // protected $apiUrl = 'https://my.kudisms.net/api/sms?token=45cQHF7Bfgm0KIaAsWE1jw9kGTDXtVNv6PuqpMxRYCzhSZLol8yUO3iJn2bedr&senderID=Lana%20Hos&recipients=2348067290192&message=XXX&gateway=2';
    protected $apiUrl = 'https://my.kudisms.net/api/';
    protected $header = 'Lana Hos';
    // protected $header = 'Prime Test';
    protected $token  = 'eWjkmJQEF9CHBDrvVZpGYTdP1fa5NKUgtyz7xXM62uw84nRSLI0oscOhq3blAi'; //lana hosp
    // protected $token  = '45cQHF7Bfgm0KIaAsWE1jw9kGTDXtVNv6PuqpMxRYCzhSZLol8yUO3iJn2bedr'; //prime-test

   
    protected $senderId  = 'Lana Hosp';
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Send bulk SMS messages.
     *
     * @param array $recipients
     * @param string $message
     * @return bool
     */
    public function sendSMS($data, $birthday_or_schedule = false)
    {
        $mobileNumbers = '';
        $responseData = [];

        if(isset($data['groups']) && $data['groups'] === 'all') {
            $mobileNumbers = Contacts::whereNotNull('mobile_no')->where('active', 1)->pluck('mobile_no')->implode(',');
        }

        if(isset($data['groups']) && $data['groups'] === 'select_group') {
            $mobileNumbers = Contacts::whereNotNull('mobile_no')->where('active', 1)->whereIn('contact_group_id', $data['Groups'])->pluck('mobile_no')->implode(',');
        }

        if(isset($data['groups']) && $data['groups'] === 'from_contacts') {
            $mobileNumbers = Contacts::whereIn('id', $data['numbers_from_contacts'])->where('active', 1)->pluck('mobile_no')->implode(',');
        }

        if(isset($data['groups']) && $data['groups'] === 'enter_numbers') {
            $mobileNumbers = str_replace(' ', ',', $data['numbers']);            
        }

        if($birthday_or_schedule == true) {
            if (is_array($data['numbers'])) {
                $mobileNumbers = implode(',', $data['numbers']);
            } else {
                $mobileNumbers = $data['numbers'];
            }
        }

        if(empty($mobileNumbers) || empty($data['content'])) {
            $this->failure('Incorrect credencials');
        }

        // First, split the mobile numbers string into an array of individual numbers
$mobileNumbers_ = explode(",", $mobileNumbers);

        // Split the mobile numbers array into chunks of 30
        $chunkedNumbers = array_chunk($mobileNumbers_, 30);
        
        foreach ($chunkedNumbers as $chunk) {
            // Join the chunk back into a string
            $chunkedNumbersString = implode(",", $chunk);
        
            // Prepare the $options array for each chunk
            $options = [
                'multipart' => [
                    [
                        'name' => 'token',
                        'contents' => $this->token
                    ],
                    [
                        'name' => 'senderID',
                        'contents' => $this->senderId
                    ],
                    [
                        'name' => 'recipients',
                        'contents' => $chunkedNumbersString
                    ],
                    [
                        'name' => 'message',
                        'contents' => $data['content']
                    ],
                    [
                        'name' => 'gateway',
                        'contents' => '2'
                    ]
                ]
            ];
        
            try {
                // Build the request for each chunk
                $request = new Request('GET', $this->apiUrl . '/sms?token=' . $this->token . '&senderID=' . 
                    $this->senderId . '&recipients=' . $chunkedNumbersString . '&message=' . $data['content'] . '&gateway=2');
                
                // Send the request asynchronously
                $client = new Client();
                $res = $client->sendAsync($request, $options)->wait();
                $body = $res->getBody()->getContents();
                $responseData = json_decode($body, true);
        
                // After sending the SMS, process each number in the chunk
                foreach ($chunk as $mobileNumber) {
                    $dt['numbers'] = $mobileNumber;
                    $dt['content'] = $data['content'];
        
                    // Record SMS history for each mobile number
                    $this->createSmsHistory($dt, $responseData);
                }
        
                // Check the response and log success/failure
                if (isset($responseData['error_code']) && $responseData['error_code'] === '000') {
                    $this->success('Sent successfully');
                } else {
                    $this->warning('Something went wrong !!');
                }
        
            } catch (\Exception $e) {
                // Handle exceptions (e.g., API failure)
                $this->warning('An error occurred !!');
            }
        }

        return $responseData;
    }

    /**
     * Check SMS balance.
     *
     * @return float
     */
    public function checkSMSBalance()
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => $this->token
                ]
            ]
        ];

        $request = new Request('POST', $this->apiUrl . '/balance');

        try {
            $client = new Client();
            $res = $client->sendAsync($request, $options)->wait();
            $body = $res->getBody()->getContents();
            $responseData = json_decode($body, true);


            if (isset($responseData['msg'])) {
                $bal =  $responseData['msg'];
                // $this->fund($bal);

                return $bal;
            } else {
                return 0.0;
            }
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    private function fund($amount) {
        if($amount > 200) {
            return; // No need to proceed if amount is greater than 200
        }

        $funding_reminder = \App\Models\FundingReminder::first();
        $currentWeek = Carbon::now()->week;

        // Check if the reminder is empty or if the current week is different from the updated week
        if(empty($funding_reminder) || $currentWeek !== Carbon::parse($funding_reminder->updated_at)->week) {
            $data['numbers'] = '08067290192';
            $data['content'] = 'Please fund bulksms, Balance is ' . $amount;

            $this->sendSMS($data, true);
            if($funding_reminder) {
                $funding_reminder->is_sent = !$funding_reminder->is_sent;
                $funding_reminder->save();
            } else {
                \App\Models\FundingReminder::create([
                    'is_sent' => 1
                ]);
            }
        }
    }
    /**
     * Get your account sms delivery report
     * @return mixed
     */
    public function getDeliveryReport()
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => $this->token
                ]
            ]
        ];

        $request = new Request('get', $this->apiUrl . '?action=reports');
        $client = new Client();
        $res = $client->sendAsync($request, $options)->wait();
        $body = $res->getBody()->getContents();

        $responseData = json_decode($body, true);
    }

    public function createSmsHistory($data, $result) {
        $number = $data['numbers'] ?? '';
        $message = $data['content'] ?? '';
        $status = is_null($result) ? false : ($result['error_code'] === '000');
        $groupName = null;
        $name = null;

        $contact = Contacts::where('mobile_no', $number)->first();
    
        if($contact) {
            $group = Groups::find($contact->contact_group_id);
            $groupName = $group ? $group->name : null;
            $name = $contact->name;
        }
    
        SmsHistory::create([
            'name'        => $name,
            'number'      => $number,
            'message'     => $message,
            'status'      => $status,
            'group_name'  => $groupName,
        ]);
    }
    
}
