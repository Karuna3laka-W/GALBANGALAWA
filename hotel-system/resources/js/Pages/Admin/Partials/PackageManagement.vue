<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ packages: Array });

const isModalOpen = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    price: '',
    description: ''
});

const openCreate = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
};

const openEdit = (pkg) => {
    isEditing.value = true;
    form.id = pkg.id;
    form.name = pkg.name;
    form.price = pkg.price;
    form.description = pkg.description;
    isModalOpen.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.patch(route('admin.packages.update', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    } else {
        form.post(route('admin.packages.store'), {
            onSuccess: () => isModalOpen.value = false
        });
    }
};
</script>

<template>
    <section>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Manage Packages</h3>
            <button @click="openCreate" class="bg-blue-600 text-white px-4 py-2 rounded-lg">+ Add New</button>
        </div>

        <div class="grid gap-4">
            <div v-for="pkg in packages" :key="pkg.id" class="p-4 border rounded-xl flex justify-between items-center">
                <div>
                    <h4 class="font-bold">{{ pkg.name }}</h4>
                    <p class="text-sm text-gray-500">${{ pkg.price }}</p>
                </div>
                <button @click="openEdit(pkg)" class="text-blue-600 font-bold hover:underline">Edit</button>
            </div>
        </div>

        <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-2xl">
                <h3 class="text-lg font-bold mb-4">{{ isEditing ? 'Edit Package' : 'New Package' }}</h3>
                <form @submit.prevent="submit" class="space-y-4">
                    <input v-model="form.name" type="text" placeholder="Package Name" class="w-full border-gray-200 rounded-lg" required />
                    <input v-model="form.price" type="number" placeholder="Price" class="w-full border-gray-200 rounded-lg" required />
                    <textarea v-model="form.description" placeholder="Description" class="w-full border-gray-200 rounded-lg"></textarea>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="isModalOpen = false" class="text-gray-400 font-bold">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold" :disabled="form.processing">
                            {{ isEditing ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>