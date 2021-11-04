<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsClass extends Model
{
    use HasFactory;

    protected $primaryKey = "students_class_id";

    public $timestamps = false;

    protected $fillable = [
        "students_class_id",
        "student_student_id",
        "section_section_id",
    ];
}
