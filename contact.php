<?php
include 'includes/header.php';
include 'includes/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Insert data into the contact_messages table
    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully. Thank you!'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href='contact.php';</script>";
    }

    $conn->close();
}
?>

<style>
    .contact-container {
        padding: 20px;
    }

    .contact-title {
        text-align: center;
        font-family: "Sriracha", cursive;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .contact-form {
        max-width: 600px;
        margin: 0 auto;
        font-family: "Arial", sans-serif;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group button {
        background-color: brown;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-group button:hover {
        background-color: darkred;
    }
</style>

<div class="container contact-container">
    <h1 class="contact-title">Contact Us</h1>
    
    <div class="contact-form">
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit">Send Message</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
