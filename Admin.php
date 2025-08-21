<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_hospital'])) {
        
        $name = $conn->real_escape_string($_POST['hospital_name']);
        $location = $conn->real_escape_string($_POST['hospital_location']);
        $contact = $conn->real_escape_string($_POST['hospital_contact']);
         $latitude = $conn->real_escape_string($_POST['hospital_latitude']);
          $longitude = $conn->real_escape_string($_POST['hospital_longitude']);
        
        $sql = "INSERT INTO hospital (Name, Location, Contact, latitude, longitude) VALUES ('$name', '$location', '$contact', '$latitude', '$longitude')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error adding hospital: " . $conn->error . "');</script>";
        } else {
            echo "<script>alert('Hospital added successfully!');</script>";
        }
    }
    elseif (isset($_POST['delete_hospital'])) {
        
        $id = $conn->real_escape_string($_POST['hospital_id']);
        $sql = "DELETE FROM hospital WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error deleting hospital: " . $conn->error . "');</script>";
        }
    }
    elseif (isset($_POST['delete_donor'])) {
       
        $id = $conn->real_escape_string($_POST['donor_id']);
        $sql = "DELETE FROM doner WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error deleting donor: " . $conn->error . "');</script>";
        }
    }
    elseif (isset($_POST['delete_employee'])) {
        
        $id = $conn->real_escape_string($_POST['employee_id']);
        $sql = "DELETE FROM employee WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error deleting employee: " . $conn->error . "');</script>";
        }
    }
    elseif (isset($_POST['accept_request'])) {
        
        $id = $conn->real_escape_string($_POST['request_id']);
        $sql = "UPDATE DonationRequest SET Status = 'Accepted' WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error accepting request: " . $conn->error . "');</script>";
        } else {
            echo "<script>alert('Request accepted successfully!');</script>";
        }
    }
    elseif (isset($_POST['reject_request'])) {
        
        $id = $conn->real_escape_string($_POST['request_id']);
        $sql = "DELETE FROM DonationRequest WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error rejecting request: " . $conn->error . "');</script>";
        } else {
            echo "<script>alert('Request rejected and deleted successfully!');</script>";
        }
    }
    elseif (isset($_POST['add_donor'])) {
    $BloodType = $conn->real_escape_string($_POST['donor_BloodType']);
    $FullName = $conn->real_escape_string($_POST['donor_Fullname']);
    $Password = $conn->real_escape_string($_POST['donor_password']);
    $Email    = $conn->real_escape_string($_POST['donor_email']);
    $Username = $conn->real_escape_string($_POST['donor_username']);
    $Phone    = $conn->real_escape_string($_POST['donor_phone']);
   

    $sql = "INSERT INTO doner (BloodType,FullName, Password, Email, Username, Phone)
            VALUES ('$BloodType', '$FullName', '$Password', '$Email', '$Username', '$Phone')";
    
    if (!$conn->query($sql)) {
        echo "<script>alert('Error adding donor: " . $conn->error . "');</script>";
    } else {
        echo "<script>alert('donor added successfully!');</script>";
    }
}
elseif (isset($_POST['add_employee'])) {
    $Department = $conn->real_escape_string($_POST['employee_Department']);
    $FullName = $conn->real_escape_string($_POST['employee_Fullname']);
    $Job = $conn->real_escape_string($_POST['employee_Job']);
    $Password = $conn->real_escape_string($_POST['employee_password']);
    $Email    = $conn->real_escape_string($_POST['employee_email']);
    $Username = $conn->real_escape_string($_POST['employee_username']);
    $Phone    = $conn->real_escape_string($_POST['employee_phone']);
   

    $sql = "INSERT INTO employee (Department,FullName,Job, Password, Email, Username, Phone)
            VALUES ('$Department', '$FullName', '$Job', '$Password', '$Email', '$Username', '$Phone')";
    
    if (!$conn->query($sql)) {
        echo "<script>alert('Error adding employee: " . $conn->error . "');</script>";
    } else {
        echo "<script>alert('employee added successfully!');</script>";
    }
} elseif (isset($_POST['add_admin'])) {
    $fullName = $conn->real_escape_string($_POST['admin_fullname']);
    $username = $conn->real_escape_string($_POST['admin_username']);
    $password = $conn->real_escape_string($_POST['admin_password']);
    $email    = $conn->real_escape_string($_POST['admin_email']);
    $phone    = $conn->real_escape_string($_POST['admin_phone']);
    $role     = $conn->real_escape_string($_POST['admin_role']);

    $sql = "INSERT INTO admin (FullName, Username, Password, Email, Phone, Role)
            VALUES ('$fullName', '$username', '$password', '$email', '$phone', '$role')";
    
    if (!$conn->query($sql)) {
        echo "<script>alert('Error adding admin: " . $conn->error . "');</script>";
    } else {
        echo "<script>alert('Admin added successfully!');</script>";
    }
}
 elseif (isset($_POST['delete_admin'])) {
        
        $id = $conn->real_escape_string($_POST['admin_id']);
        $sql = "DELETE FROM admin WHERE id = $id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error deleting admin: " . $conn->error . "');</script>";
        }
    }

    
    }
   
     




$donors = $conn->query("SELECT id, FullName, BloodType, Email, Phone FROM doner");
$employees = $conn->query("SELECT id, FullName, Email, Phone, Job, Department FROM employee");
$donationRequests = $conn->query("SELECT * FROM DonationRequest WHERE Status = 'Pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Blood Donation</title>
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

 
    .admin-section {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .admin-section h2 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }


    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }

    table th,
    table td {
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

    
    .action-buttons {
      display: flex;
      gap: 5px;
    }

    .action-buttons button {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
    }

    .add-btn {
      background: #28a745;
      color: #fff;
    }

    .edit-btn {
      background: #ffc107;
      color: #333;
    }

    .delete-btn {
      background: #dc3545;
      color: #fff;
    }

    
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-content h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #ff4d4d;
    }

    .modal-content label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }

    .modal-content input {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .modal-content button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      margin-right: 10px;
    }

    .modal-content .save-btn {
      background: #28a745;
      color: #fff;
    }

    .modal-content .cancel-btn {
      background: #dc3545;
      color: #fff;
    }

    
    .status-pending {
      color: #ffc107;
      font-weight: bold;
    }

    .status-accepted {
      color: #28a745;
      font-weight: bold;
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
	
	select {
  width: 100%;
  padding: 10px;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
  background-color: white;
  cursor: pointer;
}

select:focus {
  outline: none;
  border-color: #ff4d4d;
  box-shadow: 0 0 0 2px rgba(255, 77, 77, 0.2);
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
    
   
    <div class="admin-section">
      <h2>Donation Requests</h2>
      <table>
        <thead>
          <tr>
            <th>Donator Name</th>
            <th>Blood Type</th>
            <th>Message</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($request = $donationRequests->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($request['DonatorName']); ?></td>
              <td><?php echo htmlspecialchars($request['BloodType']); ?></td>
              <td><?php echo htmlspecialchars($request['Message']); ?></td>
              <td class="status-pending"><?php echo htmlspecialchars($request['Status']); ?></td>
              <td class="action-buttons">
                <form method="POST" style="display: inline;">
                  <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                  <button type="submit" name="accept_request" class="add-btn">Accept</button>
                </form>
                <form method="POST" style="display: inline;">
                  <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                  <button type="submit" name="reject_request" class="delete-btn">Reject</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

   
    <div class="admin-section">
      <h2>Manage Hospitals</h2>
      <table>
        <thead>
          <tr>
            <th>Hospital Name</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody id="hospitalTable">
          <?php
          $hospitals = $conn->query("SELECT * FROM hospital");
           while($hospital = $hospitals->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($hospital['Name']); ?></td>
              <td><?php echo htmlspecialchars($hospital['Location']); ?></td>
              <td><?php echo htmlspecialchars($hospital['Contact']); ?></td>
              <td class="action-buttons">
                <form method="POST" style="display: inline;">
                  <input type="hidden" name="hospital_id" value="<?php echo $hospital['id']; ?>">
                  <button type="submit" name="delete_hospital" class="delete-btn">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div class="action-buttons" style="margin-top: 10px;">
        <button class="add-btn" onclick="openModal()">Add Hospital</button>
      </div>
    </div>
     <!-- الجديد-->
      
    
     <div class="admin-section">
      <h2>add admin</h2>
      <table>
        <thead>
          <tr>
            <th>FullName</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
              <th>Phone</th>
                <th>Role</th>
                <th>Actions</th>

          </tr>
        </thead>

        <tbody id="adminTable">
           <?php
           $admins = $conn->query("SELECT * FROM admin");
          while($admin = $admins->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($admin['FullName']); ?></td>
              <td><?php echo htmlspecialchars($admin['Username']); ?></td>
              <td><?php echo htmlspecialchars($admin['Password']); ?></td>
               <td><?php echo htmlspecialchars($admin['Email']); ?></td>
                <td><?php echo htmlspecialchars($admin['Phone']); ?></td>
                 <td><?php echo htmlspecialchars($admin['Role']); ?></td>
              <td class="action-buttons">
                <form method="POST" style="display: inline;">
               <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                  <button type="submit" name="delete_admin" class="delete-btn">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div class="action-buttons" style="margin-top: 10px;">
        <button class="add-btn" onclick="openAdminModal()">add admin</button>
      </div>
    </div>
    

   
    <div class="admin-section">
      <h2>Donor List</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Blood Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
       
        <tbody id="donorTable">
          <?php while($donor = $donors->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($donor['FullName']); ?></td>
              <td><?php echo htmlspecialchars($donor['BloodType']); ?></td>
              <td><?php echo htmlspecialchars($donor['Email']); ?></td>
              <td><?php echo htmlspecialchars($donor['Phone']); ?></td>
              <td class="action-buttons">
                <form method="POST" style="display: inline;">
                  <input type="hidden" name="donor_id" value="<?php echo $donor['id']; ?>">
                  <button type="submit" name="delete_donor" class="delete-btn">Delete</button>
                  
                 
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div class="action-buttons" style="margin-top: 10px;">
         <button class="add-btn" onclick="opendonorModal()">add donor</button>
              </div>
    </div>

    
    <div class="admin-section">
      <h2>Employee List</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Job</th>
            <th>Department</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
       
        <tbody id="employeeTable">
          <?php while($employee = $employees->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($employee['FullName']); ?></td>
              <td><?php echo htmlspecialchars($employee['Job']); ?></td>
              <td><?php echo htmlspecialchars($employee['Department']); ?></td>
              <td><?php echo htmlspecialchars($employee['Email']); ?></td>
              <td><?php echo htmlspecialchars($employee['Phone']); ?></td>
              <td class="action-buttons">
                <form method="POST" style="display: inline;">
                  <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                  <button type="submit" name="delete_employee" class="delete-btn">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
     <div class="action-buttons" style="margin-top: 10px;">
         <button class="add-btn" onclick="openemployeeModal()">add employe</button>
              </div>
  </div>
  <!-- Modal لإضافة أدمن جديد -->

  <div class="modal" id="addAdminModal">
  <div class="modal-content">
    <h3>Add New Admin</h3>
    <form method="POST">
      <label for="adminFullname">Full Name:</label>
      <input type="text" id="adminFullname" name="admin_fullname" required>

      <label for="adminUsername">Username:</label>
      <input type="text" id="adminUsername" name="admin_username" required>

      <label for="adminPassword">Password:</label>
      <input type="text" id="adminPassword" name="admin_password" required>

      <label for="adminEmail">Email:</label>
      <input type="email" id="adminEmail" name="admin_email" required>

      <label for="adminPhone">Phone:</label>
      <input type="text" id="adminPhone" name="admin_phone" required>

      <label for="adminRole">Role:</label>
      <select id="adminRole" name="admin_role" required>
        <option value="">Select Role</option>
        <option value="Super Admin">Super Admin</option>
        <option value="Department Admin">Department Admin</option>
      </select>

      <button type="submit" name="add_admin" class="save-btn">Save</button>
      <button type="button" class="cancel-btn" onclick="closeAdminModal()">Cancel</button>
      


    </form>
  </div>
</div>
<div class="modal" id="adddonorModal">
  <div class="modal-content">
    <h3>Add New Donor</h3>
    <form method="POST">
      
      <label for="Donorbloodtype">blodetype:</label>
      <input type="text" id="BloodType" name="donor_BloodType" required>  
      <label for="DonorFullname">fullname:</label>
      <input type="text" id="donorFullname" name="donor_Fullname" required>  



      <label for="donorUsername">Username:</label>
      <input type="text" id="donorUsername" name="donor_username" required>

      <label for="donorPassword">Password:</label>
      <input type="text" id="donorPassword" name="donor_password" required>

      <label for="donorEmail">Email:</label>
      <input type="email" id="donorEmail" name="donor_email" required>

      <label for="donorPhone">Phone:</label>
      <input type="text" id="donorPhone" name="donor_phone" required>

    

      <button type="submit" name="add_donor" class="save-btn">Save</button>
      <button type="button" class="cancel-btn" onclick="closedonorModal()">Cancel</button>
      


    </form>
  </div>
</div>
<div class="modal" id="addemployeeModal">
  <div class="modal-content">
    <h3>Add New employee</h3>
    <form method="POST">
      
      <label for="employeeDepartment">Department:</label>
      <input type="text" id="Department" name="employee_Department" required>  

      <label for="employeeFullname">Fullname:</label>
      <input type="text" id="Fullname" name="employee_Fullname" required>  

      <label for="employeeJob">Jop:</label>
      <input type="text" id="employeeJob" name="employee_Job" required>

      <label for="employeePassword">Password:</label>
      <input type="text" id="employeePassword" name="employee_password" required>

      <label for="employeeEmail">Email:</label>
      <input type="email" id="employeeEmail" name="employee_email" required>

        <label for="employeePhone">username:</label>
      <input type="text" id="employeePhone" name="employee_username" required>

      <label for="employeePhone">Phone:</label>
      <input type="text" id="employeePhone" name="employee_phone" required>

    

      <button type="submit" name="add_employee" class="save-btn">Save</button>
      <button type="button" class="cancel-btn" onclick="closeemployeeModal()">Cancel</button>
      


    </form>
  </div>
</div>




<div class="modal" id="addHospitalModal">
  <div class="modal-content">
    <h3>Add New Hospital</h3>
    <form method="POST" id="hospitalForm">
      <label for="hospitalName">Hospital Name:</label>
      <input type="text" id="hospitalName" name="hospital_name" required>
      <label for="hospitalLatitude">Latitude (خط العرض):</label>
<input type="text" id="hospitalLatitude" name="hospital_latitude" required>

<label for="hospitalLongitude">Longitude (خط الطول):</label>
<input type="text" id="hospitalLongitude" name="hospital_longitude" required>


      <label for="hospitalLocation">Location:</label>
      <select id="hospitalLocation" name="hospital_location" required>
        <option value="">Select a city</option>
        <option value="Riyadh">Riyadh</option>
        <option value="Jeddah">Jeddah</option>
        <option value="Mecca">Mecca</option>
        <option value="Medina">Medina</option>
        <option value="Dammam">Dammam</option>
        <option value="Khobar">Khobar</option>
        <option value="Taif">Taif</option>
        <option value="Tabuk" selected>Tabuk</option>
        <option value="Abha">Abha</option>
        <option value="Jazan">Jazan</option>
        <option value="Najran">Najran</option>
        <option value="Hail">Hail</option>
        <option value="Buraidah">Buraidah</option>
        <option value="Arar">Arar</option>
        <option value="Sakaka">Sakaka</option>
        <option value="Al Bahah">Al Bahah</option>
        <option value="Al Jawf">Al Jawf</option>
        <option value="Yanbu">Yanbu</option>
        <option value="Al Qassim">Al Qassim</option>
        <option value="Al Kharj">Al Kharj</option>
        <option value="Dhahran">Dhahran</option>
        <option value="Hafr Al-Batin">Hafr Al-Batin</option>
        <option value="Al-Khafji">Al-Khafji</option>
        <option value="Qatif">Qatif</option>
        <option value="Al-Ahsa">Al-Ahsa</option>
      </select>

      <label for="hospitalContact">Contact:</label>
      <input type="text" id="hospitalContact" name="hospital_contact" required>

      <button type="submit" name="add_hospital" class="save-btn">Save</button>
      <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>


 
  <footer>
    <p>&copy; 2025 Blood Donation. All rights reserved.</p>
  </footer>

  <script>

   function openAdminModal() {
  document.getElementById('addAdminModal').style.display = 'flex';
}

function closeAdminModal() {
  document.getElementById('addAdminModal').style.display = 'none';
}
  function openemployeeModal() {
  document.getElementById('addemployeeModal').style.display = 'flex';
}

function closeemployeeModal() {
  document.getElementById('addemployeeModal').style.display = 'none';
}

 function opendonorModal() {
  document.getElementById('adddonorModal').style.display = 'flex';
}

function closedonorModal() {
  document.getElementById('adddonorModal').style.display = 'none';
}

 
  
   
    function openModal() {
      document.getElementById('addHospitalModal').style.display = 'flex';
    }

   
    function closeModal() {
      document.getElementById('addHospitalModal').style.display = 'none';
    }

   
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        if (this.querySelector('button[type="submit"]').name.includes('delete') || 
            this.querySelector('button[type="submit"]').name.includes('reject')) {
          if (!confirm('Are you sure you want to perform this action?')) {
            e.preventDefault();
          }
        }
      });
    });
  </script>
  
</body>
</html>
<?php
$conn->close();
?>