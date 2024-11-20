<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

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
        'evidence_number', //C
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
        'type_of_adoption', //C
        'adopter_first_name', //C
        'adopter_last_name', //C
        'adopter_type', //C
        'adopter_type_name', //C
        'adopter_email', //C
        'adopter_phone', //C
        //'flag_comandory', //C
        'adopter_address', //C
        'commandory_id', //C
        'image_url', //C
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    

 /*    // Add the remaining time calculation function
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
    } */
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        return $this->hasMany(Payment::class); // A child can have multiple payments
    }

    public function commandory()
    {
        return $this->belongsTo(Commandory::class); //
    }


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
    public function getCommandoryNameAttribute()
    {
        return $this->commandory ? $this->commandory->commandory_name : 'brak';
    }
    public function getAdopterFirstNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getAdopterLastNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getAdopterPhoneAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getAdopterEmailAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getAdopterAddressAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
        // Mutators to encrypt each field before saving
    public function setAdopterFirstNameAttribute($value)
    {
        $this->attributes['adopter_first_name'] = Crypt::encryptString($value);
    }

    public function setAdopterLastNameAttribute($value)
    {
        $this->attributes['adopter_last_name'] = Crypt::encryptString($value);
    }

    public function setAdopterPhoneAttribute($value)
    {
        $this->attributes['adopter_phone'] = Crypt::encryptString($value);
    }

    public function setAdopterEmailAttribute($value)
    {
        $this->attributes['adopter_email'] = Crypt::encryptString($value);
    }

    public function setAdopterAddressAttribute($value)
    {
        $this->attributes['adopter_address'] = Crypt::encryptString($value);
    }
}
