<script setup lang="ts">
import { computed, toRaw, onMounted } from "vue"
// Se utiliza un componente sencillo para simplificar la codificación
import LayoutControl from "../../utils/LayoutControl.vue"
//catalogos
import { useCatalogoStore } from "@/stores/catalogo"

const props = defineProps({
  personal: Object
})

// catalogos computados
const catalogos = computed(() => useCatalogoStore().catalogos )
const sx_array = computed(() => useCatalogoStore().catalogos.sexo)

const rellenaValores = ():void => {
    // Se 'limpia' el arreglo del catalogo para valida que exista el elemento
    const arr_sx:Array<string> = []
    toRaw(sx_array.value)!.forEach((s) => {
        arr_sx.push(s.key as string)
    })

    // se obtiene el año actual a 2 digitos para saber si se agrega 1900 0 20000 a la fecha de nacimiento
    const current_year = new Date().getFullYear().toString().substring(2,4)

    if(props.personal!.curp.length >=11) {
        // se asigna la fecha de nacimiento
        let _curp = props.personal!.curp
        const f_n = [_curp.substring(4,6),_curp.substring(6,8),_curp.substring(8,10)]
        f_n[0] = (parseInt(f_n[0]) > parseInt(current_year) ? '19' : '20') + f_n[0]
        props.personal!.fecha_nacimiento = Date.parse(f_n.join('-')) ? f_n.join('-') : null

        // se asigna el valor para el campo sexo
        const s= props.personal!.curp.substring(10,11).toUpperCase()
        if(arr_sx.includes(s))
            props.personal!.sexo = s
        else
            props.personal!.sexo = null
    }   
}

const limpiaValores = (campo: String):void => {
    switch(campo) {
        case 'banco':
            if(props.personal!.banco == '0') {
                props.personal!.numero_cuenta = null
                props.personal!.clabe = null
            }
            break
        case 'nss':
            if(props.personal!.seguridad_social == '0') {
                props.personal!.nss = null
            }
            break
        case 'status':
            if(props.personal!.status !== 'BAJA') {
                props.personal!.fecha_baja = null
            }
    }
}
</script>
<template lang="pug">
div
    .columns
        LayoutControl(label="RFC*" extraClass="is-one-third")
            input.input(type="text" placeholder="RFC  a 13 posiciones" maxlength="13" minlength="13" required v-model="personal.rfc")
        LayoutControl(label="CURP*")
            input.input(type="text" placeholder="CURP a 18 posiciones" maxlength="18" minlength="18" required v-model="personal.curp" @change="rellenaValores")
        LayoutControl(label="Fecha de nacimiento*")
            input.input(type="date" placeholder="Fecha de nacimiento" required v-model="personal.fecha_nacimiento" tabindex="199")
        LayoutControl(label="Sexo*" extraClass="is-2")
            .select
                select(placeholder="Nombre" required v-model="personal.sexo" tabindex="200")
                    option(v-for="_sx in catalogos.sexo" :value="_sx.key") {{ _sx.value }}
        
    .columns
        LayoutControl(label="Nombre(s)*")
            input.input(type="text" placeholder="Nombre" required v-model="personal.nombre")
        LayoutControl(label="Primer Apellido*")
            input.input(type="text" placeholder="Primer apellido" required v-model="personal.primer_apellido")
        LayoutControl(label="Segundo Apellido")
            input.input(type="text" placeholder="Segundo apellido" v-model="personal.segundo_apellido")
    .columns
        LayoutControl(label="Banco*" required extraClass="is-2")
            .select
                select(required v-model="personal.banco" @change="limpiaValores('banco')")
                    option(v-for="banco in catalogos.bancos" :value="banco.key") {{ banco.value }}
        
        LayoutControl(label="Número de cuenta*" v-if="personal.banco !== '0'")
            input.input(type="text" placeholder="Número de cuenta" required v-model="personal.numero_cuenta")
        LayoutControl(label="CLABE" v-if="personal.banco !== '0'")
            input.input(type="text" placeholder="Número de cuenta CLABE (21 dígitos)" minlength="21" maxlength="21" v-model="personal.clabe")
    .columns
        LayoutControl(label="Codigo Postal*" extraClass="is-2")
            input.input(type="text" placeholder="5 dígitos" minlength="5" maxlength="5" required v-model="personal.codigo_postal")
        LayoutControl(label="Correo electrónico*" extraClass="is-5")
            input.input(type="email" placeholder="Correo personal o institucional" required  v-model="personal.correo_electronico")
                
    .columns
        LayoutControl(label="¿Tiene hijos?*" extraClass="is-2")
            .select
                select(required v-model="personal.tiene_hijos")
                    option(value=0) NO
                    option(value=1) SÍ
        LayoutControl(label="Seguridad Social*" extraClass="is-2")
            .select
                select(required  v-model="personal.seguridad_social" @change="limpiaValores('nss')")
                    option(v-for="_sg in catalogos.seguridad_social" :value="_sg.key") {{ _sg.value }}
        LayoutControl(label="Número Seguridad Social" v-if="personal.seguridad_social !== '0'")
            input.input(type="text" placeholder="NSS"  v-model="personal.nss")
</template>