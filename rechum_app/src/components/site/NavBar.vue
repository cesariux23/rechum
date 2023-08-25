<template lang="pug">
nav.navbar.is-fixed-top.is-dark(role="navigation" aria-label="main navigation")
    .navbar-brand
        RouterLink.navbar-item(to="/")
            b IVEA | Recursos Humanos
    .navbar-menu
        .navbar-start
            RouterLink.navbar-item(:to="{name:'ListaPersonal'}")
                span.icon
                    span.material-icons people
                span Personal
            //-
                RouterLink.navbar-item(to="/nominas")
                    span.icon
                        span.material-icons-outlined featured_play_list
                    span Nóminas
                RouterLink.navbar-item(to="/asistencia")
                    span.icon
                        span.material-icons calendar_today
                    span Asistencia
        .navbar-end
            //-
                RouterLink.navbar-item(to="/catalogos")
                    span.icon
                        span.material-icons-outlined dataset
                    span Catálogos
                RouterLink.navbar-item(to="/configuracion")
                    span.icon
                        span.material-icons build
                    span Configuración
            RouterLink.navbar-item(to="/login") 
                span.icon
                    span.material-icons logout
                span Cerrar sesión
</template>
<style>

a.navbar-item.is-active {
    background-color: #720f3c !important;
}
</style>