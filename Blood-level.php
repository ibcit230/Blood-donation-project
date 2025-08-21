==<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function checkBloodLevels($conn) {
    $alerts = [];
    $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    $bloodLevels = [];
    
    foreach ($bloodTypes as $type) {
      
        $sql = "SELECT COUNT(*) as count FROM DonationRequest WHERE BloodType = '$type' AND Status = 'Accepted'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $bloodLevels[$type] = $count;
        
      
        if ($count > 10) {
            $alerts[] = [
                'type' => $type,
                'level' => $count,
                'message' => "Blood type $type has exceeded safe levels ($count donors). Please stop accepting donations for this type.",
                'priority' => 'high'
            ];
        }
      
        elseif ($count < 2) {
            $alerts[] = [
                'type' => $type,
                'level' => $count,
                'message' => "Blood type $type is critically low ($count donors). Please request donations for this type.",
                'priority' => 'low'
            ];
        }
    }
    
    return [
        'alerts' => $alerts,
        'levels' => $bloodLevels
    ];
}



$bloodData = checkBloodLevels($conn);
$bloodAlerts = $bloodData['alerts'];
$bloodLevels = $bloodData['levels'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
      color: #333;
      min-height: 100vh;
    }
    .container {
      background: rgba(19, 14, 14, 0.9);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 1200px;
      margin: 2rem auto;
      animation: fadeIn 1s ease-in-out;
    }
    h1 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      color: #ff6f61;
      text-align: center;
    }
    .blood-types {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      justify-content: center;
      margin-bottom: 2rem;
    }
    .blood-type {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      width: 200px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .blood-type:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .blood-type h2 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #333;
      text-align: center;
    }
    .blood-level {
      font-size: 1.2rem;
      font-weight: bold;
      text-align: center;
    }
    .level-high {
      color: #dc3545;
    }
    .level-low {
      color: #fd7e14;
    }
    .level-normal {
      color: #28a745;
    }
    .alert-container {
      margin: 1rem 0;
    }
    .alert {
      padding: 1rem;
      border-radius: 5px;
      margin-bottom: 0.5rem;
      animation: slideIn 0.5s ease;
    }
    .alert-high {
      background: #ffebee;
      border-left: 5px solid #f44336;
      color: #d32f2f;
    }
    .alert-low {
      background: #fff3e0;
      border-left: 5px solid #ff9800;
      color: #e65100;
    }
    .admin-section {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    
	
	body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
      color: #333;
      min-height: 100vh;
    }
    .container {
      background: rgba(255, 255, 255, 0.9);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 1200px;
      margin: 2rem auto;
      animation: fadeIn 1s ease-in-out;
      position: relative;
    }
    .navigation-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      gap: 10px;
    }
    .back-btn, .logout-btn {
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      text-decoration: none;
      color: white;
      font-weight: bold;
    }
    .back-btn {
      background: #6c757d;
    }
    .back-btn:hover {
      background: #5a6268;
    }
    .logout-btn {
      background: #dc3545;
    }
    .logout-btn:hover {
      background: #c82333;
    }
  </style>
</head>
<body>

<div class="container">
   
    <div class="navigation-buttons">
      <a href="javascript:history.back()" class="back-btn">Back</a>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>
  <div class="container">
    <h1>Blood Bank Management System</h1>
    
    
    <div class="admin-section">
      <h2>Blood Inventory Levels</h2>
      <div class="blood-types">
        <?php foreach ($bloodLevels as $type => $count): ?>
          <div class="blood-type">
            <h2>Type <?php echo $type; ?></h2>
            <p>Current Level: 
              <span class="blood-level 
                <?php 
                  if ($count > 10) echo 'level-high';
                  elseif ($count < 2) echo 'level-low';
                  else echo 'level-normal';
                ?>">
                <?php echo $count; ?> units
              </span>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
      
      <?php if (!empty($bloodAlerts)): ?>
        <div class="alert-container">
          <?php foreach ($bloodAlerts as $alert): ?>
            <div class="alert <?php echo ($alert['priority'] == 'high') ? 'alert-high' : 'alert-low'; ?>">
              <?php echo $alert['message']; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    

   

    

  </div>

  <script>
  
    setTimeout(function() { location.reload(); }, 30000);
  </script>
</body>
</html>
<?php
$conn->close();
?>