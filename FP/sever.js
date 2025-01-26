const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const app = express();
const port = 3000;

// Enable CORS (if needed for frontend integration)
app.use(cors());

// MySQL connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'healthbridge',
});

db.connect((err) => {
  if (err) {
    console.error('Error connecting to the database:', err.message);
    process.exit(1); // Exit the process if the connection fails
  }
  console.log('Connected to the database.');
});

// Endpoint to get patient details
app.get('/getPatientDetails', (req, res) => {
  const patientId = req.query.patient_id;

  // Validate patient_id
  if (!patientId) {
    return res.status(400).json({ error: 'patient_id is required' });
  }

  const query = 'SELECT * FROM patients WHERE patient_id = ?';
  db.query(query, [patientId], (err, results) => {
    if (err) {
      console.error('Error executing query:', err.message);
      return res.status(500).json({ error: 'Failed to retrieve patient details' });
    }
    if (results.length === 0) {
      return res.status(404).json({ error: 'Patient not found' });
    }
    res.json(results[0]); // Return the first patient details object
  });
});

// Endpoint to get medical history
app.get('/getMedicalHistory', (req, res) => {
  const patientId = req.query.patient_id;

  // Validate patient_id
  if (!patientId) {
    return res.status(400).json({ error: 'patient_id is required' });
  }

  const query = 'SELECT * FROM medical_history WHERE patient_id = ?';
  db.query(query, [patientId], (err, results) => {
    if (err) {
      console.error('Error executing query:', err.message);
      return res.status(500).json({ error: 'Failed to retrieve medical history' });
    }
    res.json(results); // Return medical history as an array
  });
});

// Start the server
app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
