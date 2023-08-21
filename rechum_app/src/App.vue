<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import SiteNavBar from './components/site/NavBar.vue'
</script>

<template lang="pug">
.main
  header
    SiteNavBar  
  .container
    Suspense
      RouterView
    template#fallback
      span.mt20 aaaaa
      || Loading...
</template>