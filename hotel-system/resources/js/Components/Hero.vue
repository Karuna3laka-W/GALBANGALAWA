<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';

onMounted(() => {
    const tl = gsap.timeline();

    // 1. Initial background zoom-out (Azure style)
    tl.from(".hero-bg-image", {
        scale: 1.3,
        duration: 2.5,
        ease: "power2.out"
    })
    // 2. Title fade-up (starts before zoom finishes)
    .from(".hero-title", {
        y: 60,
        opacity: 0,
        duration: 1.2,
        ease: "expo.out"
    }, "-=1.8")
    // 3. Button pop-in
    .from(".btn-primary", {
        opacity: 0,
        y: 20,
        duration: 0.8,
        ease: "power2.out"
    }, "-=0.5");
});
</script>

<template>
    <header class="hero-container">
        <div class="hero-bg">
            <div class="hero-bg-image"></div>
            <div class="hero-overlay"></div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                Immerse yourself <br>
                in the <span class="accent-text">vibrant</span> <br>
                colours of life
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
    overflow: hidden; /* Important for the zoom effect */
    background-color: #000;
}

.hero-bg {
    position: absolute;
    inset: 0;
    z-index: 1;
}

/* New class specifically for the animated image */
.hero-bg-image {
    width: 100%;
    height: 100%;
    background-image: url('https://images.unsplash.com/photo-1532712938310-34cb3982ef74?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
    background-size: cover;
    background-position: center;
    will-change: transform;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.6), transparent);
    z-index: 2;
}

.hero-content {
    position: relative;
    z-index: 10;
    color: white;
}

/* ... Keep your existing .hero-title, .accent-text, and .btn-primary styles ... */
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
}
</style>