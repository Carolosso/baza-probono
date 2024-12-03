<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopter extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'adopters';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'adopter_type_id',
        'commandory_id',
        'adopter_type_name',
        'adopter_first_name',
        'adopter_last_name',
        'adopter_email', 
        'adopter_phone',
        'adopter_address', 
        'others'
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
        return $this->hasMany(Declaration::class,'id');
    }
    public function adopterType()
    {
        return $this->belongsTo(AdopterType::class,'id');
    }
        public function commandory()
    {
        return $this->belongsTo(Commandory::class,'id');
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

    public function getAdopterFullNameAttribute()
    {
        $adopterTypeTypeName = $this->adopterType->type_name ? "{$this->adopterType->type_name} - " : "";
        $adopterTypeName = $this->adopter_type_name ? "{$this->adopter_type_name} - " : "";
        return "$adopterTypeTypeName $adopterTypeName {$this->adopter_first_name} {$this->adopter_last_name}";
    }

    public function getAdopterTypeTypeNameAttribute()
    {
        return $this->adopterType ? $this->adopterType->type_name : '-';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
