<script setup>
import { computed } from 'vue';

const props = defineProps({
    item: Object
});

// Calculate the discounted price if offer is active
const finalPrice = computed(() => {
    if (props.item.has_offer && props.item.offer_percent) {
        const discount = (props.item.price * props.item.offer_percent) / 100;
        return props.item.price - discount;
    }
    return props.item.price;
});
</script>

<template>
    <div class="group relative bg-white rounded-[40px] border border-gray-100 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
        
        <div v-if="item.has_offer" class="offer-badge">
            <span class="font-black text-[10px] tracking-widest">{{ item.offer_percent }}% OFF</span>
        </div>

        <div class="relative z-10 flex flex-col h-full">
            <h3 class="text-3xl font-serif italic text-[#001a2c] mb-2">{{ item.name }}</h3>
            
            <div class="flex items-baseline gap-3 mb-6">
                <span v-if="item.has_offer" class="text-xs text-gray-400 line-through decoration-red-400 decoration-1 font-bold">
                    LKR {{ Number(item.price).toLocaleString() }}
                </span>
                
                <span class="text-xs font-black text-[#d4a373] uppercase tracking-[0.2em]">
                    LKR {{ Number(finalPrice).toLocaleString() }}
                </span>
            </div>

            <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow border-l-2 border-[#d4a373]/30 pl-4">
                {{ item.description }}
            </p>

            <button class="w-full py-4 rounded-full border border-[#001a2c]/10 text-[#001a2c] font-black text-[10px] uppercase tracking-[0.3em] hover:bg-[#001a2c] hover:text-white transition-all mt-auto">
                View Details
            </button>
        </div>

        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-[#f4f1ea] rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
    </div>
</template>

<style scoped>
.offer-badge {
    @apply absolute top-6 right-6 bg-[#d4a373] text-white px-3 py-1.5 rounded-full 
           flex items-center gap-2 shadow-lg shadow-[#d4a373]/40 z-20 
           transform group-hover:scale-110 transition-transform duration-300 animate-pulse;
}
</style>