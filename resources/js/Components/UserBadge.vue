<script setup lang="ts">
import NavLink from './../Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import type { User } from './../types/index.d';

type PropsType = {
    user: User;
};

const props = defineProps<PropsType>();

const pageProps = usePage().props as any;
</script>

<template>
    <div class="flex justify-between items-center">
        <div class="">{{ user.name }}</div>
        <div class="opacity-50">{{ user.email }}</div>
        <NavLink
            v-if="user.id !== pageProps.auth.user.id"
            :href="'#'"
            class="min-w-[50px] dark:bg-indigo-800 px-4 py-1 dark:hover:bg-indigo-700 rounded-md"
        >
            chat
        </NavLink>
        <div v-else class="min-w-[50px]"></div>
    </div>
</template>

<style scoped></style>
