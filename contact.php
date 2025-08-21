<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Blood Donation</title>
  <style>

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      color: #333;
      background: #f9f9f9;
    }


    header {
      background: #ff4d4d;
      color: #fff;
      padding: 1rem 0;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    header h1 {
      margin-bottom: 0.5rem;
      font-size: 2.5rem;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      font-size: 1.1rem;
    }

    nav a:hover {
      text-decoration: underline;
    }

  
    .contact {
      display: flex;
      justify-content: space-around;
      padding: 80px 20px;
      background: #fff;
      max-width: 1200px;
      margin: 50px auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-form {
      flex: 1;
      margin-right: 20px;
    }

    .contact-form h2,
    .contact-info h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .contact-form textarea {
      height: 150px;
      resize: vertical;
    }

    .contact-form button {
      background: #ff4d4d;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
     .login-button {
      background: #fff;
      color: #ff4d4d;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .contact-form button:hover {
      background: #e60000;
    }

    .contact-info {
      flex: 1;
      margin-left: 20px;
    }

    .contact-info p {
      font-size: 1.1rem;
      margin-bottom: 1rem;
      color: #666;
    }

    .contact-info i {
      margin-right: 10px;
      color: #ff4d4d;
    }

    .map {
      padding: 20px;
      background: #f9f9f9;
      text-align: center;
    }

    .map h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    .map iframe {
      width: 100%;
      height: 400px;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 20px 0;
      margin-top: 50px;
    }

    footer p {
      margin: 0;
    }
  </style>
</head>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".contact-form form");
   

    form.addEventListener("submit", function (e) {
    
      alert(" Your message has been sent successfully.");
    });
  });
</script>
<body>
  <header>
    <h1>Blood Donation</h1>
   <nav>
   <a href="home.php">Home</a>
      <a href="aboutus.php">About Us</a>
            <a href="contact.php">Contact Us</a>
      <a href="login.php" class="login-button">Login</a>
    </nav>
  </header>

  <section class="contact">
    <div class="contact-form">
      <h2>Get in Touch</h2>
      <form action="#" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
        
      </form>
    </div>

    <div class="contact-info">
      <h2>Contact Information</h2>
      <p><i class="fas fa-map-marker-alt"></i> Tabuk City,  Saudi Arabia</p>
      <p><i class="fas fa-phone"></i> +966 14 123 4567</p>
      <p><i class="fas fa-envelope"></i> info@blooddonation.com</p>
      <p><i class="fas fa-clock"></i> Sun - Thu: 9:00 AM - 6:00 PM</p>
    </div>
  </section>

  <section class="map">
    <h2>Our Location</h2>
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3579.988243832318!2d36.57292331503189!3d28.38388238244662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15034a5b5f5b5b5b%3A0x5b5b5b5b5b5b5b5b!2sTabuk%20City%2C%20Saudi%20Arabia!5e0!3m2!1sen!2sus!4v1622549400000!5m2!1sen!2sus"
      allowfullscreen=""
      loading="lazy">
    </iframe>
  </section>

  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>

  <script src="https://kit.fontawesome.com/a076d05399.js">
    
  </script>
</body>
</html>