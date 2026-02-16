<script setup>
// No complex logic needed here, primarily a styling and layout component
</script>

<template>
    <div class="glass-bridge-container">
        <div class="glass-element">
            <div class="content">
                <span class="eyebrow">Discover</span>
                <h3 class="title">Our Curated Packages</h3>
            </div>
        </div>
    </div>
</template>

<style scoped>
.glass-bridge-container {
    position: relative;
    width: 100%;
    /* This creates the vertical space you requested */
    height: 350px; 
    /* Gradient flows from your Map Navy (#001a2c) to a soft off-white (#f9fafb) */
   background: linear-gradient(to bottom, #f9fafb 0%, #001a2c 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 5;
    overflow: hidden;
}

.glass-element {
    /* Glassmorphism effect */
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    
    padding: 3rem 6rem;
    border-radius: 30px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    text-align: center;
}

.eyebrow {
    display: block;
    color: #d4a373; /* Your Gold Accent */
    text-transform: uppercase;
    font-size: 0.65rem;
    letter-spacing: 0.4em;
    font-weight: 900;
    margin-bottom: 0.5rem;
}

.title {
    color: white;
    font-size: 2rem;
    font-weight: 300;
    letter-spacing: -0.02em;
    font-family: 'serif'; /* Match your Azure/luxury font */
}
</style>