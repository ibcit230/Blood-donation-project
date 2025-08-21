<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood";


$successMessage = "";
$errorMessage = "";
$requests = [];


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    try {
       
       $donatorName = $conn->real_escape_string($_SESSION['username']);
       $bloodType = $conn->real_escape_string($_SESSION['blood_type']);
        $message = $conn->real_escape_string(trim($_POST['message']));

// ✅ التحقق من مستوى الدم
$levelSql = "SELECT COUNT(*) as count FROM donationrequest 
             WHERE BloodType = '$bloodType' AND Status = 'Accepted'";
$levelRes = $conn->query($levelSql);
$levelRow = $levelRes->fetch_assoc();
$currentLevel = $levelRow['count'];

// ✅ تحديد الحالة حسب الاحتياج
$status = ($currentLevel >= 10) ? "Pending" :  "Pending";

//  Stop donating if the level is full
if ($currentLevel >= 10) {
    throw new Exception("Sorry, we currently have enough donations for blood type $bloodType. Please try again later.");
}



// 🔴 تحقق من التبرع اليومي
$today = date('Y-m-d');
$checkSql = "SELECT * FROM donationrequest 
             WHERE DonatorName = '$donatorName' 
             AND DATE(RequestDate) = '$today'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    throw new Exception("You have already submitted a request today. Please try again tomorrow.");
}

     
        if (empty($donatorName)) {
            throw new Exception("Name is required");
        }
        if (empty($bloodType)) {
            throw new Exception("Blood type is required");
        }
        if (empty($message)) {
            throw new Exception("Message is required");
        }

        
        $stmt = $conn->prepare("INSERT INTO DonationRequest (DonatorName, BloodType, Message, Status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $donatorName, $bloodType, $message, $status);
        
        if ($stmt->execute()) {
            $successMessage = "Request submitted successfully!";
        } else {
            throw new Exception("Error submitting request: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}


try {
    
    if (isset($_SESSION['username'])) {
        $currentUser = $conn->real_escape_string($_SESSION['username']);
        $stmt = $conn->prepare("SELECT DonatorName, BloodType, Message, Status FROM DonationRequest WHERE DonatorName = ? ORDER BY id DESC");
        $stmt->bind_param("s", $currentUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } 
} catch (Exception $e) {
    $errorMessage = "Error fetching requests: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor Request - Blood Donation</title>
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
      position: relative;
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

    .container {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      padding: 40px 20px;
      gap: 20px;
    }

    .donor-request, .donor-requests {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    h2 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    label {
      display: block;
      font-size: 1rem;
      margin-bottom: 0.5rem;
      color: #666;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    textarea {
      height: 100px;
      resize: vertical;
    }

    button {
      background: #ff4d4d;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #e60000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #ff4d4d;
      color: #fff;
    }

    tr:hover {
      background: #f5f5f5;
    }

    .message {
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      text-align: center;
    }

    .success {
      background-color: #dff0d8;
      color: #3c763d;
    }

    .error {
      background-color: #f2dede;
      color: #a94442;
    }

    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 20px 0;
      margin-top: 50px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        align-items: center;
      }
    }
    
    .ai-button {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #fff;
      color: #ff4d4d;
      border: none;
      border-radius: 50%;
      padding: 10px;
      font-size: 1.2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .ai-button:hover {
      background-color: #ffe5e5;
      color: #e60000;
    }
    
    .action-buttons {
      position: absolute;
      top: 20px;
      left: 20px;
      display: flex;
      gap: 10px;
    }
    
    .back-button, .logout-button {
      background-color: #fff;
      color: #ff4d4d;
      border: none;
      border-radius: 5px;
      padding: 8px 15px;
      font-size: 0.9rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      transition: background-color 0.3s;
      cursor: pointer;
    }
    
    .back-button:hover, .logout-button:hover {
      background-color: #ffe5e5;
      color: #e60000;
    }

  </style>
</head>
<body>

  <header>
    <div class="action-buttons">
      <a href="home.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="?logout=1" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
      <?php endif; ?>
    </div>
    
    <h1>Blood Donation</h1>
    <nav>
      <a href="home.php">Home</a>
      <a href="aboutus.php">About Us</a>
      <a href="Blood-level.php">Donate Blood</a>
      <a href="BloodBank.php">Find a Blood Bank</a>
      <a href="contact.php">Contact Us</a>
    </nav>
    <a href="Blood-level.php" class="ai-button" title="AI Assistant">
      <i class="fas fa-robot"></i>
    </a>
  </header>

  <div class="container">
    <div class="donor-request">
      <h2>Send Request</h2>
      
      <?php if (!empty($successMessage)): ?>
        <div class="message success"><?php echo htmlspecialchars($successMessage); ?></div>
      <?php endif; ?>
      
      <?php if (!empty($errorMessage)): ?>
        <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
      <?php endif; ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Your Name</label>
       <input type="text" id="name" name="name" placeholder="Enter your name" required
value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>" readonly>



      <label for="bloodType">Blood Type</label>
<input type="text" id="bloodType" name="bloodType"
    value="<?php echo isset($_SESSION['blood_type']) ? htmlspecialchars($_SESSION['blood_type']) : ''; ?>"
    readonly>


        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Enter your message" required></textarea>

        <button type="submit">Send Request</button>
      </form>
    </div>

    <div class="donor-requests">
      <h2>Your Requests</h2>
      <?php if (!empty($requests)): ?>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Blood Type</th>
              <th>Message</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($requests as $request): ?>
              <tr>
                <td><?php echo htmlspecialchars($request['DonatorName']); ?></td>
                <td><?php echo htmlspecialchars($request['BloodType']); ?></td>
                <td><?php echo htmlspecialchars($request['Message']); ?></td>
                <td><?php echo htmlspecialchars($request['Status']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No donation requests found.</p>
      <?php endif; ?>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>
</body>
</html>