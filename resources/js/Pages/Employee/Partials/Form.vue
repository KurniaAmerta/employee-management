<script setup>
import { ref, watchEffect, watch } from 'vue';
import Multiselect from 'vue-multiselect';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const isEditMode = ref(false);
const modelData = ref({
  name: '',
  username: '',
  dateJoined: '',
  password: '',
  password_confirmation: '',
  unit_id: null,
  jabatans: [],
});

const props = defineProps({
  employee: Object,
  units: Array,
  jabatans: Array,
});

watchEffect(() => {
  if (props.employee) {
    isEditMode.value = true;
    modelData.value = { ...props.employee };
  } else {
    isEditMode.value = false;
  }
});

const form = useForm({
  name: modelData.value.name,
  username: modelData.value.username,
  dateJoined: modelData.value.dateJoined,
  password: modelData.value.password,
  password_confirmation: modelData.value.password_confirmation,
  unit_id: modelData.value.unit_id,
  jabatans: props.employee ? props.employee.jabatans.map(jabatan => jabatan.id) : [],
});

const selectedJabatan1 = ref(
  props.jabatans.find(jabatan => form.jabatans[0] === jabatan.id) || null
);
const selectedJabatan2 = ref(
  props.jabatans.find(jabatan => form.jabatans[1] === jabatan.id) || null
);

watch([selectedJabatan1, selectedJabatan2], ([jabatan1, jabatan2]) => {
  form.jabatans = [jabatan1?.id, jabatan2?.id].filter(id => id !== undefined);
});

const selectedUnit = ref(props.units.find(unit => unit.id === modelData.value.unit_id));

watch(selectedUnit, (unit) => {
    form.unit_id = unit.id;
});


const submitForm = () => {
  const routeName = isEditMode.value ? 'employee.update' : 'employee.store';
  const routeParams = isEditMode.value ? [props.employee.id] : [];

  form[isEditMode.value ? 'put' : 'post'](route(routeName, routeParams), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.name) form.reset('name');
      if (form.errors.username) form.reset('username');
      if (form.errors.password) form.reset('password');
      if (form.errors.password_confirmation) form.reset('password_confirmation');
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">
        {{ isEditMode ? 'Edit' : 'Create' }} Employee
      </h2>
      <p class="mt-1 text-sm text-gray-600">
        {{ isEditMode ? 'Update employee\'s information.' : 'Create a new employee.' }}
      </p>
    </header>

    <form @submit.prevent="submitForm" class="mt-6 space-y-6">
      <!-- Name -->
      <div>
        <InputLabel for="name" value="Name" />
        <TextInput
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Username -->
      <div>
        <InputLabel for="username" value="Username" />
        <TextInput
          id="username"
          v-model="form.username"
          type="text"
          class="mt-1 block w-full"
          autocomplete="username"
        />
        <InputError :message="form.errors.username" class="mt-2" />
      </div>

      <!-- Date Joined -->
      <div>
        <InputLabel for="dateJoined" value="Date Joined" />
        <TextInput
          id="dateJoined"
          v-model="form.dateJoined"
          type="date"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.dateJoined" class="mt-2" />
      </div>

      <!-- Unit -->
      <div>
        <InputLabel for="unit_id" value="Unit" />
        <Multiselect
          v-model="selectedUnit"
          :options="props.units"
          :searchable="true"
          :close-on-select="true"
          :label="'name'"
          :track-by="'id'"
          placeholder="Select Unit"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.unit_id" class="mt-2" />
      </div>

      <!-- Jabatan 1 -->
      <div>
        <InputLabel for="jabatan_1" value="Jabatan 1" />
        <Multiselect
          v-model="selectedJabatan1"
          :options="props.jabatans"
          :searchable="true"
          :close-on-select="true"
          :label="'name'"
          :track-by="'id'"
          placeholder="Select Jabatan 1"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.jabatans" class="mt-2" />
      </div>

      <!-- Jabatan 2 -->
      <div>
        <InputLabel for="jabatan_2" value="Jabatan 2 (Optional)" />
        <Multiselect
          v-model="selectedJabatan2"
          :options="props.jabatans"
          :searchable="true"
          :close-on-select="true"
          :label="'name'"
          :track-by="'id'"
          placeholder="Select Jabatan 2"
          class="mt-1 block w-full"
        />
      </div>

      <!-- Password -->
      <div>
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          v-model="form.password"
          type="password"
          class="mt-1 block w-full"
          autocomplete="new-password"
        />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <!-- Password Confirmation -->
      <div>
        <InputLabel for="password_confirmation" value="Confirm Password" />
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="mt-1 block w-full"
          autocomplete="new-password"
        />
        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>

      <!-- Submit Button -->
      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">
          {{ isEditMode ? 'Save Changes' : 'Create' }}
        </PrimaryButton>
      </div>
    </form>
  </section>
</template>

<style>
@import "vue-multiselect/dist/vue-multiselect.min.css";
</style>
