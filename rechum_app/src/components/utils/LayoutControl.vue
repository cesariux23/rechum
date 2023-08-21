<script setup lang="ts">
defineProps<{
  label: string,
  extraClass?: string
  extraClassControl?:string
}>()
</script>
<template lang="pug">
.column(:class="extraClass")
  .field
      label.label {{ label }}
      .control(:class="extraClassControl")
          slot
</template>