<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
public function department() { 
    return $this->belongsTo(Department::class); 
    }
public function level()      { 
    return $this->belongsTo(Level::class); 
    }
public function documents()  {
     return $this->hasMany(Document::class);
      }
}
