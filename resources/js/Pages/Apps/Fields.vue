<script setup>

import Field from '@/Components/Field.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';

defineProps(['table', 'app', 'types'])

const form = useForm({
    name: '',
    type: 'string',
});

const focus = {
    mounted: (el) => el.focus()
}

</script>

<template>
    <Head :title="app.name + ' > ' + table.name" />
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

            <h1>Fields: {{ table.name }} Table</h1>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Field
                    v-for="field in table.fields"
                    :key="field.id"
                    :field="field"
                    :app="app"
                    :table="table"
                    :types="types"
                >
                </Field>
            </div>

            <form @submit.prevent="form.post(route('fields.store', { app: app.slug, table: table.slug }), { onSuccess: () => form.reset() })">

                <input type="text" id="field-name"
                       v-model="form.name"
                       placeholder="What would you like to name your new field?"
                       class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >

                <select
                        v-model="form.type"
                        class="mt-4 block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                    <option v-for="(human, machine) in types" :value="machine">{{ human }}</option>
                </select>


                <InputError :message="form.errors.name" class="mt-2" />
                <InputError :message="form.errors.type" class="mt-2" />

                <PrimaryButton class="mt-4">Create Field</PrimaryButton>
            </form>

        </div>
    </AuthenticatedLayout>
</template>
