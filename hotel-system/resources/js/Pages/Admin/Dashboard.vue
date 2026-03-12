<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PackageManagement from './Partials/PackageManagement.vue';
import SeasonalManagement from './Partials/SeasonalManagement.vue';
import ServiceManagement from './Partials/ServiceManagement.vue';
import ReservationManagement from './Partials/ReservationManagement.vue';

const props = defineProps({
    packages: Array,
    seasonalOffers: Array,
    services: Array,
    reservations: Array,
});

const activeTab = ref('reservations');
</script>

<template>
    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6">
                
                <aside class="w-64 flex flex-col gap-2 shrink-0">
                    <button @click="activeTab = 'reservations'" :class="['nav-btn', { 'active': activeTab === 'reservations' }]">📋 Reservations</button>
                    <button @click="activeTab = 'packages'" :class="['nav-btn', { 'active': activeTab === 'packages' }]">📦 Packages</button>
                    <button @click="activeTab = 'marketing'" :class="['nav-btn', { 'active': activeTab === 'marketing' }]">🎉 Seasonal Promos</button>
                    <button @click="activeTab = 'services'" :class="['nav-btn', { 'active': activeTab === 'services' }]">📸 Experiences</button>
                </aside>

                <main class="flex-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <ReservationManagement v-if="activeTab === 'reservations'" :reservations="reservations" />
                    <PackageManagement v-if="activeTab === 'packages'" :packages="packages" />
                    <SeasonalManagement v-if="activeTab === 'marketing'" :seasonalOffers="seasonalOffers" />
                    <ServiceManagement v-if="activeTab === 'services'" :services="services" />
                </main>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.nav-btn { @apply w-full text-left p-4 rounded-xl font-bold text-gray-500 transition-all; }
.nav-btn.active { @apply bg-white shadow-md border border-gray-100 text-[#001a2c]; }
</style>