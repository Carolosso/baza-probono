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
