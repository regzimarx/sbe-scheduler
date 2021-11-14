<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Department;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sections", function (Blueprint $table) {
            $table->increments("section_id");
            $table->string("section_name");
            $table->boolean("is_star");
            $table->integer("grade_level");
            $table->foreignIdFor(Department::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("sections");
    }
}
