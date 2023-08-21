<template lang="pug">
.app-view
    .columns
        .column
            h3.title.is-3 Datos personales
        .column.is-right
            RouterLink(:to="{name:'EditarPersonal', params:{rfc: personal.rfc}}" class="button is-primary is-pulled-right mr-1 is-outlined" title="Volver al listado")
                span.icon
                    span.material-icons edit
                span Editar
    .columns
        LayoutControl(label="Estatus actual")
            span {{ personal.status}}
    .columns
        LayoutControl(label="RFC")
            span {{ personal.rfc }}
        LayoutControl(label="CURP")
            span {{ personal.curp }}
        LayoutControl(label="Fecha de nacimiento")
            span {{ personal.fecha_nacimiento }}
        LayoutControl(label="sexo")
            span {{ personal.sexo }}
    .columns
        LayoutControl(label="Nombre")
            span {{ personal.nombre }}
        LayoutControl(label="Primer apellido")
            span {{ personal.primer_apellido }}
        LayoutControl(label="Segundo apellido")
            span {{ personal.segundo_apellido }}
    .columns
        LayoutControl(label="Banco")
            span {{ personal.banco }}
        LayoutControl(label="Número de cuenta")
            span {{ personal.numero_cuenta }}
        LayoutControl(label="CLABE")
            span {{ personal.clave }}
    .columns
        LayoutControl(label="Codigo postal")
            span {{ personal.codigo_postal }}
        LayoutControl(label="Correo electronico")
            span {{ personal.correo_electronico }}
    .columns
        LayoutControl(label="¿Tiene hijos?")
            span {{ personal.tiene_hijos }}
        LayoutControl(label="Seguridad social")
            span {{ personal.seguridad_social }}
        LayoutControl(label="NSS")
            span {{ personal.nss }}
</template>
<script setup lang="ts">
import LayoutControl from "@/components/utils/LayoutControl.vue"
const props = defineProps({
    personal: Object
})
</script>