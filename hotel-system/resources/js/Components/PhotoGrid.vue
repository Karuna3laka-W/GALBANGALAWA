<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register GSAP for the scroll reveal
gsap.registerPlugin(ScrollTrigger);

const galleryItems = [
    { src: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1470', alt: 'Ocean Horizon Pool', size: 'large' },
    { src: 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=1470', alt: 'Luxury Suite Interior', size: 'small' },
    { src: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1470', alt: 'Wellness Spa Detail', size: 'medium' },
    { src: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1470', alt: 'Private Balcony View', size: 'small' },
    { src: 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=1470', alt: 'Evening Cocktail Lounge', size: 'medium' },
];

onMounted(() => {
    // Header Reveal
    gsap.from(".gallery-header-centered", {
        y: 30,
        opacity: 0,
        duration: 1.5,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".gallery-section",
            start: "top 85%",
        }
    });

    // Grid Items Reveal
    gsap.from(".gallery-item", {
        y: 60,
        opacity: 0,
        duration: 1.2,
        stagger: 0.15,
        ease: "expo.out",
        scrollTrigger: {
            trigger: ".gallery-grid",
            start: "top 80%",
        }
    });
});
</script>

<template>
    <section class="gallery-section">
        <div class="container mx-auto px-6 relative z-10">
            
            <header class="gallery-header-centered">
                <div class="chapter-mark">IV</div>
                <h2 class="title-serif">
                    Glimpses of <br> 
                    <span class="accent-italic">Serenity</span>
                </h2>
                <div class="subtitle-wrapper">
                    <p class="subtitle-sans">A curated visual journey through our private oasis.</p>
                </div>
            </header>

            <div class="gallery-grid">
                <div 
                    v-for="(item, index) in galleryItems" 
                    :key="index" 
                    class="gallery-item group"
                    :class="item.size"
                >
                    <div class="image-viewport">
                        <img :src="item.src" :alt="item.alt" class="base-img" />
                        
                        <div class="hover-overlay">
                            <div class="icon-stack">
                                <span class="material-icons-outlined text-4xl">open_in_full</span>
                                <span class="reveal-text">Explore View</span>
                            </div>
                        </div>

                        <div class="item-label">
                            <span class="label-count">0{{ index + 1 }}</span>
                            <span class="label-name">{{ item.alt }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-letter">G</div>
        </div>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,500&family=Montserrat:wght@300;500&display=swap');

.gallery-section {
    @apply py-32 relative overflow-hidden;
    background-color: #f9f7f2; /* Light Luxury Beige */
}

/* Header Composition */
.gallery-header-centered {
    @apply flex flex-col items-center text-center mb-24 relative z-20;
}

.chapter-mark {
    @apply inline-block border border-[#001a2c]/20 px-5 py-1 text-[11px] text-[#001a2c]/40 tracking-[0.5em] mb-10 uppercase;
}

.title-serif {
    @apply text-6xl md:text-8xl text-[#001a2c] font-serif leading-[1.1] mb-8;
    font-family: 'Playfair Display', serif;
}

.accent-italic { 
    @apply italic font-medium text-[#001a2c]/80; 
}

.subtitle-wrapper {
    @apply flex items-center justify-center;
}

/* Decorative Gold Lines */
.subtitle-wrapper::before,
.subtitle-wrapper::after {
    content: '';
    @apply hidden md:block w-12 h-[1px] bg-[#d4a373]/30 mx-8;
}

.subtitle-sans {
    @apply text-[10px] md:text-xs text-[#001a2c]/60 uppercase tracking-[0.4em] font-medium;
    font-family: 'Montserrat', sans-serif;
}

/* The 12-Column Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-auto-rows: minmax(140px, auto);
    gap: 32px;
}

.gallery-item { @apply relative overflow-hidden cursor-pointer; }

/* Asymmetric Column Spans */
.small { grid-column: span 3; grid-row: span 3; }
.medium { grid-column: span 4; grid-row: span 4; }
.large { grid-column: span 6; grid-row: span 5; }

@media (max-width: 1024px) {
    .gallery-grid { gap: 20px; }
    .small, .medium, .large { grid-column: span 12; grid-row: span 3; }
}

/* Image Interaction */
.image-viewport {
    @apply relative w-full h-full bg-[#eeeae3] rounded-[10px] overflow-hidden;
}

.base-img {
    @apply w-full h-full object-cover transition-transform duration-[2.5s] ease-out;
}
.gallery-item:hover .base-img { @apply scale-110; }

/* Overlay & Reveal */
.hover-overlay {
    @apply absolute inset-0 bg-[#001a2c]/40 flex items-center justify-center opacity-0 transition-all duration-700;
}
.gallery-item:hover .hover-overlay { @apply opacity-100; }

.icon-stack {
    @apply flex flex-col items-center text-white scale-75 transition-transform duration-700;
}
.gallery-item:hover .icon-stack { @apply scale-100; }
.reveal-text { @apply text-[9px] uppercase tracking-[0.3em] font-bold mt-3; }

.item-label {
    @apply absolute bottom-6 left-8 flex flex-col gap-1 text-white opacity-0 translate-y-4 transition-all duration-700;
}
.gallery-item:hover .item-label { @apply opacity-100 translate-y-0; }
.label-count { @apply text-[10px] font-bold text-[#d4a373]; }
.label-name { @apply text-xs uppercase tracking-[0.2em] font-medium; }

/* Large Letter "G" for Galbangalawa Background */
.bg-letter {
    position: absolute;
    right: -5%;
    bottom: -5%;
    font-size: 45vw;
    font-family: 'Playfair Display', serif;
    color: #fff;
    line-height: 1;
    z-index: 1;
    pointer-events: none;
    user-select: none;
}
</style>