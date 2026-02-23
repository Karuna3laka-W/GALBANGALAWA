<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import gsap from 'gsap';

// 1. Define your luxury image slides here
const slides = [
    'https://images.unsplash.com/photo-1532712938310-34cb3982ef74?q=80&w=1470', // Your original image
    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1470', // Luxury hotel exterior
    'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1470'  // High-end resort pool
];

const currentSlide = ref(0);
let slideInterval = null;

onMounted(() => {
    // GSAP Text Animations (Kept exactly as you had them)
    const tl = gsap.timeline();
    tl.from(".hero-title", { y: 60, opacity: 0, duration: 1.2, ease: "expo.out", delay: 0.5 })
      .from(".btn-primary", { opacity: 0, y: 20, duration: 0.8, ease: "power2.out" }, "-=0.5");

    // Start the 5-second slideshow timer
    startSlideshow();
});

onUnmounted(() => {
    // Clean up timer when leaving page
    stopSlideshow();
});

const startSlideshow = () => {
    slideInterval = setInterval(() => {
        // Increment slide index, loop back to 0 if at the end
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000); // 5 Seconds
};

const stopSlideshow = () => {
    if (slideInterval) clearInterval(slideInterval);
};
</script>

<template>
    <header class="hero-container">
        <div class="hero-bg">
            <div 
                v-for="(image, index) in slides" 
                :key="index"
                class="hero-slide"
                :class="{ 'active': currentSlide === index }"
                :style="{ backgroundImage: `url(${image})` }"
            ></div>
            
            <div class="hero-overlay"></div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                Lets Celebrate your <br>
                Lovely day <span class="accent-text">vibrantly</span> <br>
                wis uss
            </h1>
            
            <div class="hero-actions">
                <button class="btn-primary">View Rooms</button>
            </div>
        </div>
    </header>
</template>

<style scoped>
.hero-container {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-left: 10%;
    overflow: hidden;
    background-color: #000;
}

.hero-bg {
    position: absolute;
    inset: 0;
    z-index: 1;
}

/* Base Style for All Slides */
.hero-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0; /* Hidden by default */
    transform: scale(1.1); /* Start slightly zoomed in */
    transition: opacity 1.5s ease-in-out, transform 6s ease-out; /* Smooth Fade & Slow Zoom */
    z-index: 1;
}

/* Active Slide Style */
.hero-slide.active {
    opacity: 1; /* Visible */
    transform: scale(1); /* Zoom out slowly to normal size */
    z-index: 2;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.6), transparent);
    z-index: 10; /* Above images, below text */
}

.hero-content {
    position: relative;
    z-index: 20; /* Above everything */
    color: white;
}

/* Text Styles */
.hero-title {
    font-family: 'Inter', sans-serif;
    font-size: clamp(3rem, 8vw, 6rem);
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

.accent-text {
    font-family: 'Playfair Display', serif;
    font-style: italic;
    color: #d4a373;
    font-weight: 700;
}

.btn-primary {
    background: white;
    color: #1e3a8a;
    padding: 1rem 2.5rem;
    border-radius: 9999px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-size: 0.75rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 2rem;
}

.btn-primary:hover {
    background: #d4a373; /* Gold hover */
    color: white;
    transform: translateY(-3px);
}
</style>