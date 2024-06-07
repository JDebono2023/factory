<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DeleteLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteLogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete log files daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $logPath = storage_path('logs');
            $file = $logPath . '/schedule.log';
            File::delete($file);

            Log::channel('delete_logs')->info('Log files deleted successfully.');
        } catch (\Exception $e) {
            // Handle the logging error
            error_log('Logging to delete_logs.log failed: ' . $e->getMessage());
        }
    }
}
