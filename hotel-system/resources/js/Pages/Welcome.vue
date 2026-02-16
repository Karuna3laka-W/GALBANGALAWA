<script setup>
import { Head } from '@inertiajs/vue3';
import Hero from '@/Components/Hero.vue';
import BookingBar from '@/Components/BookingBar.vue'; // <--- 1. Import your new file
import Navbar from '@/Components/Navbar.vue';

defineProps({
    packages: Array
});
</script>

<template>
    <Head title="Hotel Galbangalawa" />

    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <Navbar />
        <Hero />

        <BookingBar />

        <section id="packages" class="max-w-6xl mx-auto py-20 px-6">
            <h3 class="text-3xl font-bold text-center mb-12 text-blue-900 font-serif italic">
                Our Room Packages
            </h3>
            
            <div class="grid md:grid-cols-2 gap-10">
                <div v-for="item in packages" :key="item.id" class="package-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h4 class="text-2xl font-bold mb-2">{{ item.name }}</h4>
                    <p class="text-gray-600 mb-6">{{ item.description }}</p>
                    <div class="flex justify-between items-center border-t pt-6">
                        <span class="text-3xl font-black text-blue-700">${{ item.price }}</span>
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

