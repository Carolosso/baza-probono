@php
    $remainingDays = $entry->remaining_days_of_adoption;
    $class = '';
    $displayText = $remainingDays . ' dni';

    if(!$entry->adopter_id){
        $displayText = 'Brak opiekuna'; // Set display text to "Expired" if days are less than 1
        $class = 'd-flex justify-content-center badge bg-grey text-white';
    }
    elseif ($remainingDays < 1) {
        $displayText = 'Wygasło'; // Set display text to "Expired" if days are less than 1
        $class = 'd-flex justify-content-center badge bg-red text-white';
    } elseif ($remainingDays >= 1 && $remainingDays < 30) {
        $class = 'd-flex justify-content-center badge bg-orange text-white';
    } elseif ($remainingDays >= 30 && $remainingDays <= 90) {
        $class = 'd-flex justify-content-center badge bg-yellow text-white';
    } else {
        $class = 'd-flex justify-content-center badge bg-green text-white';
    }
@endphp

<div class="col {{ $class }}">
    {{ $displayText }}
</div>
