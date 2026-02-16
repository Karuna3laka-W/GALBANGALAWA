<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PackageManagement from './Partials/PackageManagement.vue';
import DiscountManagement from './Partials/DiscountManagement.vue';
import GlobalSettings from './Partials/GlobalSettings.vue';

const props = defineProps({
    packages: Array
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
                    <button @click="activeTab = 'discounts'" :class="['nav-btn', { 'active': activeTab === 'discounts' }]">🏷️ Discounts</button>
                    <button @click="activeTab = 'settings'" :class="['nav-btn', { 'active': activeTab === 'settings' }]">⚙️ Settings</button>
                </aside>

                <main class="flex-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <PackageManagement v-if="activeTab === 'packages'" :packages="packages" />
                    <DiscountManagement v-if="activeTab === 'discounts'" />
                    <GlobalSettings v-if="activeTab === 'settings'" />
                </main>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.nav-btn { @apply w-full text-left p-4 rounded-xl font-bold text-gray-500 transition-all; }
.nav-btn.active { @apply bg-white shadow-md border border-gray-100 text-blue-600; }
</style>