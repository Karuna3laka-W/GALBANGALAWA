<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        required: true
    }
});

const activeIndex = ref(0);
let autoPlayInterval = null;

/**
 * Calculates the 3D position and visibility of each card
 * based on its distance from the active index.
 */
const getCardStyle = (index) => {
    if (!props.services || props.services.length === 0) return {};
    
    const total = props.services.length;
    let diff = (index - activeIndex.value + total) % total;
    if (diff > Math.floor(total / 2)) diff -= total;

    // The Math: translateX spreads them, scale/opacity creates depth
    const translateX = -50 + (diff * 85); 
    const scale = 1 - Math.abs(diff) * 0.2; 
    const zIndex = 50 - Math.abs(diff) * 10; 
    const opacity = Math.abs(diff) > 1 ? 0 : (1 - Math.abs(diff) * 0.5); 
    const rotateY = diff * -15; // 3D Tilt

    return {
        transform: `translate(${translateX}%, -50%) scale(${scale}) rotateY(${rotateY}deg)`,
        zIndex: zIndex,
        opacity: opacity,
        filter: Math.abs(diff) > 0 ? 'blur(4px) brightness(0.4)' : 'none', 
        pointerEvents: Math.abs(diff) > 1 ? 'none' : 'auto' 
    };
};

const nextCard = () => {
    if(props.services.length > 0) {
        activeIndex.value = (activeIndex.value + 1) % props.services.length;
    }
};

const selectCard = (index) => {
    activeIndex.value = index;
    resetAutoPlay(); 
};

const startAutoPlay = () => {
    if(props.services.length > 0) {
        autoPlayInterval = setInterval(() => { nextCard(); }, 5000); 
    }
};

const resetAutoPlay = () => {
    clearInterval(autoPlayInterval);
    startAutoPlay();
};

onMounted(() => { startAutoPlay(); });
onUnmounted(() => { clearInterval(autoPlayInterval); });
</script>

<template>
    <section v-if="services && services.length > 0" class="services-slider-wrapper">
        
        <div class="header-content">
            <div class="decorative-numeral">III</div>
            <span class="sub-label">Curated Experiences</span>
            <h2 class="section-title">Tailored For You</h2>
        </div>

        <div class="slider-container">
            <div 
                v-for="(service, index) in services" 
                :key="service.id" 
                class="absolute left-1/2 top-1/2 service-card group"
                :class="{'is-active': activeIndex === index}"
                :style="getCardStyle(index)"
                @click="selectCard(index)"
            >
                <div class="image-container">
                    <img :src="`/storage/${service.image_path}`" :alt="service.title" class="card-img" />
                    <div class="overlay-vignette"></div>
                </div>
                
                <div class="content-box">
                    <span class="service-category">{{ service.subtitle }}</span>
                    <h3 class="service-name">{{ service.title }}</h3>
                    
                    <p v-if="activeIndex === index" class="service-text animate-fadeIn">
                        {{ service.description || 'Experience the height of luxury with our bespoke hospitality services.' }}
                    </p>
                </div>

                <div class="glass-frame"></div>
            </div>
        </div>

        <div class="pagination-track">
            <button 
                v-for="(service, index) in services" 
                :key="'dot-'+index"
                @click="selectCard(index)"
                class="pill"
                :class="{ 'active': activeIndex === index }"
            ></button>
        </div>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,700&family=Montserrat:wght@300;600&display=swap');

.services-slider-wrapper {
    @apply py-32 relative overflow-hidden;
    background-color: #001a2c; /* Matches your project's navy theme */
    perspective: 1500px;
}

/* Header Text */
.header-content {
    @apply max-w-7xl mx-auto px-6 mb-20 text-center relative z-20;
}

.decorative-numeral {
    @apply inline-block border border-white/20 px-3 py-1 text-[10px] text-white/60 tracking-[0.3em] mb-6;
}

.sub-label {
    @apply block text-[#d4a373] text-[10px] font-bold uppercase tracking-[0.5em] mb-3;
    font-family: 'Montserrat', sans-serif;
}

.section-title {
    @apply text-5xl md:text-6xl text-white font-serif italic;
    font-family: 'Playfair Display', serif;
}

/* Slider Track */
.slider-container {
    @apply relative w-full h-[600px] md:h-[700px] flex items-center justify-center;
}

/* The Service Card */
.service-card {
    @apply w-[300px] h-[450px] md:w-[420px] md:h-[580px] rounded-[24px] overflow-hidden cursor-pointer;
    transition: all 1.2s cubic-bezier(0.2, 1, 0.3, 1);
}

.image-container {
    @apply absolute inset-0 w-full h-full;
}

.card-img {
    @apply w-full h-full object-cover transition-transform duration-[3s] ease-out;
}

.service-card:hover .card-img {
    transform: scale(1.1);
}

.overlay-vignette {
    @apply absolute inset-0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0, 26, 44, 1) 100%);
}

/* Text Content within Card */
.content-box {
    @apply absolute bottom-0 left-0 p-10 w-full z-10 text-left;
}

.service-category {
    @apply block text-[#d4a373] text-[10px] font-bold uppercase tracking-[0.2em] mb-2;
}

.service-name {
    @apply text-white text-3xl md:text-4xl font-serif italic mb-4;
}

.service-text {
    @apply text-white/60 text-sm leading-relaxed max-w-[90%];
    font-family: 'Montserrat', sans-serif;
}

/* Active Highlight Frame */
.glass-frame {
    @apply absolute inset-0 border border-white/10 rounded-[24px] z-20 pointer-events-none opacity-0 transition-opacity duration-1000;
}
.is-active .glass-frame {
    @apply opacity-100;
}

/* Navigation Track */
.pagination-track {
    @apply flex justify-center gap-4 mt-12 relative z-20;
}

.pill {
    @apply h-[2px] w-8 bg-white/10 transition-all duration-500;
}

.pill.active {
    @apply bg-[#d4a373] w-16;
}
</style>