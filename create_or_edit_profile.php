<?php


include 'includes/header.php';
include 'includes/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$profile_exists = false;
$name = $bio = $profile_image = $contact_info = "";

// Check if the artist profile already exists for the logged-in user
$query = "SELECT * FROM artists WHERE user_id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $profile_exists = true;
        $artist = $result->fetch_assoc();
        $name = $artist['name'];
        $bio = $artist['bio'];
        $profile_image = $artist['profile_image'];
        $contact_info = $artist['contact_info'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $contact_info = $_POST['contact_info'];

    // Handle file upload
    if ($_FILES['profile_image']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_image = basename($_FILES["profile_image"]["name"]);
    }

    if ($profile_exists) {
        // Update existing profile
        $update_query = "UPDATE artists SET name = ?, bio = ?, profile_image = ?, contact_info = ? WHERE user_id = ?";
        if ($stmt = $conn->prepare($update_query)) {
            $stmt->bind_param("ssssi", $name, $bio, $profile_image, $contact_info, $user_id);
            $stmt->execute();
            header("Location: user_dashboard.php");
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    } else {
        // Create new profile
        $insert_query = "INSERT INTO artists (user_id, name, bio, profile_image, contact_info) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($insert_query)) {
            $stmt->bind_param("issss", $user_id, $name, $bio, $profile_image, $contact_info);
            $stmt->execute();
            header("Location: user_dashboard.php");
        } else {
            echo "Error creating profile: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile_exists ? 'Edit Profile' : 'Create Profile'; ?></title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .half-bg {
            position: relative;
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZmkZ3XdT4oI0rjxyOQCi5LSZySRBmWsgvpA&s'); /* Change to your background image path */
            background-size: cover;
            background-position: center;
            height: 50vh;
            filter: blur(3px);
        }

        .content-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: black;
            font-family: "Sriracha", cursive;
            z-index: 2;
        }

        .content-wrapper h1 {
            font-size: 4em;
            margin: 0;
        }

        .content-wrapper p {
            font-size: 1.5em;
            margin: 0;
        }

        .form-container {
            margin-top: 155px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #FADFA1;
            border-radius: ;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 50%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-top: 20px;
        }

        .unblurred-text {
            position: relative;
            z-index: 3;
            margin-top: -25vh;
        }
    </style>
</head>
<body>
    <div class="half-bg"></div>
    <div class="unblurred-text">
        <div class="content-wrapper">
            <h1><?php echo $profile_exists ? 'Edit Your Profile' : 'Create Your Profile'; ?></h1>
            <p>Showcase your artistic journey and let the world see your creativity.</p>
        </div>
    </div>
    <div class="container">
        <div class="form-container">
            <form action="create_or_edit_profile.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <textarea name="bio" id="bio" class="form-control"><?php echo htmlspecialchars($bio); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" name="profile_image" id="profile_image" class="form-control">
                    <?php if ($profile_image): ?>
                        <p>Current Image: <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" width="100"></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="contact_info">Contact Info:</label>
                    <input type="text" name="contact_info" id="contact_info" class="form-control" value="<?php echo htmlspecialchars($contact_info); ?>">
                </div>
                <button type="submit" class="btn btn-dark" style="margin-top:5px;margin-left:37%;"><?php echo $profile_exists ? 'Update Profile' : 'Create Profile'; ?></button>
            </form>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
