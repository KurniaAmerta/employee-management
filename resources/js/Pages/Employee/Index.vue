<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import FlashMessage from '@/Components/FlashMessage.vue';
    import { onMounted } from 'vue';
    import DataTable from 'datatables.net-dt';
    import { Inertia } from '@inertiajs/inertia';

    const { props } = usePage();
    const employees = props.employees;

    onMounted(() => {
        const table = new DataTable('#employees', {
            responsive: true,
            order: [[2, 'asc']],
            pageLength: 10,
        });
    });

    const confirmDelete = (employeeId) => {
        if (confirm('Are you sure you want to delete this employee?')) {
            Inertia.visit(route('employee.destroy', employeeId), { method: 'delete' });
        }
    };
</script>

<style>
    @import 'datatables.net-dt';
</style>

<template>
    <Head title="Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee</h2>
            <FlashMessage />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <table id="employees" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Creted at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(employee, index) in employees" :key="employee.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ employee.name }}</td>
                                <td>{{ employee.created_at_formatted }}</td>
                                <td>
                                    <a :href="route('employee.edit', employee.id)" class="text-blue-600 hover:underline">Edit</a>
                                    <a :href="route('employee.destroy', employee.id)" 
                                        class="text-red-600 hover:underline"
                                        @click.prevent="confirmDelete(employee.id)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <a :href="route('employee.create')" class="btn-secondary-xl">New Employee</a>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
