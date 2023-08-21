<script setup lang="ts">
//templates
import DatosPersonalesForm from "./forms/DatosPersonalesPersonalForm.vue"
import BackButton from '@/components/utils/BackButton.vue'


import { ref } from "vue"
import { useHttp } from '@/plugins/axios.js'
import { useRouter } from 'vue-router'

const http = useHttp()
const router = useRouter()
const personal = ref({status:'SIN ASIGNAR'})

const save = async (event:Event) => {
    event.preventDefault()
    try {
        const response= await http!.post('personal', personal.value)
        const newPersonal = response.data
        router.replace({ name: 'HistorialLaboral', params:{rfc: newPersonal.rfc} })
    } catch (error) {
        console.log(error)
    }
}

</script>
<template lang="pug">
.app-module
    .columns
        .column
            h2.title.is-2 Registro de personal
        .column
            BackButton
    hr
    form.form(@submit="save")
        DatosPersonalesForm(:personal="personal")
        .columns
            .column
                button.button.is-success(type="submit")
                    span.icon
                        span.material-icons-outlined save
                    span Registrar
</template>