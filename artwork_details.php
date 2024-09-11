<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch artwork details
$artwork_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$artwork_query = "SELECT * FROM artwork WHERE id = $artwork_id";
$artwork_result = $conn->query($artwork_query);

if ($artwork_result->num_rows > 0) {
    $artwork = $artwork_result->fetch_assoc();
} else {
    echo "<p>Artwork not found.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
    .artwork-details {
        margin-top: 20px;
        text-align: center;
        font-family: "Sriracha", cursive;
    }

    .artwork-details p{
        margin-top: 20px;
        text-align: justify;
    }
    .artwork-image {
        width: 100%;
        max-width: 600px;
        height: auto;
        cursor: pointer;
    }
    .btn-back {
        background-color: brown;
        color: white;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background-color: black;
        color: white;
    }

    /* Overlay styles */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .overlay img {
        max-width: 90%;
        max-height: 90%;
    }

    /* Zoom buttons */
    .zoom-controls {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1001;
        display: flex;
        gap: 10px;
    }

    .zoom-controls button {
        background-color: brown;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
    }

    .zoom-controls button:focus {
        outline: none;
    }
</style>

<div class="container artwork-details">
    <h1><?php echo htmlspecialchars($artwork['title']); ?></h1>
    <img src="uploads/<?php echo htmlspecialchars($artwork['image']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" class="artwork-image" id="artwork-image">
    <p><?php echo nl2br(htmlspecialchars($artwork['description'])); ?></p>
    <p>Rs.<?php echo nl2br(htmlspecialchars($artwork['price'])); ?></p>
    <a href="gallery.php" class="btn btn-back">Back to Gallery</a><a href="purchase.php?id=<?php echo $artwork['id']; ?>" class="btn btn-success" style="margin-left:10px;">Buy Now</a>

</div>

<!-- Overlay for image zoom -->
<div class="overlay" id="image-overlay">
    <div class="zoom-controls">
        <button id="zoom-in">Zoom In</button>
        <button id="zoom-out">Zoom Out</button>
        <button id="close-overlay">Close</button>
    </div>
    <img src="uploads/<?php echo htmlspecialchars($artwork['image']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" id="zoomed-image">
</div>

<script>
    const artworkImage = document.getElementById('artwork-image');
    const imageOverlay = document.getElementById('image-overlay');
    const zoomedImage = document.getElementById('zoomed-image');
    const zoomInBtn = document.getElementById('zoom-in');
    const zoomOutBtn = document.getElementById('zoom-out');
    const closeOverlayBtn = document.getElementById('close-overlay');

    let zoomLevel = 1;

    // Open overlay on image click
    artworkImage.addEventListener('click', () => {
        imageOverlay.style.display = 'flex';
    });

    // Close overlay
    closeOverlayBtn.addEventListener('click', () => {
        imageOverlay.style.display = 'none';
        zoomLevel = 1; // Reset zoom level
        zoomedImage.style.transform = `scale(${zoomLevel})`;
    });

    // Zoom in function
    zoomInBtn.addEventListener('click', () => {
        zoomLevel += 0.1;
        zoomedImage.style.transform = `scale(${zoomLevel})`;
    });

    // Zoom out function
    zoomOutBtn.addEventListener('click', () => {
        if (zoomLevel > 0.1) {
            zoomLevel -= 0.1;
            zoomedImage.style.transform = `scale(${zoomLevel})`;
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
