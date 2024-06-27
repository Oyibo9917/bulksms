<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\SMSManager;
use App\Models\Scheduler;
use App\Models\Messages;
use App\Models\ScheduleHistory;

class SchedulerMessagesCommand extends Command
{
    use SMSManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scheduler-messages-command';

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
        $data = [];
        $response = [];
        $currentTime = now();
        $windowStart = $currentTime->clone()->subMinutes(5);
        $windowEnd = $currentTime->clone()->addMinutes(5);

        $schedules = Scheduler::where('active', true)
            ->whereDate('scheduled_at', $currentTime)
            ->whereNotNull('message_id')
            ->whereNotNull('scheduled_contact')
            ->get()
            ->toArray();

        if (empty($schedules)) {
            return;
        }

        foreach ($schedules as $schedule) {
            $message = Messages::find($schedule['message_id'])->content;
        
            $dateTime = \Carbon\Carbon::parse($schedule['scheduled_at']);
            $scheduledMonth = (int)$dateTime->format('n'); 
            $scheduledDay = (int)$dateTime->format('N'); 
            $scheduledTime = $dateTime->format('H:i');
        
            if (!$message) {
                continue; // Skip to next iteration if message not found
            }

            $data['numbers'] = str_replace('"', '', trim($schedule['scheduled_contact'], "\"[]"));
            $data['content'] = $message . ' Lana hosp';

            $now = \Carbon\Carbon::now();
            $currentMonth = (int)$now->format('n'); 
            $currentDay = (int)$now->format('N'); 
            $currentTime = $now->format('H:i');

            // once 25-1-31
            // every_weekday Monday
            // every_day

            // Adjust conditions accordingly
            // dd( $schedule, $scheduledMonth , $currentMonth , $scheduledDay , $currentDay , $scheduledTime , $currentTime);

            if ( ($schedule['frequency'] === 'once' || $schedule['frequency'] === 'every_weekday') && 
                ( $scheduledMonth === $currentMonth && $scheduledDay === $currentDay && $scheduledTime === $currentTime )) {
                if($schedule['frequency'] === 'once') {
                    $this->deActivateSchedule($schedule['id']);
                }
                $response = $this->sendSMS($data, true);
                $this->createScheduleHistory($data, $schedule['frequency'], $response);
            } elseif ($schedule['frequency'] === 'every_day' && $scheduledTime === $currentTime) {
                $response = $this->sendSMS($data, true);
                $this->createScheduleHistory($data, $schedule['frequency'], $response);
            }
        }
    }

    private function deActivateSchedule($sheduleId) {
        $disableSchedule = Scheduler::find($sheduleId);
        $disableSchedule->active = false;
        $disableSchedule->save();
    }

    private function createScheduleHistory($data, $frequency, $response) {
        $error_code = is_null($response) ? false : $response['error_code'] === '000';

        ScheduleHistory::create([
            'contacts'      => $data['numbers'], 
            'message'       => $data['content'], 
            'delivered_at'  => now(), 
            'frequency'     => $frequency, 
            'status'        => $error_code,
        ]);
    }
}
