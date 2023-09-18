<template lang="pug">
div
    //- encabezado
    .columns
        .column
            h3.title.is-3 Historial de contratación
        .column
            .field.is-grouped.is-pulled-right
                p.control 
                    button.button.is-danger.is-outlined(
                        title="Registrar baja"
                        v-if="personal.contratacion && personal.contratacion.status ==='ACTIVO' && personal.contratacion.actual"
                        @click="toggleContratacionForm('baja', personal.contratacion? personal.contratacion.id: 0)")
                        span.icon
                            span.material-icons remove_circle
                        span Finalizar actual
                p.control
                    button.is-pulled-right.button.is-info(v-if="personal.contratacion && personal.contratacion.status === 'ACTIVO'" @click="toggleContratacionForm('historico')" title="Agregar historico contratación")
                        span.icon
                            span.material-icons post_add
                        span Agregar historico
                p.control
                button.is-pulled-right.button.is-success(v-if="personal.contrataciones.length === 0 || (personal.contratacion && personal.contratacion.status === 'BAJA')" @click="toggleContratacionForm('nuevo')" title="Agregar contratación")
                        span.icon
                            span.material-icons add
                        span Registrar

    //- listado de contrataciones
    .card.is-radiusless(v-if="personal.contrataciones.length>0" v-for="contratacion in personal.contrataciones")
        .card-header.has-background-grey-lighter.is-radiusless
            p.card-header-title(@click="toggleCard(contratacion.id)")
                | {{ contratacion.tipo_contratacion }}&nbsp;
                .tags
                    span.tag.is-primary(v-if="contratacion.actual" :class= "[contratacion.status !=='ACTIVO' ? 'is-light' : '']")
                        | {{ contratacion.status ==='ACTIVO' && contratacion.actual ? 'Actual' : 'Último' }}
                    span.tag.is-danger(v-if="contratacion.status === 'BAJA'") Baja
            button.card-header-icon(@click="toggleCard(contratacion.id)")
                span.icon
                    span.material-icons keyboard_arrow_{{ contratacion.id === cardVisibleId ? 'up' : 'down' }}
                    
        .card-content
            .notification.is-info.is-light(v-if="contratacion.status === 'HISTORICO'")
                .icon-text
                    span.icon.has-text-info
                        i.material-icons info
                    span La información mostrada en esta sección forma parte del historico de contrataciones y no
                        |  indica una relación laboral activa.
            button.button.is-pulled-right.is-white(title="Editar contratación" @click="toggleContratacionForm('editar', contratacion.id)")
                span.icon.has-text-info
                    span.material-icons edit
            span &nbsp;
            .columns
                LayoutControl(label="Tipo de contratación")   
                    span {{ contratacion.tipo_contratacion }}
                LayoutControl(label="Número de empleado")   
                    span {{ contratacion.numero_empleado }}
                LayoutControl(label="Fecha de inicio")   
                    span {{ contratacion.fecha_inicio }}
            .columns(v-if="contratacion.status!=='ACTIVO'")
                LayoutControl(label="Fecha de baja", extra-class="is-4")   
                    span {{ contratacion.fecha_baja ? contratacion.fecha_baja : '--'}}
                LayoutControl(label="Motivo de baja")   
                    span {{ contratacion.motivo_baja ? contratacion.motivo_baja : '--'}}
            hr
            .is-pulled-right
                .field.is-grouped
                    p.control(@click="toggleMovimientoForm(contratacion.id, 'baja', personal.contratacion? personal.contratacion.puesto.id: 0)" v-if="personal.contratacion && personal.contratacion.id === contratacion.id && personal.contratacion.puesto && personal.contratacion.puesto.status === 'ACTIVO'")
                        button.button.is-danger.is-outlined(title="Realizar baja del puesto actual")
                            span.icon
                                span.material-icons playlist_remove
                            span Baja puesto actual
                    p.control(v-else)
                        button.button.is-primary.is-outlined(title="Registrar nuevo movimiento" v-if = "contratacion.actual && !contratacion.fecha_baja" @click="toggleMovimientoForm(contratacion.id, 'nuevo')")
                            span.icon
                                span.material-icons add
                            span Nuevo movimiento
                    p.control
                        button.button.is-info.is-outlined(title="Agregar puesto al historico" @click="toggleMovimientoForm(contratacion.id, 'historico')")
                            span.icon
                                span.material-icons playlist_add
                            span HISTORICO
            h4.title.is-4 Movimientos de puesto
            table.table.is-fullwidth.is-hoverable
                thead
                    tr
                        th Núm.
                        th Adscripción
                        th Función real
                        th Plaza tabular
                        th Periodo
                        th Acciones
                tbody(v-if="contratacion.movimientos")
                    tr(v-for="(mov, index) in contratacion.movimientos")
                        td.has-text-centered(:class="{'is-selected': mov.actual}") {{ index + 1 }}
                            span.is-size-7(v-if="mov.actual")
                                br
                                | Actual
                        td 
                            p
                                strong {{ mov.adscripcion.unidad_administrativa }} 
                                span  / 
                                | {{ mov.adscripcion.adscripcion }}
                            p(v-if="mov.es_titular")
                                i.icon.has-text-warning
                                    span.material-icons.is-size-6 star
                                i.has-text-grey Titular del área
                        td
                            | {{mov.funcion}}
                        td
                            div(v-if="mov.plaza")
                                p
                                    strong {{ mov.codigo_plaza }}
                                    span /
                                    strong {{ mov.codigo_tabulador }}
                                p {{ mov.plaza.descripcion }}
                            p(v-else)| {{ mov.funcion? mov.funcion: '--' }}
                        td
                            strong De
                            span : {{ mov.fecha_inicio }}
                            br
                            strong Hasta
                            span : {{ mov.fecha_baja? mov.fecha_baja : '-' }}
                        td
                            button.button.is-small.is-white.ml-4(@click="toggleMovimientoForm(mov.contratacion_id, 'editar', mov.id)" title="Editar puesto")
                                span.icon.has-text-info
                                    span.material-icons edit
                                    p.control
                            button.button.is-small.is-white.ml-4(@click="deleteMovimiento(mov.id)" title="Eliminar puesto" v-if="mov.status!=='ACTIVO'")
                                span.icon.has-text-danger
                                    span.material-icons delete
                                    p.control                               
                
            .notification.is-warning.is-light.has-text-centered(v-if="contratacion.movimientos.length === 0")
                p Sin historico registrado.
                button.button.is-danger(@click="deleteContratacion(contratacion.id)")
                    span.icon
                        span.material-icons delete
                    span Eliminar contratación

    .notification.is-warning.is-light.has-text-centered(v-else)
         p.m-6 Sin historico.
         button.button.is-danger(@click="deletePersonal(personal.rfc)")
                    span.icon
                        span.material-icons person_remove
                    span Eliminar registro

    //- ********** MODALS PARA MODIFICAR **********

    //- modal contratacion
    form(@submit="guardarContratacion")
        ModalCard(v-model:isOpen="modalContratacionIsOpen"  modal-class='width-1000')
            template(#modal-title)
                span {{ tituloModalContratacion }}
            template(#modal-body)
                .message.is-info(v-if="_contratacion")
                    .message-body
                        h5.title.is-5.mb-1 Datos de la contratación {{ _contratacion.status === 'ACTIVO' ? 'actual' : 'seleccionada' }}
                        .columns
                            .column
                                p Status:
                                b {{ _contratacion.status }}
                            .column
                                p Tipo de contratación:
                                b {{ _contratacion.tipo_contratacion }}
                            .column(v-if="_contratacion && contratacion.status ==='PRE_BAJA'")
                                p Núm. empleado:
                                b {{ _contratacion.numero_empleado }}
                            .column(v-if="_contratacion && contratacion.status ==='PRE_BAJA'")
                                p Inicio:
                                b {{ _contratacion.fecha_inicio }}

                div(v-if="contratacion.status !== 'PRE_BAJA'")
                    .columns
                        LayoutControl(label="Tipo de contratación*" v-if="!contratacion.id")
                            .select
                                select(required v-model="contratacion.tipo_contratacion" :disabled="props.MovimientoEditMode" @change="contratacion.interinato = false")
                                    option(v-for="_tc in catalogos.tipo_contratacion" :value="_tc.key") {{ _tc.value }}
                        LayoutControl(label="Número de empleado" extraClass="is-4")
                            input.input(type="text" v-model="contratacion.numero_empleado")
                        LayoutControl(label="Fecha de inicio*" extraClass="is-4")
                            input.input(type="date" v-model="contratacion.fecha_inicio" required)
                div(v-if="contratacion.status === 'BAJA' || contratacion.status === 'PRE_BAJA' || contratacion.status === 'HISTORICO'")
                    .columns
                        LayoutControl(label="Fecha de baja*" extraClass="is-4")
                            input.input(type="date" v-model="contratacion.fecha_baja" required)
                        LayoutControl(label="Motivo baja*" v-if="contratacion.status !== 'ACTIVO'")
                            input.input(type="text" v-model="contratacion.motivo_baja" required)
            template(#modal-foot)
                button.button.is-primary(type="submit" :class="{'is-loading':isSaving}")
                    span.icon
                        span.material-icons-outlined save
                    span {{ textBtnGuardarContratacion }}
                button.button.is-danger.ml-1(type="button" @click="toggleContratacionForm('close')" :disabled="isSaving")
                    span.icon
                        span.material-icons-outlined close
                    span Cancelar

    //- modal Movimiento
    form(@submit="guardarMovimiento")
        ModalCard(v-model:isOpen="modalMovimientoIsOpen" modal-class='width-1000')
            template(#modal-title)
                span {{ tituloModalMovimiento }}
            template(#modal-body)
                .message.is-info(v-if="_contratacion")
                    .message-body
                        h5.title.is-5 Contratación
                        .columns
                            .column
                                p Tipo de contratación:
                                b {{ _contratacion.tipo_contratacion }}
                            .column
                                p Núm. empleado:
                                b {{ _contratacion.numero_empleado }}
                .columns
                    LayoutControl(label="Fecha de inicio*" extraClass="is-6")
                        input.input(type="date" required v-model="movimiento.fecha_inicio")
                    LayoutControl(label="Fecha de baja*" v-if="movimiento.status === 'HISTORICO' || movimiento.status === 'BAJA' || movimiento.status === 'PRE_BAJA'" extraClass="is-6")
                        input.input(type="date" required v-model="movimiento.fecha_baja")
                .columns 
                    LayoutControl(label="Adscripción*")
                        .select
                            select(required v-model="movimiento.adscripcion_id")
                                option(v-for="_ad in catalogos.adscripciones" :value="_ad.id") {{ _ad.unidad_administrativa }} - {{ _ad.adscripcion }}
                    .column
                        .field
                            label.label Es titular
                            input(type="checkbox" v-model="movimiento.es_titular")
                .columns
                    LayoutControl(label="Función real o actividad que desempeña*")
                        .select
                            select(v-model="movimiento.funcion" required)
                                option(v-for="_fun in catalogos.funcion" :value="_fun") {{ _fun }}
                    LayoutControl(label="Especifique la función*" v-if="movimiento.funcion === 'OTRA'")
                        input.input(type="text" required v-model="otra_funcion")
                                   
                .columns(v-if="_contratacion && (_contratacion.tipo_contratacion==='BASE' || _contratacion.tipo_contratacion === 'CONFIANZA')")
                    LayoutControl(label="Puesto tabular*")
                        .select
                            select(required v-model="movimiento.codigo_plaza")
                                option(v-for="_pl in catalogos.plazas" :value="_pl.codigo_plaza") {{ _pl.codigo_plaza }} - {{ _pl.descripcion }}
            template(#modal-foot)
                button.button.is-primary(type="submit" :class="{'is-loading':isSaving}")
                    span.icon
                        span.material-icons-outlined save
                    span {{textBtnGuardarMovimiento }}
                button.button.is-danger.ml-1(type="button" @click="toggleForm" :disabled="isSaving")
                    span.icon
                        span.material-icons-outlined close
                    span Cancelar
    

</template>
<script setup lang="ts">
import { ref, toRaw , reactive, computed } from 'vue'
import LayoutControl from "@/components/utils/LayoutControl.vue"
import ModalCard from "@/components/utils/ModalCard.vue"
import { useCatalogoStore } from "@/stores/catalogo"
import {useHttp} from '@/plugins/axios.js'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'
import { type Contratacion } from '@/types/Contratacion'
import { type Movimiento } from '@/types/Movimiento'
import{ type AxiosResponse } from 'axios'

const selectedContratacion = ref(0)
const modalContratacionIsOpen = ref(false)
const ContratacionEditMode = ref(false)
const tituloModalContratacion = ref('Editar')
const textBtnGuardarContratacion = ref('Guardar')


const selectedMovimiento = ref(0)
const otra_funcion = ref('')
const modalMovimientoIsOpen = ref(false)
const MovimientoEditMode = ref(false)
const tituloModalMovimiento = ref('Editar')
const textBtnGuardarMovimiento = ref('Guardar')

const cardVisible = ref(-1)
let movimiento = ref<Movimiento>({})

let contratacion = ref<Contratacion>({})
let _actual = reactive<Movimiento>({})
let params = {}
const http= useHttp()
const router = useRouter()
const isSaving = ref(false)

const _funcion = computed(() => toRaw(useCatalogoStore().catalogos.funcion))

const emit = defineEmits<{
  (event: 'updatePersonal'): void
}>()

const props = defineProps({
        personal: Object
    })

const cardVisibleId = computed(() =>{
    return cardVisible.value === -1 && props.personal && props.personal!.contratacion? props.personal!.contratacion.id : cardVisible.value
})

const _contratacion = computed<Contratacion>(()=> {
    if(props.personal && props.personal.contrataciones)
        return props.personal.contrataciones.find((c:Contratacion) => c.id === selectedContratacion.value)
    return {}
})

const _movimiento = computed(() => {
    if(_contratacion && _contratacion.value.movimientos)
        return _contratacion.value.movimientos.find((m:Movimiento) => m.id === selectedMovimiento.value)
    return {}
})

const toggleCard = (id:number) => {
    if(id === cardVisibleId.value) {
        cardVisible.value = 0
    } else cardVisible.value = id

}

const catalogos = computed(() => {return useCatalogoStore().catalogos})

const toggleForm = () => {
    modalMovimientoIsOpen.value = !modalMovimientoIsOpen.value
    isSaving.value = false
}

const toggleMovimientoForm = (contratacion_id:number, mode:string, movId:number = 0) => {
    MovimientoEditMode.value = mode === 'editar'
    selectedContratacion.value = contratacion_id
    selectedMovimiento.value = movId
    movimiento.value = {..._movimiento.value}

    // checa el valor para "otra funcion"
    console.log(_funcion.value.includes(movimiento.value.funcion))
    if(_funcion.value.includes(movimiento.value.funcion)){
        otra_funcion.value = ''
    } else {
        otra_funcion.value = movimiento.value.funcion
        movimiento.value.funcion = 'OTRA'
    }

    clearMovimientoProps()
    textBtnGuardarMovimiento.value = 'Registrar'
    switch (mode) {
        case 'nuevo':
            tituloModalMovimiento.value = 'Registrar movimiento'
            movimiento.value = {
                contratacion_id:contratacion_id,
                status:'NUEVO',
                actual: _contratacion.value.status === 'ACTIVO' ? 1 :0
            }
            break
        case 'historico':
            tituloModalMovimiento.value = 'Agregar movimiento al historial'
            movimiento.value = {contratacion_id:contratacion_id, status:'HISTORICO', actual: 0}
            break
        
        case 'editar':
            tituloModalMovimiento.value = 'Actualizar movimiento'
            textBtnGuardarMovimiento.value = 'Guardar cambios'
            break
        case 'baja':
            tituloModalMovimiento.value = 'Finalizar puesto'
            movimiento.value.status = 'PRE_BAJA'
            textBtnGuardarMovimiento.value = 'Registrar baja'
            break
    }
    toggleForm()
}

const editMovimiento =  (mov:object):void => {
    MovimientoEditMode.value = true
    movimiento.value = {...mov}
    toggleForm()
}

const persistMov = async (id:number, params:object) => {
    const query = id? http!.patch('movimiento/'+id, params) : http!.post('movimiento/', params)
    let message = (id? 'Se actualizó ' : 'Se registró ') + 'correctamente'
    await query.then(() => {
        toggleForm()
        emit('updatePersonal')
        toast.success(message)

    })
}

const toggleContratacionForm = (mode: string, contratacion_id:number = 0) => {
    modalContratacionIsOpen.value = !modalContratacionIsOpen.value
    selectedContratacion.value = contratacion_id
    contratacion.value = {..._contratacion.value}
    textBtnGuardarContratacion.value = 'Registrar'
    clearContratacionProps()
    // se define el modo para las contrataciones
    ContratacionEditMode.value = false
    switch(mode){
        case 'baja':
            tituloModalContratacion.value = 'Baja de contratación actual'
            contratacion.value.status = 'PRE_BAJA'
            textBtnGuardarContratacion.value = 'Registrar baja'
            
            break
        case 'nuevo':
            tituloModalContratacion.value = 'Registro de contratación'
            contratacion.value = {
                status: 'NUEVO',
                rfc: props.personal!.rfc,
                actual:1
            }
            break
        case 'historico':
            tituloModalContratacion.value = 'Agregar historial de contratación'
            contratacion.value = {
                status: 'HISTORICO',
                rfc: props.personal!.rfc,
                actual:0
            }
            break
        case 'editar':
            tituloModalContratacion.value = 'Editar datos de la contratación'
            ContratacionEditMode.value = true
            textBtnGuardarContratacion.value = 'Guardar cambios'
            break
    }
}

const guardarContratacion = async (event:Event) => {
    event.preventDefault()
    // enviar y guardar los cambios en la base de datos
    let response = {} as AxiosResponse
    let message = 'Se actualizó correctamente'
    try {
        // identifacar si tiene id
        if(contratacion.value.id){
            response= await http!.patch<AxiosResponse>('contratacion/' + contratacion.value.id, contratacion.value)
        } else {
            response= await http!.post('contratacion', contratacion.value)
            message = 'Se registró correctamente'
        }
        if(response.status === 200) {
            emit('updatePersonal')
            console.log(response.data)
            modalContratacionIsOpen.value = false
            toast.success(message)
            cardVisible.value = response.data.id
        }

    } catch (error) {
        console.log(error)
        toast.error('<b>Ocurrió el siguiente error:</b><br><em>'+(error as Error).message+'</em><hr><b>Favor de notificarar</b>', {
            dangerouslyHTMLString: true,
            autoClose: false
        })
    }

}

const clearContratacionProps = () => {
    delete contratacion.value.movimientos
    delete contratacion.value.puesto
    delete contratacion.value.created_at
    delete contratacion.value.updated_at
}

const clearMovimientoProps = () => {
    delete movimiento.value.plaza
    delete movimiento.value.adscripcion
    delete movimiento.value.created_at
    delete movimiento.value.updated_at
}
 
const guardarMovimiento = async (event:Event) => {
    event.preventDefault()
    isSaving.value = true
    let params = {movimiento: movimiento.value} as {movimiento: Movimiento, anterior?:number}
    let id = movimiento.value.id ? movimiento.value.id : 0
    delete params.movimiento.id
    // valida otra funcion
    if(params.movimiento.funcion === 'OTRA'){
        params.movimiento.funcion = otra_funcion.value
    }
    
    persistMov(id, params)
}


// metodos para eliminar

const deletePersonal = async (rfc:string) => {
    let response = await http!.delete('personal/'+rfc)
    if(response.status === 200){
        toast.success('Registro eliminado')
        router.push({name: 'ListaPersonal'})
        
    }
}

const deleteContratacion = async (id:number) => {
    let response = await http!.delete('contratacion/'+id)
    if(response.status === 200){
        emit('updatePersonal')
        toast.success('Registro eliminado')
    }
}

const deleteMovimiento = async (id:number) => {
    let response = await http!.delete('movimiento/'+id)
    if(response.status === 200){
        emit('updatePersonal')
        toast.success('Registro eliminado')
    }
}

</script>