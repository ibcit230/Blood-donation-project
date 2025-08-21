<?php
session_start();


$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "blood";

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Failed to connect to database.");
        }

        $inputUsername = trim($_POST['username'] ?? '');
        $inputPassword = $_POST['password'] ?? '';
        $inputRole = $_POST['role'] ?? '';
        $adminType = $_POST['admin_type'] ?? '';

        if (empty($inputUsername) || empty($inputPassword) || empty($inputRole)) {
            throw new Exception("Please enter username, password, and select your role.");
        }

        $tables = [
            'admin' => 'Admin.php',
            'employee' => 'Employee.php',
            'doner' => 'Doner.php'
        ];

        $userFound = false;

        if (!empty($inputRole)) {
            $table = strtolower($inputRole);
            if (!isset($tables[$table])) {
                throw new Exception("Invalid role selected.");
            }

            $stmt = $conn->prepare("SELECT * FROM $table WHERE Username = ?");
            if (!$stmt) throw new Exception("Database error preparing query.");

            $stmt->bind_param("s", $inputUsername);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $dbPassword = $user['Password'];

                if ($dbPassword === $inputPassword || password_verify($inputPassword, $dbPassword)) {
                    $_SESSION['user_type'] = $table;
                    $_SESSION['username'] = $user['Username'];
                    if (isset($user['FullName'])) $_SESSION['full_name'] = $user['FullName'];
                    if (isset($user['Email'])) $_SESSION['email'] = $user['Email'];
                    if (isset($user['BloodType'])) $_SESSION['blood_type'] = $user['BloodType'];

                    if ($inputRole == 'admin' && !empty($adminType)) {
                        $_SESSION['admin_type'] = $adminType;
                    }

                    header("Location: {$tables[$table]}");
                    exit();
                } else {
                    $loginError = "Invalid password.";
                }
            } else {
                $loginError = "Invalid username.";
            }
            $stmt->close();
        } else {
            $loginError = "Please select your role.";
        }

        $conn->close();
    } catch (Exception $e) {
        $loginError = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Blood Donation</title>
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
    }

    .login-container {
      background: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
      position: relative;
    }

    .login-container h2 {
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

    .login-form {
      display: flex;
      flex-direction: column;
    }

    .login-form label {
      font-size: 1rem;
      margin-bottom: 0.5rem;
      color: #666;
    }

    .login-form input {
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .login-form input:focus {
      border-color: #ff4d4d;
      outline: none;
    }

    .login-form button {
      background: #ff4d4d;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-form button:hover {
      background: #e60000;
    }

    .error-message {
      color: #ff4d4d;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      display: none;
    }

    .hint-text {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #666;
    }

    .hint-text a {
      color: #ff4d4d;
      text-decoration: none;
      font-weight: bold;
      margin: 0 5px;
    }

    .hint-text a:hover {
      text-decoration: underline;
    }

    .role-buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .role-buttons input[type="radio"] {
      display: none;
    }

    .role-buttons .role-button {
      flex: 1;
      text-align: center;
      background: #eee;
      padding: 10px;
      margin: 0 5px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, color 0.3s ease;
      font-weight: bold;
      color: #ff4d4d;
      border: 1px solid #ff4d4d;
    }

    .role-buttons .role-button:hover {
      background: #ffcccc;
    }

    .role-buttons input[type="radio"]:checked + .role-button {
      background: #ff4d4d;
      color: white;
    }

    @media (max-width: 600px) {
      .login-container {
        padding: 20px;
      }

      .login-container h2 {
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

<div class="login-container">
  <a href="home.php" class="home-button-top">Home</a>

  <h2>Login</h2>
  
  <?php if (!empty($loginError)): ?>
    <div class="error-message" style="display: block;"><?php echo htmlspecialchars($loginError); ?></div>
  <?php else: ?>
    <div class="error-message" id="error-message">
      Please enter a valid username and password.
    </div>
  <?php endif; ?>

  <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Enter your username" required>
    

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <label>Select Role</label>
    <div class="role-buttons">
      <input type="radio" id="admin" name="role" value="admin" required>
      <label for="admin" class="role-button">Admin</label>

      <input type="radio" id="employee" name="role" value="employee" required>
      <label for="employee" class="role-button">Employee</label>

      <input type="radio" id="doner" name="role" value="doner" required>
      <label for="doner" class="role-button">Donor</label>
      
    </div>


    <button type="submit">Login</button>
  </form>

  <div class="hint-text">
    Don't have an account? 
    <a href="RegisterAll.php">Register here</a>
  </div>
</div>

<script>
  const adminRadio = document.getElementById('admin');
  const employeeRadio = document.getElementById('employee');
  const donorRadio = document.getElementById('doner');
 

  adminRadio.addEventListener('change', function() {
    if (this.checked) {
      adminTypeContainer.style.display = 'block';
    }
  });

  employeeRadio.addEventListener('change', function() {
    if (this.checked) {
      adminTypeContainer.style.display = 'none';
    }
  });

  donorRadio.addEventListener('change', function() {
    if (this.checked) {
      adminTypeContainer.style.display = 'none';
    }
  });
</script>

</body>
</html>
