<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patients Management System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('calum-lewis-vA1L1jRTM70-unsplash.jpg'); /* Replace with your background image URL */
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
      padding: 20px;
      border-radius: 15px;
      
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px; /* Increased width */
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin: 10px 0 5px;
    }

    input, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Patients Management System</h1>
    <form id="patientForm" onsubmit="return submitForm(event);">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required><br>
      <label for="age">Age:</label>
      <input type="number" id="age" name="age"><br>
      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select><br>
      <label for="height">Height (cm):</label>
      <input type="number" id="height" name="height"><br>
      <label for="weight">Weight (kg):</label>
      <input type="number" id="weight" name="weight"><br>
      <label for="contact">Contact:</label>
      <input type="text" id="contact" name="contact" pattern="[0-9]{10}"><br>
      <label for="address">Address:</label>
      <input type="text" id="address" name="address"><br>
      <label for="symptoms">Symptoms:</label>
      <select id="symptoms" name="symptoms">
        <option value="Indigestion">Indigestion</option>
        <option value="Fatigue">Fatigue</option>
        <option value="Acne">Acne</option>
        <option value="Cough">Cough</option>
        <option value="Headache">Headache</option>
      </select><br>
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    function submitForm(event) {
      event.preventDefault(); // Prevent the default form submission

      const form = document.getElementById('patientForm');
      const formData = new FormData(form);

      fetch('fdetails.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        console.log(data);
        window.location.href = 'dis.php';
      })
      .catch(error => console.error('Error:', error));

      return false; // Prevent default form submission
    }
  </script>
</body>
</html>
