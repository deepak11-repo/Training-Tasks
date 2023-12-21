<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>SEO Insights Pro</title>
    <link rel="stylesheet" href="./assets/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .keyword-group ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .keyword-group li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .keyword-group svg {
            margin-right: 5px;
            fill: #fe6100;
        }
    </style>

</head>

<body>

    <!-- NavBar -->
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand navbarTitle" href="#">
                <img src="./assets/images/navLogo2.png" alt="Logo" width="40" height="40"
                    class="d-inline-block align-text-top">
                SEO Insights PRO
            </a>
            <button class="btn  btn-shadow custom-btn-color" id="logoutBtn">Logout&nbsp;&nbsp;
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="fill: rgba(255, 255, 255, 1);transform:;msFilter:;">
                    <path d="m2 12 5 4v-3h9v-2H7V8z"></path>
                    <path
                        d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z">
                    </path>
                </svg>
            </button>
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

            <?php
            $pageRankInteger = $rank = $domain = $lastUpdated = $error = $image = $title = $description = '';
            $keywords = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["form1_submit"])) {
                $inpUrl = $_POST['urlInput'];

                //Meta Data Information
                $murl = 'https://api.linkpreview.net/?key=4bc9c6686ec0c3aa359f1e09f01aeac0&q=' . urlencode($inpUrl);
                $response = file_get_contents($murl);
                $data = json_decode($response, true);
                $image = $data['image'];
                $title = $data['title'];
                $description = $data['description'];
                $furl = $data['url'];


                //Page Rank 
                $url = 'https://openpagerank.com/api/v1.0/getPageRank';
                $query = http_build_query(array(
                    'domains' => array(
                        $inpUrl
                    )
                ));
                $url = $url . '?' . $query;
                $ch = curl_init();
                $headers = ['API-OPR: 4sgkogww408owwgw0080woggw8wk4csc4gkwk80c'];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($output, true);
                if ($response['status_code'] == 200) {
                    $responseData = $response['response'][0];
                    $pageRankInteger = $responseData['page_rank_integer'];
                    $rank = $responseData['rank'];
                    $domain = $responseData['domain'];
                    $lastUpdated = $response['last_updated'];
                } else {
                    $error = 'Error: ' . $response['error'];
                }

                //Keywords Extraction
                $api_key = '24a00253-92b5-444a-aa50-e3a2fdc0d9cc';
                $api_endpoint = 'https://api.builtwith.com/kw2/api.json?KEY=' . $api_key . '&LOOKUP=' . $inpUrl;
                $response = file_get_contents($api_endpoint);
                $data = json_decode($response, true);
                if (isset($data['Errors']) && !empty($data['Errors'])) {
                    echo '<p>Error occurred while fetching keywords</p>';
                } else {
                    $keywords = [];
                    foreach ($data['Keywords'] as $item) {
                        $keywords[$item['Domain']] = $item['Keywords'];
                    }
                }
            }
            ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group mb-2 searchBar">
                    <input type="text" class="form-control" placeholder="Enter website URL e.g. https://www.example.com"
                        aria-label="Recipient's username" aria-describedby="button-addon2" name="urlInput"
                        id="urlInput">
                    <button class="btn btn-outline-secondary search-btn" name="form1_submit" type="submit"
                        id="button-addon2">Analyze
                        SEO</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Condition - Only display the html content only when the fetched data is ready -->
    <?php if (!empty($image) && !empty($title) && !empty($description) && !empty($furl) && !empty($pageRankInteger) && !empty($rank) && !empty($domain) && !empty($lastUpdated)): ?>
        <!-- Meta Data and Rank -->
        <div id="metadataResult"
            style="width: 100%; display: flex; align-items: center; justify-content: center; padding-bottom: 2%;">
            <div style="width: 35%; margin: auto;">
                <div class="card">
                    <img src="<?php echo $image; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <table class="table">
                            <tbody style="text-align: justify">
                                <tr>
                                    <th scope="row">Domain Name</th>
                                    <td>
                                        <?php echo $domain; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Website Title</th>
                                    <td>
                                        <?php echo $title; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Website Description</th>
                                    <td>
                                        <?php echo $description; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Page Rank</th>
                                    <td>
                                        <?php
                                        function updateProgressBar($score)
                                        {
                                            $percentage = ($score / 10) * 100;
                                            echo '
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: ' . $percentage . '%;" aria-valuenow="' . $score . '" aria-valuemin="0" aria-valuemax="10"></div>
                                                    </div>
                                                    <p class="mt-3">' . $score . '/10</p>';
                                        }
                                        updateProgressBar($pageRankInteger);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">SERP</th>
                                    <td>
                                        <?php echo $rank; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button onclick="window.open('<?php echo $furl; ?>', '_blank');"
                        class="card-link btn btn-outline-secondary search-btn"
                        style="width:60%; margin: auto; margin-bottom: 3%;">Click here to know more&nbsp;&nbsp;<svg
                            xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                            <path fill="#ffffff"
                                d="M432 320H400a16 16 0 0 0 -16 16V448H64V128H208a16 16 0 0 0 16-16V80a16 16 0 0 0 -16-16H48A48 48 0 0 0 0 112V464a48 48 0 0 0 48 48H400a48 48 0 0 0 48-48V336A16 16 0 0 0 432 320zM488 0h-128c-21.4 0-32.1 25.9-17 41l35.7 35.7L135 320.4a24 24 0 0 0 0 34L157.7 377a24 24 0 0 0 34 0L435.3 133.3 471 169c15 15 41 4.5 41-17V24A24 24 0 0 0 488 0z" />
                        </svg></button>
                    <div class="card-footer">
                        <small class="text-body-secondary">Last Updated&nbsp;
                            <?php echo $lastUpdated; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div style="width:100%; display: flex; justify-content:space-around; background:#f8f6f3; padding-top:2%;">
        <?php
        if (!empty($keywords)) {
            foreach ($keywords as $inpUrl => $domainKeywords) {
                echo '<div class="card keywords-container" style="width:20%; margin-left:3%; margin-bottom:3%;">';
                echo '<div class="card-header" style="font-weight: 700; color: #fff; font-size: 18px; letter-spacing: 0.5px; background-color: #fe6100; border-color: #fe6100;">Keywords for ' . $inpUrl . '</div>';
                echo '<div class="card-body">';
                echo '<ul class="keyword-group">';
                foreach ($domainKeywords as $keyword) {
                    echo "<li><svg xmlns='http://www.w3.org/2000/svg' height='16' width='16' viewBox='0 0 512 512'><path fill='#fe6100' d='M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z'/></svg>&nbsp;&nbsp;$keyword</li>";
                }
                echo '</ul>';
                echo "</div>";
                echo "</div>";
            }
        }
        ?>

        <div class="accordion" id="accordionExample" style="width:60%; padding-bottom: 2%;">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                        style="background-color: #fe6100; border-color: #fe6100; font-weight: 700; color: #fff; font-size: 18px; letter-spacing: 0.5px;">
                        Checkout Keyword Rank
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="seoChecker">
                            <div class="searchURL">
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="input-group mb-2 searchBar">
                                        <input type="text" class="form-control" placeholder="Enter the keyword"
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            name="keywordInput" id="keywordInput">
                                        <button class="btn btn-outline-secondary search-btn" type="submit"
                                            name="form2_submit" id="button-addon2">
                                            Get Websites
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form2_submit"])) {
                            $keyword = isset($_POST['keywordInput']) ? $_POST['keywordInput'] : '';
                            function checkKeywordRank($apiKey, $searchEngineId, $keyword, $numResultsPerPage = 10, $currentPage = 1)
                            {
                                $startIndex = ($currentPage - 1) * $numResultsPerPage + 1;
                                $url = "https://www.googleapis.com/customsearch/v1?q=" . urlencode($keyword) . "&cx=$searchEngineId&key=$apiKey&start=$startIndex&num=$numResultsPerPage";
                                $response = file_get_contents($url);
                                if ($response === false) {
                                    echo "Error fetching search results.\n";
                                    return false;
                                }
                                $data = json_decode($response, true);
                                if (isset($data['error'])) {
                                    echo "API Error: " . $data['error']['message'] . "\n";
                                    return false;
                                }
                                $items = $data['items'];
                                if (empty($items)) {
                                    echo "No search results found for the keyword.\n";
                                    return false;
                                }
                                echo '<div style="width:85%; margin:auto;">';
                                echo '<table class="table table-hover">';
                                echo '<thead>';
                                echo '<tr><th scope="col">Rank</th><th scope="col">Title</th><th scope="col">Link</th></tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                foreach ($items as $index => $item) {
                                    $rank = $startIndex + $index;
                                    $title = $item['title'];
                                    $link = $item['link'];
                                    echo "<tr><td>$rank</td><td>$title</td><td><a href='$link' target='_blank'>$link</a></td></tr>";
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                return true;
                            }
                            if (!empty($keyword)) {
                                $apiKey = 'AIzaSyAEcDBAVLiS5N6C0iLbhS8tYY1JbE3-pN0';
                                $searchEngineId = '768a32dc799a54383';
                                $numResultsPerPage = 10;
                                $currentPage = 1;
                                checkKeywordRank($apiKey, $searchEngineId, $keyword, $numResultsPerPage, $currentPage);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>






</body>

<!-- Logout Button Functiionality -->
<script>
    let res = document.getElementById("metadataResult");
    document.getElementById("logoutBtn").addEventListener("click", function () {
        window.location.href = "logout.php";
    });
</script>

</html>