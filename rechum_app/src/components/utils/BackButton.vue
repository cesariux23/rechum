<template lang="pug">
a.button.is-info.is-pulled-right.is-outlined(@click="goBack" title="Volver")
    span.icon
        span.material-icons arrow_back
    span volver
</template>
<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router' 
const router = useRouter()
const route = useRoute()

const goBack = () => {
    console.log(router.options.history.state.back)
    console.log(route.fullPath)
    
    if(router.options.history.state.back === route.fullPath) {
        router.go(-2)
    } else {
        router.go(-1)
    }
}
</script>