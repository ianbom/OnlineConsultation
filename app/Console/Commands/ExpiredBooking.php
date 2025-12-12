<?php

namespace App\Console\Commands;

use App\Jobs\ExpirePendingBookings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpiredBooking extends Command
{

    protected $signature = 'app:expired-booking';

    protected $description = 'Dispatch job untuk meng-expire booking dan payment yang sudah melewati waktu pembayaran';


    public function handle(): int
    {
        // Dispatch job ke queue
        ExpirePendingBookings::dispatch();

        $this->info('ExpirePendingBookings job berhasil dikirim ke queue.');
        

        return Command::SUCCESS;
    }
}
