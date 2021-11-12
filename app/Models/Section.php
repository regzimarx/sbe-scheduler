<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $primaryKey = "section_id";

    public $timestamps = false;

    protected $fillable = [
        "section_id",
        "section_name",
        "is_star",
        "grade_level",
        "department_dept_id",
    ];

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            "students_classes",
            "section_section_id",
            "student_student_id"
        )->orderBy("students.last_name", "asc");
    }
}
