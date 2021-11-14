<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Department;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = "subject_id";

    public $timestamps = false;

    protected $fillable = ["subject_id", "subject_name", "department_dept_id"];
}
