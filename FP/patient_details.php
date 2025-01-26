<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "patient_details"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get patient ID from URL
if (isset($_GET['patient_id'])) {
  $patient_id = $_GET['patient_id'];

  // Fetch patient details
  $stmt = $conn->prepare("SELECT name, age, address FROM details WHERE patient_id = ?");
  $stmt->bind_param("s", $patient_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    $name = $patient['name'];
    $age = $patient['age'];
    $address = $patient['address'];
  } else {
    $name = $age = $address = "Not Found";
  }
  $stmt->close();
} else {
  die("Patient ID not provided.");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Details</title>
</head>

<body>
  <h1>Patient Details</h1>
  <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
  <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
  <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
  <button onclick="viewMedicalHistory()">View Medical History</button>

  <script>
    function viewMedicalHistory() {
      const patientId = <?= json_encode($patient_id) ?>;
      window.location.href = `get_medical_history.php?patient_id=${patientId}`;
    }
  </script>
</body>

</html>