<style>

</style>

<body class="bg-gray-900 text-white">
  <!-- Loader -->
  <div id="pageLoader"
    class="fixed inset-0 z-[9999] bg-gray-900 flex items-center justify-center transition-opacity duration-1000"
    aria-live="polite">
    <div class="relative h-20 w-20">
      <div class="loader inset-0 ease-linear"></div>
    </div>
  </div>

  <!-- Loader Script -->
  <script>
    // Wait until EVERYTHING is fully loaded (HTML + CSS + images + external resources)
    window.addEventListener("load", function() {
      const loader = document.getElementById("pageLoader");
      loader.classList.add("opacity-0"); // fade out

      setTimeout(() => {
        loader.style.display = "none";
        loader.setAttribute("aria-hidden", "true");
      }, 1000); // match transition duration
    });
  </script>
</body>