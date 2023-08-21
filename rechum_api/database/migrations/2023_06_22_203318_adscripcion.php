<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('adscripciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('adscripcion');
            $table->string('unidad', 15);
            $table->string('subunidad', 15);
            $table->string('unidad_administrativa', 30);
            $table->tinyInteger('zona_economica');
            $table->string('status',20);
            // por definir si se quedan
            $table->boolean('interinato')->default(false);
            $table->boolean('comisionado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('adscripciones');
    }
};
