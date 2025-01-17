<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Form from './Partials/Form.vue';
    import { Head } from '@inertiajs/vue3';
    import { defineProps } from 'vue';

    const props = defineProps({
        employee: Object,
        units: Array,
        jabatans: Array,
    });
</script>

<template>
    <Head title="Edit Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <Form
                        class="max-w-xl"
                        :employee="props.employee"
                        :units="props.units"
                        :jabatans="props.jabatans"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
