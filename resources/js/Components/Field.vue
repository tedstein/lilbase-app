<script setup>

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

dayjs.extend(relativeTime);

const props = defineProps(['field', 'app', 'table', 'types']);
const form = useForm({
    name: props.field.name,
    type: props.field.type,
});
const editing = ref(false);

</script>

<template>
    <div class="p-6 flex space-x-2">

        <div class="flex-1">
            <div class="flex justify-between items-center">

                <div>
                    <small class="ml-2 text-sm text-gray-600">Field created by </small>
                    <span class="text-gray-800">{{ app.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs().to( dayjs(field.created_at)) }}
                    </small>
                    <small v-if="field.created_at !== field.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>

                <Dropdown>

                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>

                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                            @click="editing = true"
                        >
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('fields.destroy', { table: table.slug, app: app.slug, field: field.slug })" method="delete">
                            Delete
                        </DropdownLink>
                    </template>

                </Dropdown>

            </div>

            <form
                v-if="editing"
                @submit.prevent="form.put(
                    route('fields.update', { field: field.slug, table: table.slug, app: app.slug }),
                { onSuccess: editing = false })
            ">

                <input type="text" id="field-name"
                       v-model="form.name"
                       class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >

                <select
                    v-model="form.type"
                    class="mt-4 block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                    <option v-for="(human, machine) in types" :value="machine">{{ human }}</option>
                </select>

                <InputError :name="form.errors.name" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset()">Cancel</button>
                </div>
            </form>

            <p v-else class="mt-4 text-lg text-gray-900">
                <Link :href="route('fields.index', { table: table.slug, app: app.slug })">
                    {{ field.name }} ({{ types[field.type] }})
                </Link>
            </p>

        </div>
    </div>
</template>
