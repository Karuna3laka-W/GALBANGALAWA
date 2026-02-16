<template>
    <div class="fixed inset-0 z-[-1] overflow-hidden bg-[#f9fafb]">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
</template>

<style scoped>
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px); /* Creates the misty/shade look */
    opacity: 0.6;
    animation: float 20s infinite ease-in-out alternate;
}

.orb-1 {
    width: 600px;
    height: 600px;
    background: #1e3a8a; /* Deep Blue */
    top: -100px;
    left: -100px;
    animation-duration: 25s;
}

.orb-2 {
    width: 500px;
    height: 500px;
    background: #3b82f6; /* Vibrant Blue */
    bottom: -50px;
    right: -100px;
    animation-duration: 28s;
    animation-delay: -5s;
}

.orb-3 {
    width: 400px;
    height: 400px;
    background: rgba(212, 163, 115, 0.3); /* Gold Accent */
    top: 40%;
    left: 40%;
    animation-duration: 30s;
    animation-delay: -10s;
}

@keyframes float {
    0% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0, 0) scale(1); }
}
</style>