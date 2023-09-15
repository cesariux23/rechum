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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('contratacion_id');
            $table->integer('adscripcion_id');
            $table->boolean('es_titular')->default(false);
            $table->string('codigo_plaza', 15)->nullable();
            $table->string('codigo_tabulador', 15)->nullable();;
            $table->date('fecha_inicio');
            $table->date('fecha_baja')->nullable();
            $table->string('funcion')->nullable();
            $table->tinyInteger('zona_economica')->nullable();
            $table->string('status',30);
            $table->boolean('actual')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('movimientos');
    }
};
