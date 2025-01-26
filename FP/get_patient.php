<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "patient_details"; // Your database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    header("Content-Type: application/json");
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Set JSON response header
header("Content-Type: application/json");

// Check if 'patient_id' is provided
if (isset($_GET['patient_id'])) {
    $patient_id = htmlspecialchars($_GET['patient_id']); // Sanitize input

    // Prepare SQL query to fetch patient details
    $sql = "SELECT name, age, address FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data); // Return patient data as JSON
        } else {
            http_response_code(404); // Not Found
            echo json_encode(["error" => "No patient found with the provided ID"]);
        }

        $stmt->close();
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to prepare the database query"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "No patient_id provided in the request"]);
}

// Close the database connection
$conn->close();
?>