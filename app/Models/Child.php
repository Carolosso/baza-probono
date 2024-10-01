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
        'first_name',
        'last_name',
        'age',
        'birth_place',
        'country',
        'remaining_days_of_adoption',
        'adoption_date',
        'length_of_adoption',
        'adopter_first_name',
        'adopter_last_name',
        'flag',
        'flag_comandory',
        'image_url',
        'one_time_pay',
        'first_pay',
        'second_pay',
        'third_pay',
        'forth_pay'
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
        $adoptionStartDate = Carbon::parse($this->adoption_date);
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
