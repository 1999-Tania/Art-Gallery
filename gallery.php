<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch categories for the filter dropdown
$categories = [];
$category_query = "SELECT id, category_name FROM categories";
$category_result = $conn->query($category_query);
if ($category_result->num_rows > 0) {
    while ($category_row = $category_result->fetch_assoc()) {
        $categories[] = $category_row;
    }
}

// Fetch artworks by category
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$query = $category_id ? "SELECT * FROM artwork WHERE category_id = $category_id" : "SELECT * FROM artwork";
$result = $conn->query($query);
?>
<style>
    h1 {
        text-align: center;
        font-family: "Sriracha", cursive;
        margin-top: 10px;
    }
    .form-group {
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Sriracha", cursive;
    }

    .form-group label {
        margin-right: 10px;
    }

    form{
        display: flex;
    }

    .btn {
        background-color: brown;
        color: white;
        margin-top:5px;
        margin-bottom: 5px;
        margin-left: 10px;
    }

    .card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .card img {
    width: 100%;
    height: 250px; /* Set a fixed height for images */
    object-fit: cover; /* Ensure images cover the card area without distortion */
    transition: transform 0.3s ease;
}

    .card:hover img {
        transform: scale(1.1);
    }

    .card-body {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-family: "Sriracha", cursive;
    }

    .card:hover .card-body {
        opacity: 1;

    }
</style>
<div class="container">
    <h1>Art Gallery</h1>
    
    <!-- Filter Form -->
    <form action="gallery.php" method="GET" class="mb-4">
        <div class="form-group">
            <label for="category_id">Filter by Category:</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn">Filter</button>
    </form>

    <!-- Artworks Display -->
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <a href="artwork_details.php?id=<?php echo $row['id']; ?>" class="card-link">
                    <div class="card">
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="margin-top:100px;margin-bottom:200px;font-size: 2em;">No artworks found in this category.</p>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
