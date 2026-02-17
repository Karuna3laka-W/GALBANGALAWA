<script setup>
import PackageCard from '@/Components/PackageCard.vue';

defineProps({
    packages: Array
});
</script>

<template>
    <section id="packages" class="py-32 px-6 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-[#d4a373] uppercase tracking-[0.4em] font-black text-[10px] block mb-4">
                    Accommodations
                </span>
                <h3 class="text-6xl font-light text-[#001a2c] font-serif italic tracking-tight">
                    Our Wedding Packages
                </h3>
                <p class="text-gray-500 mt-4 max-w-2xl mx-auto uppercase tracking-widest text-[10px] font-bold">
                    Currently showing {{ packages.length }} exclusive offers
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <PackageCard 
                    v-for="item in packages" 
                    :key="item.id" 
                    :item="item"
                />
            </div>
        </div>
    </section>
</template>