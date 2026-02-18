<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ seasonalOffers: Array });
const isModalOpen = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    title: '',
    badge_text: '',
    description: '',
    
    is_active: false,
    theme_color: '#d4a373'
});

const openCreate = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
};

const openEdit = (offer) => {
    isEditing.value = true;
    form.id = offer.id;
    form.title = offer.title;
    form.badge_text = offer.badge_text;
    form.description = offer.description;
    form.is_active = !!offer.is_active;
    isModalOpen.value = true;
};

const confirmDelete = () => {
    if (confirm(`Remove this seasonal offer?`)) {
        form.delete(route('admin.offers.destroy', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    }
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.offers.update', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    } else {
        form.post(route('admin.offers.store'), {
            onSuccess: () => {
                form.reset();
                isModalOpen.value = false;
            }
        });
    }
};
</script>

<template>
    <section class="mt-16">
        <div class="flex justify-between items-center mb-8">
            <div class="text-left">
                <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.4em] block mb-1">Marketing</span>
                <h3 class="text-2xl font-serif italic text-[#001a2c]">Seasonal Offers</h3>
            </div>
            <button @click="openCreate" class="bg-[#001a2c] text-white px-8 py-3 rounded-full font-black text-[10px] tracking-[0.2em] hover:bg-[#d4a373] transition-all">
                + NEW PROMO
            </button>
        </div>

        <div class="space-y-4">
            <div v-for="offer in seasonalOffers" :key="offer.id" 
                 class="flex items-center justify-between bg-white border border-gray-100 rounded-[30px] p-6 shadow-sm"
                 :class="{ 'border-[#d4a373] shadow-[#d4a373]/20': offer.is_active, 'opacity-50 grayscale': !offer.is_active }">
                
                <div class="flex items-center gap-4">
                    <span class="bg-[#d4a373] text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ offer.badge_text }}
                    </span>
                    <h4 class="font-bold text-[#001a2c]">{{ offer.title }}</h4>
                    <span v-if="offer.is_active" class="text-[9px] font-black uppercase tracking-widest text-green-500 animate-pulse">Live Now</span>
                </div>
                
                <button @click="openEdit(offer)" class="bg-gray-50 text-[#001a2c] px-6 py-2 rounded-full font-black text-[10px] tracking-widest border border-gray-100 hover:bg-[#001a2c] hover:text-white transition-all">
                    MANAGE
                </button>
            </div>
            <div v-if="!seasonalOffers || seasonalOffers.length === 0" class="text-center py-8 text-gray-400 text-sm font-bold uppercase tracking-widest">
                No seasonal offers currently designed.
            </div>
        </div>

        <div v-if="isModalOpen" class="fixed inset-0 bg-[#001a2c]/90 backdrop-blur-md flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-[40px] w-full max-w-xl shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-[#001a2c] px-10 py-8">
                    <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.5em] block mb-2">Promo Editor</span>
                    <h3 class="text-white text-3xl font-serif italic">{{ isEditing ? 'Edit Promo' : 'Create Promo' }}</h3>
                </div>

                <form @submit.prevent="submit" class="p-10 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Promo Title</label>
                            <input v-model="form.title" type="text" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] font-bold text-sm focus:border-[#d4a373] outline-none" placeholder="e.g. Valentine's Day" required />
                        </div>
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Badge Text</label>
                            <input v-model="form.badge_text" type="text" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] font-bold text-sm focus:border-[#d4a373] outline-none" placeholder="e.g. 40% OFF" required />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Description</label>
                        <textarea v-model="form.description" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] min-h-[100px] font-bold text-sm focus:border-[#d4a373] outline-none"></textarea>
                    </div>

                    <div v-if="isEditing" class="flex items-center justify-between p-2 pl-6 bg-gray-50 rounded-full border border-gray-100 shadow-inner">
                        <div class="flex items-center gap-4">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-[#001a2c]">
                                {{ form.is_active ? 'Status: Live on Site' : 'Status: Hidden' }}
                            </span>
                            <label class="relative inline-flex items-center cursor-pointer scale-90">
                                <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                                <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-[#d4a373] after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-6"></div>
                            </label>
                        </div>
                        <button type="button" @click="confirmDelete" class="flex items-center gap-2 pr-5 pl-1 py-1 rounded-full transition-all duration-300 bg-red-50 border border-red-100 group hover:bg-red-100">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-red-400 group-hover:text-red-600 group-hover:bg-white transition-all"><span class="material-icons-outlined">delete</span></div>
                            <span class="text-[9px] font-black uppercase tracking-[0.1em] text-red-500">Remove</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Promo Title</label>
                            <input v-model="form.title" type="text" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] font-bold text-sm focus:border-[#d4a373] outline-none" required />
                        </div>
                        
                        <div class="space-y-2 col-span-2 sm:col-span-1">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Theme Color</label>
                            <div class="flex items-center gap-4 bg-gray-50 border border-gray-100 rounded-[25px] px-4 py-3">
                                <input v-model="form.theme_color" type="color" class="w-10 h-10 rounded cursor-pointer border-0 bg-transparent p-0" />
                                <span class="font-bold text-sm text-gray-500 uppercase">{{ form.theme_color }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" @click="isModalOpen = false" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-[#001a2c]">Cancel</button>
                        <button type="submit" class="bg-[#001a2c] text-white px-10 py-5 rounded-full font-black text-[11px] tracking-[0.3em] shadow-xl hover:bg-[#d4a373] transition-all" :disabled="form.processing">
                            {{ isEditing ? 'SAVE PROMO' : 'PUBLISH PROMO' }}
                        </button>
                    </div>

                    
                </form>
            </div>
        </div>
    </section>
</template>