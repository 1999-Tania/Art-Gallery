<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch all artist profiles from the database
$query = "SELECT * FROM artists";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artists</title>
   
    <style>
        body{
            
        }
        .artist-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-top: 30px;
            font-family: "Sriracha", cursive;
        }
        .artist-card:hover {
            transform: scale(1.05);
        }
        .artist-card img {
            width: 400px;
            height: auto;
            object-fit: cover;
        }
        .artist-card-body {
            padding: 20px;
        }
        .artist-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .artist-bio {
            margin-bottom: 10px;
            text-align: justify;
        }

        h4{
            text-align: center;
            background-color: #C68FE6;
            padding: 10px;
            font-family: "Sriracha", cursive;
        }

        h2{
            text-align: center;
            padding: 10px;
            background-color: #EEDF7A;
            font-family: "Sriracha", cursive;
        }
    </style>
</head>
<body>
    <h2><marquee direction="left" behavior="scroll" scrollamount="5" loop="infinite">All artists details are here, you can contact any artist of your choise</marquee></h2>
    <div class="container mt-3">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($artist = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="artist-card">
                            <img src="uploads/<?php echo htmlspecialchars($artist['profile_image']); ?>" alt="<?php echo htmlspecialchars($artist['name']); ?>">
                            <div class="artist-card-body">
                                <div class="artist-name"><?php echo htmlspecialchars($artist['name']); ?></div>
                                <h4>Bio</h4>
                                <p class="artist-bio"><?php echo nl2br(htmlspecialchars($artist['bio'])); ?></p>
                                <h4>Contact Information</h4>
                                <p><?php echo htmlspecialchars($artist['contact_info']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>No artists found!</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
include 'includes/footer.php';
?>
