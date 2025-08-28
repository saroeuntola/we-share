<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="fixed top-0 left-0 right-0 bg-green-700 shadow-md flex items-center justify-between px-4 lg:px-10 py-3 z-50">

    <!-- Left: Mobile Menu Button (hidden on desktop) -->
    <button class="md:hidden p-2 rounded hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-gray-700" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Title -->
    <h1 class="text-lg md:text-xl font-bold text-white 
             absolute left-1/2 transform -translate-x-1/2 md:static md:translate-x-0">
        Admin Dashboard
    </h1>

    <!-- Right: Controls -->
    <div class="flex items-center gap-4">
        <!-- Notification -->
        <button class="relative p-2 rounded-full hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 
                 14.158V11a6.002 6.002 0 00-4-5.659V4a2 
                 2 0 10-4 0v1.341C7.67 6.165 6 8.388 
                 6 11v3.159c0 .538-.214 1.055-.595 
                 1.436L4 17h5m6 0v1a3 3 0 11-6 
                 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- Welcome (hidden on mobile) -->
        <div class="hidden md:flex items-center gap-2 text-white font-medium">
            <span>Welcome,</span>
            <span class="font-bold">
                <?= htmlspecialchars($_SESSION['username'] ?? 'NaN'); ?>
            </span>
        </div>

        <!-- Avatar + Dropdown -->
        <div class="relative">
            <img src="/weshare/admin/user/user_image/no-profile.svg"
                id="avatarBtn"
                class="w-10 h-10 rounded-full bg-gray-300 cursor-pointer hover:ring-2 hover:ring-gray-400">

            <!-- Dropdown -->
            <div id="userDropdown"
                class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md hidden z-50">
                <div class="px-4 py-2 border-b">
                    <span class="block text-gray-700 font-semibold">
                        <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                    </span>
                </div>
                <a href="/logout"
                    class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    </div>
</header>

<script>
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdown = document.getElementById('userDropdown');

    avatarBtn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown if clicked outside
    window.addEventListener('click', (e) => {
        if (!avatarBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>