<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Blood Donation</title>
  <style>
 
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  
     .login-button {
      background: #fff;
      color: #ff4d4d;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
    
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

    .page-background {
      background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url('https://images.unsplash.com/photo-1584118624012-df056829fbd0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') no-repeat center center/cover;
      min-height: 100vh;
      padding: 20px;
    }

    .about-us {
      padding: 80px 20px;
      text-align: center;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      max-width: 800px;
      margin: 50px auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .about-us h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    .about-us p {
      font-size: 1.1rem;
      color: #666;
      margin-bottom: 1.5rem;
    }

    .mission-vision {
      display: flex;
      justify-content: space-around;
      padding: 50px 20px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      max-width: 1200px;
      margin: 0 auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .mission-vision .card {
      flex: 1;
      margin: 0 20px;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .mission-vision .card h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    .mission-vision .card p {
      font-size: 1rem;
      color: #666;
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

  <div class="page-background">
    
    <section class="about-us">
      <h2>About Us</h2>
      <p>
        Welcome to <strong>Blood Donation</strong>, a platform dedicated to saving lives through the power of blood donation. 
        Our mission is to connect donors with those in need, ensuring that no one suffers due to a lack of blood. 
        Join us in making a difference today!
      </p>
    </section>

   
    <section class="mission-vision">
      <div class="card">
        <h3>Our Mission</h3>
        <p>
          To create a reliable and efficient blood donation network that ensures timely access to safe blood for everyone in need.
        </p>
      </div>
      <div class="card">
        <h3>Our Vision</h3>
        <p>
          A world where no life is lost due to the unavailability of blood, and every individual is inspired to donate blood regularly.
        </p>
      </div>
    </section>
  </div>

 
  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>
</body>
</html>