<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'children';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id',];
    protected $fillable = [
        'first_name', //C
        'last_name', //C
        'age',  //C
        'birth_place', //C
        'country',  //C
        'sex',  //C
        'others', //C
        'coordinator_first_name', //C
        'coordinator_last_name', //C
        'remaining_days_of_adoption', //C
        'adoption_start_date', //C
        'adoption_end_date', //C
        'group', //C
        'length_of_adoption', //C
        'adopter_first_name', //C
        'adopter_last_name', //C
        'adopter_city', 
        'adopter_type', //C
        'adopter_email', //C
        'adopter_phone', //C
        'flag_comandory', //C
        'address', //C
        'image_url', //C
        'one_time_pay', //C
        'first_pay', //C
        'second_pay', //C
        'third_pay', //C
        'forth_pay' //C
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // Add the remaining time calculation function
    public function getRemainingTime()
    {
        $currentDate = Carbon::now();
        $adoptionStartDate = Carbon::parse($this->adoption_start_date);
        $lengthOfAdoption = $this->length_of_adoption;

        // Calculate the adoption end date
        $adoptionEndDate = $adoptionStartDate->addDays($lengthOfAdoption);

        // Calculate remaining days
        $remainingDays = intval($currentDate->diffInDays($adoptionEndDate, false)); // false includes negative values

 
        return $remainingDays+1;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
