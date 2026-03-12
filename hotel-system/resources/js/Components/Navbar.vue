<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpen = ref(false);

// Lock body scroll when menu is open
watch(isOpen, (val) => {
    document.body.style.overflow = val ? 'hidden' : '';
});
</script>

<template>
    <nav class="fixed top-0 left-0 w-full z-50 glass-nav">
        <div class="max-w-[1800px] mx-auto px-10 py-4 flex justify-between items-center">
            
            <button @click="isOpen = !isOpen" class="pill-btn group">
                <span class="material-icons-outlined text-xl">{{ isOpen ? 'close' : 'menu' }}</span>
                <span class="uppercase text-xs tracking-widest font-bold">{{ isOpen ? 'Close' : 'Menu' }}</span>
            </button>

            <Link href="/booking" class="pill-btn group">
                <span class="uppercase text-xs tracking-widest font-bold">Booking</span>
                <span class="material-icons-outlined text-xl">shopping_bag</span>
            </Link>
        </div>

        <div class="w-full h-[1px] bg-white/10"></div>

        <div class="flex justify-center items-center py-5 gap-12">
            <a href="#" class="nav-link">About Us</a>
            <a href="#" class="nav-link">Rooms</a>
            <a href="#" class="nav-link">Weddings</a>
            <a href="#" class="nav-link">Events</a>
            <a href="#" class="nav-link">Contact</a>
        </div>
    </nav>

    <!-- ========== FULL-SCREEN MENU OVERLAY ========== -->
    <Transition name="menu-overlay">
        <div v-if="isOpen" class="menu-overlay" @click.self="isOpen = false">
            <div class="menu-inner">
                <!-- Left column – main navigation -->
                <div class="menu-column menu-main">
                    <h3 class="menu-section-title">Navigate</h3>
                    <ul class="menu-links">
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">01</span>
                            <span class="menu-link-text">Home</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">02</span>
                            <span class="menu-link-text">About Us</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">03</span>
                            <span class="menu-link-text">Rooms & Suites</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">04</span>
                            <span class="menu-link-text">Spa & Wellness</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">05</span>
                            <span class="menu-link-text">Weddings & Events</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">06</span>
                            <span class="menu-link-text">Packages & Offers</span>
                        </a></li>
                        <li><a href="#" @click="isOpen = false" class="menu-link">
                            <span class="menu-link-number">07</span>
                            <span class="menu-link-text">Gallery</span>
                        </a></li>
                    </ul>
                </div>

                <!-- Right column – secondary links & contact -->
                <div class="menu-column menu-secondary">
                    <div class="menu-secondary-group">
                        <h3 class="menu-section-title">Explore</h3>
                        <ul class="menu-sub-links">
                            <li><a href="#" @click="isOpen = false">Experiences</a></li>
                            <li><a href="#" @click="isOpen = false">Dining</a></li>
                            <li><a href="#" @click="isOpen = false">Facilities</a></li>
                            <li><a href="#" @click="isOpen = false">Gift Vouchers</a></li>
                        </ul>
                    </div>

                    <div class="menu-secondary-group">
                        <h3 class="menu-section-title">Get in Touch</h3>
                        <div class="menu-contact">
                            <a href="mailto:info@galbangalawa.com" class="contact-email">info@galbangalawa.com</a>
                            <a href="tel:+94112161161" class="contact-phone">+94 112 161 161</a>
                        </div>
                    </div>

                    <div class="menu-secondary-group">
                        <h3 class="menu-section-title">Follow Us</h3>
                        <div class="menu-socials">
                            <a href="#" class="social-icon">Instagram</a>
                            <a href="#" class="social-icon">Facebook</a>
                            <a href="#" class="social-icon">TripAdvisor</a>
                        </div>
                    </div>

                    <div class="menu-admin-link">
                        <Link href="/login" class="admin-link" @click="isOpen = false">
                            <span class="material-icons-outlined" style="font-size:16px">lock</span>
                            Admin Panel
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.glass-nav {
    /* The specific dark teal/blue from your image */
    background: rgba(12, 66, 80, 0.95); 
    backdrop-filter: blur(10px);
}

/* Pill Buttons (Menu & Booking) */
.pill-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 24px;
    background: #061922;
    border-radius: 999px;
    color: white;
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.3s ease;
}
.pill-btn:hover {
    background: #1a2c38;
}

/* Centered Logo container */
.logo-circle {
    @apply w-16 h-16 rounded-full border border-white/40 flex items-center justify-center;
}

/* Bottom Nav Links */
.nav-link {
    @apply text-white text-[11px] font-bold uppercase tracking-[0.25em] 
           transition-opacity duration-300 hover:opacity-60;
}

/* Material Icon adjustments */
.material-icons-outlined, .material-icons {
    font-size: 1.2rem;
}
.material-icons-outlined {
    font-family: 'Material Icons Outlined';
    font-weight: normal;
    font-style: normal;
    line-height: 1;
    display: inline-block;
    white-space: nowrap;
}

/* Tracking for pill buttons */
.pill-btn span:last-child {
    letter-spacing: 0.15em;
    font-size: 11px;
}

/* ============================================ */
/*          FULL-SCREEN MENU OVERLAY            */
/* ============================================ */
.menu-overlay {
    position: fixed;
    inset: 0;
    z-index: 40;
    background: rgba(0, 26, 44, 0.97);
    backdrop-filter: blur(20px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 100px; /* Clear the navbar */
    overflow-y: auto;
}

.menu-inner {
    display: flex;
    gap: 8vw;
    max-width: 1200px;
    width: 100%;
    padding: 2rem 4rem;
}

/* Columns */
.menu-column {
    flex: 1;
}
.menu-main {
    flex: 1.4;
}

/* Section Title */
.menu-section-title {
    color: #d4a373;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.25em;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 0.75rem;
}
.menu-section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 30px;
    height: 1px;
    background: #d4a373;
}

/* Main Links */
.menu-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.menu-links li {
    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.menu-link {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 0;
    text-decoration: none;
    color: white;
    transition: all 0.35s ease;
}
.menu-link:hover {
    padding-left: 1rem;
    color: #d4a373;
}

.menu-link-number {
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    opacity: 0.3;
    font-weight: 300;
    min-width: 24px;
}

.menu-link-text {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 400;
    letter-spacing: 0.02em;
}

/* Secondary Links */
.menu-secondary-group {
    margin-bottom: 2.5rem;
}

.menu-sub-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.menu-sub-links li {
    margin-bottom: 0.6rem;
}
.menu-sub-links a {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.85rem;
    letter-spacing: 0.03em;
    transition: all 0.3s ease;
}
.menu-sub-links a:hover {
    color: #d4a373;
    padding-left: 0.5rem;
}

/* Contact */
.menu-contact a {
    display: block;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.85rem;
    margin-bottom: 0.4rem;
    transition: color 0.3s;
}
.menu-contact a:hover {
    color: #d4a373;
}

/* Social Links */
.menu-socials {
    display: flex;
    gap: 1.5rem;
}
.social-icon {
    color: rgba(255,255,255,0.5);
    font-size: 0.75rem;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    transition: color 0.3s;
}
.social-icon:hover {
    color: #d4a373;
}

/* Admin Link */
.menu-admin-link {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.08);
}
.admin-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    transition: color 0.3s;
}
.admin-link:hover {
    color: #d4a373;
}

/* ============ TRANSITION ANIMATIONS ============ */
.menu-overlay-enter-active {
    transition: opacity 0.5s ease;
}
.menu-overlay-enter-active .menu-inner {
    animation: menuSlideUp 0.6s ease forwards;
}
.menu-overlay-leave-active {
    transition: opacity 0.4s ease;
}

.menu-overlay-enter-from,
.menu-overlay-leave-to {
    opacity: 0;
}

@keyframes menuSlideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============ RESPONSIVE ============ */
@media (max-width: 768px) {
    .menu-inner {
        flex-direction: column;
        gap: 3rem;
        padding: 1.5rem 2rem;
    }
    .menu-link-text {
        font-size: 1.3rem;
    }
}
</style>