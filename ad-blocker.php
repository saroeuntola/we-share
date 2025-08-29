<style>
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
        padding: 0px 10px;
    }
</style>

<div id="adblock-message">
    <h1 class="text-3xl font-bold mb-4">Please Disable Your Ad Blocker</h1>
    <p class="text-lg">To access this website, you need to disable your ad blocker.</p>
</div>

<script>
    function checkAdBlock() {
        const message = document.getElementById('adblock-message');

        // Create bait divs
        const adClasses = ['adsbox', 'adsbygoogle', 'ad-banner', 'advert', 'ad-container'];
        let blocked = false;

        adClasses.forEach(cls => {
            let div = document.createElement('div');
            div.className = cls;
            div.style.width = '1px';
            div.style.height = '1px';
            div.style.position = 'absolute';
            div.style.top = '-1000px';
            document.body.appendChild(div);

            if (div.offsetParent === null || div.offsetHeight === 0 || div.offsetWidth === 0) {
                blocked = true;
            }
            div.remove();
        });

        // Create a fake ad script to detect blocked scripts
        const adScript = document.createElement('script');
        adScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
        adScript.async = true;

        adScript.onerror = function() {
            blocked = true;
            if (blocked) {
                message.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        adScript.onload = function() {
            if (blocked) {
                message.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                message.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        document.body.appendChild(adScript);

        // Show message if div bait was blocked
        if (blocked) {
            message.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            message.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    window.addEventListener('load', checkAdBlock);
</script>