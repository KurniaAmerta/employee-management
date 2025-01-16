<script setup>
    import { usePage } from '@inertiajs/vue3';

    const { flash } = usePage();

    console.log(flash)

    const message = flash?.success || flash?.error || null;

    const messageClass = flash?.success
    ? 'bg-green-500 text-white'
    : flash?.error
    ? 'bg-red-500 text-white'
    : '';
</script>

<template>
  <div v-if="message" :class="messageClass" class="fixed top-0 right-0 m-4 p-4 rounded shadow-lg">
    <p>{{ message }}</p>
  </div>
</template>