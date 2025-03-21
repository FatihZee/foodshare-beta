<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Donation;
use Carbon\Carbon;

class UpdateDonationStatus extends Command
{
    protected $signature = 'donations:update-status';
    protected $description = 'Mengupdate status donasi menjadi completed setelah 30 menit';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Current time: " . $now);

        $expiredDonations = Donation::where('expiration', '<=', $now)
                                ->where('status', 'available')
                                ->get();
        
        $this->info("Found " . $expiredDonations->count() . " expired donations");
        
        foreach ($expiredDonations as $donation) {
            $this->info("Sebelum update - Donation #{$donation->id}: status={$donation->status}");
        
            $donation->status = 'completed';
            $result = $donation->save();
            
            $this->info("Save result: " . ($result ? "Success" : "Failed"));
            
            $refreshed = Donation::find($donation->id);
            $this->info("Setelah update - Donation #{$refreshed->id}: status={$refreshed->status}");
        }
        
        $this->info('Status donasi yang expired telah diperbarui.');
    }
}