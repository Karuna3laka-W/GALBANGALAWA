<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Hero from '@/Components/Hero.vue';
import BookingBar from '@/Components/BookingBar.vue';
import PackageCard from '@/Components/PackageCard.vue';
import GlassBridge from '@/Components/GlassBridge.vue';
import LocationSection from '@/Components/LocationSection.vue';

defineProps({
    packages: Array
});
</script>

<template>
    <Head title="Hotel Galbangalawa" />

    <div class="min-h-screen bg-[#f9fafb] text-gray-900 font-sans">
        <Navbar />
        <Hero />
        
        <BookingBar />

        <section id="packages" class="py-24 px-6">
            <div class="max-w-6xl mx-auto">
                <h3 class="text-4xl font-bold text-center mb-16 text-blue-900 font-serif italic">
                    
                </h3>
                
                <div class="grid md:grid-cols-2 gap-10">
                    <PackageCard 
                        v-for="item in packages" 
                        :key="item.id" 
                        :item="item" 
                    />
                </div>
            </div>
        </section>

        <GlassBridge />

        <LocationSection />
    </div>
</template>