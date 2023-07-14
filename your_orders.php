<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if (empty($_SESSION['user_id']))
{
    header('location:login.php');
}
else
{

// ----------------------------------------------------------------
// Add review
if (isset($_POST['submit'])) {
    if (
        empty($_POST['o_id']) ||
        empty($_POST['msg']) ||
        empty($_POST['rating'])
    ) {
        $message = "All fields must be Required!";
    } else {
        $sql = "";
        $order = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM users_orders WHERE o_id = '" . $_POST['o_id'] . "' "));
        $dishes = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM dishes WHERE title = '" . $order['title'] . "' "));
        $new_rate = (int)$dishes['rating'] + (int)$_POST['rating'];
        $old_review = mysqli_query($db, "SELECT * FROM review WHERE o_id = '" . $_POST['o_id'] . "' ");
        if (mysqli_num_rows($old_review) == 0) {
            $sql = "INSERT INTO review(u_id,o_id,d_id,msg,rating) VALUE('" . $_SESSION["user_id"] . "','" . $_POST['o_id'] . "','" . $dishes['d_id'] . "','" . $_POST['msg'] . "','" . $_POST['rating'] . "')";
        } else {
            $new_rate -= (int)mysqli_fetch_array($old_review)['rating'];
            $sql = "UPDATE review SET msg='$_POST[msg]', rating='$_POST[rating]' WHERE o_id = '" . $_POST['o_id'] . "'";
        }
        mysqli_query($db, $sql);
        mysqli_query($db, "UPDATE dishes SET rating='$new_rate' WHERE d_id='$dishes[d_id]'");

        echo "<script>alert('Thank your review. Your Review has been save!');</script>";
    }
}
// ----------------------------------------------------------------

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>My Orders</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">


        .indent-small {
            margin-left: 5px;
        }

        .form-group.internal {
            margin-bottom: 0;
        }

        .dialog-panel {
            margin: 10px;
        }

        .datepicker-dropdown {
            z-index: 200 !important;
        }

        .panel-body {
            background: #e5e5e5;
            /* Old browsers */
            background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            /* FF3.6+ */
            background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
            /* Chrome,Safari4+ */
            background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            /* Opera 12+ */
            background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            /* IE10+ */
            background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
            font: 600 15px "Open Sans", Arial, sans-serif;
        }

        label.control-label {
            font-weight: 600;
            color: #777;
        }

        /*
        table {
            width: 750px;
            border-collapse: collapse;
            margin: auto;

            }

        /* Zebra striping */
        /* tr:nth-of-type(odd) {
            background: #eee;
            }

        th {
            background: #404040;
            color: white;
            font-weight: bold;

            }

        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 14px;

            } */
        *

        /


        @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {

            /* table {
                  width: 100%;
            }


            table, thead, tbody, th, td, tr {
                display: block;
            } */
            /* thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr { border: 1px solid #ccc; } */
            /* td {

                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {

                position: absolute;

                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;

                content: attr(data-column);

                color: #000;
                font-weight: bold;
            } */

        }


    </style>

</head>

<body>


<header id="header" class="header-scroll top-header headrom">

    <nav class="navbar navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                    data-target="#mainNavbarCollapse">&#9776;
            </button>
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/icn.png" alt=""> </a>
            <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="restaurants.php">Restaurants <span
                                    class="sr-only"></span></a></li>

                    <?php
                    if (empty($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                    } else {


                        echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                    }

                    ?>

                </ul>
            </div>
        </div>
    </nav>

</header>
<div class="page-wrapper">


    <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg">
        <div class="container"></div>

    </div>
    <div class="result-show">
        <div class="container">
            <div class="row">


            </div>
        </div>
    </div>

    <section class="restaurants-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                </div>
                <div class="col-xs-12">
                    <div class="bg-gray">
                        <div class="row">

                            <table class="table table-bordered table-hover">
                                <thead style="background: #404040; color:white;">
                                <tr>
                                    <th>Item</th>
                                    <th>From Restaurant</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subscription</th>
                                    <th>Status</th>
                                    <th>Receive Date Time</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php

                                $query_res = mysqli_query($db, "select * from users_orders where u_id='" . $_SESSION['user_id'] . "'");
                                if (!mysqli_num_rows($query_res) > 0) {
                                    echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
                                } else {

                                    while ($row = mysqli_fetch_array($query_res)) {

                                        $dishes = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM dishes WHERE title = '" . $row['title'] . "' "));
                                        $restaurant = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM restaurant WHERE rs_id = '" . $dishes['rs_id'] . "' "));

                                        ?>
                                        <tr>
                                            <td data-column="Item"> <?php echo $row['title']; ?></td>
                                            <td data-column="Restaurant"> <?php echo $restaurant['title'] ? $restaurant['title'] : "-"; ?></td>
                                            <td data-column="Quantity"> <?php echo $row['quantity']; ?></td>
                                            <td data-column="price">$<?php echo $row['price']; ?></td>
                                            <td data-column="price">
                                                <?php echo $row['subscription'] ? $row['subscription'] : "Not subscribed"; ?></td>
                                            <td data-column="status">
                                                <?php
                                                $status = $row['status'];
                                                if ($status == "" or $status == "NULL") {
                                                    ?>
                                                    <button type="button" class="btn btn-info"><span class="fa fa-bars"
                                                                                                     aria-hidden="true"></span>
                                                        Dispatch
                                                    </button>
                                                    <?php
                                                }
                                                if ($status == "in process") { ?>
                                                    <button type="button" class="btn btn-warning"><span
                                                                class="fa fa-cog fa-spin" aria-hidden="true"></span> On
                                                        The Way!
                                                    </button>
                                                    <?php
                                                }
                                                if ($status == "closed") {
                                                    ?>
                                                    <button type="button" class="btn btn-success"><span
                                                                class="fa fa-check-circle" aria-hidden="true"></span>
                                                        Delivered
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($status == "rejected") {
                                                    ?>
                                                    <button type="button" class="btn btn-danger"><i
                                                                class="fa fa-close"></i> Cancelled
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td data-column="receiveDatetime"> <?php echo $row['receiveDatetime'] ? $row['receiveDatetime'] : "-"; ?></td>
                                            <td data-column="Date"> <?php echo $row['date']; ?></td>
                                            <td data-column="Action">
                                                <?php
                                                if ($status == "closed") {
                                                    ?>
                                                    <a data-toggle="modal"
                                                       data-target="#exampleModal<?php echo $row['o_id']; ?>"
                                                       class="btn btn-info btn-flat btn-addon btn-xs m-b-10"
                                                       style="color:#ffffff">Review</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a
                                                            href="delete_orders.php?order_del=<?php echo $row['o_id']; ?>"
                                                            onclick="return confirm('Are you sure you want to cancel your order?');"
                                                            class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                                class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                    <?php
                                                }
                                                ?>

                                                <div class="modal fade" id="exampleModal<?php echo $row['o_id'] ?>"
                                                     tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Write a
                                                                    review</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action='' method='post'
                                                                      enctype="multipart/form-data">
                                                                    <input type="hidden" name="o_id"
                                                                           value="<?php echo $row['o_id'] ?>"
                                                                           class="form-control required">
                                                                    <div class="form-body">

                                                                        <div class="row p-t-20">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Message</label>
                                                                                    <input type="text" name="msg"
                                                                                           class="form-control required">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Select
                                                                                        Rating</label>
                                                                                    <select name="rating"
                                                                                            class="form-control custom-select required"
                                                                                            data-placeholder="Choose a Category"
                                                                                            tabindex="1">
                                                                                        <option>--Select Rating--
                                                                                        </option>
                                                                                        <option value="5">5 Star
                                                                                        </option>
                                                                                        <option value="4">4 Star
                                                                                        </option>
                                                                                        <option value="3">3 Star
                                                                                        </option>
                                                                                        <option value="2">2 Star
                                                                                        </option>
                                                                                        <option value="1">1 Star
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <div class="form-actions">
                                                                        <input type="submit" name="submit"
                                                                               class="btn btn-primary"
                                                                               value="Save">
                                                                        <a class="btn" data-dismiss="modal">Cancel</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </td>

                                        </tr>


                                    <?php }
                                } ?>


                                </tbody>
                            </table>


                        </div>


                    </div>

                </div>


            </div>


        </div>
</div>
</div>
</section>


<footer class="footer">
    <div class="row bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-3 payment-options color-gray">
                    <h5>Payment Options</h5>
                    <ul>
                        <li>
                            <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                        </li>
                        <li>
                            <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 address color-gray">
                    <h5>Address</h5>
                    <p>Nairobi KENYA</p>
                    <h5>Phone: +25424700079</a></h5></div>
                <div class="col-xs-12 col-sm-5 additional-info color-gray">
                    <h5>Addition informations</h5>
                    <p>Join thousands of other restaurants who benefit from having partnered with us.</p>
                </div>
            </div>
        </div>
    </div>

    </div>
</footer>

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