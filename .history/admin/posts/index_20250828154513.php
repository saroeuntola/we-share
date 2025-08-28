<?php
session_start();
include '../lib/db.php';
include '../lib/subcategory_lib.php';
include '../lib/category_lib.php';
include '../lib/post_lib.php';

$categoryModel = new Category();
$subcategoryModel = new Subcategory();
$postModel = new Post();

$categories = $categoryModel->getCategories();
$posts = $postModel->getPosts();


$added_by = $_SESSION['username'] ?? ($_SESSION['user']['username'] ?? 'Guest');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $post_id = $_POST['post_id'] ?? null;
    $name_en = $_POST['name_en'] ?? '';
    $name_kh = $_POST['name_kh'] ?? '';
    $category_id = $_POST['category_id'] ?? null;
    $subcategory_id = $_POST['subcategory_id'] ?? null;
    $description_en = $_POST['description_en'] ?? '';
    $description_kh = $_POST['description_kh'] ?? '';

    $uploadedImage = $_POST['current_image'] ?? null;

    if (!empty($_FILES['post_image']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $mime = mime_content_type($_FILES['post_image']['tmp_name']);
        if (in_array($mime, $allowed, true)) {
            $ext = pathinfo($_FILES['post_image']['name'], PATHINFO_EXTENSION);
            $safeBase = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($_FILES['post_image']['name'], PATHINFO_FILENAME));
            $fileName = time() . '_' . $safeBase . '.' . $ext;
            $target = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['post_image']['tmp_name'], $target)) {
                $uploadedImage = $fileName;
            }
        }
    }
    if ($post_id && empty($uploadedImage)) {
        if (method_exists($postModel, 'getPostById')) {
            $existing = $postModel->getPostBySlug($post_id);
            $uploadedImage = $existing['image'] ?? null;
        }
    }

    // Now save
    if ($post_id) {

        $postModel->updatePostById($post_id, $name_en, $category_id, $subcategory_id, $description_en, $uploadedImage, $name_kh, $description_kh);
    } else {

        try {

            $postModel->createPost($name_en, $category_id, $subcategory_id, $description_en, $uploadedImage, $name_kh, $description_kh, $added_by);
        } catch (ArgumentCountError $e) {

            $postModel->createPost($name_en, $category_id, $subcategory_id, $description_en, $uploadedImage, $name_kh, $description_kh);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="/weshare/assets/css/style.css">
</head>

<body class="">

    <!-- Header -->
    <?php include '../include/navbar.php' ?>

    <div class="">

        <!-- Sidebar -->
        <?php include '../include/sidebar.php' ?>

        <!-- Main Content -->
        <main class="ml-0 md:ml-64 p-4 mt-[70px]">
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-2">Posts Management</h1>
                <button onclick="openModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition">+ Add Post</button>
            </div>

            <!-- Posts Table -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name (EN)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name (KH)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subcategory</th>

                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Added By</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($posts as $p):
                            $cat = $categoryModel->getCategory($p['category_id']);
                            $sub = $p['subcategory_id'] ? $subcategoryModel->getSubcategory($p['subcategory_id']) : null;
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $p['id'] ?></td>
                                <td class="px-4 py-2">
                                    <?php if (!empty($p['image'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($p['image']) ?>"
                                            alt="Post Image"
                                            class="w-16 h-16 object-cover rounded-md border border-gray-200">
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2"><?= htmlspecialchars($p['name'] ?? '') ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($p['name_kh'] ?? '') ?></td>
                                <td class="px-4 py-2"><?= $cat ? htmlspecialchars($cat['name']) : '-' ?></td>
                                <td class="px-4 py-2"><?= $sub ? htmlspecialchars($sub['name']) : '-' ?></td>

                                <td class="px-4 py-2"><?= htmlspecialchars($p['added_by']) ?? '' ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($p['created_at']) ?></td>
                                <td class="px-4 py-2 flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded-md text-sm"
                                        onclick='openModal(<?= json_encode($p) ?>)'>Edit</button>
                                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                        <a href="delete?slug=<?= urlencode($p['slug']) ?>"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm"
                                            onclick="return confirm('Are you sure?')">Delete</a>
                                    <?php else: ?>
                                        <a href="#" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm"
                                            onclick="return noPermission()">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div id="postModal"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
                <div class="relative mt-12 mb-12 mx-auto max-w-3xl bg-white rounded-lg shadow-lg p-6 w-full">
                    <!-- Close Button -->
                    <span class="absolute top-2 right-3 text-gray-500 cursor-pointer text-2xl font-bold"
                        onclick="closeModal()">&times;</span>

                    <!-- Modal Title -->
                    <h2 id="modalTitle" class="text-xl font-bold mb-4">Create Post</h2>

                    <!-- Modal Form -->
                    <form method="POST" onsubmit="submitQuillContent()" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="post_id" id="post_id">
                        <input type="hidden" name="current_image" id="current_image">

                        <div>
                            <label class="block font-medium mb-1">Post Name (English)</label>
                            <input type="text" name="name_en" id="name_en"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Post Name (Khmer)</label>
                            <input type="text" name="name_kh" id="name_kh"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1">Category</label>
                                <select name="category_id" id="category_id"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onchange="loadSubcategories(this.value)" required>
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium mb-1">Subcategory</label>
                                <select name="subcategory_id" id="subcategory_id_modal"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select Subcategory --</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Description (English)</label>
                            <div id="editor_en" class="quill-editor h-32 border border-gray-300 rounded-md"></div>
                            <input type="hidden" name="description_en" id="description_en">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Description (Khmer)</label>
                            <div id="editor_kh" class="quill-editor h-32 border border-gray-300 rounded-md"></div>
                            <input type="hidden" name="description_kh" id="description_kh">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Link File*</label>
                            <input type="text" name="link" id="link"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Post Image</label>
                            <input type="file" name="post_image" id="post_image"
                                class="w-full border border-gray-300 rounded-md p-2">
                            <div id="imagePreview" class="mt-2 hidden">
                                <img id="imagePreviewImg" src="" alt="Preview"
                                    class="max-w-xs rounded-md border border-gray-200">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <input type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow cursor-pointer"
                                name="submit_post" value="Save Post">
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        function noPermission() {
            alert("You do not have permission to perform this action!");
            return false;
        }

        const quillEn = new Quill('#editor_en', {
            theme: 'snow'
        });
        const quillKh = new Quill('#editor_kh', {
            theme: 'snow'
        });

        function submitQuillContent() {
            document.getElementById('description_en').value = quillEn.root.innerHTML;
            document.getElementById('description_kh').value = quillKh.root.innerHTML;
        }

        function openModal(post = null) {
            document.getElementById('postModal').style.display = 'block';
            const previewWrap = document.getElementById('imagePreview');
            const previewImg = document.getElementById('imagePreviewImg');

            if (post) {
                document.getElementById('modalTitle').innerText = 'Edit Post';
                document.getElementById('post_id').value = post.id;
                document.getElementById('name_en').value = post.name;
                document.getElementById('name_kh').value = post.name_kh;
                document.getElementById('link-files').value = post.name_kh;
                document.getElementById('category_id').value = post.category_id;
                loadSubcategories(post.category_id, post.subcategory_id);
                quillEn.root.innerHTML = post.description;
                quillKh.root.innerHTML = post.description_kh;

                // keep existing image filename (if your API returns it as post.image)
                document.getElementById('current_image').value = post.image || '';

                // show preview if image exists (adjust path if needed)
                if (post.image) {
                    previewImg.src = 'uploads/posts/' + post.image;
                    previewWrap.style.display = 'block';
                } else {
                    previewImg.src = '';
                    previewWrap.style.display = 'none';
                }
            } else {
                document.getElementById('modalTitle').innerText = 'Create Post';
                document.getElementById('post_id').value = '';
                document.getElementById('name_en').value = '';
                document.getElementById('name_kh').value = '';
                document.getElementById('category_id').value = '';
                document.getElementById('subcategory_id_modal').innerHTML = '<option value="">-- Select Subcategory --</option>';
                quillEn.root.innerHTML = '';
                quillKh.root.innerHTML = '';
                document.getElementById('current_image').value = '';
                previewImg.src = '';
                previewWrap.style.display = 'none';
            }
        }

        function closeModal() {
            document.getElementById('postModal').style.display = 'none';
        }

        function loadSubcategories(catId, selectedId = null) {
            const subSelect = document.getElementById('subcategory_id_modal');
            subSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
            if (!catId) return;
            fetch('get_subcategories.php?category_id=' + catId)
                .then(res => res.json())
                .then(data => {
                    data.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.text = sub.name;
                        if (selectedId && selectedId == sub.id) opt.selected = true;
                        subSelect.add(opt);
                    });
                });
        }

        window.onclick = function(event) {
            const modal = document.getElementById('postModal');
            if (event.target == modal) modal.style.display = 'none';
        }

        // simple preview when selecting a new file
        document.getElementById('post_image')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewWrap = document.getElementById('imagePreview');
            const previewImg = document.getElementById('imagePreviewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    previewImg.src = ev.target.result;
                    previewWrap.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
                previewWrap.style.display = 'none';
            }
        });
    </script>

</body>

</html>