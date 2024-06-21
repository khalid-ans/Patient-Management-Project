 <?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "mgdb";

$conn = mysqli_connect($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching form values
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$symptoms = $_POST['symptoms'];

// Prepare and bind statement
$stmt = $conn->prepare("INSERT INTO Patients (Name, Age, Gender, Height, Weight, Contact, Address, Symptoms) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisiiiss", $name, $age, $gender, $height, $weight, $contact, $address, $symptoms);

// Execute the statement
$stmt->execute();




// Close the connection
$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: findex.php");
exit();
?> 
