<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PackageManagement from './Partials/PackageManagement.vue';
import SeasonalManagement from './Partials/SeasonalManagement.vue'; // <--- 1. Import it

// 2. Add seasonalOffers to your props so Vue can receive the data from Laravel
const props = defineProps({
    packages: Array,
    seasonalOffers: Array 
});

const activeTab = ref('packages');
</script>

<template>
    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6">
                <aside class="w-64 flex flex-col gap-2">
                    <button @click="activeTab = 'packages'" :class="['nav-btn', { 'active': activeTab === 'packages' }]">📦 Packages</button>
                    <button @click="activeTab = 'marketing'" :class="['nav-btn', { 'active': activeTab === 'marketing' }]">🎉 Seasonal Promos</button>
                </aside>

                <main class="flex-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <PackageManagement v-if="activeTab === 'packages'" :packages="packages" />
                    
                    <SeasonalManagement v-if="activeTab === 'marketing'" :seasonalOffers="seasonalOffers" />
                </main>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.nav-btn { @apply w-full text-left p-4 rounded-xl font-bold text-gray-500 transition-all; }
.nav-btn.active { @apply bg-white shadow-md border border-gray-100 text-[#001a2c]; }
</style>