<script setup lang="ts">
import LayoutControl from "@/components/utils/LayoutControl.vue";
</script>
<template lang="pug">
form.form(action="")
    .columns
        LayoutControl(label="Banco*" required extraClass="is-one-quarter")
            .select(required)
                select
                    option(value="21") BBVA BANCOMER
        
        LayoutControl(label="Número de cuenta*")
            input.input(type="text" placeholder="Número de cuenta" required)
        LayoutControl(label="CLABE")
            input.input(type="text" placeholder="Número de cuenta CLABE (21 posisciones)" minlength="21" maxlength="21")
    .columns
        LayoutControl(label="Codigo Postal*" extraClass="is-one-quarter")
            input.input(type="text" placeholder="5 dígitos" minlength="5" maxlength="5" required)
        LayoutControl(label="Domicilio")
            input.input(type="text" placeholder="calle, número exterior, colonia, localidad")
        LayoutControl(label="Correo principal*")
            input.input(type="email" placeholder="Correo personal o institucional" required)
    .columns
        LayoutControl(label="Seguridad Social*" extraClass="is-one-quarter")
            .select
                select
                    option Ninguna
                    option ISSSTE
        LayoutControl(label="Número Seguridad Social")
            input.input(type="text" placeholder="NSS")
</template>