<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login-Register</title>
    <style>
        form {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 45%;
        }

        .custom-btn-color {
            background-color: #fe6100;
            border-color: #fe6100;
            color: #fff;
        }

        .custom-btn-color:hover {
            background-color: #000;
            border-color: #000;
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Registration & Login Section -->
    <div style="width: 100%; display:flex;">
        <div style="width: 50%;">
            <img src="./assets/images/register.svg" alt="register" />
        </div>


        <div style="width: 50%;">

            <!-- PHP CODE START-->
            <?php
            if (isset($_POST["submit"])) {
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirmPassword"];
                $phone = $_POST["phone"];
                $gender = $_POST["gender"];
                $age = $_POST["age"];
                $state = $_POST["state"];
                $city = $_POST["city"];
                $pincode = $_POST["pincode"];

                // Hash the password
                // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();
                if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone) || empty($gender) || empty($age) || empty($state) || empty($city) || empty($pincode)) {
                    array_push($errors, "All fields are required");
                }
                if (strlen($password) < 6) {
                    array_push($errors, "Password must be at least 6 characters long");
                }
                if ($password !== $confirmPassword) {
                    array_push($errors, "Password does not match");
                }
                if (count($errors) > 0) {
                    echo '<div class="alert alert-danger">' . implode("<br>", $errors) . '</div>';

                } else {
                    require_once "db.php";
                    $sql = "INSERT INTO users (firstName, lastName, email, password, phone, gender, age, state, city, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "ssssssisss", $firstName, $lastName, $email, $password, $phone, $gender, $age, $state, $city, $pincode);
                        mysqli_stmt_execute($stmt);
                        echo '<div class="alert alert-success">Successfully registered!</div>';
                    } else {
                        die('Something went wrong');
                    }
                }
            }
            ?>
            <!-- PHP CODE END -->


            <form style="margin: auto; margin-top: 3%; margin-bottom: 6%; border-radius: 10px;" class="row g-4"
                method="post" action="register.php">

                <!-- First Name -->
                <div class="col-md-6  mt-4">
                    <input type="text" class="form-control" placeholder="First name" aria-label="First name"
                        name="firstName">
                </div>

                <!-- Last Name -->
                <div class="col-md-6  mt-4">
                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name"
                        name="lastName">
                </div>

                <!-- Email -->
                <div class="col-md-12 mt-3">
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
                </div>

                <!-- Password -->
                <div class="col-md-12 mt-3">
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password"
                        name="password">
                </div>

                <!-- Confirm Password -->
                <div class="col-md-12 mt-3">
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password"
                        name="confirmPassword">
                </div>

                <!-- Phone Number -->
                <div class="col-md-12  mt-3">
                    <input type="text" class="form-control" placeholder="Phone Number" name="phone">
                </div>

                <!-- Gender -->
                <div class="col-md-6 mt-3">
                    <select class="form-control" id="gender" name="gender">
                        <option selected>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Age -->
                <div class="col-md-6  mt-3">
                    <input type="text" class="form-control" placeholder="Age" aria-label="Age" name="age">
                </div>

                <!-- State  -->
                <div class="col-md-12  mt-3">
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
                </div>

                <!-- City  -->
                <div class="col-md-6 mt-3">
                    <label for="inputCity" class="form-label">City</label>
                    <input type="text" class="form-control" id="inputCity" name="city">
                </div>

                <!-- Pincode -->
                <div class="col-md-6 mt-3">
                    <label for="inputZip" class="form-label">Pincode</label>
                    <input type="text" class="form-control" id="inputZip" name="pincode">
                </div>

                <!-- Terms & Conditions -->
                <div class="col-12 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreeCheckbox" name="agreeCheckbox">
                        <label class="form-check-label" for="agreeCheckbox">
                            I agree to the <a href="#" style="color: #fe6100; text-decoration: underline;">Terms and
                                Conditions</a>
                        </label>
                    </div>
                </div>

                <!-- Signup -->
                <div class="col-12 mt-3 mb-1" style="text-align: center;">
                    <button type="submit" class="btn btn-primary btn-shadow custom-btn-color" name="submit"
                        value="Register">Signup</button>
                </div>

                <!-- Already user (Login) -->
                <div class="col-12 mt-1 mb-3" style="text-align: center;">
                    <p>Already a user? <a href="./login.php"
                            style="color: #fe6100; text-decoration: underline;">Login</a></p>
                </div>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>