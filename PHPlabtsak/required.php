<?php
session_start();

$name = $gender = $address =$division = $country = $dob = "";

$nameErr =$genderErr =$addressErr = $divisionErr = $countryErr = $dobErr = "";

function testinput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name cannot be empty";
    } else {
        $name = testinput($_POST["name"]);
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = testinput($_POST["gender"]);
        if ($gender != "male" && $gender != "female") {
            $genderErr = "Please choose male or female";
        }
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = testinput($_POST["address"]);
    }

    if (empty($_POST["division"])) {
        $divisionErr = "Division is required";
    } else {
        $division = testinput($_POST["division"]);
        if (
            $division != "DHAKA" &&
            $division != "RAJSHAHI" &&
            $division != "RANGPUR" &&
            $division != "CHITTAGONG" &&
            $division != "KHULNA" &&
            $division != "MYENSING" &&
            $division != "DINAJPUR" &&
            $division != "BARISHAL"
        ) {
            $divisionErr = "Please choose a valid division";
        }
    }

    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
    } else {
        $country = testinput($_POST["country"]);
        if ($country == "Others") {
            $countryErr = "Its not availabale outside bangladesh.";
        }
    }

    if (empty($_POST["dob"])) {
        $dobErr = "Date of birth is required";
    } else {
        $dob = testinput($_POST["dob"]);

        $birthDate = DateTime::createFromFormat("Y-m-d", $dob);
        if (!$birthDate || $birthDate->format("Y-m-d") != $dob) {
            $dobErr = "Date of birth must be valid";
        } else {
            $today = new DateTime();
            $age = $today->diff($birthDate);

            if ($birthDate > $today) {
                $dobErr = "Date of birth cannot be future";
            } else if ($age->y <= 5) {
                $dobErr = "User should be more than 5 year old";
            }
        }
    }

    if (!isset($_SESSION["total_submission"])) {
        $_SESSION["total_submission"] = 0;
    }
    if (!isset($_SESSION["male_submission"])) {
        $_SESSION["male_submission"] = 0;
    }
    if (!isset($_SESSION["female_submission"])) {
        $_SESSION["female_submission"] = 0;
    }

    $_SESSION["total_submission"] = $_SESSION["total_submission"] + 1;
    if ($gender == "male") {
        $_SESSION["male_submission"] = $_SESSION["male_submission"] + 1;
    }
    if ($gender == "female") {
        $_SESSION["female_submission"] = $_SESSION["female_submission"] + 1;
    }

    $_SESSION["name"] = $name;
    $_SESSION["gender"] = $gender;
    $_SESSION["address"] = $address;
    $_SESSION["division"] = $division;
    $_SESSION["country"] = $country;
    $_SESSION["dob"] = $dob;

    $_SESSION["nameErr"] = $nameErr;
    $_SESSION["genderErr"] = $genderErr;
    $_SESSION["addressErr"] = $addressErr;
    $_SESSION["divisionErr"] = $divisionErr;
    $_SESSION["countryErr"] = $countryErr;
    $_SESSION["dobErr"] = $dobErr;

    if (
        $nameErr == "" &&
        $genderErr == "" &&
        $addressErr == "" &&
        $divisionErr == "" &&
        $countryErr == "" &&
        $dobErr == ""
    ) {
        $today = new DateTime();
        $birthDate = DateTime::createFromFormat("Y-m-d", $dob);
        $age = $today->diff($birthDate);

        $_SESSION["age_year"] = $age->y;
        $_SESSION["age_month"] = $age->m;
        $_SESSION["age_day"] = $age->d;
        $_SESSION["eligible"] = "yes";
    } else {
        $_SESSION["eligible"] = "no";
        $_SESSION["age_year"] = "";
        $_SESSION["age_month"] = "";
        $_SESSION["age_day"] = "";
    }

    header("Location: result.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Validation</title>
</head>
<body>
<h1>Vaccination Form</h1>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error">*<?php echo $nameErr; ?></span>
    <br><br>

    Gender:
    <input type="radio" name="gender" value="male" <?php if ($gender == "male") echo "checked"; ?>>Male
    <input type="radio" name="gender" value="female" <?php if ($gender == "female") echo "checked"; ?>>Female
    <span class="error">*<?php echo $genderErr; ?></span>
    <br><br>

    Address:
    <textarea name="address" rows="3" cols="40"><?php echo $address; ?></textarea>
    <span class="error">*<?php echo $addressErr; ?></span>
    <br><br>

    Division:
    <select name="division">
        <option value="">Select Division</option>
        <option value="DHAKA" <?php if ($division == "DHAKA") echo "selected"; ?>>DHAKA</option>
        <option value="RAJSHAHI" <?php if ($division == "RAJSHAHI") echo "selected"; ?>>RAJSHAHI</option>
        <option value="RANGPUR" <?php if ($division == "RANGPUR") echo "selected"; ?>>RANGPUR</option>
        <option value="CHITTAGONG" <?php if ($division == "CHITTAGONG") echo "selected"; ?>>CHITTAGONG</option>
        <option value="KHULNA" <?php if ($division == "KHULNA") echo "selected"; ?>>KHULNA</option>
        <option value="MYENSING" <?php if ($division == "MYENSING") echo "selected"; ?>>MYENSING</option>
        <option value="DINAJPUR" <?php if ($division == "DINAJPUR") echo "selected"; ?>>DINAJPUR</option>
        <option value="BARISHAL" <?php if ($division == "BARISHAL") echo "selected"; ?>>BARISHAL</option>
    </select>
    <span class="error">*<?php echo $divisionErr; ?></span>
    <br><br>

    Country:
    <select name="country">
        <option value="">Select Country</option>
        <option value="Bangladesh" <?php if ($country == "Bangladesh") echo "selected"; ?>>Bangladesh</option>
        <option value="Others" <?php if ($country == "Others") echo "selected"; ?>>Others</option>
    </select>
    <span class="error">*<?php echo $countryErr; ?></span>
    <br><br>

    Date of birth:
    <input type="date" name="dob" value="<?php echo $dob; ?>">
    <span class="error">*<?php echo $dobErr; ?></span>
    <br><br>

    <input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
