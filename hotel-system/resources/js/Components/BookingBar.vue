<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import gsap from 'gsap';

const weddingDate = ref('');
const guestCount = ref('100-250');
const bookingBarRef = ref(null);

const checkAvailability = () => {
    if (!weddingDate.value) return alert('Please select a date.');
    router.get('/inquiry-details', { date: weddingDate.value, guests: guestCount.value });
};

onMounted(() => {
    // The "Water Bubble" Pop-up Animation
    gsap.from(bookingBarRef.value, {
        y: 80,          // Starts 80px lower (underwater)
        scale: 0.6,     // Starts smaller
        opacity: 0,     // Invisible initially
        duration: 1.8,  // Long duration for that "heavy liquid" feel
        delay: 0.5,     // Wait 0.5s so the Hero finishes loading first
        ease: "elastic.out(1, 0.4)", // The magic bounce (Wobbly like a bubble)
        force3D: true
    });
});
</script>

<template>
    <div class="booking-anchor">
        <div ref="bookingBarRef" class="booking-container">
            <div class="input-stack">
                <div class="field">
                    <label>Preferred Date</label>
                    <input v-model="weddingDate" type="date" class="ui-input" />
                </div>
                
                <div class="separator"></div>
                
                <div class="field">
                    <label>Guests</label>
                    <select v-model="guestCount" class="ui-input">
                        <option value="50-100">50 - 100</option>
                        <option value="100-250">100 - 250</option>
                        <option value="250+">250</option>
                        <option value="250+">500</option>
                    </select>
                </div>
            </div>

            <button @click="checkAvailability" class="btn-check">
                Check Availability
            </button>
        </div>
    </div>
</template>

<style scoped>
.booking-anchor {
    position: relative;
    width: 100%;
    /* Increased height to fit the bigger pill */
    height: 160px; 
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
    z-index: 20;
    /* Pulls it up more to float nicely between sections */
    margin-top: -80px; 
}

.booking-container {
    background: white;
    /* BIGGER PILL: Increased padding top/bottom and left/right */
    padding: 1.5rem 3.5rem; 
    border-radius: 999px;
    display: flex;
    align-items: center;
    /* More space between the inputs */
    gap: 4rem; 
    /* Deeper shadow for that "heavy float" look */
    box-shadow: 0 25px 60px -10px rgba(0, 49, 84, 0.25); 
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
}

.input-stack {
    display: flex;
    align-items: center;
    gap: 3rem; /* More breathing room between Date and Guests */
}

.field {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.field label {
    font-size: 0.7rem; /* Slightly larger label */
    text-transform: uppercase;
    font-weight: 900;
    color: #b0b0b0;
    letter-spacing: 2px;
    margin-bottom: 6px;
}

.ui-input {
    border: none;
    background: none;
    font-size: 1.1rem; /* Larger text for the actual input */
    font-weight: 800;
    outline: none;
    color: #001a2c;
    cursor: pointer;
    min-width: 140px; /* Ensures they don't look cramped */
}

.separator {
    width: 1px;
    height: 45px; /* Taller divider */
    background: #e5e7eb;
}

.btn-check {
    background: #003154;
    color: white;
    /* Larger Button */
    padding: 18px 45px; 
    border-radius: 99px;
    font-size: 0.8rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 10px 20px rgba(0, 49, 84, 0.2);
}

.btn-check:hover {
    background: #d4a373;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 20px 40px rgba(212, 163, 115, 0.4);
}
</style>