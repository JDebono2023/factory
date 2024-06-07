<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Models\Version;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EventScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:factoryEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate or deactivate media items by date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // // activate event
        // $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $currentHour = $now->hour;
        $currentMinute = $now->minute;

        // Log::info('New test', [$currentHour]);
        try {
            // Log to the custom 'schedule' channel
            Log::channel('schedule')->info('Scheduler executed');
        } catch (\Exception $e) {
            // Handle the logging error
            error_log('Logging to schedule.log failed: ' . $e->getMessage());
        }

        $start = Schedule::query()
            ->whereDate('start_time', '=', $now->toDateString()) // Check if start_date is today
            ->where('visible', 0) // Only select items that are currently invisible
            ->whereRaw("HOUR(start_time) <= ?", [$currentHour]) // Check if start_time hour is less than or equal to current hour
            ->whereRaw("MINUTE(start_time) <= ?", [$currentMinute]) // Check if start_time hour is less than or equal to current hour
            ->update(['visible' => 1]);


        if ($start > 0) {
            Version::where('id', 1)->increment('version');
            Log::channel('schedule')->info('Item Turned On');
        }

        $end = Schedule::query()
            ->whereDate('end_time', '<=', $now->toDateString()) // Check if end_date is less than or equal to today
            ->where('visible', 1) // Only select items that are currently visible
            ->where(function ($query) use ($now) {
                $query->where('end_time', '<', $now) // Check if end_time is less than current time
                    ->orWhere(function ($query) use ($now) {
                        $query->whereDate('end_time', '=', $now->toDateString()) // Check if end_date is today
                            ->whereTime('end_time', '<=', $now->toTimeString()); // Check if end_time is less than or equal to current time
                    });
            })
            ->delete();

        if ($end > 0) {
            Version::where('id', 1)->increment('version');
            Log::channel('schedule')->info('Item Turned Off and Deleted');
        }
    }
}
