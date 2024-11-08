<?php
namespace App\Observers;

use App\Models\Child;
use Carbon\Carbon;

class ChildObserver
{
    public function creating(Child $child)
    {
        $adoptionStartDate = Carbon::parse($child->adoption_start_date);
        $lengthOfAdoption = (int)$child->length_of_adoption;
        $adoptionEndDate = $adoptionStartDate->addDays($lengthOfAdoption);
        $remainingDays = Carbon::now()->diffInDays($adoptionEndDate, false);

        // Store the remaining days directly in the model before saving
        $child->remaining_days_of_adoption = max($remainingDays, 0); // Ensure it's not negative
    }
}
