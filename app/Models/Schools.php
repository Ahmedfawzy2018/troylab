<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schools extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "schools" ;
    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Students::class,'school_id') ;
    }
}
