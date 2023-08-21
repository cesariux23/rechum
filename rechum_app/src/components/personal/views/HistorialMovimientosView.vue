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
                    button.is-pulled-right.button.is-info(v-if="personal.contratacion && personal.contratacion.status === 'ACTIVO'" @click="toggleContratacionForm('historico')" title="Agregar historial contratación")
                        span.icon
                            span.material-icons post_add
                        span Agregar historial
                p.control
                button.is-pulled-right.button.is-success(v-if="personal.contrataciones.length === 0 || (personal.contratacion && personal.contratacion.status === 'BAJA')" @click="toggleContratacionForm('nuevo')" title="Agregar contratación")
                        span.icon
                            span.material-icons add
                        span Registrar

    //- listado de contrataciones
    .card.is-radiusless(v-if="personal.contrataciones.length>0" v-for="contratacion in personal.contrataciones")
        .card-header.has-background-light.is-radiusless
            p.card-header-title(@click="toggleCard(contratacion.id)")
                | {{ contratacion.tipo_contratacion }}&nbsp;
                .tags
                    span.tag.is-success(v-if="contratacion.actual" :class= "[contratacion.status !=='ACTIVO' ? 'is-light' : '']")
                        | {{ contratacion.status ==='ACTIVO' && contratacion.actual ? 'Actual' : 'Último' }}
                    span.tag.is-danger(v-if="contratacion.status === 'BAJA'") Baja
            button.card-header-icon(@click="toggleCard(contratacion.id)")
                span.icon
                    span.material-icons keyboard_arrow_{{ contratacion.id === cardVisibleId ? 'up' : 'down' }}
                    
        .card-content(v-if="contratacion.id === cardVisibleId")
            .notification.is-info.is-light(v-if="contratacion.status === 'HISTORICO'")
                .icon-text
                    span.icon.has-text-info
                        i.material-icons info
                    span La información mostrada en esta sección forma parte del historial de contrataciones y no
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
                    p.control(v-if="personal.contratacion && personal.contratacion.id === contratacion.id && personal.contratacion.puesto && personal.contratacion.puesto.status === 'ACTIVO'")
                        button.button.is-danger.is-outlined(title="Realizar baja del puesto actual")
                            span.icon
                                span.material-icons playlist_remove
                            span Baja puesto actual
                    p.control(v-else)
                        button.button.is-primary.is-outlined(title="Registrar nuevo puesto como actual" v-if = "contratacion.actual && !contratacion.fecha_baja")
                            span.icon
                                span.material-icons add
                            span Nuevo movimiento
                    p.control
                        button.button.is-info.is-outlined(title="Agregar puesto al historial" @click="addHistorialPuesto(contratacion.id)")
                            span.icon
                                span.material-icons playlist_add
                            span Historial
            h4.title.is-4 Movimientos de puesto
            table.table.is-fullwidth.is-hoverable
                thead
                    tr
                        th Núm.
                        th Adscripción
                        th Función
                        th Periodo
                        th Acciones
                tbody(v-if="contratacion.movimientos")
                    tr(v-for="(mov, index) in contratacion.movimientos")
                        td
                            span.tag(:class="{'is-success': mov.actual}") {{ index + 1 }}
                        td 
                            p {{ mov.adscripcion.adscripcion }}
                            strong {{ mov.adscripcion.unidad_administrativa }}
                        td 
                            div(v-if="mov.plaza")
                                p {{ mov.plaza.descripcion }}
                                p
                                    strong {{ mov.codigo_plaza }}
                                    span.has-text-grey-light /
                                    strong {{ mov.codigo_tabulador }}
                                p
                                    span.is-size-7.has-text-grey(v-if="mov.funcion") {{mov.funcion? mov.funcion: 'Auxiliar administrativo'}}
                            p(v-else)| {{ mov.funcion? mov.funcion: 'Auxiliar administrativo' }}
                        td
                            strong De
                            span : {{ mov.fecha_inicio }}
                            br
                            strong Hasta
                            span : {{ mov.fecha_baja? mov.fecha_baja : '-' }}
                        td
                            button.button.is-small.is-white.ml-4(@click="editMovimiento(mov)" title="Editar puesto")
                                span.icon.has-text-info
                                    span.material-icons edit
                                    p.control                               
                
            .notification.is-warning.is-light.has-text-centered(v-if="contratacion.movimientos.length === 0")
                p Sin historial registrado.
                button.button.is-danger(@click="deleteContratacion(contratacion.id)")
                    span.icon
                        span.material-icons delete
                    span Eliminar contratación

    .notification.is-warning.is-light.has-text-centered(v-else)
         p.m-6 Sin historial.
         button.button.is-danger(@click="deletePersonal(personal.rfc)")
                    span.icon
                        span.material-icons person_remove
                    span Eliminar registro

    //- Modals para modificar
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
                            .column(v-if="_contratacion && contratacion.status ==='BAJA'")
                                p Núm. empleado:
                                b {{ _contratacion.numero_empleado }}
                            .column(v-if="_contratacion && contratacion.status ==='BAJA'")
                                p Inicio:
                                b {{ _contratacion.fecha_inicio }}

                div(v-if="contratacion.status !== 'BAJA'")
                    .columns
                        LayoutControl(label="Tipo de contratación*" v-if="!contratacion.id")
                            .select
                                select(required v-model="contratacion.tipo_contratacion" :disabled="props.editMode" @change="contratacion.interinato = false")
                                    option(v-for="_tc in catalogos.tipo_contratacion" :value="_tc.key") {{ _tc.value }}
                        LayoutControl(label="Número de empleado" extraClass="is-4")
                            input.input(type="text" v-model="contratacion.numero_empleado")
                        LayoutControl(label="Fecha de inicio*" extraClass="is-4")
                            input.input(type="date" v-model="contratacion.fecha_inicio" required)
                div(v-if="contratacion.status === 'BAJA' || contratacion.status === 'HISTORICO'")
                    .columns
                        LayoutControl(label="Fecha de baja*" extraClass="is-4")
                            input.input(type="date" v-model="contratacion.fecha_baja" required)
                        LayoutControl(label="Motivo baja*" v-if="contratacion.status !== 'ACTIVO'")
                            input.input(type="text" v-model="contratacion.motivo_baja" required)
            template(#modal-foot)
                button.button.is-primary(type="submit" :class="{'is-loading':isSaving}")
                    span.icon
                        span.material-icons-outlined save
                    span {{ contratacion.id ? contratacion.status === 'BAJA' ? 'Registrar baja' : 'Actualizar' : 'Registrar' }}
                button.button.is-danger.ml-1(type="button" @click="toggleContratacionForm('close')" :disabled="isSaving")
                    span.icon
                        span.material-icons-outlined close
                    span Cancelar

    //- modal Movimiento
    ModalCard(v-model:isOpen="modalMovimientoIsOpen" modal-class='width-1000')
        template(#modal-title)
            span {{editMode ? 'Editar' : 'Registrar'}} movimiento {{ movimiento.status === 'HISTORICO'? 'histórico' : (movimiento.status === 'ACTIVO'? 'actual' : '') }}
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
                LayoutControl(label="Fecha de baja*" v-if="movimiento.status === 'HISTORICO'" extraClass="is-6")
                    input.input(type="date" required v-model="movimiento.fecha_baja")
            .columns 
                LayoutControl(label="Adscripción*")
                    .select
                        select(required v-model="movimiento.adscripcion_id")
                            option(v-for="_ad in catalogos.adscripciones" :value="_ad.id") {{ _ad.unidad_administrativa }} - {{ _ad.adscripcion }}
            .columns(v-if="_contratacion && (_contratacion.tipo_contratacion==='BASE' || _contratacion.tipo_contratacion === 'CONFIANZA')")
                LayoutControl(label="Puesto*")
                    .select
                        select(required v-model="movimiento.codigo_plaza")
                            option(v-for="_pl in catalogos.plazas" :value="_pl.codigo_plaza") {{ _pl.codigo_plaza }} - {{ _pl.descripcion }}
            .columns
                LayoutControl(label="Función*")
                    input.input(type="text" v-model="movimiento.funcion" placeholder="Función real, actividad que desempleña o puesto")
            | {{ movimiento }}
        template(#modal-foot)
            button.button.is-primary(type="submit" :class="{'is-loading':isSaving}")
                span.icon
                    span.material-icons-outlined save
                span Guardar
            button.button.is-danger.ml-1(type="button" @click="toggleForm" :disabled="isSaving")
                span.icon
                    span.material-icons-outlined close
                span Cancelar
    

</template>
<script setup lang="ts">
import { ref, watch, reactive, computed } from 'vue'
import LayoutControl from "@/components/utils/LayoutControl.vue"
import ModalCard from "@/components/utils/ModalCard.vue"
import { useCatalogoStore } from "@/stores/catalogo"
import {useHttp} from '@/plugins/axios.js'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'
import { type Contratacion } from '@/types/Contratacion'
import { type Movimiento } from '@/types/Movimiento'
import{ type AxiosResponse } from 'axios'

const modalBajaIsOpen = ref(false)
const modalContratacionIsOpen = ref(false)
const modalMovimientoIsOpen = ref(false)
const editMode = ref(false)
const selectedContratacion = ref(0)
const baja = ref<Contratacion>({})
const tituloModalContratacion = ref('')

const cardVisible = ref(-1)
let movimiento = ref<Movimiento>({})

let contratacion = ref<Contratacion>({})
let _actual = reactive<Movimiento>({})
let params = {}
const http= useHttp()
const router = useRouter()
const isSaving = ref(false)

const emit = defineEmits<{
  (event: 'updatePersonal'): void
}>()

const props = defineProps({
        personal: Object
    })

const cardVisibleId = computed(() =>{
    return cardVisible.value === -1 && props.personal && props.personal!.contratacion? props.personal!.contratacion.id : cardVisible.value
})

const _contratacion = computed(()=> {
    if(props.personal && props.personal!.contrataciones)
        return props.personal!.contrataciones.find((c:Contratacion) => c.id === selectedContratacion.value)
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
}

const addHistorialPuesto = (id_contratacion:number) => {
    editMode.value = false
    // se crea el nuevo movimiento
    selectedContratacion.value = id_contratacion
    movimiento.value = {id_contratacion:id_contratacion, status:'HISTORICO'}
    toggleForm()
}

const editMovimiento =  (mov:object):void => {
    editMode.value = true
    movimiento.value = {...mov}
    toggleForm()
}

const persistMov = async (id:number, params:object) => {
    const query = id? http!.patch('movimiento/'+id, params) : http!.post('movimiento/', params)
    await query.then(() => {
        toggleForm()
                emit('updatePersonal')
    })
}

const toggleBajaForm = () => {
    modalBajaIsOpen.value = !modalBajaIsOpen.value
    if(modalBajaIsOpen.value)
        baja.value = {rfc: props.personal!.rfc}
}
const toggleContratacionForm = (mode: string, id_contratacion?: number) => {
    modalContratacionIsOpen.value = !modalContratacionIsOpen.value
    selectedContratacion.value = id_contratacion ? id_contratacion: 0
    // se define el modo para las contrataciones
    switch(mode){
        case 'baja':
            tituloModalContratacion.value = 'Baja de contratación actual'
            contratacion.value = {..._contratacion.value}
            contratacion.value!.status = 'BAJA'
            clearContratacionProps()
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
            contratacion.value = {..._contratacion.value}
            clearContratacionProps()
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
 
const save = async (event:Event) => {
    event.preventDefault()
    isSaving.value = true
    let params = {movimiento: movimiento.value} as {movimiento: Movimiento, anterior?:number}
     let id = movimiento.value.id ? movimiento.value.id : 0
    delete params.movimiento.id
    //si está en modo edición
    if(editMode.value){
        persistMov(id, params)
    } else {
        // si se esta partiendo de un movimiento existente
        // se debe terminar el puesto anterior y despues generar un nuevo registro
        if(id) {
            params.anterior = id
            id = 0
        } 
        persistMov(id, params)
    }
}

const deleteContratacion = async (id:number) => {
    let response = await http!.delete('contratacion/'+id)
    if(response.status === 200){
        emit('updatePersonal')
        toast.success('Registro eliminado')
    }
}
const deletePersonal = async (rfc:string) => {
    let response = await http!.delete('personal/'+rfc)
    if(response.status === 200){
        toast.success('Registro eliminado')
        router.push({name: 'ListaPersonal'})
        
    }
}

watch(
    movimiento,
    () => {
        if(movimiento.value.status === 'ACTIVO'){
            if(props.personal!.actual){
                // se inicializan los valores para cancelar el movimiento actual
                _actual.fecha_baja = new Date().toJSON().slice(0, 10)
                _actual.id = props.personal!.actual.id
                _actual.actual = 0
                movimiento.value.actual = 0 
            } else {
                _actual = reactive({})
                movimiento.value.fecha_baja = null
                movimiento.value.actual = 0
            }
        }
    }
)

watch(
    _actual,
    () => {
        if(_actual.fecha_baja){
            const dateParts = (_actual.fecha_baja as string).split("-");
            const date = new Date(Number(dateParts[0]), Number(dateParts[1]) - 1, Number(dateParts[2].substring(0,2)));
            date.setDate(date.getDate() + 1)
            movimiento.value.fecha_inicio = date.toJSON().slice(0, 10)
            movimiento.value.actual = 1
            _actual.id = props.personal!.actual.id
        }
    }
)
</script>