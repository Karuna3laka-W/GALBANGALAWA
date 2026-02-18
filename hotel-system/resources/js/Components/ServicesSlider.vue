<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const services = [
    {
        id: 1,
        subtitle: "Elegant Celebrations",
        title: "Weddings",
        image: "https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop"
    },
    {
        id: 2,
        subtitle: "Joyful Moments",
        title: "Birthdays",
        image: "https://images.unsplash.com/photo-1530103862676-de3c9de59a9e?q=80&w=800&auto=format&fit=crop"
    },
    {
        id: 3,
        subtitle: "Corporate Excellence",
        title: "Office Functions",
        image: "https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=800&auto=format&fit=crop"
    },
    {
        id: 4,
        subtitle: "Escape The City",
        title: "Day Outings",
        image: "https://images.unsplash.com/photo-1533759413974-9e15f3b745ac?q=80&w=800&auto=format&fit=crop"
    },
    {
        id: 5,
        subtitle: "Intimate Gatherings",
        title: "Private Dining",
        image: "https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=800&auto=format&fit=crop"
    }
];

// 1. State for the Active Card
const activeIndex = ref(0);
let autoPlayInterval = null;

// 2. The Math to make it rotate like a clock
const getCardStyle = (index) => {
    const total = services.length;
    let diff = (index - activeIndex.value + total) % total;
    
    if (diff > Math.floor(total / 2)) {
        diff -= total;
    }

    const translateX = -50 + (diff * 110); 
    const scale = 1 - Math.abs(diff) * 0.15; 
    const zIndex = 50 - Math.abs(diff) * 10; 
    const opacity = Math.abs(diff) > 1 ? 0 : (1 - Math.abs(diff) * 0.4); 

    return {
        transform: `translate(${translateX}%, -50%) scale(${scale})`,
        zIndex: zIndex,
        opacity: opacity,
        filter: Math.abs(diff) > 0 ? 'blur(2px)' : 'none', 
        pointerEvents: Math.abs(diff) > 1 ? 'none' : 'auto' 
    };
};

// 3. Carousel Controls
const nextCard = () => {
    activeIndex.value = (activeIndex.value + 1) % services.length;
};

const selectCard = (index) => {
    activeIndex.value = index;
    resetAutoPlay(); 
};

// 4. Auto-Play Logic
const startAutoPlay = () => {
    autoPlayInterval = setInterval(() => {
        nextCard();
    }, 3500); 
};

const resetAutoPlay = () => {
    clearInterval(autoPlayInterval);
    startAutoPlay();
};

// Lifecycle Hooks
onMounted(() => {
    startAutoPlay();
});

onUnmounted(() => {
    clearInterval(autoPlayInterval);
});
</script>

<template>
    <section class="py-24 bg-white relative overflow-hidden">
        
        <div class="max-w-7xl mx-auto px-6 mb-16 text-center relative z-20">
            <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.5em] block mb-4">Experiences</span>
            <h2 class="text-4xl md:text-5xl font-serif italic text-[#001a2c]">Tailored For You</h2>
        </div>

        <div class="relative w-full h-[550px] md:h-[650px] mx-auto overflow-hidden flex items-center justify-center">
            
            <div 
                v-for="(service, index) in services" 
                :key="service.id" 
                class="absolute left-1/2 top-1/2 service-card group"
                :style="getCardStyle(index)"
                @click="selectCard(index)"
            >
                <img :src="service.image" :alt="service.title" class="card-image" loading="lazy" />
                
                <div class="card-overlay" :class="{'opacity-90': activeIndex !== index, 'opacity-70': activeIndex === index}"></div>

                <div class="card-content" :class="{'translate-y-4 opacity-50': activeIndex !== index}">
                    <span class="subtitle">{{ service.subtitle }}</span>
                    <h3 class="title">{{ service.title }}</h3>
                </div>

                <div v-if="activeIndex === index" class="absolute inset-0 border-2 border-[#d4a373]/50 rounded-[40px] z-10 pointer-events-none"></div>
            </div>

        </div>

        <div class="flex justify-center gap-3 mt-8 relative z-20">
            <button 
                v-for="(service, index) in services" 
                :key="'dot-'+index"
                @click="selectCard(index)"
                class="h-2 rounded-full transition-all duration-500"
                :class="activeIndex === index ? 'w-8 bg-[#d4a373]' : 'w-2 bg-gray-200 hover:bg-gray-300'" 
            ></button>
            </div>

    </section>
</template>

<style scoped>
/* THE CARD (Absolute positioning is required for 3D Math) */
.service-card {
    @apply w-[280px] h-[400px] sm:w-[320px] sm:h-[480px] md:w-[380px] md:h-[550px] rounded-[40px] overflow-hidden cursor-pointer shadow-2xl;
    /* Transition for the smooth "clock" rotation */
    transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    transform-origin: center center;
}

/* THE IMAGE */
.card-image {
    @apply absolute inset-0 w-full h-full object-cover transition-transform duration-1000 ease-out;
}
.service-card:hover .card-image {
    transform: scale(1.05);
}

/* THE GRADIENT OVERLAY */
.card-overlay {
    @apply absolute inset-0 bg-gradient-to-t from-[#001a2c] via-[#001a2c]/60 to-transparent transition-opacity duration-500;
}

/* THE TEXT CONTENT */
.card-content {
    @apply absolute bottom-0 left-0 p-8 w-full transition-all duration-700 ease-in-out;
}

.subtitle {
    @apply block text-[#d4a373] text-[9px] font-black uppercase tracking-[0.3em] mb-2 drop-shadow-md;
}

.title {
    @apply text-white text-3xl md:text-4xl font-serif italic tracking-wide drop-shadow-lg;
}
</style>