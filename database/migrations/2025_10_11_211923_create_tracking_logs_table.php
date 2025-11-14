<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('tracking_logs', function (Blueprint $table) {
        $table->id();
        $table->string('robot_name');
        $table->string('position');
        $table->string('battery')->nullable();
        $table->string('tag_rfid')->nullable();
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
        Schema::dropIfExists('tracking_logs');
    }
};
