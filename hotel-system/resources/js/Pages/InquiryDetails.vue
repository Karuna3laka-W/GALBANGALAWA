<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import { gsap } from 'gsap'; //

const props = defineProps({
    selectedDate: String,
    selectedGuests: String
});

const customerName = ref('');
const customerPhone = ref('');
const ownerPhoneNumber = "94763593988"; 

// GSAP Animation Logic
onMounted(() => {
    const tl = gsap.timeline({ defaults: { ease: "power4.out" } });

    // 1. Fade in the background overlay
    tl.from(".overlay", {
        opacity: 0,
        duration: 1.5
    })
    // 2. Slide the form card up
    .from(".form-card", {
        y: 100,
        opacity: 0,
        duration: 1.2
    }, "-=1") // Overlap by 1 second
    // 3. Stagger the inner elements (Header, Summary, Inputs)
    .from(".card-header, .summary-box, .input-group, .btn-whatsapp", {
        y: 20,
        opacity: 0,
        duration: 0.8,
        stagger: 0.15 // Each element appears 0.15s after the previous
    }, "-=0.5");
});

const sendWhatsApp = () => {
    if (!customerName.value || !customerPhone.value) {
        alert('Please provide your name and phone number.');
        return;
    }

    const message = `*NEW WEDDING INQUIRY*%0A%0A` +
                    `*Guest Name:* ${customerName.value}%0A` +
                    `*Contact:* ${customerPhone.value}%0A` +
                    `*Wedding Date:* ${props.selectedDate}%0A` +
                    `*Estimated Guests:* ${props.selectedGuests}%0A%0A` +
                    `Please let me know if the date is available!`;
    
    const whatsappUrl = `https://wa.me/${ownerPhoneNumber}?text=${message}`;
    window.open(whatsappUrl, '_blank');
};
</script>

<template>
    <Head title="Wedding Inquiry Details" />

    <div class="min-h-screen bg-gray-50 font-sans">
        <Navbar />

        <main class="content-wrapper">
            <div class="page-header-bg">
                <div class="overlay"></div>
            </div>

            <div class="form-container">
                <div class="form-card">
                    <div class="card-header">
                        <h2 class="title">Complete Your Inquiry</h2>
                        <p class="subtitle">Provide your contact details to check availability</p>
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
                                <input v-model="customerName" type="text" placeholder="Enter your name" class="underlined-input" />
                            </div>

                            <div class="input-group">
                                <label>WhatsApp Number</label>
                                <input v-model="customerPhone" type="text" placeholder="+94 ..." class="underlined-input" />
                            </div>

                            <button 
    @click="sendWhatsApp" 
    class="flex items-center justify-center gap-3 w-full py-4 px-6 bg-[#25D366] hover:bg-[#128C7E] text-white font-bold rounded-xl uppercase tracking-widest text-xs transition-all duration-300 shadow-lg hover:shadow-green-500/20 transform hover:-translate-y-1 active:scale-95"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
    </svg>
    <span>Send WhatsApp Inquiry</span>
</button>
                            
                            <Link href="/" class="back-link">Return to Home</Link>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
/* Ensure content doesn't hide behind the fixed Navbar */
.content-wrapper {
    padding-top: 100px; 
    position: relative;
    min-height: 100vh;
}

/* Matching the Hero Background Style */
.page-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 400px;
    background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920');
    background-size: cover;
    background-position: center;
    z-index: 1;
}

.overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(30, 58, 138, 0.8), #f9fafb);
    z-index: 2;
}

.form-container {
    position: relative;
    z-index: 10;
    max-width: 500px;
    margin: 40px auto;
    padding: 0 20px;
}

.form-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: #1e3a8a;
    padding: 40px 30px;
    text-align: center;
    color: white;
}

.title {
    font-family: 'Playfair Display', serif;
    font-style: italic;
    font-size: 1.8rem;
    margin-bottom: 8px;
}

.subtitle {
    font-size: 0.8rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-body {
    padding: 40px 30px;
}

.summary-box {
    display: flex;
    background: #f8fafc;
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 30px;
}

.summary-item {
    flex: 1;
    text-align: center;
}

.summary-divider {
    width: 1px;
    background: #e2e8f0;
    margin: 0 15px;
}

.label {
    display: block;
    font-size: 0.6rem;
    text-transform: uppercase;
    color: #94a3b8;
    font-weight: 800;
    margin-bottom: 4px;
}

.value {
    font-weight: 700;
    color: #1e3a8a;
}

.input-stack {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.input-group label {
    display: block;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #475569;
    margin-bottom: 8px;
}

.underlined-input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #e2e8f0;
    padding: 10px 0;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.underlined-input:focus {
    border-color: #d4a373;
}

.btn-whatsapp {
    background: #25d366; /* WhatsApp Green */
    color: white;
    padding: 18px;
    border-radius: 12px;
    border: none;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2);
}

.btn-whatsapp:hover {
    background: #128c7e;
    transform: translateY(-2px);
}

.back-link {
    text-align: center;
    font-size: 0.75rem;
    color: #94a3b8;
    text-decoration: underline;
}
.btn-whatsapp {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px; /* Space between icon and text */
    
    background-color: #25D366; /* Official WhatsApp Green */
    color: white;
    
    padding: 18px 30px;
    border: none;
    border-radius: 12px;
    
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    
    cursor: pointer;
    box-shadow: 0 10px 20px rgba(37, 211, 102, 0.25);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-whatsapp:hover {
    background-color: #128C7E; /* Darker WhatsApp Teal */
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 30px rgba(18, 140, 126, 0.3);
}

.btn-whatsapp:active {
    transform: translateY(-1px);
}
</style>