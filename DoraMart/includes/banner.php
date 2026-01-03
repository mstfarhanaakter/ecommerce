<!-- Carousel Start -->
<div class="relative w-full overflow-hidden">

  <!-- Slides -->
  <div id="carousel" class="flex transition-transform duration-700 ease-in-out">

    <!-- Slide 1 -->
    <div class="min-w-full h-[430px] relative mt-3">
      <img src="assets/img/m-ban.jpg" class="absolute inset-0 w-full h-full object-cover" />
      <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center">
        <div class="max-w-xl px-4 text-white">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Men Fashion</h1>
          <p class="mb-6">Style Meets Strength - Everything for the Modern Man.</p>
          <a href="#" class="inline-block border border-white px-6 py-2 hover:bg-white hover:text-black transition">
            Shop Now
          </a>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="min-w-full h-[430px] relative">
      <img src="assets/img/w-ban.jpg" class="absolute inset-0 w-full h-full object-cover" />
      <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center">
        <div class="max-w-xl px-4 text-white">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Women Fashion</h1>
          <p class="mb-6">Slay Every Day - Shop Your Way.</p>
          <a href="#" class="inline-block border border-white px-6 py-2 hover:bg-white hover:text-black transition">
            Shop Now
          </a>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="min-w-full h-[430px] relative">
      <img src="assets/img/k-ban.jpg" class="absolute inset-0 w-full h-full object-cover" />
      <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center">
        <div class="max-w-xl px-4 text-white">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Kids Fashion</h1>
          <p class="mb-6">Because Kids Deserve the Best!</p>
          <a href="#" class="inline-block border border-white px-6 py-2 hover:bg-white hover:text-black transition">
            Shop Now
          </a>
        </div>
      </div>
    </div>

  </div>

  <!-- Indicators -->
  <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-3">
    <button class="dot w-3 h-3 rounded-full bg-white/50"></button>
    <button class="dot w-3 h-3 rounded-full bg-white/50"></button>
    <button class="dot w-3 h-3 rounded-full bg-white/50"></button>
  </div>

</div>
<!-- Carousel End -->


<script>
  const carousel = document.getElementById("carousel");
  const dots = document.querySelectorAll(".dot");
  let index = 0;

  function showSlide(i) {
    index = i;
    carousel.style.transform = `translateX(-${index * 100}%)`;

    dots.forEach(dot => dot.classList.remove("bg-white"));
    dots[index].classList.add("bg-white");
  }

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => showSlide(i));
  });

  setInterval(() => {
    index = (index + 1) % dots.length;
    showSlide(index);
  }, 4000);

  showSlide(0);
</script>
