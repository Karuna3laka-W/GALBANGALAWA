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
        y: 80,
        scale: 0.6,
        opacity: 0,
        duration: 1.8,
        delay: 0.5,
        ease: "elastic.out(1, 0.4)",
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
                
                <div class="separator hide-mobile"></div>
                
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
/* BASE STYLES (Desktop First) */
.booking-anchor {
    position: relative;
    width: 100%;
    min-height: 160px; 
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
    z-index: 20;
    margin-top: -80px; 
}

.booking-container {
    background: white;
    padding: 1.5rem 3.5rem; 
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 4rem; 
    box-shadow: 0 25px 60px -10px rgba(0, 49, 84, 0.25); 
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    width: auto;
}

.input-stack {
    display: flex;
    align-items: center;
    gap: 3rem;
}

.field {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.field label {
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 900;
    color: #b0b0b0;
    letter-spacing: 2px;
    margin-bottom: 6px;
}

.ui-input {
    border: none;
    background: none;
    font-size: 1.1rem;
    font-weight: 800;
    outline: none;
    color: #001a2c;
    cursor: pointer;
    min-width: 140px;
    transition: color 0.3s ease;
}

/* Added Focus State for Accessibility */
.ui-input:focus {
    color: #d4a373;
}

.separator {
    width: 1px;
    height: 45px;
    background: #e5e7eb;
}

.btn-check {
    background: #003154;
    color: white;
    padding: 18px 45px; 
    border-radius: 99px;
    font-size: 0.8rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 10px 20px rgba(0, 49, 84, 0.2);
    border: none;
    cursor: pointer;
}

.btn-check:hover {
    background: #d4a373;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 20px 40px rgba(212, 163, 115, 0.4);
}

/* RESPONSIVE BREAKPOINT (Mobile/Tablet) */
@media (max-width: 960px) {
    .booking-anchor {
        margin-top: -40px; 
        padding: 0 1.5rem;
        height: auto;
    }

    .booking-container {
        flex-direction: column;
        width: 100%;
        max-width: 450px;
        gap: 2rem;
        padding: 2.5rem 2rem;
        border-radius: 30px; /* Changes from pill to rounded box */
    }

    .input-stack {
        flex-direction: column;
        gap: 2rem;
        width: 100%;
    }

    .field {
        align-items: center;
        width: 100%;
    }

    .hide-mobile {
        display: none;
    }

    .ui-input {
        text-align: center;
        width: 100%;
        font-size: 1.2rem;
    }

    .btn-check {
        width: 100%;
        padding: 20px;
    }
}
</style>