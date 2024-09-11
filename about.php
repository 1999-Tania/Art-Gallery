<?php
include 'includes/header.php';
include 'includes/db.php';
?>
<style>
    .about-container {
        padding: 20px;
    }

    .about-title {
        text-align: center;
        font-family: "Sriracha", cursive;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .about-content {
        font-family: "Arial", sans-serif;
        line-height: 1.6;
        margin: 0 auto;
        max-width: 800px;
    }

     h2 {
        margin-top: 20px;
        background-color: #C68FE6;
        text-align: center;
        padding: 10px;
        font-family: "Sriracha", cursive;
    }

    .about-content p {
        margin-bottom: 15px;
    }

    .about-image {
        text-align: center;
        margin: 20px 0;
    }

    .about-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>

<div class="container about-container">
    <h1 class="about-title">About Us</h1>
    
    <!-- <div class="about-content"> -->
        <h2>Our Mission</h2>
        <p>Welcome to our Art Gallery! Our mission is to provide a vibrant platform for artists and art enthusiasts to connect, explore, and celebrate creativity. We are dedicated to showcasing a diverse range of artworks, from contemporary pieces to timeless classics, and fostering a community where art can thrive.</p>

        <h2>Our Story</h2>
        <p>Founded in 2024, our gallery has grown from a small local space into a renowned destination for art lovers. We started with a simple vision: to create a space where art could be appreciated and artists could find their audience. Over the years, we have expanded our collection, hosted numerous exhibitions, and supported emerging talents.</p>

        <h2>What We Offer</h2>
        <p>At our gallery, you can explore a wide range of art forms, including paintings, sculptures, photography, and more. We offer:</p>
        <ul>
            <li>Regular exhibitions featuring both established and emerging artists.</li>
            <li>A variety of art styles and mediums to suit diverse tastes.</li>
            <li>Opportunities for artists to showcase their work and engage with the community.</li>
            <li>Educational programs and workshops to enhance art appreciation.</li>
        </ul>

        <h2>Visit Us</h2>
        <p>We invite you to visit our gallery and experience the beauty of art firsthand. Our doors are open 5days, and we look forward to welcoming you. For more information, please <a href="contact.php">contact us</a> or visit our website.</p>

        <div class="about-image">
            <img src="https://i.pinimg.com/originals/87/46/37/874637bc449aeeb3cf7cd69e7fb08132.jpg" alt="Art Gallery Interior">
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
