<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpen = ref(false);
</script>

<template>
    <nav class="fixed top-0 left-0 w-full z-50 glass-nav">
        <div class="max-w-[1800px] mx-auto px-10 py-4 flex justify-between items-center">
            
            <button @click="isOpen = !isOpen" class="pill-btn group">
                <span class="material-icons-outlined text-xl">menu</span>
                <span class="uppercase text-xs tracking-widest font-bold">Menu</span>
            </button>

   

            <button class="pill-btn group">
                <span class="uppercase text-xs tracking-widest font-bold">Booking</span>
                <span class="material-icons-outlined text-xl">shopping_bag</span>
            </button>
        </div>

        <div class="w-full h-[1px] bg-white/10"></div>

        <div class="flex justify-center items-center py-5 gap-12">
            <a href="#" class="nav-link">About Us</a>
            <a href="#" class="nav-link">Rooms</a>
            <a href="#" class="nav-link">Weddings</a>
            <a href="#" class="nav-link">Events</a>
            <a href="#" class="nav-link">Contact</a>
        </div>
    </nav>
</template>

<style scoped>
.glass-nav {
    /* The specific dark teal/blue from your image */
    background: rgba(12, 66, 80, 0.95); 
    backdrop-filter: blur(10px);
}

/* Pill Buttons (Menu & Booking) */
.pill-btn {
    @apply flex items-center gap-4 px-8 py-3 bg-[#0a1a23] text-white rounded-full 
           border border-white/5 transition-all duration-300 hover:bg-[#1a2c38];
}

/* Centered Logo container */
.logo-circle {
    @apply w-16 h-16 rounded-full border border-white/40 flex items-center justify-center;
}

/* Bottom Nav Links */
.nav-link {
    @apply text-white text-[11px] font-bold uppercase tracking-[0.25em] 
           transition-opacity duration-300 hover:opacity-60;
}

/* Material Icon adjustments to match image size */
.material-icons-outlined, .material-icons {
    font-size: 1.2rem;
}
/* Ensure the icon font is actually applied */
.material-icons-outlined {
    font-family: 'Material Icons Outlined';
    font-weight: normal;
    font-style: normal;
    line-height: 1;
    display: inline-block;
    white-space: nowrap;
}

.pill-btn {
    display: flex;
    align-items: center;
    gap: 12px; /* Adds space between icon and text */
    padding: 10px 24px;
    background: #061922; /* Very dark blue-black */
    border-radius: 999px;
    color: white;
    transition: all 0.3s ease;
}

/* Tracking makes the text look high-end */
.pill-btn span:last-child {
    letter-spacing: 0.15em;
    font-size: 11px;
}
</style>