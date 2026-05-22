<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Employee extends Model
{
  protected $fillable = [
    'name',
    'email',
    'salary',
    'department_id',
    'image',
    'role'
  ];

  public function department(){
    return $this->belongsTo(Department::class);
  }
}
