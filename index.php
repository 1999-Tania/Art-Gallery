
<?php
include 'includes/header.php';
include 'includes/db.php'; // Database connection

// Fetch featured artworks
$query = "SELECT * FROM artwork ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($query);
?>

<style>
    .background-container {
        position: relative;
        height: 50vh;
        overflow: hidden;
    }

    .blurred-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://png.pngtree.com/thumb_back/fh260/background/20231105/pngtree-vibrant-abstract-art-colorful-paint-texture-background-wallpaper-image_13772345.png') no-repeat center center;
        background-size: cover;
        filter: blur(5px);
        z-index: 1;
    }

    .background-text {
        position: relative;
        color: black;
        font-size: 2.5em;
        font-weight: bold;
        text-align: center;
        z-index: 2;
        padding-top: 15vh;
        font-family: "Sriracha", cursive;
        font-weight: 400;
        font-style: normal;
        top:-8%;
    }

    .logo-description-container {
        display: flex;
        align-items: center;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .description-container {
        flex: 1;
    }

    .description-container h2 {
        font-size: 2em;
        text-align: center;
        font-family: "Sriracha", cursive;
    }

    .description-container p {
        text-align: justify;
        margin-left: 20%;
        margin-right: 15%;
    }

    .logo-container img {
        height: 300px;
        padding-left: 30px;
    }

    .categories-container {
        padding: 40px 20px;
        text-align: center;
    }

    .categories-container h2 {
        font-size: 2.5em;
        margin-bottom: 30px;
        font-family: "Sriracha", cursive;
        background-color: #C68FE6;
        padding: 10px;
    }

    .card {
        margin-bottom: 20px;
        font-family: "Sriracha", cursive;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card img{
        height: 200px;
        object-fit: cover;
    }

    .btn-view {
        margin-top: 10px;
    }

    .card-text {
        text-align: justify;
    }

    .card-title {
        font-family: "Sriracha", cursive;
    }

    .btn-view {
        background-color: brown;
        border-radius: 5px;
        padding-left: 30px;
        padding-right: 30px;
        border: none;
    }

    .highlights-container {
        padding: 40px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: left;
    }

    .highlights-container .highlights {
        flex: 1;
    }

    h2 {
        font-size: 2.5em;
        font-family: "Sriracha", cursive;
        margin-bottom: 20px;
        text-align: center;
        background-color: #C68FE6;
        padding: 10px;
        margin-left: 35px;
        margin-right: 35px;
    }

    .highlight-point {
        top: -10%;
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        margin-left: 100px;
        font-size: 20px;
        font-family: "Sriracha", cursive;
    }

    .highlight-point i {
        font-size: 1.5em;
        margin-right: 15px;
        color: #C68FE6; /* Adjust color as needed */
    }

    .highlights-container .highlights-image img {
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 50px;
    }
</style>

<div class="background-container">
    <div class="blurred-background"></div>
    <div class="background-text">
        Welcome to Artistry Haven<br>Where Creativity Meets Canvas <br> <button style="background-color:pink; border-radius:7px;"><a href="login.php" style="text-decoration:none; color:black;">Login Here</a></button>
    </div>
</div>

<div class="logo-description-container">
    <div class="logo-container">
        <img src="images/logo1.png" alt="Art Gallery Logo"> <!-- Replace with your logo path -->
    </div>
    <div class="description-container">
        <h2>About Us</h2>
        <p>At Artistry Haven, we celebrate the beauty of artistic expression and creativity. Our gallery showcases a diverse collection of artworks from talented artists around the world. We aim to provide a platform for artists to share their work with the public and offer art enthusiasts a chance to explore and appreciate various forms of art. Join us in our journey to explore, appreciate, and support the world of art. Experience the transformative power of art and connect with a vibrant community of creators and admirers.</p>
    </div>
</div>

<div class="categories-container">
    <h2>Different Art Categories</h2>
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-3">
            <div class="card">
                <img src="https://d28jbe41jq1wak.cloudfront.net/BlogsImages/abstract_art_Compressed_638250928944386407.jpg" class="card-img-top" alt="Abstract Art">
                <div class="card-body">
                    <h5 class="card-title"><u>Abstract Art</u></h5>
                    <p class="card-text">Explore the world of abstract art where shapes, colors, and forms come together to create unique and thought-provoking compositions.</p>
                    <a href="gallery.php?category_id=21" class="btn btn-primary btn-view">View</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-3">
            <div class="card">
                <img src="https://www.artfactory.in/product_pictures/CP-WA199.jpg" class="card-img-top" alt="Landscape Art">
                <div class="card-body">
                    <h5 class="card-title"><u>Landscape Art</u></h5>
                    <p class="card-text">Immerse yourself in beautiful depictions of natural scenes, capturing the essence of landscapes from serene mountains to vibrant forests.</p>
                    <a href="gallery.php?category_id=1" class="btn btn-primary btn-view">View</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-3">
            <div class="card">
                <img src="https://img.freepik.com/free-photo/painting-woman-with-blue-shirt-pink-eyes_1340-37516.jpg" class="card-img-top" alt="Portrait Art">
                <div class="card-body">
                    <h5 class="card-title"><u>Portrait Art</u></h5>
                    <p class="card-text">Discover stunning portraits that reveal the personality and emotions of individuals through skilled artistic representation.</p>
                    <a href="gallery.php?category_id=22" class="btn btn-primary btn-view">View</a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-3">
            <div class="card">
                <img src="https://media.timeout.com/images/105575726/750/422/image.jpg" class="card-img-top" alt="Sculpture">
                <div class="card-body">
                    <h5 class="card-title"><u>Sculpture</u></h5>
                    <p class="card-text">Explore three-dimensional art created through carving, modeling, or assembling materials, bringing forms to life in a tactile and engaging way.</p>
                    <a href="gallery.php?category_id=23" class="btn btn-primary btn-view">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<h2>Gallery Highlights and Features</h2>
<div class="highlights-container">
    
    <div class="highlights">
        
        <div class="highlight-point">
            <i class="fas fa-palette"></i> <!-- Font Awesome icon for example -->
            <span><b>Diverse Art Categories:</b> Explore multiple artistic styles and mediums.</span>
        </div>
        <div class="highlight-point">
            <i class="fas fa-user"></i> <!-- Font Awesome icon for example -->
            <span><b>Interactive Artist Profiles:</b> Learn about artists and their work.</span>
        </div>
        <div class="highlight-point">
            <i class="fas fa-calendar-alt"></i> <!-- Font Awesome icon for example -->
            <span><b>Curated Exhibitions:</b> Regularly updated thematic showcases.</span>
        </div>
        <div class="highlight-point">
            <i class="fas fa-mobile-alt"></i> <!-- Font Awesome icon for example -->
            <span><b>User-Friendly Design:</b> Seamless experience on all devices.</span>
        </div>
    </div>
    <div class="highlights-image">
        <img src="https://indianartideas.in/articleimages/1606284249art%20gallery.png" alt="Gallery Highlights"> <!-- Replace with your image path -->
    </div>
</div>
 <!-- Font Awesome for icons -->

 <h2>Featured Artworks</h2>
<div class="container container-content">
   
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <a href="artwork_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-view">View Details</a><a href="purchase.php?id=<?php echo $row['id']; ?>" class="btn btn-success" style="margin-top:10px; margin-left:5px">Buy</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<?php include 'includes/footer.php'; ?>