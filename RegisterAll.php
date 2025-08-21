<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Blood Donation</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1584118624012-df056829fbd0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') no-repeat center center/cover;
      backdrop-filter: blur(5px); 
    }

   
    .register-container {
      background: rgba(255, 255, 255, 0.9); 
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      text-align: center;
      backdrop-filter: blur(10px); 
    }

    .register-container h2 {
      font-size: 2rem;
      margin-bottom: 1.5rem;
      color: #ff4d4d; 
    }

    
    .register-buttons {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .register-buttons a {
      background: #ff4d4d;
      color: #fff;
      padding: 15px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 1.1rem;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .register-buttons a:hover {
      background: #e60000;
      transform: translateY(-5px); 
    }

    .home-button-top {
      position: absolute;
      top: 20px;
      left: 20px;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.2); 
      padding: 8px 16px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .home-button-top:hover {
      background: rgba(255, 255, 255, 0.3);
    }

   
    @media (max-width: 600px) {
      .register-container {
        padding: 20px;
      }

      .register-container h2 {
        font-size: 1.5rem;
      }

      .home-button-top {
        top: 10px;
        left: 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>

  <a href="home.php" class="home-button-top">Home</a>

  
  <div class="register-container">
    <h2>Register</h2>
    <div class="register-buttons">
      <a href="DonorRegister.php">Donor</a>
     
    </div>
  </div>
</body>
</html>