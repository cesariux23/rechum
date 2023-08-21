<template lang="pug">
.app-module
    .columns
        .column
            h2.title.is-2 {{ personal.nombre_completo}} 
                span.tag.is-danger(v-if="personal.status ==='BAJA'") Baja
                span.tag.is-primary(v-if="personal.status ==='ACTIVO'") Activo
                span.tag.is-warning(v-if="personal.status ==='SIN ASIGNAR'") Sin asignar
        .column.is-1.is-right
            BackButton
    .tabs
        ul
            li(:class="{'is-active':route.name === 'HistorialLaboral'}")
                RouterLink(:to="{name:'HistorialLaboral'}") Contratatación
            li(:class="{'is-active':route.name === 'DatosPersonales'}")
                RouterLink(:to="{name:'DatosPersonales'}") Datos personales

    RouterView(:personal='personal' @update-personal="updatePersonal")
</template>
<script setup lang="ts">
import { ref } from "vue"
import { useHttp } from '@/plugins/axios.js'
import { useRoute, useRouter } from 'vue-router'
import LayoutControl from "@/components/utils/LayoutControl.vue"
import BackButton from '@/components/utils/BackButton.vue'
import { toast } from 'vue3-toastify'

const http= useHttp()
const route = useRoute()    
const router = useRouter()
const personal = ref({contrataciones:[]})

const updatePersonal = async () => {
    try {
        const response = await http!.get('personal/'+route.params.rfc)
        personal.value = response.data 
    } catch (error){
        toast.error('No se encontró el RFC ' + route.params.rfc + ' en la base de datos.')
        console.error(error)
        //regresa al punto anterior
        router.push({name:'ListaPersonal'})
    }
}

updatePersonal()

</script>