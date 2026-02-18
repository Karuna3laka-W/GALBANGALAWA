<script setup>
defineProps({
    offer: Object
});
</script>

<template>
    <section v-if="offer" 
             class="bg-[#03070e] py-32 px-6 relative overflow-hidden flex flex-col items-center justify-center font-sans selection:bg-[--theme] selection:text-white" 
             :style="{ '--theme': offer.theme_color || '#d4a373' }">

        <div class="relative z-20 text-center max-w-4xl mx-auto flex flex-col items-center">
            
            <div class="flex items-center gap-6 mb-4">
                <svg class="w-5 h-5 text-white animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/>
                </svg>
                
                <span class="text-white/80 text-xl md:text-3xl font-medium tracking-wide">
                    {{ offer.description }}
                </span>
                
                <svg class="w-5 h-5 text-white animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/>
                </svg>
            </div>

            <h2 class="text-5xl md:text-7xl font-bold text-white tracking-tight leading-tight mb-6">
                {{ offer.title }}
            </h2>
        </div>

        <div class="relative w-full max-w-3xl mx-auto mt-16 h-[380px] flex justify-center items-end group">
            
            <div class="absolute bottom-10 w-full h-40 bg-[#0a121c] rounded-[40px] z-0 shadow-inner border border-white/5"></div>

            <div class="absolute z-10 w-[240px] h-[340px] bg-gradient-to-br from-[#1e3a8a] to-[#0f172a] rounded-3xl shadow-2xl transition-all duration-500 hover:-translate-y-8 hover:rotate-[-5deg] hover:z-30 left-1/2 ml-[-260px] bottom-16 -rotate-12 border border-white/20 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex justify-between items-center text-white/80">
                    <div class="flex gap-1">
                        <div class="w-4 h-4 rounded-full border-2 border-white/50"></div>
                        <div class="w-4 h-4 rounded-full border-2 border-white/50 -ml-2"></div>
                    </div>
                    <span class="font-bold text-xs uppercase tracking-widest text-white/50">Standard</span>
                </div>
                <div>
                    <h3 class="font-bold text-2xl text-white tracking-tight">Sapphire</h3>
                    <p class="text-[10px] uppercase font-bold text-white/50 tracking-widest mt-1">Gift Card</p>
                </div>
            </div>

            <div class="absolute z-10 w-[240px] h-[340px] bg-gradient-to-br from-[#333333] to-[#111111] rounded-3xl shadow-2xl transition-all duration-500 hover:-translate-y-8 hover:rotate-[5deg] hover:z-30 left-1/2 ml-[20px] bottom-16 rotate-12 border border-white/10 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex justify-between items-center text-white/80">
                    <div class="flex gap-1">
                        <div class="w-4 h-4 rounded-full border-2 border-white/50"></div>
                        <div class="w-4 h-4 rounded-full border-2 border-white/50 -ml-2"></div>
                    </div>
                    <span class="font-bold text-xs uppercase tracking-widest text-white/50">Exclusive</span>
                </div>
                <div>
                    <h3 class="font-bold text-2xl text-white tracking-tight">Obsidian</h3>
                    <p class="text-[10px] uppercase font-bold text-white/50 tracking-widest mt-1">Gift Card</p>
                </div>
            </div>

            <div class="absolute z-20 w-[260px] h-[360px] rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.6)] transition-all duration-500 hover:-translate-y-10 left-1/2 ml-[-130px] bottom-20 border border-white/40 p-6 flex flex-col justify-between dynamic-card cursor-pointer">
                
                <div class="flex justify-between items-center text-white">
                    <div class="flex gap-1">
                        <div class="w-5 h-5 rounded-full bg-white/30 backdrop-blur-md"></div>
                        <div class="w-5 h-5 rounded-full bg-white/30 backdrop-blur-md -ml-2"></div>
                    </div>
                    <span class="font-black text-[10px] uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full text-white">
                        {{ offer.badge_text }}
                    </span>
                </div>

                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-24 h-24 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm flex items-center justify-center shadow-inner">
                        <span class="text-5xl font-serif italic text-white drop-shadow-md">G</span>
                    </div>
                </div>

                <div class="relative z-10 text-white drop-shadow-md">
                    <h3 class="font-black text-3xl tracking-tight">{{ offer.title }}</h3>
                    <p class="text-[10px] uppercase font-bold text-white/80 tracking-widest mt-1">Limited Pass</p>
                </div>
            </div>

            <div class="absolute -bottom-4 w-full max-w-4xl h-24 bg-gradient-to-t from-[#03070e] to-transparent z-30 pointer-events-none"></div>
        </div>

        <button class="relative z-40 mt-12 claim-btn">
            Get Your Card
        </button>

        <div class="relative z-20 mt-24 pt-10 border-t border-white/5 w-full max-w-5xl flex justify-center gap-8 md:gap-16 opacity-30 flex-wrap">
            <span class="text-white font-bold tracking-widest uppercase text-xs">Luxury</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Exclusivity</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Galbangalawa</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Verified</span>
        </div>

    </section>
</template>

<style scoped>
/* MAGIC CSS: Mixes your Admin Color with Black to create a perfect gradient! */
.dynamic-card {
    background: linear-gradient(135deg, var(--theme), color-mix(in srgb, var(--theme) 30%, black));
}

/* Modern Pill Button */
.claim-btn {
    @apply px-12 py-5 bg-white text-[#03070e] font-black text-[12px] uppercase tracking-[0.3em] rounded-full transition-all duration-300;
    /* Soft glow matching the dynamic color */
    box-shadow: 0 0 40px color-mix(in srgb, var(--theme) 30%, transparent);
}

.claim-btn:hover {
    background: var(--theme);
    color: white;
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 40px color-mix(in srgb, var(--theme) 60%, transparent);
}
</style>