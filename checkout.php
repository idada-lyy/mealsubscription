<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();


function function_alert()
{
    echo "<script>alert('Thank you. Your Order has been placed!');</script>";
    echo "<script>window.location.replace('your_orders.php');</script>";
}
if (empty($_SESSION["user_id"]))
{
    header('location:login.php');
}
else{
if (!empty($_GET['receiveDatetime'])) {
    foreach ($_SESSION["cart_item"] as $k => $v) {
        $_SESSION["cart_item"][$k]["receiveDatetime"] = $_GET['receiveDatetime'];
    }
}

if (!empty($_GET['subscription'])) {
    foreach ($_SESSION["cart_item"] as $k => $v) {
        $_SESSION["cart_item"][$k]["subscription"] = $_GET['subscription'];
    }
}

foreach ($_SESSION["cart_item"] as $item) {

    $item_total += ($item["price"] * $item["quantity"]);

    if ($_POST['submit']) {

        $receiveDatetime = strtotime($item["receiveDatetime"]) === FALSE ? null : date('Y-m-d H:i:s',strtotime($item["receiveDatetime"]));
        $insert = ['u_id', 'title', 'quantity', 'price'];
        $value = [sprintf("'%s'", $_SESSION["user_id"]), sprintf("'%s'", $item["title"]), sprintf("'%s'", $item["quantity"]), sprintf("'%s'", $item["price"])];
        if (!empty($receiveDatetime)) {
            $insert[] = "receiveDatetime";
            $value[] =  sprintf("'%s'", $item["receiveDatetime"]);
        }

        if (!empty($item["subscription"])) {
            $insert[] = "subscription";
            $value[] =  sprintf("'%s'", $item["subscription"]);
        }

        $SQL = "insert into users_orders(" . implode(',', $insert) . ") values(" . implode(',', $value) . ")";
        mysqli_query($db, $SQL);


        unset($_SESSION["cart_item"]);
        unset($item["title"]);
        unset($item["quantity"]);
        unset($item["price"]);
        $success = "Thank you. Your order has been placed!";

        function_alert();


    }

}
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Checkout</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/styler.css" rel="stylesheet">
</head>
<body>

<div class="site-wrapper">
<?php
include("header.html");
?>
    <div class="page-wrapper">
        <div class="top-links">
            <div class="container">
                <ul class="row links">

                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose
                            Restaurant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and
                            Pay</a></li>
                </ul>
            </div>
        </div>

        <div class="container">
                 
					   <span style="color:green;">
								<?php echo $success; ?>
										</span>

        </div>


        <div class="container m-t-30">
            <form action="" method="post">
                <div class="widget clearfix">

                    <div class="widget-body">
                        <form method="post" action="#">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="cart-totals-title">
                                            <h4>Cart Summary</h4></div>
                                        <div class="cart-totals-fields">

                                            <table class="table">
                                                <tbody>


                                                <tr>
                                                    <td>Cart Subtotal</td>
                                                    <td> <?php echo "RM" . $item_total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Delivery Charges</td>
                                                    <td>Free</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-color"><strong>Total</strong></td>
                                                    <td class="text-color">
                                                        <strong> <?php echo "RM" . $item_total; ?></strong></td>
                                                </tr>
                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD"
                                                           type="radio" class="custom-control-input"> <span
                                                            class="custom-control-indicator"></span> <span
                                                            class="custom-control-description">Cash on Delivery</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod" type="radio" value="paypal" disabled
                                                           class="custom-control-input"> <span
                                                            class="custom-control-indicator"></span> <span
                                                            class="custom-control-description">Paypal <img
                                                                src="images/paypal.jpg" alt="" width="90"></span>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-xs-center"><input type="submit"
                                                                         onclick="return confirm('Do you want to confirm the order?');"
                                                                         name="submit" class="btn btn-success btn-block"
                                                                         value="Order Now"></p>
                                    </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>
    </form>
</div>

<?php
include("footer.html");
?>
</div>
</div>

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

<?php
}
?>
