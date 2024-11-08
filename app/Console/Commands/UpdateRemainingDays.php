<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Child;
use Carbon\Carbon;

class UpdateRemainingDays extends Command
{
    protected $signature = 'children:update-remaining-days';
    protected $description = 'Update remaining days for each child daily';

    public function handle()
    {
        $children = Child::all();
        $currentDate = Carbon::now();

        foreach ($children as $child) {
            $adoptionStartDate = Carbon::parse($child->adoption_start_date);
            $adoptionEndDate = $adoptionStartDate->copy()->addDays($child->length_of_adoption);
            $remainingDays = $currentDate->diffInDays($adoptionEndDate, false);

            // Update remaining days in the database
            $child->remaining_days_of_adoption = max($remainingDays, 0); // Ensure it's not negative
            $child->save();
        }

        $this->info('Remaining days updated successfully.');
    }
}
