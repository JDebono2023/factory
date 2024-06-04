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
        Log::info('Delete function triggered');
        $logPath = storage_path('logs');

        // Iterate through log files and delete them
        $logFiles = File::glob($logPath . '/*.log');
        foreach ($logFiles as $file) {
            File::delete($file);
        }

        $this->info('Log files deleted successfully.');
    }
}
