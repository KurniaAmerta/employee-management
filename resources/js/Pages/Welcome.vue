<script setup>
</script>

<template>
  <Head title="Welcome" />

  <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
    <div class="text-center mb-6">
      <h1 class="text-4xl font-extrabold text-gray-900">Welcome to Our Site</h1>
    </div>

    <div class="flex justify-center">
        <a :href="route('dashboard')" class="btn-secondary-xl">Dashboard</a>
    </div>
  </div>
</template>
