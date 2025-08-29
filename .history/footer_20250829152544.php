<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 ">

        <!-- About -->
        <div class="mt-6 me-4">
            <h2 class="text-lg font-semibold text-white mb-2">We Share</h2>
            <p class="text-sm leading-relaxed text-wrap <?= $lang === 'kh' ? 'khmer-font' : '' ?>">
                <?= $lang === 'en' ? 'We Share is a free platform offering Khmer-language documents, IT document, and free PDF downloads. Our goal is to provide accessible learning materials to everyone and promote knowledge sharing across all fields.' : 'We Share គឺជាវែបសាយមួយដែលផ្តល់ឯកសារភាសាខ្មែរ ឯកសារ IT និង ទាញយក PDF ដោយឥតគិតថ្លៃ។ គោលបំណងរបស់យើងគឺចែករំលែកឯកសារសម្រាប់ការសិក្សា និងការស្វែងយល់សម្រាប់មនុស្សគ្រប់គ្នា។' ?>
            </p>
        </div>

        <!-- Quick Links -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-white mb-2">Quick Links</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="/?lang=<?= $lang ?>" class="hover:text-green-400 transition">Home</a></li>
                <li><a href="about?lang=<?= $lang ?>" class="hover:text-green-400 transition">About Us</a></li>
                <li><a href="contact?lang=<?= $lang ?>" class="hover:text-green-400 transition">Contact</a></li>
                <li><a href="privacy-policy?lang=<?= $lang ?>" class="hover:text-green-400 transition">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Resources -->
        <div class="mt-6">

            <h2 class="text-lg font-semibold text-white mb-2">​ <?= $lang === 'en' ? '' : '' ?></h2>
            <ul class="space-y-2 text-sm">
                <li><a href="web-development?lang=<?= $lang ?>" class="hover:text-green-400 transition">Web Development</a></li>
                <li><a href="programming?lang=<?= $lang ?>" class="hover:text-green-400 transition">Programming</a></li>
                <li><a href="linux-system?lang=<?= $lang ?>" class="hover:text-green-400 transition">Linux System</a></li>
                <li><a href="windows-server?lang=<?= $lang ?>" class="hover:text-green-400 transition">Windows Server</a></li>
                <li><a href="database?lang=<?= $lang ?>" class="hover:text-green-400 transition">Database</a></li>
                <li><a href="ebook?lang=<?= $lang ?>" class="hover:text-green-400 transition">Ebooks</a></li>
                <li><a href="ms-office?lang=<?= $lang ?>" class="hover:text-green-400 transition">Microsoft Office</a></li>
                <li><a href="software?lang=<?= $lang ?>" class="hover:text-green-400 transition">Software</a></li>
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