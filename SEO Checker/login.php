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
            <img src="./assets/images/tablet.svg" alt="login" />
        </div>

        <div style="width: 50%;">

            <!-- PHP CODE START-->
            <?php
            if (isset($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                require_once "db.php";
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $user = mysqli_fetch_assoc($result);
                    if ($user && $password === $user["password"]) {
                        // Plain text password comparison
                        session_start();
                        $_SESSION["user"] = "yes";
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Email or password does not match</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error executing the query</div>";
                }
            }
            ?>
            <!-- PHP CODE END -->


            <form style="margin: auto; margin-top: 10%; margin-bottom: 6%; border-radius: 10px;" class="row g-4"
                method="post" action="login.php">

                <div class="col-md-12 mt-3">
                    <img src="./assets/images/user.png" alt="user"
                        style="display: flex; width: 50px; height: 50px; margin: auto;" />
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

                <!-- Login -->
                <div class="col-12 mt-3 mb-1" style="text-align: center;">
                    <button type="submit" class="btn btn-primary btn-shadow custom-btn-color" value="Login"
                        name="login">Login</button>
                </div>

                <!-- New User (Register) -->
                <div class="col-12 mt-1 mb-3" style="text-align: center;">
                    <p>New user? <a href="register.php" style="color: #fe6100; text-decoration: underline;">Register</a>
                    </p>
                </div>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>