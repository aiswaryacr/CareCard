<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthBridge Login</title>
    <style>
        /* Add styles for layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
        }

        input,
        button {
            display: block;
            width: 90%;
            margin: 10px auto;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>HealthBridge Login</h1>
        <form id="loginForm" action="patient_details.php" method="GET">
            <label for="patient_id">Enter Patient ID:</label>
            <input type="text" name="patient_id" id="patient_id" placeholder="Patient ID" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>