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

$sql .= "ORDER BY rating DESC LIMIT 9";
$query_res = mysqli_query($db, $sql);

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


<section style="padding: 110px 0 15px 0 ">
    <div class="container">
        <form action='' method='get' enctype="multipart/form-data">
            <div class="form-body">

                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="keyword"
                               class="form-control" placeholder="Search">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="allergies" class="form-control custom-select"
                                data-placeholder="Choose a Category" tabindex="1">
                            <option value="">-- Allergies --</option>
                            <option value="milk">Milk</option>
                            <option value="eggs">Eggs</option>
                            <option value="peanuts">Peanuts</option>
                            <option value="tree-nuts">Tree Nuts</option>
                            <option value="soy">Soy</option>
                            <option value="fish">Fish</option>
                            <option value="shellfish">Shellfish</option>
                            <option value="wheat">Wheat</option>
                            <option value="celery">Celery</option>
                            <option value="strawberries">Strawberries</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="diets" class="form-control custom-select"
                                data-placeholder="Choose a diets" tabindex="1">
                            <option value="">-- Diets --</option>
                            <option value="ketogenic">Ketogenic</option>
                            <option value="vegan">Vegan</option>
                            <option value="pescatarian">Pescatarian</option>
                            <option value="gluten-free">Gluten Free</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-actions">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

<section class="popular">
    <div class="container">
        <div class="title text-xs-center m-b-30">
            <div class="h2overwrite">You Might Like</div>
            <p class="lead">Some of the recommended dishes</p>
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