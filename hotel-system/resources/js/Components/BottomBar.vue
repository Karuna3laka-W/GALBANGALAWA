<script setup>
// Minimal logic needed for a static footer
</script>

<template>
  <footer class="footer-container">
    <div class="waves-wrapper">
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
      viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
          <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
          <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(0, 43, 73, 0.7" />
          <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(0, 43, 73, 0.5)" />
          <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(0, 43, 73, 0.3)" />
          <use xlink:href="#gentle-wave" x="48" y="7" fill="#001a2c" />
        </g>
      </svg>
    </div>

    <div class="footer-content">
      <div class="footer-grid">
        <div class="footer-column signup-section">
          <h3 class="column-title">Sign Up for Special Offers</h3>
          <p class="signup-text">Be the first to know about our luxury escapes and exclusive member rates.</p>
          <div class="signup-form">
            <input type="email" placeholder="Email Address" class="signup-input" />
            <button class="signup-btn">Join</button>
          </div>
        </div>

        <div class="footer-column">
          <h3 class="column-title">Explore</h3>
          <ul class="footer-links">
            <li><a href="#">Hotels & Resorts</a></li>
            <li><a href="#">Offers</a></li>
            <li><a href="#">Experiences</a></li>
            <li><a href="#">Weddings & Events</a></li>
            <li><a href="#">ESG</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Gift Vouchers</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="column-title">Information</h3>
          <ul class="footer-links">
            <li><a href="#">Investor Relations</a></li>
            <li><a href="#">Pressroom</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">U Blog</a></li>
            <li><a href="#">Site Map</a></li>
            <li><a href="#">Privacy Statements</a></li>
            <li><a href="#">Cinnamon Hospitality Academy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">FAQs</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="column-title">Get in Touch</h3>
          <p class="contact-info">Hotel Contact Information</p>
          <a href="mailto:info@cinnamonhotels.com" class="contact-link">info@cinnamonhotels.com</a>
          <a href="tel:+94112161161" class="contact-link">+94 112 161 161</a>
          
          <div class="social-section">
            <h3 class="column-title mt-8">Follow Us</h3>
            <a href="#" class="insta-link">
               <span class="insta-icon">Instagram</span>
            </a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>© 2026 Hotel Galbangalawa. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer-container {
  @apply relative w-full;
  background-color: #001a2c; /* Navy Blue */
  color: #ffffff;
  min-height: 400px;
}

/* Wavy Animation */
.waves-wrapper {
  @apply relative w-full h-[15vh] min-h-[100px] max-h-[150px] overflow-hidden;
}

.waves {
  @apply relative w-full h-full mb-[-7px]; /* Fix for safari gap */
}

.parallax > use {
  animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
}
.parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
.parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
.parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
.parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }

@keyframes move-forever {
  0% { transform: translate3d(-90px,0,0); }
  100% { transform: translate3d(85px,0,0); }
}

/* Layout */
.footer-content {
  @apply max-w-7xl mx-auto px-8 pb-12;
}

.footer-grid {
  @apply grid grid-cols-1 md:grid-cols-4 gap-12 pt-10;
}

.column-title {
  @apply text-[#d4a373] text-sm font-bold uppercase tracking-widest mb-6;
}

.footer-links li {
  @apply mb-3;
}

.footer-links a {
  @apply text-gray-300 text-sm no-underline transition-colors duration-300 hover:text-[#d4a373];
}

/* Signup Form */
.signup-text {
  @apply text-sm text-gray-400 mb-4;
}

.signup-form {
  @apply flex items-center border-b border-gray-600 pb-2;
}

.signup-input {
  @apply bg-transparent border-none outline-none text-sm w-full text-white placeholder-gray-500;
}

.signup-btn {
  @apply text-[#d4a373] text-xs font-bold uppercase ml-2 hover:text-white transition-colors;
}

.contact-link {
  @apply block text-sm text-gray-300 mb-2 hover:text-[#d4a373];
}

.footer-bottom {
 @apply border-t border-white/10 mt-16 pt-8 text-center text-xs text-gray-500 uppercase tracking-widest;
}

/* Mobile adjustments */
@media (max-width: 768px) {
  .footer-grid { @apply grid-cols-1 text-center; }
  .signup-form { @apply justify-center; }
}
</style>