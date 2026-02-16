<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import { gsap } from 'gsap';

const props = defineProps({
    selectedDate: String,
    selectedGuests: String
});

const customerName = ref('');
const customerPhone = ref('');
const ownerPhoneNumber = "94763593988"; 

onMounted(() => {
    const tl = gsap.timeline({ defaults: { ease: "power4.out" } });

    tl.from(".page-header-bg", { opacity: 0, scale: 1.1, duration: 2 })
      .from(".form-card", { y: 60, opacity: 0, duration: 1.5 }, "-=1.2")
      .from(".card-header, .summary-box, .input-group, .action-area", {
          y: 30,
          opacity: 0,
          duration: 1,
          stagger: 0.15
      }, "-=0.8");
});

const sendWhatsApp = () => {
    if (!customerName.value || !customerPhone.value) {
        alert('Please provide your name and contact details.');
        return;
    }

    const message = `*NEW WEDDING INQUIRY*%0A%0A` +
                    `*Guest Name:* ${customerName.value}%0A` +
                    `*Contact:* ${customerPhone.value}%0A` +
                    `*Wedding Date:* ${props.selectedDate}%0A` +
                    `*Estimated Guests:* ${props.selectedGuests}%0A%0A` +
                    `Please let me know if the date is available!`;
    
    window.open(`https://wa.me/${ownerPhoneNumber}?text=${message}`, '_blank');
};
</script>

<template>
    <Head title="Wedding Inquiry Details" />

    <div class="min-h-screen bg-[#f8f9fa] font-sans overflow-x-hidden">
        <Navbar />

        <main class="content-wrapper">
            <div class="page-header-bg">
                <div class="navy-overlay"></div>
            </div>

            <div class="form-container">
                <div class="form-card">
                    <div class="gold-top-bar"></div>

                    <div class="card-header">
                        <span class="tag">Reservation</span>
                        <h2 class="title">Check Availability</h2>
                    </div>

                    <div class="card-body">
                        <div class="summary-box">
                            <div class="summary-item">
                                <span class="label">Wedding Date</span>
                                <span class="value">{{ selectedDate }}</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-item">
                                <span class="label">Guests</span>
                                <span class="value">{{ selectedGuests }}</span>
                            </div>
                        </div>

                        <div class="input-stack">
                            <div class="input-group">
                                <label>Your Full Name</label>
                                <input v-model="customerName" type="text" placeholder="Type Your Name" class="custom-input" />
                            </div>

                            <div class="input-group">
                                <label>WhatsApp Number</label>
                                <input v-model="customerPhone" type="text" placeholder="+94 77 000 0000" class="custom-input" />
                            </div>

                            <div class="action-area pt-4">
                                <button @click="sendWhatsApp" class="luxury-btn">
                                    <div class="btn-reflection"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                    </svg>
                                    <span>Send Inquiry via WhatsApp</span>
                                    <div class="gold-line"></div>
                                </button>
                                
                                <Link href="/" class="back-link">Return to Home</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.content-wrapper {
    padding-top: 120px; 
    position: relative;
    min-height: 100vh;
}

.page-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 500px;
    background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920');
    background-size: cover;
    background-position: center;
    z-index: 1;
}

.navy-overlay {
    position: absolute;
    inset: 0;
    /* Using your Deep Navy for the gradient overlay */
    background: linear-gradient(to bottom, rgba(0, 26, 44, 0.9), #f8f9fa);
    z-index: 2;
}

.form-container {
    position: relative;
    z-index: 10;
    max-width: 520px;
    margin: 40px auto;
    padding: 0 20px;
}

.form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 40px 80px -20px rgba(0, 26, 44, 0.15);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
}

.gold-top-bar {
    height: 6px;
    background: #d4a373;
    width: 100%;
}

.card-header {
    background: #001a2c;
    padding: 50px 30px;
    text-align: center;
    color: white;
}

.tag {
    color: #d4a373;
    text-transform: uppercase;
    font-size: 0.65rem;
    font-weight: 900;
    letter-spacing: 0.4em;
    display: block;
    margin-bottom: 12px;
}

.title {
    font-family: 'serif';
    font-style: italic;
    font-size: 2.2rem;
    font-weight: 300;
}

.card-body {
    padding: 45px 40px;
}

.summary-box {
    display: flex;
    background: #ffffff;
    padding: 24px;
    border: 1px solid #f1f5f9;
    border-radius: 8px;
    margin-bottom: 35px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.summary-item {
    flex: 1;
    text-align: center;
}

.summary-divider {
    width: 1px;
    background: #e2e8f0;
    margin: 0 20px;
}

.label {
    display: block;
    font-size: 0.6rem;
    text-transform: uppercase;
    color: #94a3b8;
    font-weight: 900;
    letter-spacing: 0.1em;
    margin-bottom: 6px;
}

.value {
    font-weight: 700;
    color: #001a2c;
    font-size: 0.95rem;
}

.input-group label {
    display: block;
    font-size: 0.7rem;
    font-weight: 900;
    text-transform: uppercase;
    color: #001a2c;
    letter-spacing: 0.1em;
    margin-bottom: 10px;
}

.custom-input {
    width: 100%;
    border: 2px solid #f1f5f9;
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    font-size: 0.95rem;
    outline: none;
    transition: all 0.4s ease;
    color: #001a2c;
}

.custom-input:focus {
    border-color: #d4a373;
    background: white;
    box-shadow: 0 10px 20px rgba(212, 163, 115, 0.1);
}

/* Luxury Action Button */
.luxury-btn {
    @apply relative overflow-hidden bg-[#001a2c] text-white w-full py-5 rounded-lg flex items-center justify-center gap-4 transition-all duration-700;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.2em;
}

.luxury-btn:hover {
    @apply shadow-2xl;
    box-shadow: 0 20px 40px -10px rgba(0, 26, 44, 0.4);
    transform: translateY(-4px);
}

.btn-reflection {
    @apply absolute -inset-full bg-gradient-to-r from-transparent via-white/10 to-transparent;
    transform: rotate(45deg) translateX(-100%);
    transition: transform 0.8s ease-in-out;
}

.luxury-btn:hover .btn-reflection {
    transform: rotate(45deg) translateX(100%);
}

.gold-line {
    @apply absolute bottom-0 left-0 h-[3px] bg-[#d4a373] transition-all duration-700 w-0;
}

.luxury-btn:hover .gold-line {
    @apply w-full;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 25px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 0.15em;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #001a2c;
}
</style>