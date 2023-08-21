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
        Schema::create('plazas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('codigo_plaza',20)->primary()->comment('Clave interna');
            $table->string('codigo_tabulador',20)->comment('Clave tabulador INEA');
            $table->string('descripcion')->comment('Descripcion de la plaza');
            $table->string('nivel_puesto',5);
            $table->string('nivel_sueldo',5);
            $table->string('tipo_contratacion',20);
            $table->tinyInteger('zona_economica');
            $table->tinyInteger('autorizadas');
            $table->string('funcion',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('plazas');
    }
};
