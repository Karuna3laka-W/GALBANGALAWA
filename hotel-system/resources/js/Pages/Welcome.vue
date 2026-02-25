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
import ServicesSlider from '@/Components/ServicesSlider.vue';

import WeddingSection from '@/Components/WeddingSection.vue';

defineProps({
    packages: Array,
    specialOffer: Object,
    services: Array
});
</script>

<template>
    <Head title="Hotel Galbangalawa" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <div class="min-h-screen text-[#001a2c] font-sans relative flex flex-col">
        
        <AnimatedBackground />

        <Navbar />

        <main class="flex-grow">
            <Hero />
            
            <BookingBar />

            <ServicesSlider :services="services" />

            <WeddingSection />

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
html {
    scroll-behavior: smooth;
}

body {
    overflow-x: hidden;
    /* Adding a background color that matches the dark luxury theme */
    background-color: #001a2c;
}
</style>