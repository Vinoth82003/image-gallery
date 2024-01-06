<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">

    <div class="mb-2">
        <h1 class="mt2">Role <span class="badge text-bg-secondary" style="color: green;">Admin</span></h1>
    </div>

    <h2 class="mb-4">Image Gallery</h2>

    <!-- Add Button to Open Modal -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addImageModal">
        Add Image
    </button>

    <!-- Image Gallery Cards -->
    <div class="row" id="imageGallery">
        <!-- Images will be displayed here using PHP -->
    </div>
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Adding Image -->
                <form id="addImageForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imageTitle">Title</label>
                        <input type="text" class="form-control" id="imageTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="imageDescription">Description</label>
                        <textarea class="form-control" id="imageDescription" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imageFile">Choose Image</label>
                        <input type="file" class="form-control-file" id="imageFile" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Image</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImageModalLabel">Edit Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Editing Image -->
                <form id="editImageForm" enctype="multipart/form-data">
                    <input type="hidden" id="editImageId" name="id">
                    <div class="form-group">
                        <label for="editImageTitle">Title</label>
                        <input type="text" class="form-control" id="editImageTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editImageDescription">Description</label>
                        <textarea class="form-control" id="editImageDescription" name="description" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                    <img class="card-img-top" id="image">
                    </div> -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Handle CRUD operations using jQuery and Ajax
    $(document).ready(function () {
        // Load images on page load
        loadImages();

        // Submit form to add image
        $('#addImageForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: 'crud.php',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#addImageModal').modal('hide');
                    $('#addImageForm')[0].reset();
                    loadImages();
                }
            });
        });

        // Function to load images
        function loadImages() {
            $.ajax({
                url: 'crud.php',
                type: 'GET',
                success: function (response) {
                    $('#imageGallery').html(response);
                }
            });
        }

        // ...

// Edit Image
$('#imageGallery').on('click', '.edit-btn', function () {
    var imageId = $(this).data('id');

    // Fetch image details using AJAX
    $.ajax({
        url: 'crud.php',
        type: 'POST',
        data: { action: 'edit', id: imageId },
        success: function (response) {
            // console.log(response);
            if (response.status && response.status === 'success') {
                var imageData = response;

                // Populate the Edit Image Modal with the existing data
                $('#editImageId').val(imageData.id);
                $('#editImageTitle').val(imageData.title);
                $('#editImageDescription').val(imageData.description);
                // $('#image').attr('src', imageData.file_path);

                // Show the Edit Image Modal
                $('#editImageModal').modal('show');
            } else {
                // Handle the case where the image is not found or other errors
                // alert('Error fetching image details.');
                console.log(response);
            }
        },
        error: function (err) {
            // Handle other errors, if any
            console.log("err");
            alert('Error image details.');
        }
    });
});

// ...


        // Submit form to edit image
        $('#editImageForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('action', 'edit-submit'); // Add the action
    formData.append('id', $('#editImageId').val()); // Add the image ID
    formData.append('title', $('#editImageTitle').val()); // Add the image 
    formData.append('description', $('#editImageDescription').val()); // Add the image ID

    $.ajax({
        url: 'crud.php', // Change to the actual file handling edit logic
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editImageModal').modal('hide');
            $('#editImageForm')[0].reset();
            loadImages();
        },
        error: function () {
            alert('Error updating image details.');
        }
    });
});


        // Delete Image
        $('#imageGallery').on('click', '.delete-btn', function () {
            var confirmDelete = confirm('Are you sure you want to delete this image?');
            if (confirmDelete) {
                var imageId = $(this).data('id');

                // Perform delete operation using AJAX
                $.ajax({
                    url: 'crud.php', // Change to the actual file handling delete logic
                    type: 'POST',
                    data: { action: 'delete', id: imageId },
                    success: function (response) {
                        loadImages();
                    }
                });
            }
        });
    });
</script>
</body>
</html>