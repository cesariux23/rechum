<script setup lang="ts">
// templates
import DatosPersonalesForm from "./forms/DatosPersonalesPersonalForm.vue"
import BackButton from "@/components/utils/BackButton.vue"


import { ref } from "vue"
import { useHttp } from '@/plugins/axios.js'
import { useRoute, useRouter } from 'vue-router'


const http= useHttp()
const route = useRoute()    
const router = useRouter()
const personal = ref({})
try {
    const test = await http!.get('personal/'+route.params.rfc)
    personal.value = test.data

    
} catch (error){
    alert('No se encontró el RFC ' + route.params.rfc + ' en la base de datos')
    console.error(error)
    //regresa al punto anterior
    router.go(-1)
}

const update = async (event:Event) => {
    event.preventDefault()
    try {
        const response= await http!.patch('personal/'+route.params.rfc, personal.value)
        const newPersonal = response.data
        // TO-DO: evitar el "doble atras" para volver al listado
        router.push({ name: 'HistorialLaboral', params:{rfc: newPersonal.rfc} })
    } catch (error) {
        console.log(error)
    }
}

</script>

<template lang="pug">
.app-module
    .columns
        .column
            h2.title.is-2 Editar datos personales
        .column
            BackButton
    hr
    form.form(@submit="update")
        DatosPersonalesForm(:personal="personal")
        .columns
            .column
                button.button.is-success(type="submit")
                    span.icon
                        span.material-icons-outlined save
                    span Guardar cambios
</template>