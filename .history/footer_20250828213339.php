<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mt-6">

        <!-- About -->
        <div>
            <h2 class="text-lg font-semibold text-white mb-4">We Share</h2>
            <p class="text-sm leading-relaxed">
                We Share is a free resource hub for Khmer documents, study materials, IT tutorials,
                and PDF downloads. Our mission is to make knowledge accessible for everyone in Cambodia and beyond.
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h2 class="text-lg font-semibold text-white mb-4">Quick Links</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="/" class="hover:text-green-400 transition">Home</a></li>
                <li><a href="/categories" class="hover:text-green-400 transition">Categories</a></li>
                <li><a href="/about" class="hover:text-green-400 transition">About Us</a></li>
                <li><a href="/contact" class="hover:text-green-400 transition">Contact</a></li>
            </ul>
        </div>

        <!-- Resources -->
        <div>
            <h2 class="text-lg font-semibold text-white mb-4">Resources</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="/downloads" class="hover:text-green-400 transition">Download PDFs</a></li>
                <li><a href="/it-tutorials" class="hover:text-green-400 transition">IT Tutorials</a></li>
                <li><a href="/study-materials" class="hover:text-green-400 transition">Study Materials</a></li>
                <li><a href="/privacy-policy" class="hover:text-green-400 transition">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div>
            <h2 class="text-lg font-semibold text-white mb-4">Follow Us</h2>
            <div class="flex space-x-5">
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