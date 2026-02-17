<script setup>
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import { Grid } from '@splidejs/splide-extension-grid';
import '@splidejs/vue-splide/css';

// Using the same images array as before...
const images = [
    { src: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1470', alt: 'Luxury Exterior' },
    { src: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1470', alt: 'Infinity Pool' },
    { src: 'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=1470', alt: 'Grand Lobby' },
    { src: 'https://images.unsplash.com/photo-1590490360182-c87295ecc059?q=80&w=1470', alt: 'Fine Dining' },
    { src: 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?q=80&w=1470', alt: 'Master Suite' },
    { src: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1470', alt: 'Spa & Wellness' },
    { src: 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=1470', alt: 'Ocean View' },
    { src: 'https://images.unsplash.com/photo-1560624052-449f5ddf0c31?q=80&w=1470', alt: 'Presidential Suite' },
];

const gridOptions = {
    type: 'loop',
    perPage: 1,
    gap: '2rem',
    grid: { rows: 2, cols: 2, gap: { row: '1.5rem', col: '1.5rem' } },
    breakpoints: {
        1024: { grid: { rows: 2, cols: 1, gap: { row: '1rem', col: '1rem' } } },
        640: { grid: false, perPage: 1, gap: '1rem' },
    },
};
</script>

<template>
    <section class="py-24 px-6 bg-transparent relative z-10">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-center mb-16">
                <span class="text-[#d4a373] uppercase tracking-[0.4em] font-black text-[10px] block mb-4">Gallery</span>
                <h3 class="text-5xl font-light text-[#003154] font-serif italic">
                    A Glimpse of Paradise
                </h3>
            </div>

            <div class="slider-wrapper">
                <Splide :options="gridOptions" :extensions="{ Grid }" class="luxury-splide">
                    <SplideSlide v-for="(img, index) in images" :key="index">
                        <div class="slide-content group">
                            <img :src="img.src" :alt="img.alt" class="gallery-image" />
                            
                            <div class="hover-overlay">
                                <div class="pop-up-icon">
                                    <span class="material-icons-outlined text-4xl">visibility</span>
                                </div>
                                <span class="overlay-text">{{ img.alt }}</span>
                            </div>
                        </div>
                    </SplideSlide>
                </Splide>
            </div>

        </div>
    </section>
</template>

<style scoped>
.slider-wrapper {
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.6);
    background: rgba(255, 255, 255, 0.5); /* Lighter glass feel */
    backdrop-filter: blur(10px);
    box-shadow: 0 30px 60px -15px rgba(0, 49, 84, 0.15);
    border-radius: 20px; /* Added rounded corners to wrapper */
}

.slide-content {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    cursor: pointer;
    aspect-ratio: 4/3; /* Slightly taller aspect ratio looks more premium */
    border-radius: 12px; /* Rounded corners on images */
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Faster, snappier zoom on hover */
    transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); 
}

.slide-content:hover .gallery-image {
    transform: scale(1.15); /* Slightly larger zoom */
}

/* === NEW HOVER OVERLAY STYLES === */
.hover-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 26, 44, 0.4); /* Lighter Navy tint */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center vertically */
    align-items: center;     /* Center horizontally */
    opacity: 0;
    transition: all 0.4s ease;
}

.slide-content:hover .hover-overlay {
    opacity: 1;
    background: rgba(0, 26, 44, 0.7); /* Darkens a bit more on full hover */
}

/* THE POP-UP ICON BOX */
.pop-up-icon {
    width: 60px;
    height: 60px;
    background: #d4a373; /* Gold background */
    color: white;
    border-radius: 50%; /* Circle shape */
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(212, 163, 115, 0.3);
    
    /* Initial state: tiny and invisible */
    transform: scale(0); 
    opacity: 0;
    /* Bouncy "pop" animation */
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    margin-bottom: 1rem;
}

/* Hover state: Scale up to full size and become visible */
.slide-content:hover .pop-up-icon {
    transform: scale(1);
    opacity: 1;
}

.overlay-text {
    color: white;
    font-family: 'serif';
    font-style: italic;
    font-size: 1.2rem;
    /* Slide up effect for text */
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.5s ease 0.1s; /* Slight delay after icon pops */
}

.slide-content:hover .overlay-text {
    transform: translateY(0);
    opacity: 1;
}

/* === SPLIDE UI UPDATES === */
/* Moving arrows outside for a cleaner look */
:deep(.splide__arrows) {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    left: 0;
    z-index: 20;
    pointer-events: none; /* Allows clicking through the container area */
    padding: 0 10px;
}

:deep(.splide__arrow) {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 3.5rem;
    height: 3.5rem;
    transition: all 0.3s ease;
    pointer-events: auto; /* Re-enable events on buttons */
}

:deep(.splide__arrow svg) {
    fill: #001a2c;
}

:deep(.splide__arrow:hover) {
    background: #001a2c;
}

:deep(.splide__arrow:hover svg) {
    fill: #d4a373;
}
</style>