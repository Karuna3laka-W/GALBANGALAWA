<script setup>
import { ref } from 'vue';

const discounts = ref([
    { id: 1, name: 'Summer Wedding Promo', code: 'SUMMER20', value: '20%', active: true },
    { id: 2, name: 'Early Bird Special', code: 'EARLY10', value: '10%', active: false },
]);
</script>

<template>
    <section>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Discounts & Offers</h3>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-green-700">
                + Create Coupon
            </button>
        </div>

        <div class="grid gap-4">
            <div v-for="offer in discounts" :key="offer.id" class="p-5 border rounded-2xl flex justify-between items-center bg-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">
                        %
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ offer.name }}</h4>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600 font-mono">{{ offer.code }}</code>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <span class="text-lg font-black text-green-600">{{ offer.value }} OFF</span>
                    <span :class="offer.active ? 'text-green-500 bg-green-50' : 'text-gray-400 bg-gray-50'" class="text-[10px] font-bold uppercase px-2 py-1 rounded-md">
                        {{ offer.active ? 'Active' : 'Paused' }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>