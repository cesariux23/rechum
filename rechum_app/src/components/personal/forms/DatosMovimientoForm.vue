<template lang="pug">
div
    .columns
        LayoutControl(label="Estatus*" extraClass="is-2")
            .select
                select(required v-model="movimiento.status" :disabled="props.editMode")
                    option(v-for="_st in catalogos.status_movimiento" :value="_st.key") {{ _st.value }}
        LayoutControl(label="Fecha de inicio*" extraClass="is-3")
            input.input(type="date" required v-model="movimiento.fecha_inicio")
        LayoutControl(label="Fecha de finalización*" v-if="movimiento.status === 'HISTORICO'" extraClass="is-3")
            input.input(type="date" required v-model="movimiento.fecha_baja")
    .columns
        LayoutControl(label="Tipo de contratación*" extraClass="is-4")
            .select
                select(required v-model="movimiento.tipo_contratacion" :disabled="props.editMode")
                    option(v-for="_tc in catalogos.tipo_contratacion" :value="_tc.key") {{ _tc.value }}
        LayoutControl(label="interinato" v-if="movimiento.tipo_contratacion === 'BASE'" extraClass="is-2")
            label.checkbox
                input(type="checkbox" v-model="movimiento.interinato")
        LayoutControl(label="Número de empleado*" extraClass="is-4")
            input.input(type="text" v-model="movimiento.numero_empleado" required)
        //-- 
            LayoutControl(label="Comisionado" v-if="movimiento.tipo_contratacion === 'BASE'" extraClass="is-2")
                label.checkbox
                    input(type="checkbox" v-model="movimiento.comisionado")
    .columns
        LayoutControl(label="Adscripción*")
            .select
                select(required v-model="movimiento.adscripcion_id")
                    option(v-for="_ad in catalogos.adscripciones" :value="_ad.id") {{ _ad.unidad_administrativa }} - {{ _ad.adscripcion }}
    .columns(v-if="movimiento.tipo_contratacion==='BASE' || movimiento.tipo_contratacion === 'CONFIANZA'")
        LayoutControl(label="Puesto*")
            .select
                select(required v-model="movimiento.codigo_plaza")
                    option(v-for="_pl in catalogos.plazas" :value="_pl.codigo_plaza") {{ _pl.codigo_plaza }} - {{ _pl.descripcion }}
    .columns
        LayoutControl(label="Función*")
            input.input(type="text" v-model="movimiento.funcion" placeholder="Función real, actividad que desempleña o puesto")
</template>
<script setup lang="ts">
import { useCatalogoStore } from "@/stores/catalogo"
import LayoutControl from "@/components/utils/LayoutControl.vue"
import { computed, watch } from "vue"
import HistorialMovimientosView from "../views/HistorialMovimientosView.vue";

const props = defineProps({
  movimiento: Object,
  editMode: Boolean
})

const catalogos = computed(() => {return useCatalogoStore().catalogos})

</script>