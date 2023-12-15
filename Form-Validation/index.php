<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        form {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 45%;
        }
        @media (max-width:640px) {
            form {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: white; font-weight: 700; font-size: 1.5rem;">
            <img src="./Assets/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            Form Validation</a>
        </div>
    </nav>

    <?php
    // Initialize the form validity variable
    $isFormValid = true;

    // Initialize variables to hold error messages
    $firstNameError = $lastNameError = $genderError = $contactNumberError = $emailError = "";
    $passwordError = $confirmPasswordError = $stateError = $cityError = $zipError = $qualificationError = "";
    $agreeCheckboxError = $confirmInfoCheckboxError = "";

    // Handle form submission and validation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Function to validate input
        function validateInput($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Validate first name
        $firstName = validateInput($_POST["firstName"]);
        if (empty($firstName)) {
            $isFormValid = false;
            $firstNameError = "First name is required.";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
            $isFormValid = false;
            $firstNameError = "Only letters are allowed.";
        }

        // Validate last name
        $lastName = validateInput($_POST["lastName"]);
        if (empty($lastName)) {
            $isFormValid = false;
            $lastNameError = "Last name is required.";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
            $isFormValid = false;
            $lastNameError = "Only letters are allowed.";
        }

        // Validate Gender
        if (!isset($_POST["gender"])) {
            $isFormValid = false;
            $genderError = "Gender is required.";
        } else {
            $gender = $_POST["gender"];
        }

        // Validate contact number
        $contactNumber = validateInput($_POST["contactNumber"]);
        if (empty($contactNumber)) {
            $isFormValid = false;
            $contactNumberError = "Contact number is required.";
        } elseif (!ctype_digit($contactNumber) || strlen($contactNumber) !== 10) {
            $isFormValid = false;
            $contactNumberError = "Contact number should be exactly 10 digits.";
        }

        // Validate Email
        $email = trim($_POST["email"]);
        if (empty($email)) {
            $isFormValid = false;
            $emailError = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isFormValid = false;
            $emailError = "Invalid email format.";
        } elseif (!preg_match('/@gmail\.com$/', $email)) {
            $isFormValid = false;
            $emailError = "Email address must be from gmail.com.";
        }

        // Validate Password
        $password = $_POST["password"];
        if (empty($password)) {
            $isFormValid = false;
            $passwordError = "Password is required.";
        } elseif (
            strlen($password) < 8 ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/[0-9]/", $password) ||
            !preg_match("/[^a-zA-Z0-9]/", $password)
        ) {
            $isFormValid = false;
            $passwordError = "Invalid password format.";
        }

        // Validate Confirm Password
        $confirmPassword = $_POST["confirmPassword"];
        if (empty($confirmPassword) || $confirmPassword !== $password) {
            $isFormValid = false;
            $confirmPasswordError = "Passwords do not match.";
        }

        // Validate State
        $state = $_POST["state"];
        if ($state === "Choose...") {
            $isFormValid = false;
            $stateError = "Please select your state.";
        }

        // Validate City
        $city = trim($_POST["city"]);
        if (empty($city)) {
            $isFormValid = false;
            $cityError = "City is required.";
        }

        // Validate Zip
        $zip = validateInput($_POST["zip"]);
        if (empty($zip) || !ctype_digit($zip) || strlen($zip) !== 6) {
            $isFormValid = false;
            $zipError = "Pin code should be 6 digits and contain only numbers.";
        }

        // Validate Highest Qualification
        $highestQualification = $_POST["highestQualification"];
        if ($highestQualification === "Select an option...") {
            $isFormValid = false;
            $qualificationError = "Please select your highest qualification.";
        }

        // Validate "I agree" checkbox
        if (!isset($_POST["agreeCheckbox"])) {
            $isFormValid = false;
            $agreeCheckboxError = "You must agree to the Terms and Conditions.";
        }

        // Validate "I confirm" checkbox
        if (!isset($_POST["confirmInfoCheckbox"])) {
            $isFormValid = false;
            $confirmInfoCheckboxError = "You must confirm that the information provided is true.";
        }

        
        if ($isFormValid) {
            echo '<script>alert("Form submitted successfully!");</script>';
        }
    }
    ?>


    <form style="margin: auto; margin-top: 3.5%;" class="row g-3" method="post" action="index.php">
        <div class="col-md-6  mt-3">
            <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="firstName">
            <?php if (isset($firstNameError)) { ?>
                <small style="color: red;">
                    <?php echo $firstNameError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6  mt-3">
            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="lastName">
            <?php if (isset($lastNameError)) { ?>
                <small style="color: red;">
                    <?php echo $lastNameError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-12 mt-3">
            <label class="form-label col-md-2">Gender</label>
            <div class="form-check form-check-inline col-md-2">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                <label class="form-check-label" for="male">
                    Male
                </label>
            </div>
            <div class="form-check form-check-inline col-md-2">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">
                    Female
                </label>
            </div>
            <div class="form-check form-check-inline col-md-2">
                <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                <label class="form-check-label" for="other">
                    Other
                </label>
            </div>
            <?php if (isset($genderError)) { ?>
                <small style="color: red;">
                    <?php echo $genderError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6  mt-3">
            <input type="text" class="form-control" placeholder="Contact Number" name="contactNumber">
            <?php if (isset($contactNumberError)) { ?>
                <small style="color: red;">
                    <?php echo $contactNumberError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6 mt-3">
            <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
            <?php if (isset($emailError)) { ?>
                <small style="color: red;">
                    <?php echo $emailError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6 mt-3">
            <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="password">
            <?php if (isset($passwordError)) { ?>
                <small style="color: red;">
                    <?php echo $passwordError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6 mt-3">
            <input type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password"
                name="confirmPassword">
            <?php if (isset($confirmPasswordError)) { ?>
                <small style="color: red;">
                    <?php echo $confirmPasswordError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6  mt-3">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-select" name="state">
                <option selected>Choose...</option>
                <option>Andhra Pradesh</option>
                <option>Arunachal Pradesh</option>
                <option>Assam</option>
                <option>Bihar</option>
                <option>Chhattisgarh</option>
                <option>Goa</option>
                <option>Gujarat</option>
                <option>Haryana</option>
                <option>Himachal Pradesh</option>
                <option>Jharkhand</option>
                <option>Karnataka</option>
                <option>Kerala</option>
                <option>Madhya Pradesh</option>
                <option>Maharashtra</option>
                <option>Manipur</option>
                <option>Meghalaya</option>
                <option>Mizoram</option>
                <option>Nagaland</option>
                <option>Odisha</option>
                <option>Punjab</option>
                <option>Rajasthan</option>
                <option>Sikkim</option>
                <option>Tamil Nadu</option>
                <option>Telangana</option>
                <option>Tripura</option>
                <option>Uttar Pradesh</option>
                <option>Uttarakhand</option>
                <option>West Bengal</option>
            </select>
            <?php if (isset($stateError)) { ?>
                <small style="color: red;">
                    <?php echo $stateError; ?>
                </small>
            <?php } ?>
        </div>

        <div class="col-md-4 mt-3">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity" name="city">
            <?php if (isset($cityError)) { ?>
                <small style="color: red;">
                    <?php echo $cityError; ?>
                </small>
            <?php } ?>
        </div>

        <div class="col-md-2 mt-3">
            <label for="inputZip" class="form-label">Zip</label>
            <input type="text" class="form-control" id="inputZip" name="zip">
            <?php if (isset($zipError)) { ?>
                <small style="color: red;">
                    <?php echo $zipError; ?>
                </small>
            <?php } ?>
        </div>

        <div class="col-md-6  mt-3">
            <label class="form-label">Highest Qualification</label>
            <select class="form-select" aria-label="Default select example" name="highestQualification">
                <option selected>Select an option...</option>
                <option value="10th">10th (High School)</option>
                <option value="12th">12th (Intermediate/Higher Secondary)</option>
                <option value="bachelor">Bachelor's Degree</option>
                <option value="master">Master's Degree</option>
                <option value="doctorate">Doctorate (Ph.D.)</option>
            </select>
            <?php if (isset($qualificationError)) { ?>
                <small style="color: red;">
                    <?php echo $qualificationError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-md-6  mt-3">
            <label class="form-label">Specialization</label>
            <input type="text" class="form-control" id="inputCity">
        </div>

        <div class="col-md-6 mt-3">
            <label class="form-label">Upload Your CV</label>
            <input type="file" class="form-control-file" accept=".pdf, .doc, .docx" name="cv">
        </div>

        <div class="col-md-6 mt-3">
            <label class="form-label">How do you hear about us?</label>
            <select class="form-select" aria-label="How do you hear about us?">
                <option selected>Select an option...</option>
                <option value="friend">From a friend</option>
                <option value="website">Website</option>
                <option value="social-media">Social Media</option>
                <option value="advertisement">Advertisement</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="col-12 mt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="agreeCheckbox" name="agreeCheckbox">
                <label class="form-check-label" for="agreeCheckbox">
                    I agree to the <a href="#">Terms and Conditions</a>
                </label>
            </div>
            <?php if (isset($agreeCheckboxError)) { ?>
                <small style="color: red;">
                    <?php echo $agreeCheckboxError; ?>
                </small>
            <?php } ?>
        </div>

        <div class="col-12 mt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmInfoCheckbox" name="confirmInfoCheckbox">
                <label class="form-check-label" for="confirmInfoCheckbox">
                    I confirm that the information I provided is true.
                </label>
            </div>
            <?php if (isset($confirmInfoCheckboxError)) { ?>
                <small style="color: red;">
                    <?php echo $confirmInfoCheckboxError; ?>
                </small>
            <?php } ?>
        </div>
        <div class="col-12 mt-3 mb-3" style="text-align: center;">
            <button type="submit" class="btn btn-primary btn-shadow">Submit</button>
        </div>
    </form>
        

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>