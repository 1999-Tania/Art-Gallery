<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch all categories from the database
$query = "SELECT * FROM categories";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php while ($category = $result->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <a href="gallery.php?category_id=<?php echo htmlspecialchars($category['id']); ?>" class="category-link">
                        <div class="category-circle text-center" style="background-color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)); ?>">
                            <!-- Display the category name inside the circle -->
                            <span><?php echo htmlspecialchars($category['category_name']); ?></span>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
} else {
    echo "<p>No categories found!</p>";
}

include 'includes/footer.php';
?>

<style>
    body{
        background-image: url('https://as1.ftcdn.net/v2/jpg/02/28/18/62/1000_F_228186227_hTEQS8k4VtopmEVnkBbPvOaSIfXsqWON.jpg');
        background-size: cover;
    }
    .category-circle {
        width: 200px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20%
        color: white;
        font-size: 18px;
        font-weight: bold;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 0 auto;
    }
    
    .category-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .category-link {
        text-decoration: none;
        color: black;
    }

    .category-link span {
        display: block;
        width: 100%;
        height: 100%;
        line-height: 100px;
        text-align: center;
    }
</style>
