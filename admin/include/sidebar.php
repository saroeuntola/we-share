<!-- Desktop Sidebar -->
<aside class="fixed top-16 left-0 h-screen w-64 bg-gray-800 text-white shadow-lg hidden md:block">
    <nav class="mt-4 flex flex-col space-y-2 px-4">
        <a href="#" class="py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
        <a href="/weshare/admin/user" class="py-2 px-4 hover:bg-gray-700 rounded">Users</a>
        <a href="/weshare/admin/visitor_logs" class="py-2 px-4 hover:bg-gray-700 rounded">Visitor Logs</a>
        <a href="/weshare/admin/posts" class="py-2 px-4 hover:bg-gray-700 rounded">Posts</a>
        <a href="/weshare/admin/category" class="py-2 px-4 hover:bg-gray-700 rounded">Category</a>
        <a href="/weshare/admin/sub-category" class="py-2 px-4 hover:bg-gray-700 rounded">Sub Category</a>
    </nav>
</aside>

<!-- Mobile Sidebar Toggle -->
<input type="checkbox" id="menu-toggle" class="hidden" />
<label for="menu-toggle" class="fixed top-4 left-4 p-2 px-4 bg-gray-800 text-white rounded-md cursor-pointer md:hidden z-50">
    ☰
</label>

<!-- Mobile Sidebar -->
<aside id="mobile-menu" class="fixed top-0 left-0 h-screen w-64 bg-gray-800 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden z-40">
    <nav class="mt-16 flex flex-col space-y-2 px-4">
        <a href="#" class="py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
        <a href="#" class="py-2 px-4 hover:bg-gray-700 rounded">Users</a>
        <a href="#" class="py-2 px-4 hover:bg-gray-700 rounded">Posts</a>
        <a href="#" class="py-2 px-4 hover:bg-gray-700 rounded">Reports</a>
    </nav>
</aside>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('change', () => {
        mobileMenu.classList.toggle('-translate-x-full');
    });
</script>