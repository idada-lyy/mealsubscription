<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

$checkAllergies = mysqli_query($db, "SELECT dishes.allergies FROM dishes LEFT JOIN users_orders ON dishes.title = users_orders.title WHERE users_orders.u_id ='" . $_SESSION['user_id'] . "' GROUP BY dishes.allergies LIMIT 1");
$allergiesValue = mysqli_fetch_array($checkAllergies);

$allergies = $_GET['allergies'];
$diets = $_GET['diets'];
$keyword = $_GET['keyword'];

if (empty($keyword) && empty($allergies) && empty($diets) && !empty($allergiesValue["allergies"])) {
    $sql = "SELECT * FROM dishes WHERE (allergies IS NULL OR NOT allergies LIKE ". " '%" . $allergiesValue["allergies"] . "%') ";
} else {
    $sql = "SELECT * FROM dishes ";
}

if (!empty($keyword)) {
    $sql .= " WHERE title LIKE '%" . $keyword . "%' ";
}
if (!empty($allergies)) {
    $sql .= empty($keyword) ? " WHERE " : " AND ";
    $sql .= " (allergies IS NULL OR NOT allergies LIKE '%" . $allergies . "%') ";
}
if (!empty($diets)) {
    $sql .= empty($keyword) && empty($allergies) ? " WHERE " : " AND ";
    $sql .= " (diets IS NULL OR diets LIKE '%" . $diets . "%') ";
}

$sql .= "ORDER BY rating DESC LIMIT 6";
$query_res = mysqli_query($db, $sql);

$totalstars= mysqli_query($db,"select rating from dishes");
$getreviews= mysqli_query($db,"select * from review");
$userPreferences= mysqli_query($db,"select users.preference from users");
$userRatings= mysqli_query($db,"select review.u_id from review");
$numRecommendations = mysqli_num_rows(mysqli_query($db, "SELECT * FROM review WHERE d_id='$r[d_id]'"));

$avg_rating


$query1 = "SELECT column1, column2 FROM table1 WHERE condition1";
$query2 = "SELECT column3, column4 FROM table2 WHERE condition2";

$combinedQuery = $query1 . " INNER JOIN " . $query2 . " ON table1.columnX = table2.columnY";
mysqli_query($db, "SELECT * FROM review INNER JOIN users ON users.u_id=review.u_id WHERE d_id='$r[d_id]'");

$result = mysqli_query($db, $combinedQuery);

function collaborativeFiltering($db, $u_id, $numRecommendations, $totalstars) {
    // Step 1: Calculate Similarity
    //$query = "SELECT u_id, AVG(rating) as avg_rating FROM review GROUP BY u_id";
    //$result = mysqli_query($db, $query);

    //$userRatings = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $userRatings[$row['u_id']] = $row['avg_rating'];
    }

    $targetUserRatings = $userRatings[$user_id];

    $similarities = array();
    foreach ($userRatings as $otherUser => $rating) {
        if ($otherUser != $user_id) {
            $similarity = calculateSimilarity($db, $targetUserRatings, $otherUser);
            $similarities[$otherUser] = $similarity;
        }
    }

    // Step 2: Find Similar Users
    arsort($similarities); // Sort in descending order
    $similarUsers = array_slice(array_keys($similarities), 0, $numRecommendations);

    // Step 3: Generate Recommendations
    $recommendations = array();
    foreach ($similarUsers as $user) {
        $query = "SELECT d_id, AVG(rating) as avg_rating FROM review WHERE u_id='$user' GROUP BY d_id";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $restaurant = $row['d_id'];
            $rating = $row['avg_rating'];
            if (!isset($targetUserRatings[$restaurant])) {
                $recommendations[$restaurant] = $rating;
            }
        }
    }

    // Step 4: Return Recommendations
    arsort($recommendations); // Sort in descending order based on ratings
    $recommendedRestaurants = array_keys(array_slice($recommendations, 0, $numRecommendations));

    return $recommendedRestaurants;
}

function calculateSimilarity($db, $targetUserRatings, $otherUser) {
    // Implement similarity calculation (e.g., Pearson correlation) between two users
    // Use SQL queries to fetch data from the database and perform calculations
    // Return the similarity score between the target user and other user

    // Example of Pearson correlation calculation (you can modify this based on your data model):
    $query = "SELECT d_id, rating FROM review WHERE u_id='$otherUser' AND d_id IN (" . implode(",", array_keys($targetUserRatings)) . ")";
    $result = mysqli_query($db, $query);

    $ratings = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[$row['d_id']] = $row['rating'];
    }

    // Calculate Pearson correlation
    $numerator = 0;
    $denominator1 = 0;
    $denominator2 = 0;

    foreach ($targetUserRatings as $restaurant => $rating1) {
        if (isset($ratings[$restaurant])) {
            $rating2 = $ratings[$restaurant];
            $numerator += ($rating1 - $targetUserRatings['avg_rating']) * ($rating2 - $ratings['avg_rating']);
            $denominator1 += pow(($rating1 - $targetUserRatings['avg_rating']), 2);
            $denominator2 += pow(($rating2 - $ratings['avg_rating']), 2);
        }
    }

    if ($denominator1 == 0 || $denominator2 == 0) {
        return 0.0;
    }

    $similarity = $numerator / (sqrt($denominator1) * sqrt($denominator2));

    return $similarity;
}



function contentBasedFiltering($userPreferences, $numRecommendations) {
    // Implement content-based filtering algorithm here
    // Use userPreferences to find restaurants with similar attributes
    // Return an array of recommended restaurants for the user
    // based on content-based filtering
}


function hybridRecommendations($userPreferences, $userRatings, $numRecommendations) {
    // Get collaborative filtering recommendations for the user
    $collaborativeRecommendations = collaborativeFiltering($userRatings, $userPreferences['u_id'], $numRecommendations);

    // Get content-based filtering recommendations for the user
    $contentBasedRecommendations = contentBasedFiltering($userPreferences, $numRecommendations);

    // Combine the recommendations (you can use different strategies, e.g., weighted average)
    $hybridRecommendations = array_merge($collaborativeRecommendations, $contentBasedRecommendations);

    // Return the final list of hybrid recommendations
    return $hybridRecommendations;
}



// Call the hybrid recommendation function
$hybridRecommendations = hybridRecommendations($userPreferences, $userRatings, $getreviews);

// Display the recommendations on your website
//echo "<h3>Recommended Restaurants:</h3>";
//echo "<ul>";
//foreach ($hybridRecommendations as $restaurant => $score) {
//    echo "<li>$restaurant (Score: $score)</li>";
//}
//echo "</ul>";

?>




<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/styler.css" rel="stylesheet">
</head>

<body class="home">


<?php
include("header.html");
?>


<section class="popular">
    <div class="container">
        <div class="title text-xs-center m-b-30">
            <div class="h2overwrite">Recommended by others</div>
            <p class="lead">Easiest way to order your favourite food among these top 6 dishes</p>
        </div>
        <div class="row">
            <?php
            while ($r = mysqli_fetch_array($query_res)) {

                $count_review = mysqli_num_rows(mysqli_query($db, "SELECT * FROM review WHERE d_id='$r[d_id]'"));
                $query_review = mysqli_query($db, "SELECT * FROM review INNER JOIN users ON users.u_id=review.u_id WHERE d_id='$r[d_id]'");

                $review_list = "";
                $totalRating = 0;

                while ($review = mysqli_fetch_array($query_review)) {
                    $totalRating += $review['rating'];
                    $color = $review['rating'] == 0 ? '#000000' : '#FDCC0D';
                    $review_list .= '<div class="card d-inline-block" style="border:1px solid black;width: 48%;padding: 10px; margin-right: 10px" >
                                        <p style="margin:0; font-weight: bold;">By ' . $review['username'] . '</p>
                                        <div>' . $review['rating'] . '/5 <i class="fa fa-star rating-color" style="color:' . $color . '"></i></div>
                                        <div>Comment:</div>
                                        <div><p>' . $review['msg'] . '</p></div>
                                    </div>';
                }

                if ($count_review == 1) {
                    $avg = $totalRating;
                } else {
                    $avg = $count_review > 0 ? round(($count_review * 5) / $totalRating) == 1 ? 5 : round(($count_review * 5) / $totalRating) : 0;
                }

                $rate = "";
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $avg) {
                        $rate .= '<i class="fa fa-star rating-color" style="color: #FDCC0D"></i>';
                    } else {
                        $rate .= '<i class="fa fa-star rating-color" style="color: black"></i>';
                    }
                }
                echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                            <div class="food-item-wrap">
                                                <div class="figure-wrap bg-image" data-image-src="admin/Res_img/dishes/' . $r['img'] . '"></div>
                                                <div class="content" style="height: 350px">
                                                    <h5><a href="dishes.php?res_id=' . $r['rs_id'] . '">' . $r['title'] . '</a></h5>
                                                    <div class="product-name">' . $r['slogan'] . '</div>
                                                    <h5>Ingredients</h5>
                                                    <div class="product-name">' . $r['ingredients'] . '</div>
                                                    <div style="display: flex; padding-bottom: 20px; justify-content:space-between; align-items: center " >
                                                        <div class="ratings" style="padding-right: 10px">
                                                        <div style="display: flex;align-items: center;justify-content: center">
                                                            <div style="padding-right: 5px">
                                                                ' . $rate . '
                                                            </div>
                                                            <p style="margin:0">' . $avg . '/5</p>
                                                        </div>
                                                        </div>
                                                        <p style="cursor:pointer; color: #db6600; margin:0" data-toggle="modal" data-target="#exampleModal' . $r['d_id'] . '">' . $count_review . ' Reviews</p>
                                                    </div>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal' . $r['d_id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">All Review</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body" >
                                                            ' . $review_list . '
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    
                                                    <div class="price-btn-block"> <span class="price">RM' . $r['price'] . '</span> <a href="dishes.php?res_id=' . $r['rs_id'] . '" class="btn theme-btn-dash pull-right">Order Now</a> </div>
                                                </div>
                                                
                                            </div>
                                    </div>';
            }
            ?>
        </div>
    </div>
</section>

<section class="hero bg-image" data-image-src="images/img/pimg.jpg">
    <div class="hero-inner">
        <div class="container text-center hero-text font-white">
            <h1>Order Delivery & Take-Out</h1>

            <div class="banner-form">
                <form class="form-inline">

                </form>
            </div>
            <div class="steps">
                <div class="step-item step1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 483 483" width="512" height="512">
                        <g fill="#FFF">
                            <path d="M467.006 177.92c-.055-1.573-.469-3.321-1.233-4.755L407.006 62.877V10.5c0-5.799-4.701-10.5-10.5-10.5h-310c-5.799 0-10.5 4.701-10.5 10.5v52.375L17.228 173.164a10.476 10.476 0 0 0-1.22 4.938h-.014V472.5c0 5.799 4.701 10.5 10.5 10.5h430.012c5.799 0 10.5-4.701 10.5-10.5V177.92zM282.379 76l18.007 91.602H182.583L200.445 76h81.934zm19.391 112.602c-4.964 29.003-30.096 51.143-60.281 51.143-30.173 0-55.295-22.139-60.258-51.143H301.77zm143.331 0c-4.96 29.003-30.075 51.143-60.237 51.143-30.185 0-55.317-22.139-60.281-51.143h120.518zm-123.314-21L303.78 76h86.423l48.81 91.602H321.787zM97.006 55V21h289v34h-289zm-4.198 21h86.243l-17.863 91.602h-117.2L92.808 76zm65.582 112.602c-5.028 28.475-30.113 50.19-60.229 50.19s-55.201-21.715-60.23-50.19H158.39zM300 462H183V306h117v156zm21 0V295.5c0-5.799-4.701-10.5-10.5-10.5h-138c-5.799 0-10.5 4.701-10.5 10.5V462H36.994V232.743a82.558 82.558 0 0 0 3.101 3.255c15.485 15.344 36.106 23.794 58.065 23.794s42.58-8.45 58.065-23.794a81.625 81.625 0 0 0 13.525-17.672c14.067 25.281 40.944 42.418 71.737 42.418 30.752 0 57.597-17.081 71.688-42.294 14.091 25.213 40.936 42.294 71.688 42.294 24.262 0 46.092-10.645 61.143-27.528V462H321z"></path>
                            <path d="M202.494 386h22c5.799 0 10.5-4.701 10.5-10.5s-4.701-10.5-10.5-10.5h-22c-5.799 0-10.5 4.701-10.5 10.5s4.701 10.5 10.5 10.5z"></path>
                        </g>
                    </svg>
                    <h4><span style="color:white;">1. </span>Choose Restaurant</h4></div>

                <div class="step-item step2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 380.721 380.721">
                        <g fill="#FFF">
                            <path d="M58.727 281.236c.32-5.217.657-10.457 1.319-15.709 1.261-12.525 3.974-25.05 6.733-37.296a543.51 543.51 0 0 1 5.449-17.997c2.463-5.729 4.868-11.433 7.25-17.01 5.438-10.898 11.491-21.07 18.724-29.593 1.737-2.19 3.427-4.328 5.095-6.46 1.912-1.894 3.805-3.747 5.676-5.588 3.863-3.509 7.221-7.273 11.107-10.091 7.686-5.711 14.529-11.137 21.477-14.506 6.698-3.724 12.455-6.982 17.631-8.812 10.125-4.084 15.883-6.141 15.883-6.141s-4.915 3.893-13.502 10.207c-4.449 2.917-9.114 7.488-14.721 12.147-5.803 4.461-11.107 10.84-17.358 16.992-3.149 3.114-5.588 7.064-8.551 10.684-1.452 1.83-2.928 3.712-4.427 5.6a1225.858 1225.858 0 0 1-3.84 6.286c-5.537 8.208-9.673 17.858-13.995 27.664-1.748 5.1-3.566 10.283-5.391 15.534a371.593 371.593 0 0 1-4.16 16.476c-2.266 11.271-4.502 22.761-5.438 34.612-.68 4.287-1.022 8.633-1.383 12.979 94 .023 166.775.069 268.589.069.337-4.462.534-8.97.534-13.536 0-85.746-62.509-156.352-142.875-165.705 5.17-4.869 8.436-11.758 8.436-19.433-.023-14.692-11.921-26.612-26.631-26.612-14.715 0-26.652 11.92-26.652 26.642 0 7.668 3.265 14.558 8.464 19.426-80.396 9.353-142.869 79.96-142.869 165.706 0 4.543.168 9.027.5 13.467 9.935-.002 19.526-.002 28.926-.002zM0 291.135h380.721v33.59H0z"/>
                        </g>
                    </svg>
                    <h4><span style="color:white;">2. </span>Order Food</h4></div>

                <div class="step-item step3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 612.001 612">
                        <path d="M604.131 440.17h-19.12V333.237c0-12.512-3.776-24.787-10.78-35.173l-47.92-70.975a62.99 62.99 0 0 0-52.169-27.698h-74.28c-8.734 0-15.737 7.082-15.737 15.738v225.043h-121.65c11.567 9.992 19.514 23.92 21.796 39.658H412.53c4.563-31.238 31.475-55.396 63.972-55.396 32.498 0 59.33 24.158 63.895 55.396h63.735c4.328 0 7.869-3.541 7.869-7.869V448.04c-.001-4.327-3.541-7.87-7.87-7.87zM525.76 312.227h-98.044a7.842 7.842 0 0 1-7.868-7.869v-54.372c0-4.328 3.541-7.869 7.868-7.869h59.724c2.597 0 4.957 1.259 6.452 3.305l38.32 54.451c3.619 5.194-.079 12.354-6.452 12.354zM476.502 440.17c-27.068 0-48.943 21.953-48.943 49.021 0 26.99 21.875 48.943 48.943 48.943 26.989 0 48.943-21.953 48.943-48.943 0-27.066-21.954-49.021-48.943-49.021zm0 73.495c-13.535 0-24.472-11.016-24.472-24.471 0-13.535 10.937-24.473 24.472-24.473 13.533 0 24.472 10.938 24.472 24.473 0 13.455-10.938 24.471-24.472 24.471zM68.434 440.17c-4.328 0-7.869 3.543-7.869 7.869v23.922c0 4.328 3.541 7.869 7.869 7.869h87.971c2.282-15.738 10.229-29.666 21.718-39.658H68.434v-.002zm151.864 0c-26.989 0-48.943 21.953-48.943 49.021 0 26.99 21.954 48.943 48.943 48.943 27.068 0 48.943-21.953 48.943-48.943.001-27.066-21.874-49.021-48.943-49.021zm0 73.495c-13.534 0-24.471-11.016-24.471-24.471 0-13.535 10.937-24.473 24.471-24.473s24.472 10.938 24.472 24.473c0 13.455-10.938 24.471-24.472 24.471zm117.716-363.06h-91.198c4.485 13.298 6.846 27.54 6.846 42.255 0 74.28-60.431 134.711-134.711 134.711-13.535 0-26.675-2.045-39.029-5.744v86.949c0 4.328 3.541 7.869 7.869 7.869h265.96c4.329 0 7.869-3.541 7.869-7.869V174.211c-.001-13.062-10.545-23.606-23.606-23.606zM118.969 73.866C53.264 73.866 0 127.129 0 192.834s53.264 118.969 118.969 118.969 118.97-53.264 118.97-118.969-53.265-118.968-118.97-118.968zm0 210.864c-50.752 0-91.896-41.143-91.896-91.896s41.144-91.896 91.896-91.896c50.753 0 91.896 41.144 91.896 91.896 0 50.753-41.143 91.896-91.896 91.896zm35.097-72.488c-1.014 0-2.052-.131-3.082-.407L112.641 201.5a11.808 11.808 0 0 1-8.729-11.396v-59.015c0-6.516 5.287-11.803 11.803-11.803 6.516 0 11.803 5.287 11.803 11.803v49.971l29.614 7.983c6.294 1.698 10.02 8.177 8.322 14.469-1.421 5.264-6.185 8.73-11.388 8.73z"
                              fill="#FFF"/>
                    </svg>
                    <h4><span style="color:white;">3. </span>Delivery or take out</h4></div>

            </div>

        </div>
    </div>

</section>

<section class="featured-restaurants">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="title-block pull-left">
                    <h4>Featured Restaurants</h4></div>
            </div>
            <div class="col-sm-8">
                <div class="restaurants-filter pull-right">
                    <nav class="primary pull-left">
                        <ul>
                            <li><a href="#" class="selected" data-filter="*">all</a></li>
                            <?php
                            $res = mysqli_query($db, "select * from res_category");
                            while ($row = mysqli_fetch_array($res)) {
                                echo '<li><a href="#" data-filter=".' . $row['c_name'] . '"> ' . $row['c_name'] . '</a> </li>';
                            }
                            ?>

                        </ul>
                    </nav>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="restaurant-listing">


                <?php
                $ress = mysqli_query($db, "select * from restaurant");
                while ($rows = mysqli_fetch_array($ress)) {

                    $query = mysqli_query($db, "select * from res_category where c_id='" . $rows['c_id'] . "' ");
                    $rowss = mysqli_fetch_array($query);

                    echo ' <div class="col-xs-12 col-sm-12 col-md-6 single-restaurant all ' . $rowss['c_name'] . '" >
														<div class="restaurant-wrap">
															<div class="row">
																<div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 text-xs-center">
																	<a class="restaurant-logo" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo"> </a>
																</div>
													
																<div class="col-xs-12 col-sm-9 col-md-12 col-lg-9">
																	<h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5> <span>' . $rows['address'] . '</span>
																</div>
													
															</div>
												
														</div>
												
													</div>';
                }


                ?>


            </div>
        </div>


    </div>
</section>


<?php
include("footer.html");
?>


<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/headroom.js"></script>
<script src="js/foodpicky.min.js"></script>
</body>

</html>