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
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            text-align: center;
            padding-top: 150px;
            z-index: 9999;
            font-family: sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Ad Blocker Message -->
    <div id="adblock-message" class="flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-4">Please Disable Your Ad Blocker</h1>
        <p class="text-lg">To access this website, you need to disable your ad blocker.</p>
    </div>

    <!-- Site Content -->
    <main class="max-w-7xl mx-auto p-4 mt-20">
        <h1 class="text-3xl font-bold mb-4">Welcome to My Site</h1>
        <p>This content is visible only if no ad blocker is active.</p>
    </main>

    <script>
        // --------------------------
        // 1️⃣ Hidden bait elements
        // --------------------------
        let baitElements = [];

        // Multiple common ad-related classes
        const adClasses = ['adsbox', 'adsbygoogle', 'ad-banner', 'advert', 'ad-container'];

        adClasses.forEach(cls => {
            let div = document.createElement('div');
            div.className = cls;
            div.style.width = '1px';
            div.style.height = '1px';
            div.style.position = 'absolute';
            div.style.top = '-1000px';
            document.body.appendChild(div);
            baitElements.push(div);
        });

        // --------------------------
        // 2️⃣ Script-based detection
        // --------------------------
        let adBlocked = false;

        function showAdBlockMessage() {
            const msg = document.getElementById('adblock-message');
            msg.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // prevent scrolling
        }

        window.addEventListener('load', function() {
            // Check if any bait div was removed or hidden
            baitElements.forEach(div => {
                if (!div || div.offsetParent === null || div.offsetHeight === 0 || div.offsetWidth === 0) {
                    adBlocked = true;
                }
                // Clean up
                if (div) div.remove();
            });

            // Load fake ad script to detect script-blocking ad blockers
            const adScript = document.createElement('script');
            adScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
            adScript.async = true;
            adScript.onerror = function() {
                adBlocked = true;
                showAdBlockMessage();
            };
            adScript.onload = function() {
                if (adBlocked) showAdBlockMessage();
            };
            document.body.appendChild(adScript);

            // If any bait div detected as blocked
            if (adBlocked) showAdBlockMessage();
        });
    </script>

</body>

</html>