<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import type { User } from './../types/index.d';
import { useForm } from '@inertiajs/vue3';

type PropsType = {
    user: User;
};

const props = defineProps<PropsType>();

const pageProps = usePage().props as any;

const form = useForm({
    userId: props.user.id,
});
</script>

<!-- :href="route('chat', { id: chat.id })" -->
<template>
    <div class="flex justify-between items-center">
        <div class="">{{ user.name }}</div>
        <div class="opacity-50">{{ user.email }}</div>
        <form
            @submit.prevent="form.post(route('open.or.create.chat'))"
            v-if="user.id !== pageProps.auth.user.id"
            class="min-w-[50px] dark:bg-indigo-800 px-4 py-1 dark:hover:bg-indigo-700 rounded-md"
        >
            <button type="submit">chat</button>
        </form>
        <div v-else class="min-w-[50px]"></div>
    </div>
</template>

<style scoped></style>
