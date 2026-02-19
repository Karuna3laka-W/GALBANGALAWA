<script setup>
import { ref } from 'vue';

const props = defineProps({
    offer: Object
});

// 1. Modal State Control
const isModalOpen = ref(false);

// 2. WhatsApp Redirect Logic
const reserveViaWhatsApp = () => {
    // Replace this with the actual Hotel Galbangalawa WhatsApp number (include country code, no + or spaces)
    const phoneNumber = "94700000000"; 
    
    // Creates a pre-filled message for the customer
    const message = `Hello Hotel Galbangalawa! I would like to reserve the exclusive "${props.offer.title}" offer.`;
    
    // Opens WhatsApp securely in a new tab
    window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
};
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
            </div>

            <div class="absolute z-10 w-[240px] h-[340px] bg-gradient-to-br from-[#333333] to-[#111111] rounded-3xl shadow-2xl transition-all duration-500 hover:-translate-y-8 hover:rotate-[5deg] hover:z-30 left-1/2 ml-[20px] bottom-16 rotate-12 border border-white/10 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex justify-between items-center text-white/80">
                    <div class="flex gap-1">
                        <div class="w-4 h-4 rounded-full border-2 border-white/50"></div>
                        <div class="w-4 h-4 rounded-full border-2 border-white/50 -ml-2"></div>
                    </div>
                    <span class="font-bold text-xs uppercase tracking-widest text-white/50">Exclusive</span>
                </div>
            </div>

            <div class="absolute z-20 w-[260px] h-[360px] left-1/2 ml-[-130px] bottom-20 transition-all duration-500 hover:-translate-y-10 cursor-pointer card-wrapper" @click="isModalOpen = true">
                
                <div class="w-full h-full rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.6)] border border-white/40 p-6 flex flex-col justify-between dynamic-card spin-slowly">
                    
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
            </div>

            <div class="absolute -bottom-4 w-full max-w-4xl h-24 bg-gradient-to-t from-[#03070e] to-transparent z-30 pointer-events-none"></div>
        </div>

        <button @click="isModalOpen = true" class="relative z-40 mt-12 claim-btn">
            Get Your Card
        </button>

        <div class="relative z-20 mt-24 pt-10 border-t border-white/5 w-full max-w-5xl flex justify-center gap-8 md:gap-16 opacity-30 flex-wrap">
            <span class="text-white font-bold tracking-widest uppercase text-xs">Luxury</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Exclusivity</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Galbangalawa</span>
            <span class="text-white font-bold tracking-widest uppercase text-xs">Verified</span>
        </div>

        <Teleport to="body">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
                
                <div class="absolute inset-0 bg-[#001a2c]/80 backdrop-blur-md cursor-pointer transition-opacity" @click="isModalOpen = false"></div>
                
                <div class="relative w-full max-w-5xl bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row transform transition-all animate-modal-pop">
                    
                    <div class="md:w-1/2 h-64 md:h-auto relative">
                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop" alt="Offer Detail" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#001a2c]/60 to-transparent"></div>
                    </div>
                    
                    <div class="md:w-1/2 p-10 md:p-14 flex flex-col justify-center bg-white relative">
                        
                        <button @click="isModalOpen = false" class="absolute top-6 right-6 w-12 h-12 bg-gray-50 hover:bg-gray-200 text-[#001a2c] rounded-full flex items-center justify-center transition-all group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">
                            {{ offer.badge_text }}
                        </span>
                        
                        <h3 class="text-4xl md:text-5xl font-serif italic text-[#001a2c] mb-6 leading-tight">
                            {{ offer.title }}
                        </h3>
                        
                        <p class="text-gray-600 text-lg leading-relaxed mb-10 font-light">
                            {{ offer.description }}
                            <br><br>
                            Experience the pinnacle of luxury with this limited-time exclusive pass. Secure your reservation today and let us create unforgettable memories for you at Galbangalawa.
                        </p>
                        
                        <button @click="reserveViaWhatsApp" class="w-full py-5 bg-[#25D366] text-white rounded-full font-black text-[12px] uppercase tracking-[0.2em] shadow-[0_10px_30px_rgba(37,211,102,0.3)] hover:bg-[#20b858] hover:shadow-[0_15px_40px_rgba(37,211,102,0.5)] hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                            </svg>
                            Reserve via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

    </section>
</template>

<style scoped>
/* MAGIC CSS: Mixes your Admin Color with Black to create a perfect gradient! */
.dynamic-card {
    background: linear-gradient(135deg, var(--theme), color-mix(in srgb, var(--theme) 30%, black));
}

/* --- THE 3D SPIN ANIMATION --- */
.spin-slowly {
    animation: spin3D 15s linear infinite;
    transform-style: preserve-3d;
}

/* Pause the spin when the user hovers over the card wrapper */
.card-wrapper:hover .spin-slowly {
    animation-play-state: paused;
}

@keyframes spin3D {
    0% { transform: perspective(1000px) rotateY(0deg); }
    100% { transform: perspective(1000px) rotateY(360deg); }
}
/* ----------------------------- */

/* Modern Pill Button */
.claim-btn {
    @apply px-12 py-5 bg-white text-[#03070e] font-black text-[12px] uppercase tracking-[0.3em] rounded-full transition-all duration-300;
    box-shadow: 0 0 40px color-mix(in srgb, var(--theme) 30%, transparent);
}

.claim-btn:hover {
    background: var(--theme);
    color: white;
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 40px color-mix(in srgb, var(--theme) 60%, transparent);
}

/* --- MODAL POP ANIMATION --- */
@keyframes modalPop {
    0% { opacity: 0; transform: scale(0.95) translateY(20px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal-pop {
    animation: modalPop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>