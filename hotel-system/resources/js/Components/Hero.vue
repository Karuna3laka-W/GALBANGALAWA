<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import gsap from 'gsap';

const slides = [
    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1470', // Spa water
    'https://images.unsplash.com/photo-1532712938310-34cb3982ef74?q=80&w=1470', 
    'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1470'
];

const currentSlide = ref(0);
let slideInterval = null;

onMounted(() => {
    const tl = gsap.timeline();
    // Animating the center content
    tl.from(".hero-top, .hero-bottom", { opacity: 0, duration: 1.5, ease: "power2.out" })
      .from(".hero-title", { y: 40, opacity: 0, duration: 1.2, ease: "expo.out" }, "-=1")
      .from(".hero-subtext", { opacity: 0, y: 10, duration: 1 }, "-=0.5");

    startSlideshow();
});

onUnmounted(() => stopSlideshow());

const startSlideshow = () => {
    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 6000);
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
        
        <div class="hero-top">
            <div class="logo-wrapper">
                <span class="logo-icon"></span>
                <h2 class="logo-text">RockHouse</h2>
                <p class="logo-sub">WELLNESS & SPA HOTEL</p>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">Touch of the healing<br>power of nature</h1>
            <div class="hero-subtext">
                <p>A place you like to return to.</p>
                <p>Welcome to one of the best hotels in LK.</p>
            </div>
        </div>

        <div class="hero-bottom">
            <div class="badge-tripadvisor">
                <p>Tripadvisor Travelers' Choice Awards</p>
                 <p>.</p>
                
            </div>
        </div>

        
    </header>
</template>

<style scoped>
/* Import sophisticated fonts */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Montserrat:wght@300;400&display=swap');

.hero-container {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Spreads top, center, bottom */
    align-items: center;
    text-align: center;
    color: white;
    overflow: hidden;
    background-color: #0b242f; /* Deep teal fallback */
}

/* Background & Overlay */
.hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 2s ease-in-out;
}
.hero-slide.active { opacity: 1; z-index: 1; }

.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(11, 36, 47, 0.6); /* Teal tint wash */
    z-index: 2;
}

/* UI Layers */
.hero-top, .hero-content, .hero-bottom {
    position: relative;
    z-index: 10;
}

/* Logo Styles */
.hero-top { padding-top: 3rem; }
.logo-text { font-family: 'Playfair Display', serif; letter-spacing: 0.3em; margin: 0.5rem 0; font-size: 1.5rem; }
.logo-sub { font-size: 0.6rem; letter-spacing: 0.2em; font-family: 'Montserrat', sans-serif; }

/* Main Text Styles */
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 400;
    line-height: 1.2;
    margin-bottom: 2rem;
}

.hero-subtext {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    line-height: 1.8;
    letter-spacing: 0.05em;
    opacity: 0.9;
}

/* Badge & Floating Info */
.hero-bottom { padding-bottom: 3rem; }
.badge-tripadvisor { font-size: 0.7rem; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 1rem; }

.info-circle {
    position: absolute;
    bottom: 40px;
    left: 40px;
    width: 80px;
    height: 80px;
    border: 1px solid rgba(255,255,255,0.5);
    background: transparent;
    color: white;
    border-radius: 50%;
    font-size: 0.6rem;
    cursor: pointer;
    z-index: 20;
    transition: all 0.3s;
}
.info-circle:hover { background: white; color: black; }
</style>