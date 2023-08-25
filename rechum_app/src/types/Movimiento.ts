export type Movimiento = {
    id?:number,
    rfc?:string,
    status?:string,
    contratacion_id?:number,
    fecha_inicio?:null | string | Date,
    fecha_baja?:null | string | Date,
    actual?:number,
    created_at?:Date,
    updated_at?:Date,
    plaza?: object,
    adscripcion?: object
}