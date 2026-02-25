<script setup>
const weddingSections = [
  {
    title: 'Beach\nWeddings',
    desc: 'Exchange vows under the golden sunset with the rhythmic sound of waves as your symphony.',
    img: 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=1470'
  },
  {
    title: 'Garden\nCeremonies',
    desc: 'Walk through a floral paradise where nature provides the perfect blooming backdrop for your love.',
    img: 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1470'
  },
  {
    title: 'Royal\nBallrooms',
    desc: 'Experience timeless elegance in our crystal-lit halls designed for magnificent celebrations.',
    img: 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1470'
  }
];
</script>

<template>
  <section class="wedding-container">
    <div class="decorative-top">
        <div class="numeral-box">III</div>
    </div>

    <div v-for="(item, index) in weddingSections" :key="index" class="wedding-col group">
      <div class="col-bg" :style="{ backgroundImage: `url(${item.img})` }"></div>
      
      <div class="col-overlay"></div>

      <div class="col-content">
        <h2 class="col-title" v-html="item.title.replace('\n', '<br>')"></h2>
        <p class="col-desc">{{ item.desc }}</p>
      </div>
    </div>

    <div class="action-wrapper">
        <button class="book-btn">Book Weddings</button>
    </div>
  </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Montserrat:wght@300;600&display=swap');

.wedding-container {
  display: flex;
  width: 100%;
  height: 90vh;
  position: relative;
  overflow: hidden;
  background: #000;
}

/* Columns Layout */
.wedding-col {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
  transition: flex 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.wedding-col:hover {
  flex: 1.2; /* Subtle expansion on hover */
}

/* Hover Effect: Background Image */
.col-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transition: transform 1.5s ease;
  z-index: 1;
}
.wedding-col:hover .col-bg {
  transform: scale(1.1); /* Zoom in */
}

.col-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, transparent 20%, rgba(0,0,0,0.8) 100%);
  z-index: 2;
  transition: opacity 0.5s ease;
}

/* Content & Typography */
.col-content {
  position: relative;
  z-index: 10;
  padding: 0 10%;
  color: white;
}

.col-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 5vw, 4rem);
  font-weight: 400;
  line-height: 1;
  margin-bottom: 1.5rem;
  transition: transform 0.6s ease;
}

.col-desc {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.85rem;
  line-height: 1.8;
  letter-spacing: 0.05em;
  opacity: 0; /* Hidden initially */
  transform: translateY(30px); /* Positioned lower */
  transition: all 0.6s ease;
}

/* Hover Effect: Reveal text */
.wedding-col:hover .col-title {
  transform: translateY(-20px);
}
.wedding-col:hover .col-desc {
  opacity: 1;
  transform: translateY(0);
}

/* UI Elements */
.decorative-top {
    position: absolute;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
}
.numeral-box {
    border: 1px solid rgba(255,255,255,0.4);
    padding: 8px 12px;
    color: white;
    font-size: 0.7rem;
    letter-spacing: 0.3em;
}

.action-wrapper {
    position: absolute;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 30;
}

.book-btn {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 14px 40px;
    border-radius: 999px;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    cursor: pointer;
    transition: all 0.3s ease;
}
.book-btn:hover {
    background: white;
    color: black;
    transform: translateY(-5px);
}
</style>