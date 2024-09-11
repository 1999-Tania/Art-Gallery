<?php

include 'includes/header.php';
include 'includes/db.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the user details from the database
    $query = "SELECT * FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists in the database
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Check if the artist profile exists for the logged-in user
    $query = "SELECT * FROM artists WHERE user_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the artist profile exists
        if ($result->num_rows > 0) {
            $artist = $result->fetch_assoc();
            $profile_exists = true;
        } else {
            $profile_exists = false;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Fetch the user's purchase history
    $purchases_query = "SELECT p.id, a.title, p.amount, p.payment_method, p.purchase_date 
                        FROM purchases p
                        JOIN artwork a ON p.artwork_id = a.id
                        WHERE p.user_id = ?";
    if ($stmt = $conn->prepare($purchases_query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $purchases_result = $stmt->get_result();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

} else {
    echo "You are not logged in.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: "Sriracha", cursive;
        }
        .user-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background-color: #161D6F;
            color: white;
            font-size: 40px;
            border-radius: 50%;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .welcome-message {
            font-size: 24px;
            font-weight: bold;
        }
        .profile-section {
            margin-top: 20px;
            background-color: whitesmoke;
            padding: 20px;
            width: 80%;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 10px;
            background-color: #161D6F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #1a237e;
        }
        .purchase-section {
            margin-top: 20px;
            width: 80%;
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
        }
        .purchase-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .purchase-table th, .purchase-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .purchase-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="user-logo">
            <?php echo strtoupper($user['username'][0]); ?>
        </div>
        <div class="welcome-message">
            Welcome, <?php echo htmlspecialchars($user['username']); ?>!
        </div>
        <p><?php echo htmlspecialchars($user['email']); ?></p>

        <div class="profile-section">
            <?php if ($profile_exists): ?>
                <h2>Your Artist Profile</h2>
                <p><b>Name:</b> <?php echo htmlspecialchars($artist['name']); ?></p>
                <p><b>Bio:</b> <?php echo htmlspecialchars($artist['bio']); ?></p>
                <p><b>Contact Info:</b> <?php echo htmlspecialchars($artist['contact_info']); ?></p>
                <a href="create_or_edit_profile.php" class="btn">Edit Profile</a>
                <a href="add_artwork.php" class="btn">Add Artwork</a>
            <?php else: ?>
                <h2>Create Your Artist Profile</h2>
                <p>You haven't created an artist profile yet.</p>
                <a href="create_or_edit_profile.php" class="btn">Create Profile</a>
            <?php endif; ?>
        </div>
        <?php if ($purchases_result->num_rows > 0): ?>
            <div id="purchases" class="purchase-section">
                <h2>Your Purchase History</h2>
                <table class="purchase-table">
                    <thead>
                        <tr>
                            <th>Purchase ID</th>
                            <th>Artwork Title</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($purchase = $purchases_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($purchase['id']); ?></td>
                                <td><?php echo htmlspecialchars($purchase['title']); ?></td>
                                <td><?php echo htmlspecialchars($purchase['amount']); ?></td>
                                <td><?php echo htmlspecialchars($purchase['payment_method']); ?></td>
                                <td><?php echo htmlspecialchars($purchase['purchase_date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div id="purchases" class="purchase-section">
                <h2>Your Purchase History</h2>
                <p>You haven't made any purchases yet.</p>
            </div>
        <?php endif; ?>
    </div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
