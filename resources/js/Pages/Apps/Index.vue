<script setup>

import App from '@/Components/App.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {useForm, Head} from '@inertiajs/inertia-vue3';

defineProps(['apps'])

const form = useForm({
    name: '',
});

</script>

<template>
    <Head title="Apps"/>

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

            <h1>
                {{ apps.length }}
                <span v-if="apps.length === 1">
                    App
                </span>
                <span v-else>
                    Apps
                </span>
            </h1>


            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <App
                    v-for="app in apps"
                    :key="app.id"
                    :app="app"
                />
            </div>


            <form
                @submit.prevent="form.post(route('apps.store'), { onSuccess: () => form.reset() })"
                class="pt-4"
            >
                <input type="text"
                       v-model="form.name"
                       placeholder="What would you like to name your new app?"
                       class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <InputError :message="form.errors.name" class="mt-2"/>

                <PrimaryButton class="mt-4">Create App</PrimaryButton>
            </form>

        </div>
    </AuthenticatedLayout>
</template>
