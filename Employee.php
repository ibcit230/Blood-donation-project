<?php
session_start();


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blood";
    
   
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    $donatorName = isset($_POST['donatorName']) ? trim($_POST['donatorName']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';
    
    if (!empty($donatorName) ){
        if ($action === 'accept') {
            
            $sql = "UPDATE DonationRequest SET Status = 'Accepted' WHERE DonatorName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $donatorName);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $message = "Request from $donatorName has been accepted.";
            } else {
                $message = "No records updated - donor name not found.";
            }
        } elseif ($action === 'reject') {
           
            $sql = "DELETE FROM DonationRequest WHERE DonatorName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $donatorName);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $message = "Request from $donatorName has been rejected and deleted.";
            } else {
                $message = "No records deleted - donor name not found.";
            }
        }
    }
    
    $conn->close();
    
    
    echo "<script>alert('$message'); window.location.href = window.location.href;</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee - Blood Donation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      padding: 40px 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .employee-requests {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .employee-requests h2 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table th, table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    table th {
      background: #ff4d4d;
      color: #fff;
    }
    table tr:hover {
      background: #f5f5f5;
    }
    .action-buttons button {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      margin-right: 5px;
    }
    .accept-btn {
      background: #28a745;
      color: #fff;
    }
    .reject-btn {
      background: #dc3545;
      color: #fff;
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
    /* Header action buttons */
    .header-actions {
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
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .back-button:hover, .logout-button:hover {
      background-color: #ffe5e5;
      color: #e60000;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-actions">
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
  </header>

  <div class="container">
    <div class="employee-requests">
      <h2>Donor Requests</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Blood Type</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
         
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "blood";
          
        
          $conn = new mysqli($servername, $username, $password, $dbname);
          
          
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          
          
          $sql = "SELECT DonatorName, BloodType, Message, Status FROM DonationRequest";
          $result = $conn->query($sql);
          
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['DonatorName']) . "</td>";
              echo "<td>" . htmlspecialchars($row['BloodType']) . "</td>";
              echo "<td>" . htmlspecialchars($row['Message']) . "</td>";
              echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
              
              
              echo "<td class='action-buttons'>";
              if ($row['Status'] == 'Pending') {
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='donatorName' value='" . htmlspecialchars($row['DonatorName'], ENT_QUOTES) . "'>";
                echo "<button type='submit' name='action' value='accept' class='accept-btn'>Accept</button>";
                echo "<button type='submit' name='action' value='reject' class='reject-btn'>Reject</button>";
                echo "</form>";
              } else {
                echo "No Action";
              }
              echo "</td>";
              
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No donation requests found</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>

  <script>
   
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const action = this.querySelector('button[type="submit"]:focus').value;
        const donatorName = this.querySelector('input[name="donatorName"]').value;
        
        if (action === 'reject') {
          if (!confirm(`Are you sure you want to reject and delete ${donatorName}'s request?`)) {
            e.preventDefault();
          }
        } else if (action === 'accept') {
          if (!confirm(`Are you sure you want to accept ${donatorName}'s request?`)) {
            e.preventDefault();
          }
        }
      });
    });
  </script>
</body>
</html>