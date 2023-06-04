<script setup lang="ts">
import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
import type { User } from '../types';
import ChatBadge from '../Components/ChatBadge.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    chats: {
        id: number;
        title: string;
        users: User[];
    }[];
}>();
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Chats
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    Choose a chat
                </h2>
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                        <div v-if="!chats.length">You have no chats</div>
                        <div class="space-y-6" v-else>
                            <ChatBadge
                                class="px-4 py-2 rounded-lg dark:bg-gray-700 dark:hover:bg-gray-600 hover:cursor-pointer"
                                v-for="chat in chats"
                                :key="chat.id"
                                :chat="chat"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
