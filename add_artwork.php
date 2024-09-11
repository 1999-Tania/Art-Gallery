<?php
// Start output buffering to prevent "headers already sent" issues
ob_start();

include 'includes/header.php';  // Adjust path as needed
include 'includes/db.php';      // Adjust path as needed

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $description = $price = $image = "";
$category_id = null;

// Fetch categories for the dropdown
$categories = [];
$query = "SELECT id, category_name FROM categories";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Handle Artwork Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_artwork'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Handle file upload
    if ($_FILES['image']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Check if the uploads directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            exit;
        }
    }

    // Insert artwork into the database
    $query = "INSERT INTO artwork (user_id, title, description, category_id, price, image) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("issids", $user_id, $title, $description, $category_id, $price, $image);
        if ($stmt->execute()) {
            header("Location:gallery.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error adding artwork: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error preparing the query: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artwork</title>
    <style>
        body {
            background: linear-gradient(to right, #ff7e5f, #feb47b, #ffb347);
        }

        .container-form {
            background-color: rgba(255, 255, 240, 0.5);
            margin-left: 450px;
            margin-right: 450px;
            margin-bottom: 50px;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container-form mt-5">
        <h1 class="mb-4">Add Artwork</h1>

        <!-- Add Artwork Form -->
        <form action="add_artwork.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description"
                    class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['category_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" class="form-control"
                    value="<?php echo htmlspecialchars($price); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Artwork Image:</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" name="add_artwork" class="btn btn-dark" style="margin-top:20px;margin-left:120px;">Add Artwork</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; // Adjust path as needed ?>
</body>
</html>

<?php
// End output buffering and flush the output
ob_end_flush();
?>
