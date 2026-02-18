<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ services: Array });

const isModalOpen = ref(false);
const isEditing = ref(false);
const imagePreview = ref(null); // Holds the visual preview of the uploaded image

// The form requires 'image' to hold the actual file data
const form = useForm({
    id: null,
    title: '',
    subtitle: '',
    image: null, 
    is_active: true
});

// Handle the file selection and create a temporary URL for the preview
const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const openCreate = () => {
    isEditing.value = false;
    form.reset();
    imagePreview.value = null; // Clear preview
    isModalOpen.value = true;
};

const openEdit = (service) => {
    isEditing.value = true;
    form.id = service.id;
    form.title = service.title;
    form.subtitle = service.subtitle;
    form.is_active = !!service.is_active;
    form.image = null; // Reset the file input so it doesn't accidentally overwrite unless they choose a new file
    
    // Show the existing image from the database as the preview
    imagePreview.value = `/storage/${service.image_path}`; 
    
    isModalOpen.value = true;
};

const confirmDelete = () => {
    if (confirm(`Are you sure? This will delete the service and its image permanently.`)) {
        form.delete(route('admin.services.destroy', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    }
};

const submit = () => {
    // IMPORTANT: File uploads in Inertia work best with POST requests.
    // Our web.php route is specifically configured as Route::post() for updates to support this!
    if (isEditing.value) {
        form.post(route('admin.services.update', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    } else {
        form.post(route('admin.services.store'), {
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
                <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.4em] block mb-1">Portfolio</span>
                <h3 class="text-2xl font-serif italic text-[#001a2c]">Experiences & Services</h3>
            </div>
            <button @click="openCreate" class="bg-[#001a2c] text-white px-8 py-3 rounded-full font-black text-[10px] tracking-[0.2em] hover:bg-[#d4a373] transition-all">
                + NEW SERVICE
            </button>
        </div>

        <div class="space-y-4">
            <div v-for="service in services" :key="service.id" 
                 class="flex items-center justify-between bg-white border border-gray-100 rounded-[30px] p-4 shadow-sm transition-all hover:shadow-md"
                 :class="{ 'opacity-50 grayscale': !service.is_active }">
                
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-50 shrink-0 shadow-inner">
                        <img :src="`/storage/${service.image_path}`" alt="Thumbnail" class="w-full h-full object-cover" />
                    </div>
                    
                    <div>
                        <span class="text-[#d4a373] text-[9px] font-black uppercase tracking-widest block">{{ service.subtitle }}</span>
                        <h4 class="font-bold text-[#001a2c] text-lg">{{ service.title }}</h4>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 pr-4">
                    <span v-if="!service.is_active" class="text-[9px] font-black uppercase tracking-widest text-gray-400 border border-gray-200 px-3 py-1 rounded-full">Hidden</span>
                    <button @click="openEdit(service)" class="bg-gray-50 text-[#001a2c] px-6 py-2 rounded-full font-black text-[10px] tracking-widest border border-gray-100 hover:bg-[#001a2c] hover:text-white transition-all">
                        MANAGE
                    </button>
                </div>
            </div>
            
            <div v-if="!services || services.length === 0" class="text-center py-12 text-gray-400 text-sm font-bold uppercase tracking-widest border-2 border-dashed border-gray-100 rounded-[30px]">
                No services added yet. Add your first experience!
            </div>
        </div>

        <div v-if="isModalOpen" class="fixed inset-0 bg-[#001a2c]/90 backdrop-blur-md flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-[40px] w-full max-w-2xl shadow-2xl overflow-hidden border border-white/20 flex flex-col max-h-[90vh]">
                
                <div class="bg-[#001a2c] px-10 py-6 shrink-0">
                    <span class="text-[#d4a373] text-[10px] font-black uppercase tracking-[0.5em] block mb-2">Service Editor</span>
                    <h3 class="text-white text-3xl font-serif italic">{{ isEditing ? 'Edit Service' : 'Add Service' }}</h3>
                </div>

                <div class="overflow-y-auto p-10 flex-grow">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Cover Image</label>
                            
                            <div class="relative border-2 border-dashed border-gray-200 rounded-[30px] p-2 hover:border-[#d4a373] transition-colors bg-gray-50 flex items-center justify-center min-h-[200px] overflow-hidden group">
                                
                                <input type="file" @change="handleImageUpload" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" :required="!isEditing" />
                                
                                <div v-if="!imagePreview" class="text-center z-10 pointer-events-none text-gray-400 group-hover:text-[#d4a373] transition-colors">
                                    <span class="material-icons-outlined text-4xl mb-2">add_photo_alternate</span>
                                    <p class="text-xs font-bold uppercase tracking-widest">Click to upload image</p>
                                </div>

                                <img v-if="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover z-10" />
                                
                                <div v-if="imagePreview" class="absolute inset-0 bg-[#001a2c]/50 opacity-0 group-hover:opacity-100 transition-opacity z-15 flex items-center justify-center pointer-events-none">
                                    <span class="text-white text-xs font-black uppercase tracking-widest px-4 py-2 bg-black/50 rounded-full backdrop-blur-sm">Change Image</span>
                                </div>
                            </div>
                            <p v-if="form.errors.image" class="text-red-500 text-xs font-bold ml-4">{{ form.errors.image }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2 col-span-2 sm:col-span-1">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Title</label>
                                <input v-model="form.title" type="text" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] font-bold text-sm focus:border-[#d4a373] outline-none" placeholder="e.g. Weddings" required />
                            </div>
                            <div class="space-y-2 col-span-2 sm:col-span-1">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#d4a373] ml-4">Subtitle</label>
                                <input v-model="form.subtitle" type="text" class="w-full px-8 py-5 bg-gray-50 border border-gray-100 rounded-[25px] font-bold text-sm focus:border-[#d4a373] outline-none" placeholder="e.g. Elegant Celebrations" required />
                            </div>
                        </div>

                        <div v-if="isEditing" class="flex items-center justify-between p-2 pl-6 bg-gray-50 rounded-full border border-gray-100 shadow-inner mt-4">
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
                        
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-8">
                            <button type="button" @click="isModalOpen = false" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-[#001a2c]">Cancel</button>
                            <button type="submit" class="bg-[#001a2c] text-white px-10 py-5 rounded-full font-black text-[11px] tracking-[0.3em] shadow-xl hover:bg-[#d4a373] transition-all disabled:opacity-50" :disabled="form.processing">
                                {{ form.processing ? 'UPLOADING...' : (isEditing ? 'SAVE CHANGES' : 'PUBLISH SERVICE') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>