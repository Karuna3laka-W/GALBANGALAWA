<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// 1. Reactive state to capture user input
const weddingDate = ref('');
const guestCount = ref('');

// 2. Redirect function
const checkAvailability = () => {
    if (!weddingDate.value || !guestCount.value) {
        alert('Please select your wedding date and estimated guest count.');
        return;
    }

    // Redirect to the new page with data in the URL
    router.get('/inquiry-details', {
        date: weddingDate.value,
        guests: guestCount.value
    });
};

onMounted(() => {
    gsap.to(".booking-container", {
        scrollTrigger: {
            trigger: ".booking-container",
            start: "top bottom", 
            end: "top 20%",     
            scrub: 1,           
        },
        backgroundColor: "#ffffff",
        boxShadow: "0px 10px 40px rgba(0,0,0,0.15)",
        borderRadius: "15px",
        y: -10,
        duration: 1
    });
});
</script>

<template>
    <section class="booking-wrapper">
        <div class="booking-container">
            <div class="booking-grid">
                <div class="input-group">
                    <label>Wedding Date</label>
                    <input v-model="weddingDate" type="date" class="wedding-input" />
                </div>

                <div class="input-group">
                    <label>Estimated Guests</label>
                    <select v-model="guestCount" class="wedding-input">
                        <option value="">Select range</option>
                        <option value="Under 50">Under 50 guests</option>
                        <option value="50-150">50 - 150 guests</option>
                        <option value="150-300">150 - 300 guests</option>
                        <option value="300+">300+ guests</option>
                    </select>
                </div>

                <div class="action-group">
                    <button @click="checkAvailability" class="btn-submit">
                        Check Availability
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.booking-wrapper {
    max-width: 1100px;
    margin: -60px auto 0;
    padding: 0 20px;
    position: sticky;
    top: 80px; /* Adjust based on your navbar height */
    z-index: 50;
}

.booking-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(12px);
    padding: 35px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.booking-grid {
    display: grid;
    grid-template-columns: 2fr 2fr 1.5fr;
    gap: 30px;
    align-items: flex-end;
}

.input-group label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 12px;
    color: #1e3a8a;
}

.wedding-input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 0;
    background: transparent;
    font-size: 1rem;
    outline: none;
}

.btn-submit {
    width: 100%;
    background: #1e3a8a;
    color: white;
    padding: 16px;
    border: none;
    font-weight: 800;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background: #d4a373;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .booking-grid { grid-template-columns: 1fr; }
}
</style>