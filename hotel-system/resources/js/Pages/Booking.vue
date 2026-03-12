<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import BottomBar from '@/Components/BottomBar.vue';

const props = defineProps({
    packages: Array,
    services: Array,
});

// ── Form State ──────────────────────────────
const currentStep = ref(1);
const totalSteps = 3;

const form = ref({
    // Step 1 – Stay Details
    checkIn: '',
    checkOut: '',
    adults: 2,
    children: 0,
    roomType: 'deluxe',

    // Step 2 – Package Selection
    selectedPackage: null,
    selectedServices: [],

    // Step 3 – Guest Info
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    country: 'Sri Lanka',
    specialRequests: '',
});

// ── Computed ────────────────────────────────
const nightCount = computed(() => {
    if (!form.value.checkIn || !form.value.checkOut) return 0;
    const d1 = new Date(form.value.checkIn);
    const d2 = new Date(form.value.checkOut);
    const diff = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
    return diff > 0 ? diff : 0;
});

const selectedPkg = computed(() => {
    if (!form.value.selectedPackage) return null;
    return props.packages.find(p => p.id === form.value.selectedPackage);
});

const canContinue = computed(() => {
    if (currentStep.value === 1) {
        return form.value.checkIn && form.value.checkOut && nightCount.value > 0;
    }
    if (currentStep.value === 2) return true; // package is optional
    if (currentStep.value === 3) {
        return form.value.firstName && form.value.lastName && form.value.email && form.value.phone;
    }
    return false;
});

// ── Minimum date helpers ────────────────────
const today = new Date().toISOString().split('T')[0];
const minCheckOut = computed(() => {
    if (!form.value.checkIn) return today;
    const d = new Date(form.value.checkIn);
    d.setDate(d.getDate() + 1);
    return d.toISOString().split('T')[0];
});

// ── Room Types ──────────────────────────────
const roomTypes = [
    { value: 'standard', label: 'Standard Room', desc: 'Comfortable essentials with garden views', price: '$120' },
    { value: 'deluxe', label: 'Deluxe Room', desc: 'Spacious luxury with private balcony', price: '$195' },
    { value: 'suite', label: 'Premium Suite', desc: 'Full living area, panoramic lake views', price: '$350' },
    { value: 'villa', label: 'Private Villa', desc: 'Ultimate privacy with plunge pool', price: '$520' },
];

// ── Methods ─────────────────────────────────
const nextStep = () => {
    if (currentStep.value < totalSteps) currentStep.value++;
};

const prevStep = () => {
    if (currentStep.value > 1) currentStep.value--;
};

const toggleService = (id) => {
    const idx = form.value.selectedServices.indexOf(id);
    if (idx === -1) form.value.selectedServices.push(id);
    else form.value.selectedServices.splice(idx, 1);
};

const submitted = ref(false);
const isSubmitting = ref(false);

const submitBooking = () => {
    isSubmitting.value = true;
    router.post('/booking', {
        check_in: form.value.checkIn,
        check_out: form.value.checkOut,
        adults: form.value.adults,
        children: form.value.children,
        room_type: form.value.roomType,
        package_id: form.value.selectedPackage,
        service_ids: form.value.selectedServices,
        first_name: form.value.firstName,
        last_name: form.value.lastName,
        email: form.value.email,
        phone: form.value.phone,
        country: form.value.country,
        special_requests: form.value.specialRequests,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            isSubmitting.value = false;
        },
        onError: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="Book Your Stay – Hotel Galbangalawa" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <div class="booking-page">
        <Navbar />

        <!-- ========== HERO BANNER ========== -->
        <section class="booking-hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <span class="hero-eyebrow">Reservations</span>
                <h1 class="hero-title">Book Your Stay</h1>
                <p class="hero-sub">Experience the healing power of nature at Hotel Galbangalawa</p>
            </div>
        </section>

        <!-- ========== SUCCESS STATE ========== -->
        <section v-if="submitted" class="success-section">
            <div class="success-card">
                <div class="success-icon-wrap">
                    <span class="material-icons-outlined" style="font-size:48px;color:#d4a373;">check_circle</span>
                </div>
                <h2 class="success-title">Booking Submitted!</h2>
                <p class="success-text">Thank you, {{ form.firstName }}. We've received your reservation request and will confirm within 24 hours.</p>
                <div class="success-details">
                    <div class="detail-row">
                        <span class="detail-label">Check-in</span>
                        <span class="detail-value">{{ form.checkIn }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Check-out</span>
                        <span class="detail-value">{{ form.checkOut }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Guests</span>
                        <span class="detail-value">{{ form.adults }} Adults, {{ form.children }} Children</span>
                    </div>
                    <div class="detail-row" v-if="selectedPkg">
                        <span class="detail-label">Package</span>
                        <span class="detail-value">{{ selectedPkg.name }}</span>
                    </div>
                </div>
                <Link href="/" class="btn-back-home">
                    <span class="material-icons-outlined" style="font-size:18px;">arrow_back</span>
                    Return Home
                </Link>
            </div>
        </section>

        <!-- ========== BOOKING FORM ========== -->
        <section v-else class="booking-form-section">
            <div class="form-wrapper">

                <!-- Progress Bar -->
                <div class="progress-bar">
                    <div class="progress-steps">
                        <div v-for="step in totalSteps" :key="step" 
                             class="progress-step" :class="{ active: currentStep >= step, current: currentStep === step }">
                            <div class="step-circle">{{ step }}</div>
                            <span class="step-label">{{ ['Stay Details', 'Packages', 'Your Info'][step - 1] }}</span>
                        </div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" :style="{ width: ((currentStep - 1) / (totalSteps - 1)) * 100 + '%' }"></div>
                    </div>
                </div>

                <!-- ── STEP 1: Stay Details ── -->
                <Transition name="step-fade" mode="out-in">
                    <div v-if="currentStep === 1" key="step1" class="step-content">
                        <h2 class="step-title">When would you like to stay?</h2>
                        <p class="step-desc">Select your preferred dates and room configuration</p>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label>Check-in Date</label>
                                <input v-model="form.checkIn" type="date" :min="today" class="form-input" />
                            </div>
                            <div class="form-field">
                                <label>Check-out Date</label>
                                <input v-model="form.checkOut" type="date" :min="minCheckOut" class="form-input" />
                            </div>
                        </div>

                        <div v-if="nightCount > 0" class="night-badge">
                            <span class="material-icons-outlined" style="font-size:16px;">nights_stay</span>
                            {{ nightCount }} Night{{ nightCount > 1 ? 's' : '' }}
                        </div>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label>Adults</label>
                                <div class="counter">
                                    <button @click="form.adults = Math.max(1, form.adults - 1)" class="counter-btn">−</button>
                                    <span class="counter-value">{{ form.adults }}</span>
                                    <button @click="form.adults = Math.min(10, form.adults + 1)" class="counter-btn">+</button>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>Children</label>
                                <div class="counter">
                                    <button @click="form.children = Math.max(0, form.children - 1)" class="counter-btn">−</button>
                                    <span class="counter-value">{{ form.children }}</span>
                                    <button @click="form.children = Math.min(6, form.children + 1)" class="counter-btn">+</button>
                                </div>
                            </div>
                        </div>

                        <h3 class="sub-heading">Select Room Type</h3>
                        <div class="room-grid">
                            <div v-for="room in roomTypes" :key="room.value"
                                 class="room-card" :class="{ selected: form.roomType === room.value }"
                                 @click="form.roomType = room.value">
                                <div class="room-card-top">
                                    <h4>{{ room.label }}</h4>
                                    <span class="room-price">{{ room.price }}<small>/night</small></span>
                                </div>
                                <p class="room-desc">{{ room.desc }}</p>
                                <div class="room-check">
                                    <span v-if="form.roomType === room.value" class="material-icons-outlined" style="font-size:20px;color:#d4a373;">check_circle</span>
                                    <span v-else class="material-icons-outlined" style="font-size:20px;opacity:0.3;">radio_button_unchecked</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>

                <!-- ── STEP 2: Packages & Services ── -->
                <Transition name="step-fade" mode="out-in">
                    <div v-if="currentStep === 2" key="step2" class="step-content">
                        <h2 class="step-title">Enhance Your Stay</h2>
                        <p class="step-desc">Choose a package and add-on services (optional)</p>

                        <!-- Packages -->
                        <h3 class="sub-heading">Available Packages</h3>
                        <div class="package-grid" v-if="packages && packages.length">
                            <div v-for="pkg in packages" :key="pkg.id"
                                 class="pkg-card" :class="{ selected: form.selectedPackage === pkg.id }"
                                 @click="form.selectedPackage = form.selectedPackage === pkg.id ? null : pkg.id">
                                <div class="pkg-badge" v-if="pkg.has_offer">{{ pkg.offer_percent }}% OFF</div>
                                <h4 class="pkg-name">{{ pkg.name }}</h4>
                                <p class="pkg-desc">{{ pkg.description }}</p>
                                <div class="pkg-footer">
                                    <span class="pkg-price">
                                        <template v-if="pkg.has_offer">
                                            <s class="old-price">LKR {{ Number(pkg.price).toLocaleString() }}</s>
                                            LKR {{ Math.round(pkg.price * (1 - pkg.offer_percent / 100)).toLocaleString() }}
                                        </template>
                                        <template v-else>
                                            LKR {{ Number(pkg.price).toLocaleString() }}
                                        </template>
                                    </span>
                                    <span class="pkg-select-icon">
                                        <span v-if="form.selectedPackage === pkg.id" class="material-icons-outlined" style="color:#d4a373;">check_circle</span>
                                        <span v-else class="material-icons-outlined" style="opacity:0.3;">add_circle_outline</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p v-else class="no-data">No packages available at this time.</p>

                        <!-- Services -->
                        <h3 class="sub-heading" style="margin-top:3rem;">Add-on Services</h3>
                        <div class="services-grid" v-if="services && services.length">
                            <div v-for="svc in services" :key="svc.id"
                                 class="svc-card" :class="{ selected: form.selectedServices.includes(svc.id) }"
                                 @click="toggleService(svc.id)">
                                <img v-if="svc.image_path" :src="'/storage/' + svc.image_path" :alt="svc.title" class="svc-img" />
                                <div class="svc-info">
                                    <h4>{{ svc.title }}</h4>
                                    <p>{{ svc.subtitle }}</p>
                                </div>
                                <span class="svc-check">
                                    <span v-if="form.selectedServices.includes(svc.id)" class="material-icons-outlined" style="color:#d4a373;">check_circle</span>
                                    <span v-else class="material-icons-outlined" style="opacity:0.3;">add_circle_outline</span>
                                </span>
                            </div>
                        </div>
                        <p v-else class="no-data">No additional services available.</p>
                    </div>
                </Transition>

                <!-- ── STEP 3: Guest Info ── -->
                <Transition name="step-fade" mode="out-in">
                    <div v-if="currentStep === 3" key="step3" class="step-content">
                        <h2 class="step-title">Almost There</h2>
                        <p class="step-desc">Please provide your contact details to complete the reservation</p>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label>First Name *</label>
                                <input v-model="form.firstName" type="text" placeholder="John" class="form-input" />
                            </div>
                            <div class="form-field">
                                <label>Last Name *</label>
                                <input v-model="form.lastName" type="text" placeholder="Doe" class="form-input" />
                            </div>
                        </div>
                        <div class="form-grid-2">
                            <div class="form-field">
                                <label>Email Address *</label>
                                <input v-model="form.email" type="email" placeholder="john@example.com" class="form-input" />
                            </div>
                            <div class="form-field">
                                <label>Phone Number *</label>
                                <input v-model="form.phone" type="tel" placeholder="+94 77 123 4567" class="form-input" />
                            </div>
                        </div>
                        <div class="form-field" style="margin-top:1rem;">
                            <label>Country</label>
                            <select v-model="form.country" class="form-input">
                                <option>Sri Lanka</option>
                                <option>India</option>
                                <option>United Kingdom</option>
                                <option>United States</option>
                                <option>Australia</option>
                                <option>Germany</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-field" style="margin-top:1rem;">
                            <label>Special Requests</label>
                            <textarea v-model="form.specialRequests" rows="4" placeholder="Any special requirements, dietary needs, celebrations..." class="form-input form-textarea"></textarea>
                        </div>

                        <!-- Summary -->
                        <div class="booking-summary">
                            <h3 class="summary-title">Booking Summary</h3>
                            <div class="summary-row">
                                <span>Room</span>
                                <span>{{ roomTypes.find(r => r.value === form.roomType)?.label }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Dates</span>
                                <span>{{ form.checkIn }} → {{ form.checkOut }} ({{ nightCount }} nights)</span>
                            </div>
                            <div class="summary-row">
                                <span>Guests</span>
                                <span>{{ form.adults }} Adults, {{ form.children }} Children</span>
                            </div>
                            <div class="summary-row" v-if="selectedPkg">
                                <span>Package</span>
                                <span>{{ selectedPkg.name }}</span>
                            </div>
                            <div class="summary-row" v-if="form.selectedServices.length">
                                <span>Add-ons</span>
                                <span>{{ form.selectedServices.length }} service(s)</span>
                            </div>
                        </div>
                    </div>
                </Transition>

                <!-- Navigation Buttons -->
                <div class="step-nav">
                    <button v-if="currentStep > 1" @click="prevStep" class="btn-prev">
                        <span class="material-icons-outlined" style="font-size:18px;">arrow_back</span>
                        Back
                    </button>
                    <div v-else></div>

                    <button v-if="currentStep < totalSteps" @click="nextStep" :disabled="!canContinue" class="btn-next">
                        Continue
                        <span class="material-icons-outlined" style="font-size:18px;">arrow_forward</span>
                    </button>
                    <button v-else @click="submitBooking" :disabled="!canContinue || isSubmitting" class="btn-submit">
                        <span class="material-icons-outlined" style="font-size:18px;">{{ isSubmitting ? 'hourglass_top' : 'lock' }}</span>
                        {{ isSubmitting ? 'Submitting...' : 'Confirm Booking' }}
                    </button>
                </div>

            </div>
        </section>

        <BottomBar />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap');

/* ═══════════════════════════════════════════ */
/*              PAGE ROOT                      */
/* ═══════════════════════════════════════════ */
.booking-page {
    background: #f8f6f3;
    min-height: 100vh;
    color: #001a2c;
    font-family: 'Montserrat', sans-serif;
}

/* ═══════════════════════════════════════════ */
/*              HERO BANNER                    */
/* ═══════════════════════════════════════════ */
.booking-hero {
    position: relative;
    height: 45vh;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1470') center/cover no-repeat;
    overflow: hidden;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,26,44,0.8) 0%, rgba(11,36,47,0.7) 100%);
}
.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}
.hero-eyebrow {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.35em;
    color: #d4a373;
    margin-bottom: 1rem;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 400;
    margin-bottom: 0.75rem;
}
.hero-sub {
    font-size: 0.9rem;
    opacity: 0.7;
    letter-spacing: 0.04em;
}

/* ═══════════════════════════════════════════ */
/*              FORM SECTION                   */
/* ═══════════════════════════════════════════ */
.booking-form-section {
    max-width: 900px;
    margin: -60px auto 4rem;
    padding: 0 1.5rem;
    position: relative;
    z-index: 10;
}

.form-wrapper {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 30px 80px -20px rgba(0,26,44,0.12);
}

/* ═══════════════════════════════════════════ */
/*              PROGRESS BAR                   */
/* ═══════════════════════════════════════════ */
.progress-bar {
    margin-bottom: 3rem;
    position: relative;
}
.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}
.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}
.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    background: #e8e4df;
    color: #999;
    transition: all 0.4s ease;
}
.progress-step.active .step-circle {
    background: #001a2c;
    color: white;
}
.progress-step.current .step-circle {
    background: #d4a373;
    color: white;
    box-shadow: 0 4px 20px rgba(212,163,115,0.4);
}
.step-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #999;
    transition: color 0.3s;
}
.progress-step.active .step-label {
    color: #001a2c;
}
.progress-track {
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: #e8e4df;
    z-index: 1;
}
.progress-fill {
    height: 100%;
    background: #d4a373;
    transition: width 0.5s ease;
}

/* ═══════════════════════════════════════════ */
/*              STEP CONTENT                   */
/* ═══════════════════════════════════════════ */
.step-content {
    min-height: 400px;
}
.step-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 400;
    color: #001a2c;
    margin-bottom: 0.3rem;
}
.step-desc {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 2rem;
}
.sub-heading {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: #d4a373;
    margin: 2rem 0 1rem;
}

/* ═══════════════════════════════════════════ */
/*              FORM FIELDS                    */
/* ═══════════════════════════════════════════ */
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 0.5rem;
}
.form-field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.form-field label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #999;
}
.form-input {
    border: 1.5px solid #e8e4df;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 0.95rem;
    font-family: 'Montserrat', sans-serif;
    color: #001a2c;
    background: #fafaf8;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.form-input:focus {
    border-color: #d4a373;
    box-shadow: 0 0 0 3px rgba(212,163,115,0.15);
}
.form-textarea {
    resize: vertical;
    min-height: 100px;
}

/* Night Badge */
.night-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #001a2c;
    color: #d4a373;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    margin: 0.75rem 0 1rem;
}

/* Counter */
.counter {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fafaf8;
    border: 1.5px solid #e8e4df;
    border-radius: 12px;
    padding: 8px 16px;
    width: fit-content;
}
.counter-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid #ddd;
    background: white;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    color: #001a2c;
}
.counter-btn:hover {
    background: #001a2c;
    color: white;
    border-color: #001a2c;
}
.counter-value {
    font-size: 1.1rem;
    font-weight: 700;
    min-width: 24px;
    text-align: center;
}

/* ═══════════════════════════════════════════ */
/*              ROOM CARDS                     */
/* ═══════════════════════════════════════════ */
.room-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.room-card {
    border: 1.5px solid #e8e4df;
    border-radius: 16px;
    padding: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    background: #fafaf8;
}
.room-card:hover {
    border-color: #d4a373;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,163,115,0.12);
}
.room-card.selected {
    border-color: #d4a373;
    background: linear-gradient(135deg, rgba(212,163,115,0.05), rgba(212,163,115,0.1));
    box-shadow: 0 8px 24px rgba(212,163,115,0.15);
}
.room-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.3rem;
}
.room-card-top h4 {
    font-size: 0.95rem;
    font-weight: 700;
    color: #001a2c;
}
.room-price {
    font-size: 1rem;
    font-weight: 800;
    color: #d4a373;
}
.room-price small {
    font-size: 0.6rem;
    font-weight: 500;
    opacity: 0.7;
}
.room-desc {
    font-size: 0.75rem;
    color: #888;
    line-height: 1.5;
}
.room-check {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

/* ═══════════════════════════════════════════ */
/*         PACKAGE CARDS (Step 2)               */
/* ═══════════════════════════════════════════ */
.package-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1rem;
}
.pkg-card {
    border: 1.5px solid #e8e4df;
    border-radius: 16px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    background: #fafaf8;
}
.pkg-card:hover {
    border-color: #d4a373;
    transform: translateY(-2px);
}
.pkg-card.selected {
    border-color: #d4a373;
    background: linear-gradient(135deg, rgba(212,163,115,0.05), rgba(212,163,115,0.1));
}
.pkg-badge {
    position: absolute;
    top: -10px;
    right: 16px;
    background: #d4a373;
    color: white;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: 999px;
    letter-spacing: 0.05em;
}
.pkg-name {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
    color: #001a2c;
}
.pkg-desc {
    font-size: 0.78rem;
    color: #888;
    line-height: 1.5;
    margin-bottom: 1rem;
}
.pkg-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pkg-price {
    font-size: 0.9rem;
    font-weight: 800;
    color: #001a2c;
}
.old-price {
    color: #ccc;
    font-size: 0.75rem;
    margin-right: 0.4rem;
}

/* ═══════════════════════════════════════════ */
/*         SERVICE CARDS (Step 2)               */
/* ═══════════════════════════════════════════ */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem;
}
.svc-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1.5px solid #e8e4df;
    border-radius: 16px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafaf8;
}
.svc-card:hover {
    border-color: #d4a373;
}
.svc-card.selected {
    border-color: #d4a373;
    background: linear-gradient(135deg, rgba(212,163,115,0.05), rgba(212,163,115,0.1));
}
.svc-img {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    object-fit: cover;
}
.svc-info h4 {
    font-size: 0.85rem;
    font-weight: 700;
    color: #001a2c;
}
.svc-info p {
    font-size: 0.72rem;
    color: #888;
}
.svc-check {
    margin-left: auto;
}
.no-data {
    font-size: 0.85rem;
    color: #bbb;
    padding: 2rem 0;
    text-align: center;
    font-style: italic;
}

/* ═══════════════════════════════════════════ */
/*         BOOKING SUMMARY (Step 3)             */
/* ═══════════════════════════════════════════ */
.booking-summary {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #001a2c;
    border-radius: 16px;
    color: white;
}
.summary-title {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: #d4a373;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.85rem;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.summary-row span:first-child {
    color: rgba(255,255,255,0.5);
}
.summary-row span:last-child {
    font-weight: 600;
}

/* ═══════════════════════════════════════════ */
/*        NAVIGATION BUTTONS                    */
/* ═══════════════════════════════════════════ */
.step-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}
.btn-prev {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: 1.5px solid #ddd;
    border-radius: 999px;
    padding: 12px 28px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #666;
    cursor: pointer;
    transition: all 0.3s;
    font-family: 'Montserrat', sans-serif;
}
.btn-prev:hover {
    border-color: #001a2c;
    color: #001a2c;
}
.btn-next, .btn-submit {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #001a2c;
    color: white;
    border: none;
    border-radius: 999px;
    padding: 14px 36px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.4s ease;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 0.03em;
}
.btn-next:hover, .btn-submit:hover {
    background: #d4a373;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(212,163,115,0.3);
}
.btn-next:disabled, .btn-submit:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* ═══════════════════════════════════════════ */
/*         SUCCESS STATE                        */
/* ═══════════════════════════════════════════ */
.success-section {
    max-width: 600px;
    margin: -60px auto 4rem;
    padding: 0 1.5rem;
    position: relative;
    z-index: 10;
}
.success-card {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    text-align: center;
    box-shadow: 0 30px 80px -20px rgba(0,26,44,0.12);
}
.success-icon-wrap {
    margin-bottom: 1.5rem;
}
.success-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 400;
    color: #001a2c;
    margin-bottom: 0.75rem;
}
.success-text {
    font-size: 0.9rem;
    color: #888;
    margin-bottom: 2rem;
}
.success-details {
    background: #f8f6f3;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}
.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.6rem 0;
    border-bottom: 1px solid #eee;
    font-size: 0.85rem;
}
.detail-row:last-child { border-bottom: none; }
.detail-label { color: #999; }
.detail-value { font-weight: 600; color: #001a2c; }
.btn-back-home {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #001a2c;
    color: white;
    text-decoration: none;
    padding: 14px 32px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.85rem;
    transition: all 0.3s;
}
.btn-back-home:hover {
    background: #d4a373;
}

/* ═══════════════════════════════════════════ */
/*         TRANSITIONS                          */
/* ═══════════════════════════════════════════ */
.step-fade-enter-active {
    transition: all 0.4s ease;
}
.step-fade-leave-active {
    transition: all 0.25s ease;
}
.step-fade-enter-from {
    opacity: 0;
    transform: translateX(30px);
}
.step-fade-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}

/* ═══════════════════════════════════════════ */
/*         MATERIAL ICONS                       */
/* ═══════════════════════════════════════════ */
.material-icons-outlined {
    font-family: 'Material Icons Outlined';
    font-weight: normal;
    font-style: normal;
    line-height: 1;
    display: inline-block;
    white-space: nowrap;
    vertical-align: middle;
}

/* ═══════════════════════════════════════════ */
/*         RESPONSIVE                           */
/* ═══════════════════════════════════════════ */
@media (max-width: 768px) {
    .form-wrapper { padding: 2rem 1.5rem; }
    .form-grid-2 { grid-template-columns: 1fr; }
    .room-grid { grid-template-columns: 1fr; }
    .step-label { display: none; }
    .progress-track { left: 30px; right: 30px; }
    .step-title { font-size: 1.4rem; }
}
</style>
