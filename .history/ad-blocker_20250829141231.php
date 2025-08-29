<style>
    /* Full-page overlay for adblock message */
    #adblock-message {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.9);
        color: white;
        text-align: center;
        z-index: 9999;
        font-family: sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0 10px;
    }
</style>

<!-- Only shown if ad blocker is active -->
<div id="adblock-message">
    <h1 class="text-3xl font-bold mb-4">Please Disable Your Ad Blocker</h1>
    <p class="text-lg">To access this website, you need to disable your ad blocker.</p>
</div>

<script>
    window.addEventListener('load', function() {
        const message = document.getElementById('adblock-message');
        let adBlocked = false;

        // 1️⃣ Create hidden bait div
        const bait = document.createElement('div');
        bait.className = 'adsbox';
        bait.style.width = '1px';
        bait.style.height = '1px';
        bait.style.position = 'absolute';
        bait.style.top = '-1000px';
        document.body.appendChild(bait);

        // 2️⃣ Check if div is blocked by ad blocker
        if (!bait.offsetParent || bait.offsetHeight === 0 || bait.offsetWidth === 0) {
            adBlocked = true;
            message.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        bait.remove();

        // 3️⃣ Try loading a known ad script (Google Ads)
        const adScript = document.createElement('script');
        adScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
        adScript.async = true;

        adScript.onerror = function() {
            // Script blocked → show message
            if (!adBlocked) {
                message.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        document.body.appendChild(adScript);
    });
</script>