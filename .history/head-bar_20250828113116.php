<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'kh']) ? $_GET['lang'] : 'en';
$currentSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

function buildLangUrl($langTarget, $currentPage, $currentSlug)
{
    $params = ['lang' => $langTarget];
    if ($currentPage === 'detail.php' && $currentSlug) {
        $params['slug'] = $currentSlug;
    }
    return $currentPage . '?' . http_build_query($params);
}

// ✅ Helper to check active page
function navItem($page, $label, $lang, $currentPage, $currentSlug)
{
    $isActive = (strpos($currentPage, $page) !== false || ($page === '/' && $currentPage === 'index.php'));
    $baseUrl = $page === '/' ? '/' : $page;
    $params = ['lang' => $lang];
    if ($currentPage === 'detail' && $currentSlug) {
        $params['slug'] = $currentSlug;
    }
    $href = $baseUrl . '?' . http_build_query($params);

    $activeClass = $isActive
        ? 'text-white underline underline-offset-4 decoration-2'  // active link underline
        : 'text-white hover:underline hover:underline-offset-4 hover:decoration-2'; // hover underline

    return "<a href=\"{$href}\" class=\"rounded-md text-base font-medium p-2 {$activeClass}\">{$label}</a>";
}



$menu = [
    'home' => $lang === 'en' ? 'Home' : 'ទំព័រដើម',
    'services' => $lang === 'en' ? 'Services' : 'សេវាកម្ម',
    'about' => $lang === 'en' ? 'About' : 'អំពីយើង',
    'faq' => $lang === 'en' ? 'FAQs' : 'សំណួរ',
    'join' => $lang === 'en' ? 'Join Now' : 'ចូលរួម',
    'search' => $lang === 'en' ? 'Search...' : 'ស្វែងរក...'
];

$languageNames = [
    'en' => 'English',
    'kh' => 'Khmer'
];
?>
<style>
    .nav-link {
        position: relative;
        display: inline-block;
        padding: 0.5rem 0.75rem;
        color: white;
        font-weight: 500;
        text-decoration: none;
    }

    .nav-link:hover {
        background-color: #16a34a;
        /* green-600 */
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        background: white;
        border-radius: 2px;
    }
</style>


<nav class="bg-green-500 shadow-md w-full" id="header">
    <div class="max-w-7xl mx-auto px-2">
        <div class="flex justify-between h-16 items-center">

            <!-- Mobile: Hamburger + Logo -->
            <div class="flex items-center lg:hidden">
                <!-- Hamburger -->
                <button id="menu-btn" class="lg:hidden p-2 text-white cursor-pointer">
                    <!-- Hamburger Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <script>
                    const menuBtn = document.getElementById('menu-btn');
                    const menuIcon = document.getElementById('menu-icon');
                    const closeIcon = document.getElementById('close-icon');

                    menuBtn.addEventListener('click', () => {
                        menuIcon.classList.toggle('hidden');
                        closeIcon.classList.toggle('hidden');
                    });
                </script>
                <!-- Logo -->
                <a href="#" class="text-2xl font-bold text-white ml-3">Logo</a>
            </div>
            <!-- Desktop: Logo + Menu -->
            <div class="hidden lg:flex justify-between items-center w-full">
                <!-- Logo -->
                <a href="#" class="text-2xl font-bold text-white">Logo</a>
                <!-- Menu Items -->
                <div class="flex space-x-6 items-center">
                    <!-- Desktop Menu Items -->
                    <div class="flex space-x-6 items-center">
                        <?= navItem('/', $menu['home'], $lang, $currentPage, $currentSlug) ?>
                        <?= navItem('services', $menu['services'], $lang, $currentPage, $currentSlug) ?>
                        <?= navItem('about', $menu['about'], $lang, $currentPage, $currentSlug) ?>
                    </div>


                    <!-- Search Icon -->
                    <div class="relative ">

                        <button id="search-icon" class="text-white focus:outline-none flex justify-between items-center">
                            <div class=" <p>Search..</p>
                            <svg class=" w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>">
                                <p>Search..</p>
                                <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>
                            </div>

                        </button>
                    </div>

                    <!-- Desktop Language Dropdown -->
                    <div class="relative">
                        <button id="lang-btn-desktop" class="flex items-center text-white px-3 py-2 rounded-md hover:bg-green-600 focus:outline-none">
                            <img id="lang-flag-desktop" src="https://flagcdn.com/<?= $lang === 'en' ? 'us' : 'kh' ?>.svg" class="w-5 h-5 ml-2 rounded-sm" alt="Flag">
                            <span class="ml-2 font-medium"><?= $lang === 'en' ? 'English' : 'Khmer' ?></span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="lang-menu-desktop" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-md shadow-lg z-50">
                            <?php foreach ($languageNames as $code => $name): ?>
                                <?php if ($code !== $lang): ?>
                                    <a href="<?= buildLangUrl($code, $currentPage, $currentSlug) ?>" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                        <img src="https://flagcdn.com/<?= $code === 'en' ? 'us' : 'kh' ?>.svg" class="w-5 h-5 mr-2 rounded-sm" alt="<?= $name ?> Flag">
                                        <span class="flex-1 text-right"><?= $name ?></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Mobile: Search Icon + Language -->
            <div class="flex items-center lg:hidden space-x-2">
                <!-- Search Icon -->
                <button id="search-icon-mobile" class="text-white focus:outline-none flex justify-center items-center">
                    <p>Search..</p>
                    <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                    </svg>
                </button>

                <!-- Mobile Language Dropdown -->
                <div class="relative">
                    <button id="lang-btn-mobile" class="flex items-center text-white px-3 py-2 rounded-md hover:bg-green-600 focus:outline-none">
                        <img id="lang-flag-mobile" src="https://flagcdn.com/<?= $lang === 'en' ? 'us' : 'kh' ?>.svg" class="w-5 h-5 ml-2 rounded-sm" alt="Flag">
                        <span class="ml-2 font-medium"><?= $lang === 'en' ? 'English' : 'Khmer' ?></span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="lang-menu-mobile" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-md shadow-lg z-50">
                        <?php foreach ($languageNames as $code => $name): ?>
                            <?php if ($code !== $lang): ?>
                                <a href="<?= buildLangUrl($code, $currentPage, $currentSlug) ?>" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <img src="https://flagcdn.com/<?= $code === 'en' ? 'us' : 'kh' ?>.svg" class="w-5 h-5 mr-2 rounded-sm" alt="<?= $name ?> Flag">
                                    <span class="flex-1 text-right"><?= $name ?></span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile Collapsed Menu -->
        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <!-- Slide-in Menu -->
        <!-- Slide-in Menu -->
        <div id="mobile-menu"
            class="fixed top-0 left-0 h-full w-64 bg-green-600 text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-50">

            <div class="flex flex-col px-5 py-3 space-y-4">
                <button id="close-btn" class="self-end text-white flex justify-end cursor-pointer">
                    ✕
                </button>
                <?= navItem('/', $menu['home'], $lang, $currentPage, $currentSlug) ?>
                <?= navItem('services', $menu['services'], $lang, $currentPage, $currentSlug) ?>
                <?= navItem('about', $menu['about'], $lang, $currentPage, $currentSlug) ?>
            </div>
        </div>


    </div>
</nav>

<!-- Search Modal (shared for Desktop & Mobile) -->
<div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-gray-600 w-full h-full max-w-4xl max-h-full overflow-y-auto relative p-4">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h2 class="text-xl text-white font-bold"><?= $lang === 'en' ? 'Search Document' : 'ស្វែងរកឯកសារ' ?></h2>
            <button onclick="closeSearchModal()" class="text-white text-3xl font-bold">&times;</button>
        </div>

        <!-- Search Input -->
        <div class="mt-4">
            <input type="text" id="search-box" placeholder="<?= $lang === 'en' ? 'Search...' : 'ស្វែងរក...' ?>"
                class="w-full px-4 py-3 rounded-md border focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Loading Indicator -->
        <div id="search-loading" class="hidden mt-2 text-white"><?= $lang === 'en' ? 'Loading...' : 'កំពុងផ្ទុក...' ?></div>

        <!-- Search Results Grid -->
        <div id="search-results" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="text-white col-span-full"><?= $lang === 'en' ? 'Type to search...' : 'វាយបញ្ចូលដើម្បីស្វែងរក...' ?></div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    const closeBtn = document.getElementById('close-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });




    // Desktop dropdown
    const langBtnDesktop = document.getElementById('lang-btn-desktop');
    const langMenuDesktop = document.getElementById('lang-menu-desktop');

    langBtnDesktop.addEventListener('click', (e) => {
        e.stopPropagation();
        langMenuDesktop.classList.toggle('hidden');
    });

    // Mobile dropdown
    const langBtnMobile = document.getElementById('lang-btn-mobile');
    const langMenuMobile = document.getElementById('lang-menu-mobile');

    langBtnMobile.addEventListener('click', (e) => {
        e.stopPropagation();
        langMenuMobile.classList.toggle('hidden');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        langMenuDesktop.classList.add('hidden');
        langMenuMobile.classList.add('hidden');
    });



    // Search Modal
    const searchIconDesktop = document.getElementById('search-icon');
    const searchIconMobile = document.getElementById('search-icon-mobile');
    const searchModal = document.getElementById('searchModal');
    const searchBox = document.getElementById('search-box');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.getElementById('search-loading');

    function openSearchModal() {
        searchModal.classList.remove('hidden');
        searchBox.focus();
    }

    function closeSearchModal() {
        searchModal.classList.add('hidden');
        searchBox.value = '';
        searchResults.innerHTML = '<div class="text-white col-span-full"><?= $lang === "en" ? "Type to search..." : "វាយបញ្ចូលដើម្បីស្វែងរក..." ?></div>';
    }

    searchIconDesktop.addEventListener('click', openSearchModal);
    searchIconMobile.addEventListener('click', openSearchModal);

    window.addEventListener('click', function(e) {
        if (e.target === searchModal) closeSearchModal();
    });

    function debounce(func, delay) {
        let timeout;
        return function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, arguments), delay);
        }
    }

    searchBox.addEventListener('input', debounce(function() {
        const query = this.value.trim();
        searchResults.innerHTML = '';
        if (!query) {
            searchResults.innerHTML = '<div class="text-white col-span-full"><?= $lang === "en" ? "Type to search..." : "វាយបញ្ចូលដើម្បីស្វែងរក..." ?></div>';
            searchLoading.classList.add('hidden');
            return;
        }
        searchLoading.classList.remove('hidden');

        fetch(`/weshare/search.php?q=${encodeURIComponent(query)}&lang=<?= $lang ?>`)
            .then(res => res.json())
            .then(data => {
                searchLoading.classList.add('hidden');
                searchResults.innerHTML = '';
                if (data.length === 0) {
                    searchResults.innerHTML = '<div class="text-white col-span-full"><?= $lang === "en" ? "No data found" : "រកមិនឃើញទិន្នន័យ។" ?></div>';
                } else {
                    data.forEach(item => {
                        const a = document.createElement('a');
                        a.href = `detail?slug=${item.slug}&lang=<?= $lang ?>`;
                        a.className = 'block border rounded p-3 hover:bg-white bg-white';
                        a.textContent = item.name;
                        searchResults.appendChild(a);
                    });
                }
            })
            .catch(err => {
                searchLoading.classList.add('hidden');
                console.error(err);
            });
    }, 300));
</script>