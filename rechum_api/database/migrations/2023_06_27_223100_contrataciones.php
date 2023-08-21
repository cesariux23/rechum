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
        Schema::create('contrataciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('rfc', 13);
            $table->string('tipo_contratacion', 20);
            $table->string('numero_empleado', 15);            
            $table->date('fecha_inicio');
            $table->date('fecha_baja')->nullable();
            $table->string('motivo_baja')->nullable();
            $table->string('status',30)->default('ACTIVO');
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
