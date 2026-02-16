<script setup>
defineProps({
    item: Object
});
</script>

<template>
    <div class="package-card">
        <h4 class="text-2xl font-bold mb-2 text-gray-800">{{ item.name }}</h4>
        <p class="text-gray-600 mb-6 leading-relaxed">{{ item.description }}</p>
        
        <div class="flex justify-between items-center border-t border-gray-50 pt-6">
            <span class="text-3xl font-black text-blue-700">${{ item.price }}</span>
            <button class="bg-[#003154] text-white px-8 py-2.5 rounded-full font-bold hover:bg-[#d4a373] transition-all duration-300 shadow-md">
                Book Now
            </button>
        </div>
    </div>
</template>

<style scoped>
.package-card {
    background: white;
    /* Professional, thin luxury border you requested */
    border: 1px solid rgba(0, 0, 0, 0.08); 
    border-radius: 24px;
    padding: 2.5rem;
    position: relative;
    transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
}

.package-card:hover {
    border-color: #d4a373; /* Gold Accent */
    transform: translateY(-12px);
    box-shadow: 0 30px 60px -15px rgba(212, 163, 115, 0.15);
}

/* Elegant top-border highlight */
.package-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(to right, transparent, #d4a373, transparent);
    opacity: 0;
    transition: opacity 0.4s;
}

.package-card:hover::before {
    opacity: 1;
}
</style>