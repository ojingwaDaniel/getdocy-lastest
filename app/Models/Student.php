<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
     protected $fillable = [
        'user_id',
        'matric_number',
        'level_id',
        'status',
    ];
    public function user()  { return $this->belongsTo(User::class); }
    public function level() { return $this->belongsTo(Level::class); }
}
