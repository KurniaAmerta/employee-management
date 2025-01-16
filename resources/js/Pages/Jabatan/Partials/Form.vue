<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue';

const nameInput = ref(null);

const isEditMode = ref(false);
const modelName = ref('Jabatan');
const modelData = ref({
    name: '',
});

const props = defineProps({
    jabatan: Object, 
});

watchEffect(() => {
    if (props.jabatan) {
        isEditMode.value = true;
        modelData.value = { ...props.jabatan }; 
    } else {
        isEditMode.value = false;
    }
});

const form = useForm({
    name: modelData.value.name,
});

const submitForm = () => {
    const routeName = isEditMode.value ? 'jabatan.update' : 'jabatan.store';
    const routeParams = isEditMode.value ? [props.jabatan.id] : [];

    form[isEditMode.value ? 'put' : 'post'](route(routeName, routeParams), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.name) {
                form.reset('name');
                nameInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ isEditMode ? 'Edit' : 'Create' }} Jabatan
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ isEditMode ? 'Update jabatan\'s information.' : 'Create a new jabatan.' }}
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    {{ isEditMode ? 'Save Changes' : 'Create' }}
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
