<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ packages: Array });

const isModalOpen = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    price: '',
    description: '',
    is_active: true,
    has_offer: false,    // New
    offer_percent: null  // New
});

const openCreate = () => {
    isEditing.value = false;
    form.reset();
    form.is_active = true;
    form.has_offer = false;
    isModalOpen.value = true;
};

const openEdit = (pkg) => {
    isEditing.value = true;
    form.id = pkg.id;
    form.name = pkg.name;
    form.price = pkg.price;
    form.description = pkg.description;
    form.is_active = !!pkg.is_active;
    form.has_offer = !!pkg.has_offer;      // Load status
    form.offer_percent = pkg.offer_percent; // Load percent
    isModalOpen.value = true;
};

const confirmDelete = () => {
    if (confirm(`Are you sure you want to permanently delete this package?`)) {
        form.delete(route('admin.packages.destroy', form.id), {
            onSuccess: () => isModalOpen.value = false,
            preserveScroll: true
        });
    }
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.packages.update', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    } else {
        form.post(route('admin.packages.store'), {
            onSuccess: () => {
                form.reset();
                isModalOpen.value = false;
            }
        });
    }
};
</script>

<template>
    <section>
        <div class="flex justify-between items-center mb-10">
            <div class="text-left">
                <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.4em] block mb-1">Stock</span>
                <h3 class="text-2xl font-serif italic text-[#001a2c]">Wedding Inventory</h3>
            </div>
            <button @click="openCreate" class="target-locked-btn">+ NEW PACKAGE</button>
        </div>

        <div class="space-y-4">
            <div v-for="pkg in packages" :key="pkg.id" 
                 class="pill-container group"
                 :class="{ 'opacity-50 grayscale-[0.5]': !pkg.is_active }">
                <div class="flex-1 px-8 py-5">
                    <div class="flex items-center gap-3">
                        <h4 class="font-bold text-[#001a2c]">{{ pkg.name }}</h4>
                        <span v-if="pkg.has_offer" class="bg-red-50 text-red-500 text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-widest border border-red-100">
                            {{ pkg.offer_percent }}% OFF
                        </span>
                        <span v-if="!pkg.is_active" class="hidden-badge">Hidden</span>
                    </div>
                    <p class="price-tag">LKR {{ Number(pkg.price).toLocaleString() }}</p>
                </div>
                <div class="pr-6">
                    <button @click="openEdit(pkg)" class="edit-pill">MANAGE</button>
                </div>
            </div>
        </div>

        <div v-if="isModalOpen" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <div>
                        <span class="modal-eyebrow">Editor Panel</span>
                        <h3 class="modal-title">{{ isEditing ? 'Edit Package' : 'Create Package' }}</h3>
                    </div>
                </div>

                <form @submit.prevent="submit" class="p-10 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="input-label">Package Name</label>
                            <input v-model="form.name" type="text" class="pill-input" required />
                        </div>
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="input-label">Price (LKR)</label>
                            <input v-model="form.price" type="number" class="pill-input" required />
                        </div>
                    </div>

                    <div class="p-4 bg-[#fdfbf7] rounded-[20px] border border-[#d4a373]/20">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373]">Special Offer?</span>
                            <label class="relative inline-flex items-center cursor-pointer scale-90">
                                <input type="checkbox" v-model="form.has_offer" class="sr-only peer">
                                <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#d4a373]"></div>
                            </label>
                        </div>
                        
                        <div v-if="form.has_offer" class="flex items-center gap-4 animate-fade-in">
                            <input 
                                v-model="form.offer_percent" 
                                type="number" 
                                placeholder="20" 
                                class="w-20 bg-white border border-[#d4a373] text-[#001a2c] font-bold text-center rounded-lg py-2 focus:outline-none"
                            />
                            <span class="text-sm font-bold text-[#001a2c]">% Discount Percentage</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="input-label">Description</label>
                        <textarea v-model="form.description" class="pill-input min-h-[100px] py-4"></textarea>
                    </div>

                    <div v-if="isEditing" class="management-tray">
                        <div class="flex items-center gap-4">
                            <span class="tray-label">
                                {{ form.is_active ? 'Status: Active' : 'Status: Hidden' }}
                            </span>
                            <label class="relative inline-flex items-center cursor-pointer scale-90">
                                <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                                <div class="toggle-bg peer"></div>
                            </label>
                        </div>

                        <button type="button" @click="confirmDelete" class="garbage-can-btn group" title="Delete Package">
                            <div class="trash-icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                            <span class="trash-text">Remove Package</span>
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" @click="isModalOpen = false" class="cancel-btn">
                            Close Without Saving
                        </button>
                        <button type="submit" class="submit-pill" :disabled="form.processing">
                            {{ isEditing ? 'SAVE CHANGES' : 'CREATE PACKAGE' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* MAIN LIST STYLES */
.target-locked-btn { @apply bg-[#001a2c] text-white px-8 py-3 rounded-full font-black text-[10px] tracking-[0.2em] transition-all hover:bg-[#d4a373]; }
.pill-container { @apply flex items-center bg-white border border-gray-100 rounded-[30px] shadow-sm transition-all; }
.price-tag { @apply text-[10px] font-black text-[#d4a373] uppercase tracking-widest mt-1; }
.hidden-badge { @apply text-[8px] font-black uppercase text-gray-400 tracking-widest border border-gray-200 px-2 py-0.5 rounded-full; }
.edit-pill { @apply bg-gray-50 text-[#001a2c] px-6 py-2 rounded-full font-black text-[10px] tracking-widest border border-gray-100 hover:bg-[#001a2c] hover:text-white transition-all; }

/* MODAL & FORM STYLES */
.modal-overlay { @apply fixed inset-0 bg-[#001a2c]/90 backdrop-blur-md flex items-center justify-center z-50 p-4; }
.modal-card { @apply bg-white rounded-[40px] w-full max-w-xl shadow-2xl overflow-hidden border border-white/20; }
.modal-header { @apply bg-[#001a2c] px-10 py-8; }
.modal-eyebrow { @apply text-[#d4a373] text-[10px] font-black uppercase tracking-[0.5em] block mb-2; }
.modal-title { @apply text-white text-3xl font-serif italic; }
.input-label { @apply block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4; }
.pill-input { @apply w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] outline-none text-[#001a2c] font-bold text-sm focus:border-[#d4a373] transition-all; }

/* MANAGEMENT TRAY STYLES */
.management-tray { @apply flex items-center justify-between p-2 pl-6 bg-gray-50 rounded-full border border-gray-100 shadow-inner; }
.tray-label { @apply text-[9px] font-black uppercase tracking-[0.2em] text-[#001a2c]; }
.toggle-bg { @apply w-12 h-6 bg-gray-200 peer-focus:outline-none rounded-full transition-all peer-checked:bg-[#d4a373] after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-6; }

/* TRASH CAN BUTTON */
.garbage-can-btn { @apply flex items-center gap-2 pr-5 pl-1 py-1 rounded-full transition-all duration-300; background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1); }
.trash-icon-box { @apply w-9 h-9 rounded-full flex items-center justify-center text-gray-400 transition-all duration-300 group-hover:bg-red-500 group-hover:text-white; }
.trash-text { @apply text-[9px] font-black uppercase tracking-[0.1em] text-gray-400 group-hover:text-red-600 transition-colors duration-300; }
.garbage-can-btn:hover { @apply bg-red-50 border-red-200 shadow-sm; transform: scale(1.02); }

.submit-pill { @apply bg-[#001a2c] text-white px-10 py-5 rounded-full font-black text-[11px] tracking-[0.3em] shadow-xl hover:bg-[#d4a373] transition-all; }
.cancel-btn { @apply text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-[#001a2c] transition-colors; }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>