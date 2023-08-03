<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

include_once 'product-action.php';

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Dishes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/styler.css" rel="stylesheet">
</head>

<body>

<?php
include("header.html");
?>


<div class="page-wrapper">
    <div class="top-links"  style="padding: 2px 0 2px 0 ">
        <div class="container" style="padding: 18px 0 10px 0;">
            <ul class="row links">

                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a>
                </li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a
                            href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>">Pick Your favorite food</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>

            </ul>
        </div>
    </div>
    <?php $ress = mysqli_query($db, "select * from restaurant where rs_id='$_GET[res_id]'");
    $rows = mysqli_fetch_array($ress);

    ?>
    <section class="inner-page-hero bg-image" data-image-src="images/img/restrr.png">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
                        <div class="image-wrap">
                            <figure><?php echo '<img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo">'; ?></figure>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                        <div class="pull-left right-text white-txt">
                            <div><a href="#"  class="secondoverwrite"><?php echo $rows['title']; ?></a></div>
                            <p><?php echo $rows['address']; ?></p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <div class="container m-t-30">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">

                <div class="widget widget-cart">
                    <div class="widget-heading">
                        <h3 class="widget-title text-dark">
                            Your Cart
                        </h3>


                        <div class="clearfix"></div>
                    </div>
                    <form action="checkout.php?res_id=<?php echo $_GET['res_id']; ?>&action=check" method="get"
                          enctype="multipart/form-data">

                        <div class="order-row bg-white">
                            <div class="widget-body">


                                <?php

                                $item_total = 0;

                                foreach ($_SESSION["cart_item"] as $item) {
                                    ?>

                                    <div class="title-row">
                                        <?php echo $item["title"]; ?><a
                                                href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>">
                                            <i class="fa fa-trash pull-right"></i></a>
                                    </div>

                                    <div class="form-group row no-gutter">
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control b-r-0"
                                                   value=<?php echo "RM" . $item["price"]; ?> readonly
                                                   id="exampleSelect1">

                                        </div>
                                        <div class="col-xs-4">
                                            <input class="form-control" type="text" readonly
                                                   value='<?php echo $item["quantity"]; ?>' id="example-number-input">
                                        </div>

                                    </div>

                                    <?php
                                    $item_total += ($item["price"] * $item["quantity"]);
                                }
                                ?>

                                <?php
                                if ($item_total == 0) {
                                    ?>
                                    <div></div>
                                    <?php
                                } else {
                                    ?>
                                    <div>
                                        <label class="control-label">Receive Date Time</label>
                                        <input class="form-control" name="receiveDatetime" type="datetime-local">
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($item_total == 0) {
                                    ?>
                                    <div></div>
                                    <?php
                                } else {
                                    ?>
                                    <div style="padding-top: 15px">
                                        <label class="control-label">Subscription</label>
                                        <select name="subscription" class="form-control custom-select"
                                                data-placeholder="Choose a diets" tabindex="1">
                                            <option value="">-- No need --</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="1 Month">1 Month</option>
                                            <option value="3 Month">3 Month</option>
                                            <option value="6 Month">6 Month</option>
                                            <option value="9 Month">9 Month</option>
                                            <option value="Year">Yearly</option>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>


                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 class="value"><strong><?php echo "RM" . $item_total; ?></strong></h3>
                                <p>Free Delivery!</p>
                                <?php
                                if ($item_total == 0) {
                                    ?>


                                    <button type="submit"
                                            class="btn btn-danger btn-lg disabled">Checkout
                                    </button>

                                    <?php
                                } else {
                                    ?>
                                    <button type="submit"
                                            class="btn btn-success btn-lg active">Checkout
                                    </button>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="col-md-8">


                <div class="menu-widget" id="2">
                    <div class="widget-heading">
                        <h3 class="widget-title text-dark">
                            MENU <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2"
                                    aria-expanded="true">
                                <i class="fa fa-angle-right pull-right"></i>
                                <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="collapse in" id="popular2">
                        <?php
                        $stmt = $db->prepare("select * from dishes where rs_id='$_GET[res_id]'");
                        $stmt->execute();
                        $products = $stmt->get_result();
                        if (!empty($products)) {
                            foreach ($products as $product) {
                                ?>
                                <div class="food-item">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-lg-8">
                                            <form method="post"
                                                  action='dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                                <div class="rest-logo pull-left">
                                                    <a class="restaurant-logo pull-left"
                                                       href="#"><?php echo '<img src="admin/Res_img/dishes/' . $product['img'] . '" alt="Food logo">'; ?></a>
                                                </div>

                                                <div class="rest-descr">
                                                    <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                                    <p> <?php echo $product['slogan']; ?></p>
                                                </div>

                                                <div class="rest-descr">
                                                    <h6 style="font-weight: bold">Ingredients</h6>
                                                    <p> <?php echo $product['ingredients']; ?></p>
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info">
                                            <span class="price pull-left">RM<?php echo $product['price']; ?></span>
                                            <input class="b-r-0" type="text" name="quantity" style="margin-left:30px;"
                                                   value="1" size="2"/>
                                            <input type="submit" class="btn theme-btn" style="margin-left:40px;"
                                                   value="Add To Cart"/>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>


            </div>

        </div>

    </div>

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
