<style>
    /* Container */
    .container {
        width: 100%;
        overflow: hidden;
        margin: 0 auto;
        align-items: center;
        color: white;
    }

    /* Fixed icon on the left */
    .announcement-icon {
        background-color: brown;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }

    /* Announcement text */
    .announcement {
        font-family: Arial, sans-serif;
        font-size: 15px;
        display: inline-block;
        white-space: nowrap;
        animation: slideLeftToRight 20s linear infinite;
    }

    #main {
        display: flex;
        overflow: hidden;
        margin: 0 auto;
        align-items: center;
        max-width: 1212px;
        width: 100%;
        color: white;
    }

    /* Desktop animation */
    @keyframes slideLeftToRight {
        0% {
            transform: translateX(1210px);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Tablet */
    @media (max-width: 1024px) {
        #main {
            width: 95%;
        }

        .announcement {
            animation: slideLeftToRightTablet 18s linear infinite;
        }

        @keyframes slideLeftToRightTablet {
            0% {
                transform: translateX(768px);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    }

    /* Mobile */
    @media (max-width: 480px) {
        #main {
            width: 92%;
        }

        .announcement {
            animation: slideLeftToRightMobile 15s linear infinite;
        }

        @keyframes slideLeftToRightMobile {
            0% {
                transform: translateX(400px);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    }
</style>
<style>
    /* Container */
    .container {
        width: 100%;
        overflow: hidden;
        margin: 0 auto;
        align-items: center;
        color: white;
    }

    /* Fixed icon on the left */
    .announcement-icon {
        background-color: black;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }

    /* Announcement text */
    .announcement {
        font-family: Arial, sans-serif;
        font-size: 15px;
        display: inline-block;
        white-space: nowrap;
        animation: slideLeftToRight 20s linear infinite;

    }

    #main {
        display: flex;
        overflow: hidden;
        margin: 0 auto;
        align-items: center;
        max-width: 1280px;
        width: 100%;
        padding: 0px 10px;

    }

    /* Desktop animation */
    @keyframes slideLeftToRight {
        0% {
            transform: translateX(1280px);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Tablet */
    @media (max-width: 1024px) {

        .announcement {
            animation: slideLeftToRightTablet 18s linear infinite;
        }

        @keyframes slideLeftToRightTablet {
            0% {
                transform: translateX(768px);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    }

    /* Mobile */
    @media (max-width: 480px) {

        .announcement {
            animation: slideLeftToRightMobile 15s linear infinite;
        }

        @keyframes slideLeftToRightMobile {
            0% {
                transform: translateX(400px);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    }
</style>



<div id="main">
    <div class="announcement-icon"><i class="fas fa-bullhorn"></i></div>
    <div class="container">
        <!-- Sliding text -->
        <p class="announcement<?= $lang === 'kh' ? '' : '' ?>"><?= $lang === 'en' ? 'Welcome! Download free PDF documents, study materials, and guides for learning.' : 'សូមស្វាគមន៍! អ្នកអាចទាញយកឯកសារ PDF សម្រាប់សិក្សា និងយល់ដឹងបន្ថែមពីមុខវិជ្ជាទាំងអស់ដោយឥតគិតថ្លៃ។' ?></p>
    </div>
</div>