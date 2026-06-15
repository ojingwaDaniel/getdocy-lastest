<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = ["title","code","department_id","level_id","credit_units"];
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
