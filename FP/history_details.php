<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History</title>
</head>

<body>
    <h1>Medical History</h1>
    <table id="historyTable" border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be dynamically inserted here -->
        </tbody>
    </table>
    <p id="errorMessage" style="color: red; display: none;">Unable to load medical history.</p>

    <h2>Add Medical History</h2>
    <form id="addHistoryForm">
        <label for="date">Date: </label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="diagnosis">Diagnosis: </label>
        <input type="text" id="diagnosis" name="diagnosis" required><br><br>

        <label for="treatment">Treatment: </label>
        <input type="text" id="treatment" name="treatment" required><br><br>

        <button type="submit">Add Entry</button>
    </form>

    <script>
        // Get patient_id from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const patientId = urlParams.get('patient_id');

        if (!patientId) {
            alert("Invalid access! Patient ID is missing.");
            document.getElementById('errorMessage').textContent = "No patient ID provided in the request.";
            document.getElementById('errorMessage').style.display = "block";
        } else {
            // Fetch medical history from the server
            fetch(`http://localhost/get_medical_history.php?patient_id=${patientId}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to fetch medical history.");
                    }
                    return response.json();
                })
                .then((data) => {
                    const tableBody = document.getElementById('historyTable').getElementsByTagName('tbody')[0];
                    data.forEach(entry => {
                        const row = tableBody.insertRow();
                        row.insertCell(0).textContent = entry.date;
                        row.insertCell(1).textContent = entry.diagnosis;
                        row.insertCell(2).textContent = entry.treatment;
                    });
                })
                .catch((error) => {
                    console.error(error);
                    document.getElementById('errorMessage').textContent = "Unable to load medical history.";
                    document.getElementById('errorMessage').style.display = "block";
                });
        }

        // Handle form submission to add new entry
        document.getElementById('addHistoryForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const date = document.getElementById('date').value;
            const diagnosis = document.getElementById('diagnosis').value;
            const treatment = document.getElementById('treatment').value;

            // Send new entry to the server
            fetch(`http://localhost/add_medical_history.php?patient_id=${patientId}&date=${date}&diagnosis=${diagnosis}&treatment=${treatment}`, {
                method: 'POST',
            })
                .then(response => response.json())
                .then(data => {
                    // Add new entry to the table
                    const tableBody = document.getElementById('historyTable').getElementsByTagName('tbody')[0];
                    const row = tableBody.insertRow();
                    row.insertCell(0).textContent = date;
                    row.insertCell(1).textContent = diagnosis;
                    row.insertCell(2).textContent = treatment;

                    // Clear the form
                    document.getElementById('addHistoryForm').reset();
                })
                .catch(error => {
                    console.error(error);
                    alert("Failed to add the new entry.");
                });
        });
    </script>
</body>

</html>