<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('graves', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('ic_number')->nullable();
        $table->date('date_of_death')->nullable();
        $table->string('plot_number')->nullable();
        $table->string('gps_lat')->nullable();
        $table->string('gps_lng')->nullable();
        $table->string('photo')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graves');
    }
};
