<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? "shadow-[0px_0px_6px_rgb(0,0,0,0.2)] w-full inline-flex items-center justify-center px-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition-all duration-150 ease-in-out"
        : "hover:shadow-[inset_0_0px_6px_rgb(0,0,0,0.2)] w-full inline-flex items-center justify-center px-1  text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition-all duration-150 ease-in-out";
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
