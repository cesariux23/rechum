export type Movimiento = {
    id?:number,
    rfc?:string,
    status?:string,
    id_contratacion?:number,
    fecha_inicio?:null | string | Date,
    fecha_baja?:null | string | Date,
    actual?:number,
}