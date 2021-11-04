<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Department;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("students", function (Blueprint $table) {
            $table->increments("student_id");
            $table->string("first_name");
            $table->string("middle_name");
            $table->string("last_name");
            $table->integer("grade_level");
            $table->foreignIdFor(Department::class);
            $table->integer("gpa");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("students");
    }
}
