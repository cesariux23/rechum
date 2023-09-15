<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Catalogo;

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Catalogo::truncate();
        $values = json_decode('{
                "bancos":[{"key":"0","value":"PAGO VÍA CHEQUE"},{"key":"012","value":"BBVA BANCOMER"},{"key":"014","value":"SANTANDER"},{"key":"021","value":"HSBC"}],
                "seguridad_social":[{"key":"0","value":"NINGUNA"},{"key":"ISSSTE","value":"ISSSTE"}],
                "sexo":[{"key":"M","value":"MUJER"},{"key":"H","value":"HOMBRE"}, {"key":"X","value":"NO BINARIO"}],
                "tipo_contratacion":[{"key":"ASIMILADO","value":"ASIMILADO A SALARIOS"},{"key":"CONFIANZA","value":"CONFIANZA"}, {"key":"BASE","value":"BASE"}],
                "status":[{"key":"ACTIVO","value":"ACTIVO"},{"key":"BAJA","value":"BAJA"}],
                "status_movimiento":[{"key":"ACTIVO","value":"ACTIVO"},{"key":"HISTORICO","value":"HISTORICO"}],   
                "funcion":["DIRECTOR(A) GENERAL","SUBDIRECTOR(A)", "COORDINADOR(A) DE ZONA", "JEFE(A) DE DEPARTAMENTO","TECNICO DOCENTE", "AUXILIAR ADMINSTRATIVO", "AUXILIAR GENERAL", "OTRO"]
            }');
        foreach($values as $cat => $items) {
            Catalogo::insert([
                "catalogo" => $cat,
                "items" => json_encode($items)
            ]);
        }
    }
}
