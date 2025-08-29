<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 ">

        <!-- About -->
        <div class="mt-6 me-4">
            <h2 class="text-lg font-semibold text-white mb-2">We Share</h2>
            <p class="text-sm leading-relaxed text-wrap">
                We Share is a free resource hub for Khmer documents, study materials, IT tutorials,
                and PDF downloads. Our mission is to make knowledge accessible for everyone in Cambodia and beyond.
            </p>
        </div>

        <!-- Quick Links -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-white mb-2">Quick Links</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="/" class="hover:text-green-400 transition">Home</a></li>
                <li><a href="/about" class="hover:text-green-400 transition">About Us</a></li>
                <li><a href="/contact" class="hover:text-green-400 transition">Contact</a></li>
                <li><a href="/privacy-policy" class="hover:text-green-400 transition">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Resources -->
        <div class="mt-6">

            <h2 class="text-lg font-semibold text-white mb-2">Documents</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="/downloads" class="hover:text-green-400 transition">Web Development</a></li>
                <li><a href="/it-tutorials" class="hover:text-green-400 transition">Programming</a></li>
                <li><a href="/study-materials" class="hover:text-green-400 transition">Ebooks</a></li>
                <li><a href="/study-materials" class="hover:text-green-400 transition">Microsoft Office</a></li>
            </ul>
        </div>
        <!-- Social Media -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-white mb-2">Follow Us</h2>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-green-400"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-youtube fa-lg"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-telegram fa-lg"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-github fa-lg"></i></a>
            </div>
            <p class="mt-4 text-sm">
                Subscribe for updates and new document uploads.
            </p>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-700 text-center py-5 text-sm text-gray-400">
        © <span id="year"></span> We Share. All rights reserved. | Made with ❤️ for learners in Cambodia
    </div>
</footer>

<script>
    // auto-update year
    document.getElementById("year").textContent = new Date().getFullYear();
</script>