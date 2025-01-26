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

// Get patient ID
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch medical history
    $stmt = $conn->prepare("SELECT date,name,age,dob,phone_number,address,blood_group,diseases,medicines,referred_doctor_name,lab_reports FROM medical_history WHERE patient_id = ?");
    $stmt->bind_param("s", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
    } else {
        $history = [];
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
    <title>Medical History</title>
</head>

<body>
    <h1>Medical History</h1>
    <?php if (!empty($history)): ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>name</th>
                    <th>age</th>
                    <th>dob</th>
                    <th>phone_number</th>
                    <th>address</th>
                    <th>blood_group</th>
                    <th>diseases</th>
                    <th>medicines</th>
                    <th>referred_doctor_name</th>
                    <th>lab_reports</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['date']) ?></td>
                        <td><?= htmlspecialchars($entry['name']) ?></td>
                        <td><?= htmlspecialchars($entry['age']) ?></td>
                        <td><?= htmlspecialchars($entry['dob']) ?></td>
                        <td><?= htmlspecialchars($entry['phone_number']) ?></td>
                        <td><?= htmlspecialchars($entry['address']) ?></td>
                        <td><?= htmlspecialchars($entry['blood_group']) ?></td>
                        <td><?= htmlspecialchars($entry['diseases']) ?></td>
                        <td><?= htmlspecialchars($entry['medicines']) ?></td>
                        <td><?= htmlspecialchars($entry['referred_doctor_name']) ?></td>
                        <td><?= htmlspecialchars($entry['lab_reports']) ?></td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No medical history found for this patient.</p>
    <?php endif; ?>
</body>

</html>