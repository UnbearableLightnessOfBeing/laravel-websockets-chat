<script setup lang="ts">
import type { User } from '../types';
import { usePage } from '@inertiajs/vue3';
import NavLink from './NavLink.vue';

defineProps<{
    chat: {
        id: number;
        title: string;
        users: User[];
    };
}>();

const pageProps = usePage().props as any;
</script>

<template>
    <NavLink
        class="flex flex-col gap-2 w-full"
        :href="route('chat', { id: chat.id })"
    >
        <h1 class="block text-[20px] w-fit mx-auto">{{ chat.title }}</h1>
        <div class="flex gap-[6px] self-end">
            <div class="block opacity-50">Participants:</div>
            <div
                :class="{
                    'text-green-300': pageProps.auth.user.id === user.id,
                }"
                v-for="user in chat.users"
                :key="user.id"
            >
                {{ user.name }}
            </div>
        </div>
    </NavLink>
</template>

<style scoped></style>
