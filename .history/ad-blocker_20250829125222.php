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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
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

    <!-- Fake ad element that ad blockers often block -->
    <div id="ad-detector" style="width:1px;height:1px;position:absolute;top:-1000px;">
        <script src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </div>

    <script>
        window.addEventListener('load', function() {
            var adDetector = document.getElementById('ad-detector');
            var adBlockMessage = document.getElementById('adblock-message');

            // If the ad script failed to load or element blocked
            if (!adDetector || adDetector.offsetHeight === 0 || adDetector.offsetWidth === 0) {
                adBlockMessage.style.display = 'block';
                document.body.style.overflow = 'hidden'; // prevent scrolling
            }
        });
    </script>

</body>

</html>