<?php

namespace App\Console\Commands;

use App\Jobs\CheckRescheduleStatus;
use Illuminate\Console\Command;

class CancellAllReschedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reschedule:auto-reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-reject pending reschedule requests that are less than 2 hours before session starts';

    /**
     * Execute the console command.
     *
     * This command dispatches CheckRescheduleStatus job to handle the logic.
     *
     * Can be run manually: php artisan reschedule:auto-reject
     * Or automatically via scheduler (every minute)
     */
    public function handle()
    {
        $this->info('Dispatching CheckRescheduleStatus job...');

        try {
            // Dispatch job untuk handle reschedule auto-reject
            CheckRescheduleStatus::dispatch();

            $this->info('✓ Job dispatched successfully!');
            $this->info('Check logs for detailed results.');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
