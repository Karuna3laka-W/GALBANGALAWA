<script setup>
import { ref, onMounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// --- THEME & CONFIG ---
const bgColor = ref('#001a2c'); // Azure Navy
const accentColor = ref('#d4a373'); // Elegant Gold
const mapUrl = "https://maps.google.com/?cid=764461551547295566&g_mp=Cidnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLlNlYXJjaFRleHQ";

const locations = [
    'Rock House (Gal Bangalawa)',
    'Reception & Dining',
    'Lakeside Garden',
    'Luxury Guest Suites'
];

onMounted(() => {
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: ".target-location-section",
            start: "top 20%",
            toggleActions: "play none none reverse"
        }
    });

    // 1. Fade in the UI
    tl.from(".ui-sidebar", { x: -100, opacity: 0, duration: 1.2, ease: "expo.out" })
      // 2. "Locking" animation for the target
      .from(".target-crosshair", { scale: 3, opacity: 0, duration: 1, ease: "power4.out" }, "-=0.8")
      .from(".target-circle", { r: 100, opacity: 0, duration: 1.5, ease: "elastic.out(1, 0.3)" }, "-=0.5");
});
</script>

<template>
    <section class="target-location-section">
        
        <div class="map-container">
        <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.8021815197824!2d79.92383187588147!3d6.794406520242258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2454e49e1aed7%3A0xca9be9bc1869a74e!2sRock%20House%20(%20Gal%20Bangalawa%20)!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk"
    width="100%" 
    height="100%" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade"
    class="google-map-iframe">
</iframe>
            
            <div class="map-vignette"></div>
        </div>

        <div class="target-overlay-ui">
            <svg class="target-crosshair" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" class="target-circle" />
                <line x1="50" y1="0" x2="50" y2="20" class="cross-line" />
                <line x1="50" y1="80" x2="50" y2="100" class="cross-line" />
                <line x1="0" y1="50" x2="20" y2="50" class="cross-line" />
                <line x1="80" y1="50" x2="100" y2="50" class="cross-line" />
                <circle cx="50" cy="50" r="2" fill="currentColor" />
            </svg>
        </div>

        <div class="content-layer">
            <div class="ui-sidebar">
                <div v-for="item in locations" :key="item" class="loc-item">
                    {{ item }}
                </div>
            </div>

            <div class="footer-info">
                <div class="text-group">
                    <span class="tag">22/1 Wewala Road, Piliyandala</span>
                    <h2 class="title text-6xl font-bold">Galbangalawa</h2>
                </div>
                
                <a :href="mapUrl" target="_blank" class="azure-action-bar">
                    <span>Target Locked: Rock House</span>
                    <div class="btn-go">Get Directions</div>
                </a>
            </div>
        </div>
    </section>
</template>

<style scoped>
.target-location-section {
    position: relative;
    width: 100vw;
    height: 100vh;
    background: v-bind(bgColor);
    overflow: hidden;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
}

/* Map Layer */
.map-container {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.google-map-iframe {
    /* Optional: Luxury Dark Filter */
    filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%);
    opacity: 0.6;
}

.map-vignette {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 50%, transparent 20%, v-bind(bgColor) 90%);
    pointer-events: none;
}

/* Target UI */
.target-overlay-ui {
    position: absolute;
    inset: 0;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.target-crosshair {
    width: 150px;
    height: 150px;
    color: v-bind(accentColor);
}

.target-circle {
    fill: none;
    stroke: currentColor;
    stroke-width: 1;
    stroke-dasharray: 5 5;
}

.cross-line {
    stroke: currentColor;
    stroke-width: 1;
}

/* Sidebar & Content */
.content-layer {
    position: relative;
    z-index: 10;
    height: 100%;
    padding: 10vh 6%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    pointer-events: none;
}

.ui-sidebar {
    pointer-events: auto;
}

.loc-item {
    color: white;
    font-size: 2.4rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    cursor: pointer;
    transition: all 0.4s ease;
    opacity: 0.4;
}

.loc-item:hover {
    opacity: 1;
    color: v-bind(accentColor);
    transform: translateX(20px);
}

.footer-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    pointer-events: auto;
    color: white;
}

.tag {
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.3em;
    color: v-bind(accentColor);
    font-weight: 900;
}

/* Azure Style Action Bar */
.azure-action-bar {
    background: rgba(255,255,255,0.98);
    color: #1a1a1a;
    padding: 10px 10px 10px 25px;
    border-radius: 99px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 700;
}

.btn-go {
    background: v-bind(bgColor);
    color: white;
    padding: 8px 20px;
    border-radius: 99px;
    text-transform: uppercase;
    font-size: 0.7rem;
}
</style>