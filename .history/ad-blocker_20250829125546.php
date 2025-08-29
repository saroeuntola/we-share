<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Block Detection</title>
    <style>
        #adblock-message {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            text-align: center;
            padding-top: 200px;
            font-size: 24px;
            z-index: 9999;
        }
    </style>
</head>

<body>

    <div id="adblock-message">
        <h1>Please Disable Your Ad Blocker</h1>
        <p>To access this website, you need to disable your ad blocker.</p>
    </div>

    <!-- Hidden bait element that ad blockers often target -->
    <div class="adsbox" style="width:1px;height:1px;position:absolute;top:-1000px;"></div>

    <script>
        window.addEventListener('load', function() {
            var bait = document.querySelector('.adsbox');
            var adBlockMessage = document.getElementById('adblock-message');

            // Some ad blockers remove the bait element
            var adBlocked = !bait || bait.offsetParent === null || bait.offsetHeight === 0 || bait.offsetWidth === 0;

            if (adBlocked) {
                adBlockMessage.style.display = 'block';
                document.body.style.overflow = 'hidden'; // prevent scrolling
            }
        });
    </script>

</body>

</html>