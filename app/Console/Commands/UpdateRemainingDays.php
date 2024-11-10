<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Add logging

class UpdateRemainingDays extends Command
{
    protected $signature = 'children:update-remaining-days';
    protected $description = 'Update remaining days for each child daily';

    public function handle()
    {
        Log::info('UpdateRemainingDays command starting...');
        $children = Child::all();
        $currentDate = Carbon::now();

        foreach ($children as $child) {
            $adoptionStartDate = Carbon::parse($child->adoption_start_date);
            $adoptionEndDate = $adoptionStartDate->copy()->addDays($child->length_of_adoption);
            $remainingDays = $currentDate->diffInDays($adoptionEndDate, false)+1;

            // Update remaining days in the database
            $child->remaining_days_of_adoption = max($remainingDays, 0); // Ensure it's not negative
            $child->saveQuietly();
        }

        $this->info('Remaining days updated successfully.');
    }
}
