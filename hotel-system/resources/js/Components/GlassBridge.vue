<script setup>
// Pure styling component for visual transition
</script>

<template>
    <div class="glass-bridge-container">
        <div class="bridge-bg"></div>
        
        <div class="pill-display group">
            <div class="reflection-streak"></div>
            
            <div class="content relative z-10 flex items-center gap-8">
                <div class="text-left">
                    <span class="eyebrow">Discover</span>
                    <h3 class="title">Find Our Location</h3>
                </div>
                
                <div class="status-pill">
                    <span class="pulse-dot"></span>
                    <span class="status-text">Selection Active</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.glass-bridge-container {
    @apply relative w-full h-[350px] flex justify-center items-center overflow-hidden;
    /* Transition from Off-white to deep Map Navy */
    background: linear-gradient(to bottom, #f9fafb 0%, #001a2c 100%);
    z-index: 5;
}

.bridge-bg {
    @apply absolute inset-0 opacity-5;
    background-image: radial-gradient(#d4a373 1px, transparent 1px);
    background-size: 40px 40px;
}

/* THE PILL CONTAINER: Sharp, High-Contrast */
.pill-display {
    @apply relative overflow-hidden px-12 py-6 rounded-full border-2 border-white/20 bg-[#001a2c]/90;
    box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.5);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.pill-display:hover {
    @apply border-[#d4a373]/50;
    transform: translateY(-5px) scale(1.02);
}

/* TEXT STYLES */
.eyebrow {
    @apply block text-[#d4a373] uppercase text-[10px] font-black mb-1;
    letter-spacing: 0.6em; /* Ultra-wide tracking */
}

.title {
    @apply text-white text-3xl font-light italic tracking-tight;
    font-family: 'serif'; /* Luxury Serif */
}

/* THE STATUS PILL (Matching your Target Locked Image) */
.status-pill {
    @apply flex items-center gap-3 bg-white/10 px-6 py-3 rounded-full border border-white/10;
}

.status-text {
    @apply text-white text-[9px] font-black uppercase tracking-[0.2em];
}

.pulse-dot {
    @apply w-2 h-2 bg-[#d4a373] rounded-full;
    box-shadow: 0 0 10px #d4a373;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(0.95); opacity: 0.8; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.8; }
}

/* THE SPECULAR REFLECTION: Sharp light streak */
.reflection-streak {
    @apply absolute -inset-full bg-gradient-to-r from-transparent via-white/10 to-transparent;
    transform: rotate(45deg) translateX(-100%);
    transition: transform 1s ease-in-out;
    z-index: 1;
}

.pill-display:hover .reflection-streak {
    transform: rotate(45deg) translateX(100%);
}
</style>