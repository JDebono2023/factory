<?php

namespace App\Observers;

use App\Models\Schedule;
use App\Models\Version;

class SchedulesObserver
{
    /**
     * Handle the Schedule "created" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {
        if ($schedule->isDirty()) {

            Version::where('id', 1)->increment('version');
        }
    }

    /**
     * Handle the Schedule "updated" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function updated(Schedule $schedule)
    {
        if ($schedule->isDirty()) {

            Version::where('id', 1)->increment('version');
        }
    }

    /**
     * Handle the Schedule "deleted" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function deleted(Schedule $schedule)
    {
        // Version::where('id', 1)->increment('version');
        if ($schedule->isDirty()) {

            Version::where('id', 1)->increment('version');
        }
    }

    /**
     * Handle the Schedule "restored" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function restored(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the Schedule "force deleted" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function forceDeleted(Schedule $schedule)
    {
        //
    }
}
