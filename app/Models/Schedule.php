<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\Section;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = "schedule_id";

    public $timestamps = false;

    protected $fillable = [
        "schedule_id",
        "subject_subject_id",
        "teacher_teacher_id",
        "room_room_id",
        "section_section_id",
        "time_start",
        "time_end",
        "day",
        "acad_year",
        "semester",
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
