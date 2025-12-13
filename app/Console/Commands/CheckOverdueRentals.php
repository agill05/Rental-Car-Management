<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use Illuminate\Console\Command;

class CheckOverdueRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentals:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue rentals and update their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueRentals = Peminjaman::whereIn('status', ['dipinjam', 'menunggu_persetujuan'])
            ->where('tanggal_kembali_rencana', '<', now())
            ->get();

        $count = 0;
        foreach ($overdueRentals as $rental) {
            $rental->update(['status' => 'terlambat']);
            $count++;
        }

        $this->info("Updated {$count} overdue rentals to 'terlambat' status.");
    }
}
