<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Site</title>

    <!-- Tailwind v5 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Full-page overlay for adblock message */
        #adblock-message {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            text-align: center;
            padding-top: 150px;
            z-index: 9999;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Ad Blocker Message -->
    <div id="adblock-message" class="flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-4">Please Disable Your Ad Blocker</h1>
        <p class="text-lg">To access this website, you need to disable your ad blocker.</p>
    </div>

    <!-- Hidden bait element for detection -->
    <div id="ad-bait" class="adsbox" style="width:1px;height:1px;position:absolute;top:-1000px;"></div>

    <!-- Your site content -->
    <main class="max-w-7xl mx-auto p-4 mt-20">
        <h1 class="text-3xl font-bold mb-4">Welcome to My Site</h1>
        <p>This content is visible only if no ad blocker is active.</p>
    </main>

    <script>
        // Ad Block Detection
        window.addEventListener('load', function() {
            const bait = document.getElementById('ad-bait');
            const message = document.getElementById('adblock-message');

            // Some ad blockers remove the bait element
            const blocked = !bait || bait.offsetParent === null || bait.offsetHeight === 0 || bait.offsetWidth === 0;

            if (blocked) {
                message.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // prevent scrolling
            }
        });
    </script>

</body>

</html>