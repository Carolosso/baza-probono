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
        return $this->hasOne(Declaration::class,'id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class,'id');
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
    // public function getCommandoryNameAttribute()
    // {
    //     return $this->commandory ? $this->commandory->commandory_name : '-';
    // }
 /*    public function getGroupNameAttribute()
    {
        return $this->group ? $this->group->group_name : '-';
    } */
/*     
    public function getAdopterFirstNameAttribute($value)
    {
        return Crypt::decryptString($value);
    } */



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
        // Mutators to encrypt each field before saving
/*     public function setAdopterFirstNameAttribute($value)
    {
        $this->attributes['adopter_first_name'] = Crypt::encryptString($value);
    } */

}
