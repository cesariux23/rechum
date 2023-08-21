import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useHttp } from '@/plugins/axios.js'

export const useCatalogoStore = defineStore('catalogo', () => {

    type parValue = {
        key?:string
        value:any
    }
    // state
    const catalogos = ref<
    {sexo?:parValue[]}
    >({})

    const http = useHttp()

    // actions
    async function getCatalogos() {
        await http!.get('catalogos')
        .then((response:any) => {
            catalogos.value = response.data
        })
    }

    // inicializa el catalogo
    getCatalogos()

    return {catalogos, getCatalogos}
})