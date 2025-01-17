
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import { usePage } from '@inertiajs/vue3';

    const { totalEmployees, totalLogins, totalUnits, totalJabatans, topEmployees } = usePage().props;

    const startDate = ref('');
    const endDate = ref('');

    function formatDate(date) {
        return new Date(date).toLocaleDateString();
    }

    function filterTopEmployees() {
        Inertia.get('/dashboard', {
            start_date: startDate.value,
            end_date: endDate.value,
        }, { preserveState: true });
    }

    function clearFilter() {
        startDate.value = '';
        endDate.value = '';
        Inertia.get('/dashboard', {}, { preserveState: true });
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
                <div class="flex mb-6">
                    <input 
                        type="date" 
                        v-model="startDate" 
                        class="border rounded px-4 py-2"
                    />
                    <span class="mx-2">to</span>
                    <input 
                        type="date" 
                        v-model="endDate" 
                        class="border rounded px-4 py-2"
                    />
                    <button 
                        @click="filterTopEmployees"
                        class="bg-blue-500 text-white rounded px-4 py-2 ml-4"
                    >
                        Filter
                    </button>
                    <button 
                        @click="clearFilter"
                        class="bg-gray-300 text-gray-800 rounded px-4 py-2 ml-4"
                    >
                        Clear Filter
                    </button>
                </div>

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
