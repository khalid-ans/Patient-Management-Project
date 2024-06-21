<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mgdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the last entered patient's symptoms
$last_patient_query = "SELECT Symptoms FROM Patients ORDER BY Patient_id DESC LIMIT 1";
$result = $conn->query($last_patient_query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_patient_symptoms = $row["Symptoms"];
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT Name, Description, Medicine_id FROM Diseases WHERE Symptoms = ?");
    $stmt->bind_param("s", $last_patient_symptoms);
    $stmt->execute();
    $disease_result = $stmt->get_result();

    if ($disease_result->num_rows > 0) {
        $disease_row = $disease_result->fetch_assoc();
        $disease_name = $disease_row["Name"];
        $disease_description = $disease_row["Description"];
        $medicine_id = $disease_row["Medicine_id"];

        // Query to get ayurvedic medicine details
        $medicine_stmt = $conn->prepare("SELECT Name, Usage_instructions, Dosage FROM ayurvedic_medicines WHERE Medicine_id = ?");
        $medicine_stmt->bind_param("i", $medicine_id);
        $medicine_stmt->execute();
        $medicine_result = $medicine_stmt->get_result();

        if ($medicine_result->num_rows > 0) {
            $medicine_row = $medicine_result->fetch_assoc();
            $medicine_name = $medicine_row["Name"];
            $usage_instructions = $medicine_row["Usage_instructions"];
            $dosage = $medicine_row["Dosage"];
        } else {
            $medicine_name = "No matching medicine found.";
            $usage_instructions = "";
            $dosage = "";
        }
        $medicine_stmt->close();

        // Query to get herb details
        $herb_stmt = $conn->prepare("SELECT Herb_id, Herb_Name, Botanical_Name, Medicinal_Properties FROM herbs WHERE Medicine_id = ?");
        $herb_stmt->bind_param("i", $medicine_id);
        $herb_stmt->execute();
        $herb_result = $herb_stmt->get_result();

        $herbs = [];
        while ($herb_row = $herb_result->fetch_assoc()) {
            $herbs[] = $herb_row;
        }
        $herb_stmt->close();
    } else {
        $disease_name = "No matching disease found.";
        $disease_description = "";
        $medicine_name = "";
        $usage_instructions = "";
        $dosage = "";
        $herbs = [];
    }
} else {
    $disease_name = "No patients found.";
    $disease_description = "";
    $medicine_name = "";
    $usage_instructions = "";
    $dosage = "";
    $herbs = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Disease Information</title>
</head>
<body>
    <h1>Last Entered Patient's Disease</h1>
    <p><strong>Disease Name:</strong> <?php echo htmlspecialchars($disease_name); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($disease_description); ?></p>

    <h2>Ayurvedic Medicine Information</h2>
    <p><strong>Medicine Name:</strong> <?php echo htmlspecialchars($medicine_name); ?></p>
    <p><strong>Usage Instructions:</strong> <?php echo htmlspecialchars($usage_instructions); ?></p>
    <p><strong>Dosage:</strong> <?php echo htmlspecialchars($dosage); ?></p>

    <h2>Herb Information</h2>
    <?php if (!empty($herbs)): ?>
        <ul>
            <?php foreach ($herbs as $herb): ?>
                <li>
                    <p><strong>Herb ID:</strong> <?php echo htmlspecialchars($herb["Herb_id"]); ?></p>
                    <p><strong>Herb Name:</strong> <?php echo htmlspecialchars($herb["Herb_Name"]); ?></p>
                    <p><strong>Botanical Name:</strong> <?php echo htmlspecialchars($herb["Botanical_Name"]); ?></p>
                    <p><strong>Medicinal Properties:</strong> <?php echo htmlspecialchars($herb["Medicinal_Properties"]); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No herbs found for this medicine.</p>
    <?php endif; ?>
</body>
</html>
