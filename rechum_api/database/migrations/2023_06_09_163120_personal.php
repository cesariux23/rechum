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
        Schema::create('personal', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('rfc', 13)->primary();
            $table->string('curp',18)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('nombre');
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('banco')->nullable()->default(null);
            $table->string('numero_cuenta')->nullable()->default(null);
            $table->string('clabe',22)->nullable()->default(null);
            $table->string('correo_electronico')->nullable();
            $table->string('codigo_postal',5);
            $table->string('seguridad_social',10)->nullable();
            $table->string('nss')->nullable();
            $table->string('tiene_hijos')->nullable();
            $table->string('status')->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('personal');
    }
};
