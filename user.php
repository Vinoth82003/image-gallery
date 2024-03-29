<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .page-container {
            background: #ddd;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
        }

        .card-container {
            min-width: 400px;
            max-height: 650px;
            max-width: calc(650px);
            display: flex;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-wrap: nowrap;
            align-items: center;
            position: relative;
            overflow-y: scroll;
        }

        .card {
            min-width: 400px;
            padding: 10px;
            background: #fff;
            position: relative;
            border-radius: 5px;
            display: flex;
            align-items: center;
            overflow: hidden;
            max-width: 100%;
            min-height: 220px;
            width: 100%;
        }

        .card.active {
            height: 100%;
        }

        .card-separate {
            flex-basis: 50%;
            position: relative;
            height: 200px;
        }

        .card-image {
            width: 310px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-image img {
            max-height: 200px;
            max-width: 100%;
        }

        .card-title {
            font-size: 24px;
            padding: 10px;
            color: #3a3a3a;
            font-family: sans-serif;
            font-weight: 600;
            text-transform: capitalize;
        }

        .card-description {
            padding: 10px;
            max-width: 300px;
        }

        .read-more {
            padding: 10px;
            border-radius: 20px;
            background: #3a3a3a3c;
            position: absolute;
            right: 0px;
            bottom: 0px;
            color: #000;
            cursor: pointer;
        }

        /* Add the following styles inside your <style> block */

        .card-container::-webkit-scrollbar {
            width: 2px;
            height: 2px;
        }

        .card-container::-webkit-scrollbar-track {
            background-color: #ddd;
        }

        .card-container::-webkit-scrollbar-thumb {
            background-color: #3a3a3a;
            border-radius: 10px;
        }

        .card-container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }


        .card-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card {
            min-width: 400px;
            padding: 10px;
            background: #fff;
            position: relative;
            border-radius: 5px;
            display: flex;
            align-items: center;
            overflow: hidden;
            max-width: 100%;
            min-height: 220px;
            width: 100%;
        }

        .card-container {
            max-height: 650px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
            /* Set to 'scroll' if you want a scrollbar always visible */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="page-container">
        <div class="card-container" id="cardContainer">
            <!-- Initial cards go here -->
        </div>
    </div>

    <script>
        const cardContainer = document.getElementById("cardContainer");
        let isScrolling = false;

        cardContainer.addEventListener("scroll", function() {
            if (!isScrolling) {
                // Check if the user has reached the bottom of the container
                if (
                    cardContainer.scrollTop + cardContainer.clientHeight >=
                    cardContainer.scrollHeight
                ) {
                    // Fetch more content or append existing content using Ajax
                    $.ajax({
                        url: 'fetch.php',
                        type: 'GET',
                        success: function(response) {
                            $('#cardContainer').append(response);
                            startAutoScroll(); // Call startAutoScroll after cards are loaded
                        }
                    });

                    // Reset the flag after a short delay to avoid continuous scrolling
                    isScrolling = true;
                    setTimeout(() => {
                        isScrolling = false;
                    }, 200);
                }
            }
        });

        // Pause infinite scroll on hover
        cardContainer.addEventListener("mouseenter", function() {
            isScrolling = true;
        });

        // Resume infinite scroll on mouse leave
        cardContainer.addEventListener("mouseleave", function() {
            isScrolling = false;
        });

        // Function to load images
        function loadImages() {
            $.ajax({
                url: 'fetch.php',
                type: 'GET',
                success: function(response) {
                    $('#cardContainer').html(response);
                    startAutoScroll(); // Call startAutoScroll after cards are loaded
                }
            });
        }

        // Load images on page load
        loadImages();

        // Set interval to continuously load images
        setInterval(loadImages, 1000);
    </script>
</body>

</html>