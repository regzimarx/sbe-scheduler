<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = "teacher_id";

    public $timestamps = false;

    protected $fillable = [
        "teacher_id",
        "first_name",
        "middle_name",
        "last_name",
        "department_dept_id",
    ];
}
