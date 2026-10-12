<?php

// ==========================================
// VEHICLE SERVICE BOOKING - PHP PROCESSING
// ==========================================

// Check that the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Get customer information
$customerName = trim($_POST["customerName"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$email = trim($_POST["email"] ?? "");

// Get vehicle information
$registration = trim($_POST["registration"] ?? "");
$vehicleType = trim($_POST["vehicleType"] ?? "");
$vehicleModel = trim($_POST["vehicleModel"] ?? "");
$year = trim($_POST["year"] ?? "");
$serviceDate = trim($_POST["serviceDate"] ?? "");

// Get selected services
$services = $_POST["services"] ?? [];

// ==========================================
// SERVER-SIDE VALIDATION
// ==========================================

$errors = [];

if ($customerName === "") {
    $errors[] = "Customer name is required.";
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone number must contain exactly 10 digits.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please provide a valid email address.";
}

if ($registration === "") {
    $errors[] = "Vehicle registration number is required.";
}

if ($vehicleType === "") {
    $errors[] = "Vehicle type is required.";
}

if ($vehicleModel === "") {
    $errors[] = "Vehicle model is required.";
}

$currentYear = date("Y");

if ($year === "" || $year < 1900 || $year > $currentYear) {
    $errors[] = "Invalid year of manufacture.";
}

if ($serviceDate === "") {
    $errors[] = "Preferred service date is required.";
}

if (empty($services)) {
    $errors[] = "Please select at least one service.";
}

// ==========================================
// SERVICE PRICES
// ==========================================

$servicePrices = [
    "Engine Oil Change" => 3000,
    "Brake Inspection" => 2000,
    "Wheel Alignment" => 2500,
    "Computer Diagnosis" => 3500,
    "Full Service" => 8000,

    // Individual requirement for ADM 25054
    "Tyre Balancing" => 2000
];

// ==========================================
// CALCULATE TOTAL ON SERVER
// ==========================================

$totalCost = 0;
$validServices = [];

foreach ($services as $service) {

    if (array_key_exists($service, $servicePrices)) {

        $totalCost += $servicePrices[$service];

        $validServices[] = $service;
    }
}

if (empty($validServices)) {
    $errors[] = "No valid services were selected.";
}

// ==========================================
// DISPLAY ERRORS
// ==========================================

if (!empty($errors)) {

    echo "<h1>Booking Error</h1>";

    echo "<ul>";

    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>";

    echo '<a href="service.html">Go Back</a>';

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Booking Confirmation - AutoCare Garage</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <nav>

        <h2>AutoCare Garage</h2>

        <ul>

            <li>
                <a href="index.html">Home</a>
            </li>

            <li>
                <a href="service.html">Book a Service</a>
            </li>

        </ul>

    </nav>

</header>


<main>

<section class="form-section">

    <fieldset>

        <h1>Booking Confirmed!</h1>

        <p>
            Thank you,
            <strong>
                <?php echo htmlspecialchars($customerName); ?>
            </strong>.
        </p>

        <br>

        <h2>Customer Information</h2>

        <p>
            <strong>Phone:</strong>
            <?php echo htmlspecialchars($phone); ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?php echo htmlspecialchars($email); ?>
        </p>

        <br>

        <h2>Vehicle Information</h2>

        <p>
            <strong>Registration:</strong>
            <?php echo htmlspecialchars($registration); ?>
        </p>

        <p>
            <strong>Vehicle Type:</strong>
            <?php echo htmlspecialchars($vehicleType); ?>
        </p>

        <p>
            <strong>Vehicle Model:</strong>
            <?php echo htmlspecialchars($vehicleModel); ?>
        </p>

        <p>
            <strong>Year:</strong>
            <?php echo htmlspecialchars($year); ?>
        </p>

        <p>
            <strong>Service Date:</strong>
            <?php echo htmlspecialchars($serviceDate); ?>
        </p>

        <br>

        <h2>Selected Services</h2>

        <ul>

            <?php foreach ($validServices as $service): ?>

                <li>
                    <?php echo htmlspecialchars($service); ?>
                    -
                    KSh
                    <?php echo number_format($servicePrices[$service]); ?>
                </li>

            <?php endforeach; ?>

        </ul>

        <br>

        <div class="cost-box">

            <h2>Total Estimated Cost</h2>

            <p>
                KSh <?php echo number_format($totalCost); ?>
            </p>

        </div>

    </fieldset>

</section>

</main>


<footer>

    <p>
        &copy; 2026 AutoCare Garage. All Rights Reserved.
    </p>

</footer>

</body>

</html>








