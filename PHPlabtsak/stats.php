<?php
session_start();

if (!isset($_SESSION["total_submission"])) {
    $_SESSION["total_submission"] = 0;
}
if (!isset($_SESSION["male_submission"])) {
    $_SESSION["male_submission"] = 0;
}
if (!isset($_SESSION["female_submission"])) {
    $_SESSION["female_submission"] = 0;
}

$submissionCount = array(
    "total_submission" => $_SESSION["total_submission"],
    "male_submission" => $_SESSION["male_submission"],
    "female_submission" => $_SESSION["female_submission"]
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submission Count</title>
</head>
<body>
<h1>Submission Count</h1>

<?php
echo "Total submissions: " . $submissionCount["total_submission"];
echo "<br>";
echo "Male submissions: " . $submissionCount["male_submission"];
echo "<br>";
echo "Female submissions: " . $submissionCount["female_submission"];
?>

<br><br>
<a href="required.php">Back to form</a>
</body>
</html>
