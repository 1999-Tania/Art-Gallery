<?php
include 'includes/header.php';
include 'includes/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>You must be logged in to make a purchase. Redirecting to login page...</p>";
    header("refresh:2;url=login.php");
    exit;
}

// Fetch artwork details
$artwork_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$artwork_query = "SELECT * FROM artwork WHERE id = $artwork_id";
$artwork_result = $conn->query($artwork_query);

if ($artwork_result->num_rows > 0) {
    $artwork = $artwork_result->fetch_assoc();
} else {
    echo "<p>Artwork not found. Redirecting to gallery...</p>";
    header("refresh:2;url=gallery.php");
    exit;
}

// Handle form submission
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $artwork['price'];
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    // Insert purchase record into database
    $purchase_query = "INSERT INTO purchases (user_id, artwork_id, amount, payment_method, purchase_date) 
                       VALUES ('$user_id', '$artwork_id', '$amount', '$payment_method', NOW())";

    if ($conn->query($purchase_query) === TRUE) {
        $success_message = "Thank you for your purchase! Your order has been processed successfully.";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'user_dashboard.php';
                }, 2000);
              </script>";
    } else {
        echo "<p>Error processing your purchase. Please try again.</p>";
    }
}
?>

<style>
    .purchase-details {
        margin-top: 20px;
        text-align: center;
        font-family: "Sriracha", cursive;
    }

    .purchase-form {
        margin-top: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
        font-family: Arial, sans-serif;
    }

    .purchase-form label {
        font-weight: bold;
        margin-top: 10px;
    }

    .purchase-form input,
    .purchase-form select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 20px;
    }

    .purchase-form button {
        width: 100%;
        padding: 10px;
        background-color: brown;
        color: white;
        border: none;
        cursor: pointer;
    }

    .purchase-form button:hover {
        background-color: darkred;
    }

    /* Transparent overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Dark transparent background */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000; /* Ensure it overlays the content */
    }

    /* Success message box inside the overlay */
    .success-message {
        max-width: 600px;
        padding: 20px;
        border: 2px solid #28a745;
        border-radius: 10px;
        background-color: rgba(212, 237, 218, 0.9); /* Semi-transparent green background */
        color: #155724;
        text-align: center;
        font-family: Arial, sans-serif;
    }

    .success-message .tick {
        font-size: 50px;
        color: #28a745;
    }
</style>

<div class="container purchase-details">
    <h1>Purchase Artwork: <?php echo htmlspecialchars($artwork['title']); ?></h1>
    <img src="uploads/<?php echo htmlspecialchars($artwork['image']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" class="artwork-image" style="max-width: 100%; height: auto;">
    
    <form class="purchase-form" method="post">
        <label for="user-id">User ID:</label>
        <input type="text" id="user-id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" readonly>

        <label for="artwork-id">Artwork ID:</label>
        <input type="text" id="artwork-id" name="artwork_id" value="<?php echo htmlspecialchars($artwork['id']); ?>" readonly>

        <label for="artwork-title">Artwork Title:</label>
        <input type="text" id="artwork-title" name="artwork_title" value="<?php echo htmlspecialchars($artwork['title']); ?>" readonly>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="Rs.<?php echo htmlspecialchars($artwork['price']); ?>" readonly>

        <label for="payment-method">Select Payment Method:</label>
        <select id="payment-method" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="debit_card">Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="net_banking">Net Banking</option>
        </select>

        <button type="submit" style="margin-bottom:10px;">Buy Now</button>
    </form>
</div>

<?php if ($success_message): ?>
    <div class="overlay">
        <div class="success-message">
            <div class="tick">✔</div>
            <p><?php echo $success_message; ?></p>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
