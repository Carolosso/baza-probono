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
    protected $guarded = ['id','group_id'];
    protected $fillable = [
        'first_name', //C
        'last_name', //C       
        'age',  //C
        'birth_place', //C
        'country',  //C
        'sex',  //C
        'others', //C
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

    public function declaration()
    {
        return $this->belongsTo(Declaration::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
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
