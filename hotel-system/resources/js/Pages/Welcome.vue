<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Hero from '@/Components/Hero.vue';
import BookingBar from '@/Components/BookingBar.vue'; 
import PackageCard from '@/Components/PackageCard.vue';
import PhotoGrid from '@/Components/PhotoGrid.vue'; 
import HotelFacilities from '@/Components/HotelFacilities.vue';
import GlassBridge from '@/Components/GlassBridge.vue';
import LocationSection from '@/Components/LocationSection.vue';
import BottomBar from '@/Components/BottomBar.vue'; 
import PackageSection from '@/Components/PackageSection.vue';
import SeasonalOffer from '@/Components/SeasonalOffer.vue';
 // Ensure this is imported

defineProps({
    packages: Array,
    specialOffer: Object
});
</script>

<template>
    <Head title="Hotel Galbangalawa" />

    <div class="min-h-screen text-[#001a2c] font-sans relative flex flex-col">
        
        <AnimatedBackground />

        <Navbar />

        <main class="flex-grow">
            <Hero />
            
            <BookingBar />

            <PackageSection :packages="packages" />

            <SeasonalOffer :offer="specialOffer" />

            <PhotoGrid />

            <HotelFacilities />
            <GlassBridge />

            <LocationSection />
        </main>

        <BottomBar />
    </div>
</template>

<style>
/* Global smooth scrolling for anchor links like #packages */
html {
    scroll-behavior: smooth;
}

/* Ensure the bluish shades don't cause horizontal overflow */
body {
    overflow-x: hidden;
}
</style>