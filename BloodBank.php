<?php
session_start();


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$hospitals = $conn->query("SELECT * FROM hospital");
$selectedHospital = null;



if (isset($_GET['hospital_id'])) {
    $hospitalId = $conn->real_escape_string($_GET['hospital_id']);
    $result = $conn->query("SELECT * FROM hospital WHERE id = $hospitalId");
    if ($result->num_rows > 0) {
        $selectedHospital = $result->fetch_assoc();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Locations - Blood Donation</title>
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
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .hospital-info {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      flex: 1;
      min-width: 300px;
    }
    .hospital-info h2 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
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
    .view-btn {
      background: #17a2b8;
      color: #fff;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      margin-right: 5px;
      text-decoration: none;
      display: inline-block;
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
    #map {
      height: 400px;
      width: 100%;
      margin-top: 20px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }
    .hospital-details {
      margin-top: 20px;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
    }
    .hospital-details h3 {
      color: #ff4d4d;
      margin-bottom: 10px;
    }
    .hospital-details p {
      margin-bottom: 8px;
    }
    .city-selector {
      margin-bottom: 20px;
    }
    .city-selector select {
      padding: 8px 12px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 16px;
      width: 100%;
      max-width: 300px;
    }
    #map-error {
      color: #721c24;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      border-radius: 5px;
      padding: 15px;
      margin-top: 20px;
      display: none;
    }
    .loading-spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
      margin-right: 10px;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
  <script> 
function filterHospitals() {
  const selectedCity = document.getElementById('cityDropdown').value.toLowerCase();
  const rows = document.querySelectorAll('#hospitalTable tbody tr');

  rows.forEach(row => {
    const city = row.getAttribute('data-city')?.toLowerCase() || '';
    if (!selectedCity || city === selectedCity) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
</script>

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
    <div class="hospital-info">
      <h2>Hospital Locations</h2>
      
      <div class="city-selector">
        <select id="cityDropdown" onchange="filterHospitals()">
          <option value="">All Cities</option>
         <?php
$cities = [];
$hospitals->data_seek(0); 
while ($row = $hospitals->fetch_assoc()) {
    $city = $row['Location'];
    if (!in_array($city, $cities)) {
        $cities[] = trim($city);
    }
}
foreach ($cities as $city) {
    echo "<option value='" . htmlspecialchars($city) . "'>" . htmlspecialchars($city) . "</option>";
}
$hospitals->data_seek(0); 
?>

        </select>
      </div>
      
      <table id="hospitalTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($hospitals->num_rows > 0) {
              while($hospital = $hospitals->fetch_assoc()) {
                  echo "<tr data-city='".htmlspecialchars($hospital['Location'])."'>";
                  echo "<td>".htmlspecialchars($hospital['Name'])."</td>";
                  echo "<td>".htmlspecialchars($hospital['Location'])."</td>";
                  echo "<td>".htmlspecialchars($hospital['Contact'])."</td>";
                  echo "<td>";
                  echo "<a href='?hospital_id=".$hospital['id']."' class='view-btn'>View on Map</a>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='4'>No hospitals found</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <?php if ($selectedHospital): ?>
        <div class="hospital-details">
          <h3><?php echo htmlspecialchars($selectedHospital['Name']); ?></h3>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($selectedHospital['Location']); ?></p>
          <p><strong>Contact:</strong> <?php echo htmlspecialchars($selectedHospital['Contact']); ?></p>
          
          <div id="map"></div>
          <div id="map-error"></div>
        </div>

       <div id="map" style="height:400px;"></div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>

 const cityCoords = <?php 
  echo json_encode([
    'lat' => floatval($selectedHospital['latitude']),
    'lng' => floatval($selectedHospital['longitude'])
  ]);
?>;
  
  const map = L.map('map').setView([cityCoords.lat, cityCoords.lng], 14);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);
  
  L.marker([cityCoords.lat, cityCoords.lng]).addTo(map)
    .bindPopup("<?php echo htmlspecialchars($selectedHospital['Name']); ?>")
    .openPopup();
</script>
      <?php endif; ?>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>
</body>
</html>