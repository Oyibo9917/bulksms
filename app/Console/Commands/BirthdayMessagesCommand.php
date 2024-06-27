<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contacts;
use App\Models\Messages;
use App\Traits\SMSManager;

class BirthdayMessagesCommand extends Command
{
    use SMSManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:birthday-messages-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mobileNumbers = Contacts::whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [now()->format('m-d')])
                            ->pluck('mobile_no')
                            ->toArray();
        
        // $mobileNumbers = Contacts::whereMonth('birth_date', now()->month)
        //                 ->whereDay('birth_date', now()->day)
        //                 ->pluck('mobile_no')
        //                 ->toArray();

        if (empty($mobileNumbers)) {
            return;
        }

        $message = Messages::where('type', 'BIRTHDAY')->where('active', 1)->first();

        if ($message) {
            $messageContent = $message->content;
        } else {
            $messageContent = "Happy Birthday! May your day be filled with joy, laughter, and unforgettable moments";
        }

        $data['content'] = $messageContent . ' Lana Hosp';

        foreach($mobileNumbers as $mobileNumber)
        {
            $data['numbers'] = $mobileNumber;

            $result = $this->sendSMS($data, true);
        }
    }
}
