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
        'adopter_others', //C
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

    public function attachments()
    {
        return $this->hasMany(Attachment::class); // A child can have multiple attachment
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
    /* public function getAdopterFirstNameAttribute($value)
    {
        // Check if the value is encrypted and decrypt only if it's not empty
        return !empty($value) ? Crypt::decryptString($value) : null;
    }

    public function getAdopterLastNameAttribute($value)
    {
        // Check if the value is encrypted and decrypt only if it's not empty
        return !empty($value) ? Crypt::decryptString($value) : null;
    }

    public function getAdopterPhoneAttribute($value)
    {
        // Check if the value is encrypted and decrypt only if it's not empty
        return !empty($value) ? Crypt::decryptString($value) : null;
    }

    public function getAdopterEmailAttribute($value)
    {
        // Check if the value is encrypted and decrypt only if it's not empty
        return !empty($value) ? Crypt::decryptString($value) : null;
    }

    public function getAdopterAddressAttribute($value)
    {
        // Check if the value is encrypted and decrypt only if it's not empty
        return !empty($value) ? Crypt::decryptString($value) : null;
    } */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    // Mutators to encrypt each field before saving
    /* public function setAdopterFirstNameAttribute($value)
    {
        // Encrypt only if the value is not empty
        $this->attributes['adopter_first_name'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    public function setAdopterLastNameAttribute($value)
    {
        // Encrypt only if the value is not empty
        $this->attributes['adopter_last_name'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    public function setAdopterPhoneAttribute($value)
    {
        // Encrypt only if the value is not empty
        $this->attributes['adopter_phone'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    public function setAdopterEmailAttribute($value)
    {
        // Encrypt only if the value is not empty
        $this->attributes['adopter_email'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    public function setAdopterAddressAttribute($value)
    {
        // Encrypt only if the value is not empty
        $this->attributes['adopter_address'] = !empty($value) ? Crypt::encryptString($value) : null;
    } */

}
