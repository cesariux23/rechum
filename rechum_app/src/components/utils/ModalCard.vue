<template lang="pug">
.modal(:class="{'is-active':isOpen}")
    .modal-background
        .modal-card(:class="modalClass")
            header.modal-card-head
                p.modal-card-title
                    slot(name='modal-title')
                button.delete(type="button" aria-label="close" @click="close")
            section.modal-card-body
                slot(name='modal-body')
            footer.modal-card-foot
                slot(name='modal-foot')
        button.modal-close.is-large(aria-label="close" @click="close")
</template>
<script setup lang="ts">

const props = defineProps<{
  isOpen: boolean,
  modalClass?: string
}>()

const emit =defineEmits(['update:isOpen'])

const closerClasses = ['modal-background', 'delete', 'modal-close']

const close = (event:Event) => {
    const el = event.target as HTMLElement

    if( closerClasses.some( cc => el.classList.contains(cc)))
        emit('update:isOpen', false)
}
</script>
<style scoped>
.modal-card{
    padding-top: 50px;
}
.width-1000{
    padding-top: 50px;
    width: 1000px;
}
</style>