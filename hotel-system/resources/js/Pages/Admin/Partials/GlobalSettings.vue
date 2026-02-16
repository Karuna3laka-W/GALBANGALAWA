<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    whatsapp_number: '+94 77 123 4567',
    site_email: 'info@galbangalawa.com',
    maintenance_mode: false,
});

const saveSettings = () => {
    // You'll connect this to a controller later
    alert('Settings saved successfully!');
};
</script>

<template>
    <section>
        <h3 class="text-xl font-bold text-gray-800 mb-6">Global Site Settings</h3>
        
        <div class="space-y-6 max-w-2xl">
            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <label class="block text-xs font-black uppercase text-gray-400 mb-2">WhatsApp Inquiry Number</label>
                <input v-model="form.whatsapp_number" type="text" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <label class="block text-xs font-black uppercase text-gray-400 mb-2">Business Email</label>
                <input v-model="form.site_email" type="email" class="w-full border-gray-200 rounded-lg focus:ring-blue-500" />
            </div>

            <div class="flex items-center justify-between p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <div>
                    <span class="block font-bold text-gray-700">Maintenance Mode</span>
                    <span class="text-xs text-gray-500">Hide the website from the public while editing.</span>
                </div>
                <button 
                    @click="form.maintenance_mode = !form.maintenance_mode"
                    :class="form.maintenance_mode ? 'bg-red-500' : 'bg-gray-300'"
                    class="w-12 h-6 rounded-full relative transition-colors"
                >
                    <span :class="form.maintenance_mode ? 'translate-x-6' : 'translate-x-1'" class="absolute top-1 left-0 bg-white w-4 h-4 rounded-full transition-transform"></span>
                </button>
            </div>

            <button @click="saveSettings" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                Save All Changes
            </button>
        </div>
    </section>
</template>