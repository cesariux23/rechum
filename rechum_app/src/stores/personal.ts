import { defineStore } from "pinia"
import { inject } from 'vue'

export const usePersonalStore = defineStore('personal', () => {
    const axios:any = inject('$axios')
    async function getPersonal(rfc:string) {
        const persona = await axios.get(`catalogos/${rfc}`)
        return persona.data
    }

    return {getPersonal}
})