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
        "department_dept_id",
    ];
}
