<template lang="pug">
.app-module
    .columns
        .column
            h2.title.is-2 Personal
        .column.is-2.is-right
            RouterLink(:to="{name:'RegistroPersonal'}" class="button is-primary is-pulled-right" title="Realizar alta de personal")
                span.icon
                    span.material-icons add
                span Registrar
    hr
    .columns
        .column
            input.input(placeholder="Búsqueda por nombre completo o RFC" @keyup.enter="buscarPersonal" v-model="search")

    div.notification.is-info(v-if="!isLoading && isSearching && searchQuery && lista_personal.data.length > 0")
        RouterLink.delete(:to="{name: 'ListaPersonal'}")
        span Se encontr{{ lista_personal.data.length>1? 'aron':'ó' }} &nbsp;
            strong {{ pagination_data.total }}&nbsp;
            | resultado{{ lista_personal.data.length>1? 's':'' }} 
            | para "
            strong {{ searchQuery }}
            | ".
    table.table.is-fullwidth.is-hoverable.is-narrow(v-if="!isLoading && lista_personal.data.length > 0")
        thead
            tr
                th RFC
                th Nombre
                th Contratación
                th Adscripción
                th Puesto
                th Status
                th Acciones
        tbody
            tr(v-for=" personal in lista_personal.data")
                td {{ personal.rfc }}
                td
                    | {{ personal.nombre_completo }}
                td
                    | {{ personal.contratacion? personal.contratacion.tipo_contratacion : ''}}
                td 
                    | {{ (personal.contratacion && personal.contratacion.puesto)? personal.contratacion.puesto.adscripcion.adscripcion : '--'}}
                td
                    | {{ (personal.contratacion && personal.contratacion.puesto)? personal.contratacion.puesto.plaza.descripcion : '--'}}
                td {{ personal.status }}
                td
                    RouterLink.button.is-small.is-inverted.is-info(:to="{name:'HistorialLaboral', params:{rfc:personal.rfc}}" title="Ver detalles")
                        span.icon
                            span.material-icons person
                    RouterLink.button.is-small.is-inverted.is-info.ml-1(:to="{name:'EditarPersonal', params:{rfc:personal.rfc}}" title="Editar información")
                        span.icon
                            span.material-icons-outlined edit
        tfoot
            tr
                td(colspan="7")
                    TablePlaginator(
                    :pagination_data="pagination_data" :key="page")
    div.has-text-grey-light.has-text-centered(v-if="isLoading")
        section.hero.is-medium
            .hero-body
                p.subtitle Cargando ...
    div.notification.is-light.is-warning(v-if="!isLoading & lista_personal.data.length === 0")
        RouterLink.delete(:to="{name: 'ListaPersonal'}")
        span.is-size-4(v-if="search") No se encontraron resultados para "
            strong {{ searchQuery }}
            | ".
        p.has-text-centered(v-else)
            span.is-size-4 Sin registros.

</template>
<script setup lang="ts">
import { onMounted, ref } from "vue"
import { useHttp } from '@/plugins/axios.js'
import TablePlaginator from "@/components/utils/TablePaginator.vue"
import LayoutControl from "@/components/utils/LayoutControl.vue"
import { useRoute, useRouter } from "vue-router"
import {type PaginationData} from "@/types/PaginationData"

const http = useHttp()
const lista_personal = ref({data:[]})
const pagination_data = ref<PaginationData>({} as PaginationData)

const route = useRoute()
const router = useRouter()

const search = ref(route.query.search? route.query.search : '')
const searchQuery = ref(route.query.search? route.query.search : '')
const isSearching = ref(false)
const isLoading = ref(false)
const page = ref(route.query.page? route.query.page : 1)
let query = {}

const getPage = async () => {
    const params = {page: page.value, search: ''}
    isLoading.value = true
    try {
        if(search.value !== '') {
            params.search = search.value as string
            isSearching.value = true
            page.value = 1
        } else {
            isSearching.value = false
        }
        await http!.get('personal/', {params})
            .then((response)=>{
                pagination_data.value.current_page = response.data.current_page
                pagination_data.value.last_page = response.data.last_page
                // pagination_data.value.per_page = response.data.per_page
                pagination_data.value.from = response.data.from
                pagination_data.value.to = response.data.to
                pagination_data.value.total = response.data.total
                lista_personal.value = response.data
                isLoading.value = false
        })
    } catch (error){
        alert('Error al obtener el listado en la DB')
        console.error(error)
    }
}

const buscarPersonal = async ()=>{
    // usamos el router para almacenar los resultados de la busqueda
    query = {}
    if(search.value !== '')
        query={search:search.value}
    router.replace({path: route.path, query})
}

onMounted(async() =>{ await getPage()})
</script>