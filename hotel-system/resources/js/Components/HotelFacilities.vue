<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const facilities = [
    { title: 'Signature Restaurant', desc: 'Fine dining with curated local flavors.', icon: 'restaurant' },
    { title: 'Infinity Pool', desc: 'Lakeside swimming under the open sky.', icon: 'pool' },
    { title: 'Wellness Center', desc: 'Modern equipment for your wellness journey.', icon: 'fitness_center' },
    { title: 'Royal Spa', desc: 'Therapeutic treatments in a tranquil setting.', icon: 'spa' },
    { title: 'Grand Ballroom', desc: 'The perfect venue for your luxury wedding.', icon: 'event' },
    { title: 'Concierge Service', desc: 'Personalized assistance for every guest.', icon: 'room_service' },
];

onMounted(() => {
    gsap.from(".fac-card", {
        scrollTrigger: {
            trigger: ".facilities-section",
            start: "top 75%",
        },
        y: 40,
        opacity: 1, // Start fully opaque to avoid "misty" fade
        stagger: 0.1,
        duration: 1.2,
        ease: "power2.out"
    });
});
</script>

<template>
    <section class="facilities-section py-32 bg-[#f8f9fa]" id="facilities">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="mb-24 text-center">
                <span class="text-[#d4a373] uppercase tracking-[0.5em] font-black text-[10px] block mb-4">The Experience</span>
                <h2 class="text-6xl font-light text-[#003154] font-serif italic tracking-tight">Exceptional Facilities</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div v-for="item in facilities" :key="item.title" class="fac-card group">
                    
                    <div class="hard-bg"></div>
                    
                    <div class="glass-reflection"></div>

                    <div class="relative z-20 p-12 flex flex-col items-center text-center h-full">
                        <div class="icon-box mb-8">
                            <span class="material-icons-outlined text-[#d4a373] text-4xl group-hover:scale-110 transition-transform duration-500">
                                {{ item.icon }}
                            </span>
                        </div>

                        <h4 class="fac-title">{{ item.title }}</h4>
                        <p class="fac-desc">{{ item.desc }}</p>
                        
                        <div class="gold-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.fac-card {
    @apply relative overflow-hidden rounded-lg border border-gray-200 bg-white;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.fac-card:hover {
    transform: translateY(-8px);
    @apply border-[#d4a373];
    box-shadow: 0 25px 50px -12px rgba(0, 49, 84, 0.3);
}

/* HARD BACKGROUND: No Opacity, No Blur */
.hard-bg {
    @apply absolute inset-0 bg-[#003154];
    z-index: 1;
    /* Geometric reveal starts from a tiny point at bottom */
    clip-path: polygon(50% 100%, 50% 100%, 50% 100%, 50% 100%);
    transition: clip-path 0.7s cubic-bezier(0.19, 1, 0.22, 1);
}

.fac-card:hover .hard-bg {
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
}

/* THE SPECULAR REFLECTION: Moves sharp light across card */
.glass-reflection {
    @apply absolute -inset-full bg-gradient-to-r from-transparent via-white/20 to-transparent;
    transform: rotate(45deg) translateX(-100%);
    transition: transform 0.6s ease-in-out;
    z-index: 2;
}

.fac-card:hover .glass-reflection {
    transform: rotate(45deg) translateX(100%);
}

.icon-box {
    @apply w-20 h-20 rounded-lg border-2 border-gray-100 flex items-center justify-center transition-all duration-500;
}

.fac-card:hover .icon-box {
    @apply border-[#d4a373] bg-[#001a2c];
}

/* TYPOGRAPHY: Solid color swaps only */
.fac-title {
    @apply text-2xl font-bold text-[#003154] mb-4 relative z-30 transition-colors duration-500;
}

.fac-desc {
    @apply text-gray-600 text-sm leading-relaxed relative z-30 transition-colors duration-500;
}

.fac-card:hover .fac-title { color: #ffffff; }
.fac-card:hover .fac-desc { color: #d1d5db; }

.gold-line {
    @apply w-12 h-[3px] bg-[#d4a373] mt-8 scale-x-0 origin-left transition-transform duration-500;
}

.fac-card:hover .gold-line {
    @apply scale-x-100;
}
</style>