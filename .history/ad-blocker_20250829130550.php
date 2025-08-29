
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

    <div id="adblock-message" class="">
        <h1 class="text-3xl font-bold">Please Disable Your Ad Blocker</h1>
        <p class="text-lg">To access this website, you need to disable your ad blocker.</p>
    </div>

    <script>
        let baitElements = [];

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


        let adBlocked = false;

        function showAdBlockMessage() {
            const msg = document.getElementById('adblock-message');
            msg.style.display = 'flex';
            document.body.style.overflow = 'hidden'; 
        }

        window.addEventListener('load', function() {
            baitElements.forEach(div => {
                if (!div || div.offsetParent === null || div.offsetHeight === 0 || div.offsetWidth === 0) {
                    adBlocked = true;
                }
                // Clean up
                if (div) div.remove();
            });

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