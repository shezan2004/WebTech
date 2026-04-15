<?php
session_start();

if (!isset($_SESSION["total_submission"])) {
    header("Location: required.php");
    exit;
}

$nameErr = isset($_SESSION["nameErr"]) ? $_SESSION["nameErr"] : "";
$genderErr = isset($_SESSION["genderErr"]) ? $_SESSION["genderErr"] : "";
$addressErr = isset($_SESSION["addressErr"]) ? $_SESSION["addressErr"] : "";
$divisionErr = isset($_SESSION["divisionErr"]) ? $_SESSION["divisionErr"] : "";
$countryErr = isset($_SESSION["countryErr"]) ? $_SESSION["countryErr"] : "";
$dobErr = isset($_SESSION["dobErr"]) ? $_SESSION["dobErr"] : "";

$hasError = false;
if ($nameErr != "" || $genderErr != "" || $addressErr != "" || $divisionErr != "" || $countryErr != "" || $dobErr != "") {
    $hasError = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
</head>
<body>
<h1>Vaccination Result</h1>

<?php
if ($hasError) {
    echo "<h2>Required/Validation Message</h2>";
    if ($nameErr != "") {
        echo "Name: " . $nameErr;
        echo "<br>";
    }
    if ($genderErr != "") {
        echo "Gender: " . $genderErr;
        echo "<br>";
    }
    if ($addressErr != "") {
        echo "Address: " . $addressErr;
        echo "<br>";
    }
    if ($divisionErr != "") {
        echo "Division: " . $divisionErr;
        echo "<br>";
    }
    if ($countryErr != "") {
        echo "Country: " . $countryErr;
        echo "<br>";
    }
    if ($dobErr != "") {
        echo "Date of birth: " . $dobErr;
        echo "<br>";
    }
    echo "<br>";
    echo "Please go back and submit again.";
} else if (isset($_SESSION["eligible"]) && $_SESSION["eligible"] == "yes") {
    echo "<h2>You are eligble for vacination.</h2>";
} else {
    echo "<h2>You are not eligible for vaccination.</h2>";
}

if (!$hasError) {
    echo "<h3>Your Details</h3>";
    echo "Name: " . $_SESSION["name"];
    echo "<br>";
    echo "Gender: " . $_SESSION["gender"];
    echo "<br>";
    echo "Address: " . ($_SESSION["address"]);
    echo "<br>";
    echo "Division: " . $_SESSION["division"];
    echo "<br>";
    echo "Country: " . $_SESSION["country"];
    echo "<br>";
    echo "Date of birth: " . $_SESSION["dob"];
    echo "<br>";
    echo "Age: " . $_SESSION["age_year"] . " year " . $_SESSION["age_month"] . " month " . $_SESSION["age_day"] . " days";
}
?>

<br><br>
<a href="stats.php">Go to statistics page</a>
<br>
<a href="required.php">Back to form</a>
</body>
</html>
