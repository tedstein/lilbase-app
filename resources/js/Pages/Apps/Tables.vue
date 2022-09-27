<script setup>

import Table from '@/Components/Table.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';

defineProps(['app'])

const form = useForm({
    name: '',
});
</script>

<template>
    <Head :title="app.name" />
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

            <h1>Tables</h1>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Table
                    v-for="table in app.tables"
                    :key="table.id"
                    :table="table"
                    :app="app"
                >
                </Table>
            </div>

            <form @submit.prevent="form.post(route('tables.store', app.slug), { onSuccess: () => form.reset() })">
                <input type="text"
                       v-model="form.name"
                       placeholder="What would you like to name your new table?"
                       class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <InputError :message="form.errors.name" class="mt-2" />

                <PrimaryButton class="mt-4">Create Table</PrimaryButton>
            </form>

        </div>
    </AuthenticatedLayout>
</template>
