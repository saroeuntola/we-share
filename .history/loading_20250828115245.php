<style>
  /* HTML: <div class="loader"></div> */
  .loader {
    width: 80px;
    aspect-ratio: 1;
    display: grid;
  }

  .loader::before,
  .loader::after {
    content: "";
    grid-area: 1/1;
    --c: no-repeat radial-gradient(farthest-side, #25b09b 92%, #0000);
    background:
      var(--c) 50% 0,
      var(--c) 50% 100%,
      var(--c) 100% 50%,
      var(--c) 0 50%;
    background-size: 12px 12px;
    animation: l12 1s infinite;
  }

  .loader::before {
    margin: 4px;
    filter: hue-rotate(45deg);
    background-size: 8px 8px;
    animation-timing-function: linear;
  }

  @keyframes l12 {
    100% {
      transform: rotate(.5turn);
    }
  }
</style>

<body class="bg-gray-900 text-white">
  <!-- Loader -->
  <div id="pageLoader" class="fixed inset-0 z-[9999] bg-gray-900 flex items-center justify-center transition-opacity  duration-1000" aria-live="polite">
    <div class="relative h-20 w-20">
      <div class="loader inset-0 ease-linear"></div>
    </div>
  </div>

  <!-- Loader Script -->
  <script>
    $(document).ready(function() {
      const $loader = $("#pageLoader");
      $loader.removeClass("opacity-0").css("opacity", "1");
      setTimeout(function() {
        $loader.addClass("opacity-0");
        setTimeout(function() {
          $loader.css("display", "none").attr("aria-hidden", "true");
        }, 1000);
      }, 1500);
    });
  </script>
</body>