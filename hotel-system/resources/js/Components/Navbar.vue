<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const isScrolled = ref(false);

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 50;
    });
});
</script>

<template>
    <nav :class="['navbar', { 'is-scrolled': isScrolled }]">
        <div class="nav-container">
            <h1 class="logo">GALBANGALAWA</h1>
            
            <div class="nav-links">
                <a href="#packages">Packages</a>
                <Link href="/login" class="btn-admin">Admin Panel</Link>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    padding: 2rem 5%;
    transition: all 0.4s ease;
    background: transparent;
    color: white;
}

.navbar.is-scrolled {
    padding: 1rem 5%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    color: #1e3a8a;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-weight: 800;
    letter-spacing: 0.2em;
    font-size: 1.2rem;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.nav-links a {
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
}

.btn-admin {
    border: 1px solid currentColor;
    padding: 0.6rem 1.2rem;
    border-radius: 999px;
    transition: all 0.3s ease;
}

.btn-admin:hover {
    background: currentColor;
    color: invert; /* Simple way to swap colors */
}
</style>