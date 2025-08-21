<?php

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "blood";


$fullName = $donorUsername = $email = $phone = $bloodType = "";
$error = "";
$success = "";


$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $fullName = sanitizeInput($_POST["name"]);
    $donorUsername = sanitizeInput($_POST["username"]);
    $password = $_POST["password"];
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $bloodType = sanitizeInput($_POST["bloodType"]);

  
    if (empty($fullName) || empty($donorUsername) || empty($password) || empty($email) || empty($phone) || empty($bloodType)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (!preg_match('/^\+966\d{9}$/', $phone)) {
        $error = "Phone must be in Saudi format (+966XXXXXXXXX)";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $checkStmt = $conn->prepare("SELECT * FROM doner WHERE Username = ?");
        $checkStmt->bind_param("s", $donorUsername);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
          
            $updateStmt = $conn->prepare("UPDATE doner SET FullName = ?, Password = ?, Email = ?, Phone = ?, BloodType = ? WHERE Username = ?");
            $updateStmt->bind_param("ssssss", $fullName, $hashedPassword, $email, $phone, $bloodType, $donorUsername);

            if ($updateStmt->execute()) {
                $success = "Update successful!";
                $fullName = $donorUsername = $email = $phone = $bloodType = "";
            } else {
                $error = "Error: " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
           
            $insertStmt = $conn->prepare("INSERT INTO doner (FullName, Username, Password, Email, Phone, BloodType) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("ssssss", $fullName, $donorUsername, $password, $email, $phone, $bloodType);

            if ($insertStmt->execute()) {
                $success = "Registration successful! Thank you for registering.";
                $fullName = $donorUsername = $email = $phone = $bloodType = "";
            } else {
                $error = "Error: " . $insertStmt->error;
            }
            $insertStmt->close();
        }
        $checkStmt->close();
    }
}


function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor Registration - Blood Donation</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

   
    .registration-container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      position: relative;
    }

    .registration-container h2 {
      font-size: 2rem;
      margin-bottom: 1.5rem;
      color: #ff4d4d;
      text-align: center;
    }

    
    .home-button-top {
      position: absolute;
      top: 20px;
      left: 20px;
      color: #ff4d4d;
      text-decoration: none;
      font-weight: bold;
      font-size: 1rem;
    }

    .home-button-top:hover {
      text-decoration: underline;
    }

    
    .registration-form {
      display: flex;
      flex-direction: column;
    }

    .registration-form label {
      font-size: 1rem;
      margin-bottom: 0.5rem;
      color: #666;
    }

    .registration-form input,
    .registration-form select {
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .registration-form input:focus,
    .registration-form select:focus {
      border-color: #ff4d4d;
      outline: none;
    }

    .registration-form button {
      background: #ff4d4d;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .registration-form button:hover {
      background: #e60000;
    }

    
    .error-message {
      color: #ff4d4d;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      text-align: center;
    }

   
    .success-message {
      color: #4CAF50;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      text-align: center;
    }

    
    @media (max-width: 600px) {
      .registration-container {
        padding: 20px;
      }

      .registration-container h2 {
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
  <
  <div class="registration-container">
   
    <a href="home.php" class="home-button-top">Home</a>
   
    

    <h2>Donor Registration</h2>
    
    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
      <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form class="registration-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
     
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($fullName); ?>" required>
      

  
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo htmlspecialchars($donorUsername); ?>" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create a password (min 8 characters)" required>

     
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>

     
      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" placeholder="+966XXXXXXXXX" value="<?php echo htmlspecialchars($phone); ?>" required>

   
      <label for="bloodType">Blood Type</label>
      <select id="bloodType" name="bloodType" required>
        <option value="" disabled selected>Select your blood type</option>
        <option value="A+" <?php echo ($bloodType == "A+") ? "selected" : ""; ?>>A+</option>
        <option value="A-" <?php echo ($bloodType == "A-") ? "selected" : ""; ?>>A-</option>
        <option value="B+" <?php echo ($bloodType == "B+") ? "selected" : ""; ?>>B+</option>
        <option value="B-" <?php echo ($bloodType == "B-") ? "selected" : ""; ?>>B-</option>
        <option value="AB+" <?php echo ($bloodType == "AB+") ? "selected" : ""; ?>>AB+</option>
        <option value="AB-" <?php echo ($bloodType == "AB-") ? "selected" : ""; ?>>AB-</option>
        <option value="O+" <?php echo ($bloodType == "O+") ? "selected" : ""; ?>>O+</option>
        <option value="O-" <?php echo ($bloodType == "O-") ? "selected" : ""; ?>>O-</option>
      </select>

      
      <div class="error-message" id="error-message" style="display: none;">
        Please fill out all fields correctly.
      </div>

     
      <button type="submit">Register</button>
    </form>
  </div>


  <script>
    function validateForm() {
      const name = document.getElementById('name').value.trim();
      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value.trim();
      const email = document.getElementById('email').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const bloodType = document.getElementById('bloodType').value;

      const errorMessage = document.getElementById('error-message');

      if (!name || !username || !password || !email || !phone || !bloodType) {
        errorMessage.textContent = 'Please fill out all fields.';
        errorMessage.style.display = 'block';
        return false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        errorMessage.textContent = 'Please enter a valid email address.';
        errorMessage.style.display = 'block';
        return false;
      }

      
      const phonePattern = /^\+966\d{9}$/;
      if (!phonePattern.test(phone)) {
        errorMessage.textContent = 'Phone must be in Saudi format (+966XXXXXXXXX).';
        errorMessage.style.display = 'block';
        return false;
      }

    
      if (password.length < 8) {
        errorMessage.textContent = 'Password must be at least 8 characters.';
        errorMessage.style.display = 'block';
        return false;
      }

      errorMessage.style.display = 'none';
      return true;
    }
  </script>
</body>
</html>