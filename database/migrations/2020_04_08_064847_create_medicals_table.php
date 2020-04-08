<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('reg_no');
            $table->string('center_name');
            $table->string('dr_name');
            $table->string('specialist_in');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('open_days');
            $table->string('city');
            $table->string('district');
            $table->text('dr_notes')->nullable();
            $table->string('image')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('issuing')->default('off'); //on|off
            $table->string('session')->default('off'); //on|off
            $table->string('current_issues_no')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicals');
    }
}

