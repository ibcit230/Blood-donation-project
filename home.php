<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Donation - Save Lives</title>
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

    nav {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
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

   
    .login-button {
      background: #fff;
      color: #ff4d4d;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .login-button:hover {
      background: #e60000;
      color: #fff;
    }

   
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1584118624012-df056829fbd0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') no-repeat center center/cover;
      color: #fff;
      padding: 150px 20px;
      text-align: center;
    }

    .hero h2 {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.5rem;
      margin-bottom: 2rem;
    }

    .hero .cta-button {
      background: #ff4d4d;
      color: #fff;
      padding: 15px 30px;
      border: none;
      border-radius: 5px;
      font-size: 1.2rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .hero .cta-button:hover {
      background: #e60000;
    }

  
    .features {
      display: flex;
      justify-content: space-around;
      padding: 80px 20px;
      background: #fff;
      text-align: center;
    }

    .features .feature {
      flex: 1;
      margin: 0 20px;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .features .feature:hover {
      transform: translateY(-10px);
    }

    .features .feature img {
      width: 80px;
      height: 80px;
      margin-bottom: 1rem;
    }

    .features .feature h3 {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
      color: #ff4d4d;
    }

    .features .feature p {
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


  <section class="hero">
    <h2>Donate Blood, Save Lives</h2>
    <p>Your single donation can save up to 3 lives. Join us in making a difference today.</p>
    <button class="cta-button" onclick="window.location.href='RegisterAll.php'">Register Now</button>
  </section>


  <section class="features">
    <div class="feature">
      <img src="https://img.icons8.com/color/96/000000/checkmark--v1.png" alt="Eligibility Icon">
      <h3>Check Eligibility</h3>
      <p>Find out if you're eligible to donate blood in just a few clicks.</p>
    </div>
    <div class="feature">
      <img src="https://img.icons8.com/color/96/000000/worldwide-location.png" alt="Location Icon">
      <h3>Find a Blood Bank</h3>
      <p>Locate the nearest blood bank or donation camp.</p>
    </div>
    <div class="feature">
      <img src="https://img.icons8.com/color/96/000000/calendar--v1.png" alt="Appointment Icon">
      <h3>Schedule Appointment</h3>
      <p>Book your donation slot at your convenience.</p>
    </div>
  </section>


  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>
</body>
</html>