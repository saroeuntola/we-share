<style>
  .loader {
    width: 45px;
    aspect-ratio: 1;
    --c: no-repeat linear-gradient(#fff 0 0);
    /* changed to white */
    background:
      var(--c) 0% 50%,
      var(--c) 50% 50%,
      var(--c) 100% 50%;
    background-size: 20% 100%;
    animation: l1 1s infinite linear;
  }

  @keyframes l1 {
    0% {
      background-size: 20% 100%, 20% 100%, 20% 100%;
    }

    33% {
      background-size: 20% 10%, 20% 100%, 20% 100%;
    }

    50% {
      background-size: 20% 100%, 20% 10%, 20% 100%;
    }

    66% {
      background-size: 20% 100%, 20% 100%, 20% 10%;
    }

    100% {
      background-size: 20% 100%, 20% 100%, 20% 100%;
    }
  }
</style>
<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'kh']) ? $_GET['lang'] : 'en';
?>
<body class="bg-gray-900 text-white">
  <!-- Loader -->
  <div id="pageLoader"
    class="fixed inset-0 z-[9999] bg-gray-900 flex flex-col items-center justify-center transition-opacity duration-1000"
    aria-live="polite">

    <!-- Loader Spinner -->
    <div class="relative h-20 w-20​​ ">
      <div class="loader inset-0 ease-linear"></div> 
      <span class=" text-white text-sm font-medium"><?= $lang === 'en' ?'Loading...' : 'សូមរងចាំ'?> </span>
    </div>
  </div>
</body>

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