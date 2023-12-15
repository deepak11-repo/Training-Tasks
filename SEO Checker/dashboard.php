<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>SEO Insights Pro</title>
    <link rel="stylesheet" href="./assets/dashboard.css">
</head>

<body>

    <!-- NavBar -->
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand navbarTitle" href="#">
                <img src="./assets/navLogo2.png" alt="Logo" width="40" height="40"
                    class="d-inline-block align-text-top">
                SEO Insights PRO
            </a>
            <button class="btn  btn-shadow custom-btn-color" id="logoutBtn">Logout&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24"
                    style="fill: rgba(255, 255, 255, 1);transform:;msFilter:;">
                    <path d="m2 12 5 4v-3h9v-2H7V8z"></path>
                    <path
                        d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z">
                    </path>
                </svg></button>
        </div>
    </nav>

    <!-- SEO Checker -->
    <div class="seoChecker">
        <div class="seoHeading">
            SEO Analyzer
        </div>
        <div class="seoSubHeading">
            Perform in-depth SEO Analysis of your website.
        </div>
        <div class="seoSubHeading">
            See if your pages are optimized and get actionable data if they aren't.
        </div>
        <div class="searchURL">
            <form>
                <div class="input-group mb-2 searchBar">
                    <input type="text" class="form-control" placeholder="Enter website URL "
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary search-btn" type="button" id="button-addon2">Analyze
                        SEO</button>
                </div>
            </form>
        </div>
    </div>

</body>

<script>
        document.getElementById("logoutBtn").addEventListener("click", function() {
            window.location.href = "logout.php";
        });
    </script>

</html>