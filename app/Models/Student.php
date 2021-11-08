<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = "student_id";

    public $timestamps = false;

    protected $fillable = [
        "student_id",
        "first_name",
        "middle_name",
        "last_name",
        "grade_level",
        "department_dept_id",
        "gpa",
    ];

    public function section()
    {
        return $this->belongsToMany(
            Section::class,
            "students_classes",
            "student_student_id",
            "section_section_id"
        );
    }
}
