<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("schedules", function (Blueprint $table) {
            $table->increments("schedule_id");
            $table->foreignIdFor(Section::class);
            $table->foreignIdFor(Subject::class);
            $table->foreignIdFor(Teacher::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("schedules");
    }
}
