<template lang="pug">
.LoginForm
  .has-text-centered
    img(src="../../assets/logo.png")
  .columns
    .column.is-half.is-offset-one-quarter
      .card
          header.card-header
            p.card-header-title.has-background-light Sistema de Recursos Humanos
          .card-content
            form(@submit.prevent="authenticate")
              .field
                label.label Usuario
                .control
                  input.input(type="text" v-model="user.username" required)
              .field
                label.label Contraseña
                .control
                  input.input(type="password" v-model="user.password" required)
              .field.is-grouped
                .control
                  button.button.is-success(type="submit")
                    span.icon
                      span.material-icons login
                    span Iniciar sesión
</template>
<script lang="ts">
export default {
  data () {
    return {
      user: {}
    }
  },
  methods: {
    authenticate: () => {
      alert('cliiiiiiick!')
    }
  }
}
</script>