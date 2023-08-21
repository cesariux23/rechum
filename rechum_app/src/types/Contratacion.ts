export type Contratacion = {
    id?:number,
    rfc?:string,
    status?:string,
    numero_empleado?:string,
    fecha_inicio?:Date,
    fecha_baja?:Date
    motivo_baja?:string
    actual?:number,
    puesto?:null | object,
    created_at?:Date,
    updated_at?:Date,
    movimientos?:object[]
}