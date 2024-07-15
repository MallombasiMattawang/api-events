<?php

namespace App\Console\Commands;

use App\Models\EventMember;
use Illuminate\Console\Command;

class DeletePendingRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-pending-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = EventMember::where('status', 'PENDING')->delete(); // Ganti dengan model dan kondisi yang sesuai
        $this->info("Deleted {$count} pending records.");
    }
}
