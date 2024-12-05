<?php
namespace App\Observers;

use App\Models\Declaration;
use Carbon\Carbon;

class DeclarationObserver
{
    public function creating(Declaration $declaration)
    {
        /* $adoptionStartDate = Carbon::parse($declaration->adoption_start_date);
        $lengthOfAdoption = (int)$declaration->length_of_adoption;
        $adoptionEndDate = $adoptionStartDate->addDays($lengthOfAdoption);
        $remainingDays = Carbon::now()->diffInDays($adoptionEndDate, false);

        // Store the remaining days directly in the model before saving
        $child->remaining_days_of_adoption = max($remainingDays, 0); // Ensure it's not negative */
    }
}
