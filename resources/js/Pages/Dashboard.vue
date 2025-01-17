<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { totalEmployees, totalLogins, totalUnits, totalJabatans, topEmployees } = usePage().props;

function formatDate(date) {
    return new Date(date).toLocaleDateString();
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-blue-800">Total Employees</h3>
                        <p class="text-3xl font-bold text-blue-700">{{ totalEmployees }}</p>
                    </div>
                    
                    <div class="bg-green-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-green-800">Total Logins</h3>
                        <p class="text-3xl font-bold text-green-700">{{ totalLogins }}</p>
                    </div>

                    <div class="bg-yellow-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-yellow-800">Total Units</h3>
                        <p class="text-3xl font-bold text-yellow-700">{{ totalUnits }}</p>
                    </div>

                    <div class="bg-purple-100 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-purple-800">Total Jabatan</h3>
                        <p class="text-3xl font-bold text-purple-700">{{ totalJabatans }}</p>
                    </div>
                </div>

                <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Top 10 Employees with More Than 25 Logins</h3>
                    <div class="mt-4">
                        <ul>
                            <li class="flex justify-between py-2 border-b">
                                <span class="font-semibold text-gray-700">Employee Name</span>
                                <span class="text-gray-600">Login Count</span>
                                <span class="text-gray-600">Login Date Range</span>
                            </li>
                            <li v-for="employee in topEmployees" :key="employee.employee_id" class="flex justify-between py-2">
                                <span class="text-gray-700">{{ employee.name }}</span>
                                <span class="text-gray-600">{{ employee.login_count }}</span>
                                <span class="text-gray-600">
                                    {{ formatDate(employee.first_login_date) }} - {{ formatDate(employee.last_login_date) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
