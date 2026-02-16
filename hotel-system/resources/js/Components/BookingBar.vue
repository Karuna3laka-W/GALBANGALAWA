<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const weddingDate = ref('');
const guestCount = ref('100-250');

const checkAvailability = () => {
    if (!weddingDate.value) return alert('Please select a date.');
    router.get('/inquiry-details', { date: weddingDate.value, guests: guestCount.value });
};
</script>

<template>
    <div class="booking-anchor">
        <div class="booking-container">
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
                        <option value="250+">250+</option>
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
/* 2. The Anchor: This tells the browser NOT to move this section */
.booking-anchor {
    position: relative; /* Changing this from 'fixed' or 'sticky' to 'relative' is the key */
    width: 100%;
    height: 120px; /* Gives it a dedicated "home" on the page */
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fdfdfd; /* Matches your background */
    z-index: 10; /* Keeps it above the hero but below the navbar */
}

.booking-container {
    background: white;
    padding: 0.8rem 2rem;
    border-radius: 99px;
    display: flex;
    align-items: center;
    gap: 3rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.03);
}

.input-stack {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.field {
    display: flex;
    flex-direction: column;
}

.field label {
    font-size: 0.6rem;
    text-transform: uppercase;
    font-weight: 900;
    color: #b0b0b0;
    letter-spacing: 2px;
}

.ui-input {
    border: none;
    background: none;
    font-size: 0.9rem;
    font-weight: 700;
    outline: none;
    color: #222;
}

.separator {
    width: 1px;
    height: 30px;
    background: #eee;
}

.btn-check {
    background: #003154;
    color: white;
    padding: 14px 35px;
    border-radius: 99px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    transition: 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.btn-check:hover {
    background: #d4a373;
    transform: translateY(-3px);
}
</style>