<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'declarations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'child_id',
        'adopter_id',
        'assistant_id',
        'evidence_number',
        'type_of_adoption',
        'length_of_adoption',
        'adoption_start_date',
        'adoption_end_date',
        'remaining_days_of_adoption',
        'status'
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
    public function child()
    {
        return $this->belongsTo(Child::class,'id');
    }
    public function adopter()
    {
        return $this->belongsTo(Adopter::class,'id');
    }
    public function assistant()
    {
        return $this->belongsTo(Assistant::class,'id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class,'id');
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

    /* public function getAssistantFullNameAttribute()
    {
        return $this->assistant ? $this->assistant->assistant_first_name : '-';
    } */
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
