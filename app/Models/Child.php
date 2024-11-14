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
        /* 'adopter_first_name', //C
        'adopter_last_name', //C
        'adopter_city', 
        'adopter_type', //C
        'adopter_type_name', //C
        'adopter_email', //C
        'adopter_phone', //C
        'adopter_address', //C */
        'commandory_id', //C
        'adopter_id',
        'image_url', //C
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function commandory()
    {
        return $this->belongsTo(Commandory::class);
    }

    public function adopter()
    {
        return $this->belongsTo(Adopter::class);
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
        return $this->commandory ? $this->commandory->commandory_name : '-';
    }

    public function getAdopterFirstNameAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_first_name : '-';
    }
    public function getAdopterLastNameAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_last_name : '-';
    }
    public function getAdopterTypeAttribute()
    {
        return $this->adopter && $this->adopter->adopterType ? $this->adopter->adopterType->type_name : '';
    }
    public function getAdopterTypeNameAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_type_name : '-';
    }
    public function getAdopterEmailAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_email : '-';
    }
    public function getAdopterPhoneAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_phone : '-';
    }
    public function getAdopterAddressAttribute()
    {
        return $this->adopter ? $this->adopter->adopter_address : '-';
    }
 


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
