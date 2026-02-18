<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpen = ref(false);

const closeMenu = () => {
    isOpen.value = false;
};
</script>

<template>
    <nav class="fixed top-0 left-0 w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center relative">
            
            <a href="/" class="flex items-center gap-3 group z-50">
                <div class="w-10 h-10 rounded-full bg-[#d4a373] flex items-center justify-center text-[#001a2c] font-black font-serif italic text-xl group-hover:scale-105 transition-transform duration-500">
                    G
                </div>
                <span class="text-white font-serif italic text-2xl tracking-wide group-hover:text-[#d4a373] transition-colors duration-500">
                    Galbangalawa
                </span>
            </a>

            <button 
                @click="isOpen = !isOpen" 
                class="hamburger-btn z-50"
                aria-label="Toggle Menu"
            >
                <span class="material-icons-outlined text-3xl transition-transform duration-500" :class="{ 'rotate-90 opacity-0 absolute': isOpen, 'rotate-0 opacity-100': !isOpen }">
                    menu
                </span>
                <span class="material-icons-outlined text-3xl transition-transform duration-500 absolute" :class="{ 'rotate-0 opacity-100': isOpen, '-rotate-90 opacity-0': !isOpen }">
                    close
                </span>
            </button>

            <transition name="menu-fade">
                <div v-if="isOpen" class="dropdown-panel">
                    <div class="flex flex-col py-4">
                        
                        <a href="#packages" @click="closeMenu" class="luxury-link">
                            Packages
                        </a>
                        
                        <a href="#gallery" @click="closeMenu" class="luxury-link">
                            Gallery
                        </a>
                        
                        <a href="#location" @click="closeMenu" class="luxury-link">
                            Location
                        </a>
                        
                        <a href="#contact" @click="closeMenu" class="luxury-link">
                            Contact Us
                        </a>

                        <div class="divider-line"></div>

                        <Link :href="route('dashboard')" @click="closeMenu" class="admin-link">
                            Admin Login
                        </Link>

                    </div>
                </div>
            </transition>

        </div>
    </nav>
</template>

<style scoped>
/* Main Navbar Glassmorphism */
.glass-nav {
    background: rgba(0, 26, 44, 0.75); 
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(212, 163, 115, 0.15);
}

/* Hamburger Button */
.hamburger-btn {
    @apply w-12 h-12 flex items-center justify-center text-[#d4a373] rounded-full hover:bg-white/10 transition-all duration-300;
}

/* RESPONSIVE DROPDOWN PANEL 
  Mobile: Stretches across the screen with margins.
  Desktop (md+): Becomes a neat 18rem (288px) box anchored to the right.
*/
.dropdown-panel {
    @apply fixed top-[85px] left-4 right-4 md:left-auto md:w-72 
           bg-[#001a2c]/95 backdrop-blur-2xl border border-[#d4a373]/30 
           rounded-2xl shadow-2xl overflow-hidden z-40;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
}

/* Luxury Link Styling (No Icons, Focus on Typography & Hover) */
.luxury-link {
    @apply px-8 py-4 text-white font-serif italic text-xl tracking-wide 
           transition-all duration-300 hover:text-[#d4a373] hover:bg-white/5 hover:pl-10;
}

/* Gold Divider */
.divider-line {
    @apply h-[1px] bg-gradient-to-r from-transparent via-[#d4a373]/40 to-transparent my-2 mx-4;
}

/* Admin Login Button Styling */
.admin-link {
    @apply mx-4 mt-2 mb-2 px-4 py-3 text-center rounded-xl border border-[#d4a373]/50 
           text-[#d4a373] font-black uppercase text-[11px] tracking-[0.3em] 
           transition-all duration-300 hover:bg-[#d4a373] hover:text-[#001a2c];
}

/* Smooth Fade & Slide Animation */
.menu-fade-enter-active, .menu-fade-leave-active {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.menu-fade-enter-from, .menu-fade-leave-to {
    opacity: 0;
    transform: translateY(-20px) scale(0.98);
}
</style>