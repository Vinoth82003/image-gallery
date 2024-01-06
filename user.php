<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            /* background: #fff; */
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
            min-width: 350px;
            padding: 10px;
            background: #fff;
            position: relative;
            border-radius: 5px;
            display: flex;
            align-items: center;
            overflow: hidden;
            max-width: 100%;
            min-height: 220px;
        }

        .card-seperate {
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
    </style>
</head>

<body>

    <div class="page-container">
        <div class="card-container" id="cardContainer">

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
                    // Fetch more content or append existing content
                    // In this example, I'll just clone the existing cards and append them
                    const cards = document.querySelectorAll(".card");
                    cards.forEach((card) => {
                        const newCard = card.cloneNode(true);
                        cardContainer.appendChild(newCard);
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
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Handle CRUD operations using jQuery and Ajax
        $(document).ready(function() {
            // Load images on page load
            loadImages();

            // Function to load images
            function loadImages() {
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    success: function(response) {
                        $('#cardContainer').html(response);
                    }
                });
            }

            setInterval(() => {
                loadImages();
            }, 1000);
        });
    </script>

    <script>
        const container = document.querySelector('#cardContainer');
        let scrollAmount = 0;

        function autoScroll() {
            if (scrollAmount >= container.scrollHeight - container.clientHeight) {
                scrollAmount = 0; // Reset scroll to the top
            }
            container.scrollTo(0, scrollAmount);
            scrollAmount += 1; // Increment the scroll amount
        }

        let scrollInterval = setInterval(autoScroll, 25); // Adjust speed as necessary

        // Stop scrolling on hover
        container.addEventListener('mouseover', () => {
            clearInterval(scrollInterval);
        });

        container.addEventListener('mouseout', () => {
            scrollInterval = setInterval(autoScroll, 25);
        });

        // Expand the description box on clicking "Read More"
        document.querySelectorAll('.read-more').forEach(button => {
            button.addEventListener('click', () => {
                const description = button.parentElement;
                if (description.style.height === '100px') {
                    description.style.height = 'auto';
                    button.textContent = 'Read Less';
                } else {
                    description.style.height = '100px';
                    button.textContent = 'Read More';
                }
            });
        });
    </script>
</body>

</html>