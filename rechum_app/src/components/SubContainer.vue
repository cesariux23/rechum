<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>
<template lang="pug">
RouterView(:key="$route.fullPath")
</template>