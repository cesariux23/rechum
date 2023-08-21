<template lang="pug">
div(v-if="props.pagination_data.current_page > 0")
    span Registros del&nbsp;
        b {{ props.pagination_data.from }}&nbsp;
        | al&nbsp;
        b {{ props.pagination_data.to }}
        | , total&nbsp;
        b {{ props.pagination_data.total}}
        | .
    nav.pagination.is-centered(role="pagination" aria-label="Paginación")
        a.pagination-previous(
            @click="changePage(props.pagination_data.current_page-1)"
            :class="{'is-disabled': props.pagination_data.current_page==1}") Anterior
        a.pagination-next(
            @click="changePage(props.pagination_data.current_page+1)"
            :class="{'is-disabled': props.pagination_data.current_page==props.pagination_data.last_page}") Siguiente
        ul.pagination-list
            li(v-for="link in links")
                a.pagination-link(v-if="link>0" @click="changePage(link)" :class="{'is-current': link === props.pagination_data.current_page}") {{link}}
                span(v-else).pagination-ellipsis &hellip;
</template>
<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {type PaginationData} from '@/types/PaginationData'


const props = defineProps<{
    pagination_data: PaginationData,
}>()

const route= useRoute()
const router = useRouter()
const links= ref([] as Array<Number>)
let query = {}

const changePage = (page:number) => {
    if(page> 0 && page <= props.pagination_data.last_page)
        query = {query: route.query, page}
        router.replace({path: route.path, query: query})
}
onMounted(()=>{
    links.value=[]
    // inicializa los links del listado de paginas
    let last_page = props.pagination_data.last_page
    if(last_page <=5) {
        for (let index = 1; index <= 5 && index <= last_page; index++) {
            links.value.push(index)
        }
    } else {
        let current_page = props.pagination_data? props.pagination_data.current_page : 1
        // primer pagina
        links.value.push(1)
        if(current_page <= 2){
            // se ajustan las primeras paginas
            current_page = 3
        }

        if(current_page >= last_page-2) {
            // se ajustan las ultimas paginas
            current_page = last_page-2
        }
        if(current_page > 3){
            // elipsis
            links.value.push(0)
        }
        if(current_page > 2){
            links.value.push(current_page-1)
        }
        links.value.push(current_page)
        if(current_page < last_page){
            links.value.push(current_page+1)
        }
        if(current_page < last_page-2) {
            // elipsis
            links.value.push(0)
        }
        links.value.push(last_page)
    }
})
</script>