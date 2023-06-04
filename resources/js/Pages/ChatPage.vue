<script setup lang="ts">
import { User } from '../types';
import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';

type Message = {
    id: number;
    message: string;
    user_id: number;
    created_at: string;
};

const props = defineProps<{
    chat: {
        id: number;
        title: string;
        users: User[];
        messages: Message[];
    };
}>();

console.log(props.chat.messages);

const pageProps = usePage().props;

const form = useForm({
    message: '',
});

const onSubmit = () => {
    axios
        .post(route('store-message', { id: props.chat.id }), {
            message: form.message,
        })
        .then((response) => {
            console.log(response.data.message);
            form.reset();
        })
        .catch();
};

//@ts-expect-error Echo
Echo.private(`chats.${props.chat.id}`).listen('.message.sent', (e) => {
    console.log(e);
});
</script>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Chat: <span class="dark:text-indigo-500">{{ chat.title }}</span>
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    Happy chatting
                </h2>
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                        <div>
                            You are chatting with:
                            <span class="font-bold">{{
                                chat.users
                                    .filter(
                                        (user) =>
                                            user.id !== pageProps.auth.user.id
                                    )
                                    .map((user) => user.name)
                                    .join(', ')
                            }}</span>
                        </div>
                        <div
                            class="dark:bg-gray-600 rounded-xl p-6 max-w-[500px] mx-auto flex flex-col gap-[15px]"
                        >
                            <div
                                class="dark:bg-gray-500 rounded-md px-3 py-2 w-fit"
                                :class="{
                                    'dark:bg-indigo-400 self-end':
                                        pageProps.auth.user.id ===
                                        message.user_id,
                                }"
                                v-for="message in chat.messages"
                                :key="message.id"
                            >
                                {{ message.message }}
                            </div>
                        </div>
                        <form
                            @submit.prevent="
                                // form.post(
                                //     route('store-message', { id: chat.id }),
                                //     {
                                //         onSuccess: () => {
                                //             form.reset();
                                //         },

                                //         preserveState: true,
                                //     }
                                // )
                                onSubmit()
                            "
                            class="flex w-full dark:bg-gray-400 max-w-[500px] mx-auto rounded-lg overflow-hidden"
                        >
                            <TextInput
                                type="text"
                                id="message"
                                class="dark:bg-transparent border-none w-full focus:ring-0 focus:text-black focus:font-semibold dark:text-gray-900 font-semibold"
                                v-model="form.message"
                                required
                                autofocus
                            />
                            <button
                                type="submit"
                                class="px-4 py-2 dark:bg-indigo-600 dark:hover:bg-indigo-500"
                            >
                                Send
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
