<script setup>
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
    <slot name="header" />
    
        <div class="px-6 py-8">
            <div class="text-2xl text-zinc-900 mb-4">
                <slot name="title" />
            </div>

            <div class="mb-18 text-sm text-zinc-700">
                <slot name="content" />
            </div>
        </div>

        <div class="flex flex-row px-6 py-4 text-end">
            <slot name="footer" />
        </div>
    </Modal>
</template>
