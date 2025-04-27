<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CneX | Invoice#<?php echo $_SESSION["checkout"]["order_id"]; ?></title>
    <link rel="icon" href="style/resources/cnex.png" />
    <link rel="stylesheet" href="style/bootstrap.css" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center p-2 pt-4">
                    <div class="logo logo-hw" onclick="window.location = 'home.php';">CneX</div>
                </div>
            </div>

            <div class="col-12" id="page">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-12 border border-opacity-50 rounded mt-4 mb-2">
                        <div class="row justify-content-center">
                            <div class="col-12 bg-lightblue p-4">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <span class="text-title rocksalt">Thank you !</span></br>
                                        </div>
                                        <div class="row mt-3">
                                            <span class="invoice-p">Please check your inbox, as a confirmation email on its way.</span>
                                        </div>

                                        <div class="row">
                                            <div class="col-4 text-start">
                                                <span class="invoice-text">Order Total</span></br>
                                                <span class="invoice-text">Order Reference</span></br>
                                                <span class="invoice-text">Delivery</span></br>
                                            </div>
                                            <?php
                                            $to = $_SESSION["shipping"]["new_date"];

                                            $date = explode("-", $to);

                                            $month = str_split($date[1]);
                                            $new_month = "";

                                            for ($m = 0; $m < 3; $m++) {
                                                $new_month = $new_month . $month[$m];
                                            }

                                            $invoice_rs1 = Database::search("SELECT * FROM `checkout` WHERE `order_id`='" . $_SESSION["checkout"]["order_id"] . "'");
                                            $invoice_data1 = $invoice_rs1->fetch_assoc();
                                            if (isset($_SESSION["buy"]))

                                            ?>
                                            <div class="col-8 text-start">

                                                <span class="invoice-t2">Rs.<?php echo $invoice_data1["total"]; ?>.00</span></br>


                                                <span class="invoice-t2 text-black-50"><?php echo $_SESSION["checkout"]["order_id"]; ?></span></br>
                                                <span class="invoice-t2 text-black-50"><?php echo $date[2]; ?>, <?php echo $new_month; ?> <?php echo $date[3]; ?></span></br>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <?php

                            $invoice_rs = Database::search("SELECT *,invoice.qty AS iqty,invoice.total AS itotal FROM `invoice` INNER JOIN `product` ON product.id=invoice.product_id INNER JOIN `checkout` ON `checkout`.`order_id`=`invoice`.`checkout_order_id` INNER JOIN `product_image` ON `product_image`.`product_id`=`product`.`id` WHERE `checkout`.`user_email`='" . $_SESSION["u"]["email"] . "' AND `order_id`='" . $_SESSION["checkout"]["order_id"] . "'");
                            $invoice_num = $invoice_rs->num_rows;

                            ?>
                            <div class="col-12 mt-4 mb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="text-title"><?php echo ($invoice_num); ?> Item</span>
                                    </div>

                                    <?php
                                    for ($i = 0; $i < $invoice_num; $i++) {

                                        $invoice_data = $invoice_rs->fetch_assoc();

                                    ?>
                                        <div class="col-12">
                                            <div class="row mt-2 mb-2">
                                                <hr class="border-purple" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row align-items-center">
                                                <div class="invoice-img-container">
                                                    <img src="<?php echo $invoice_data["path"]; ?>" class="invoice-image" />
                                                </div>
                                                <div class="col-9">
                                                    <span class="mont">Rs.<?php echo ($invoice_data["price"]); ?> x <?php echo ($invoice_data["iqty"]); ?></span></br>
                                                    <span class="invoice-t2"><?php echo ($invoice_data["title"]); ?></span></br>
                                                    <span class="invoice-t2">QTY : <?php echo ($invoice_data["iqty"]); ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                    <div class="col-12">
                                        <div class="row mt-2 mb-2">
                                            <hr class="border-purple" />
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-center mt-3 mb-3">
                                    <div class="col-12 d-grid">
                                        <button class="btn-edit fw-normal cart-check-btn btn-invoice" onclick="window.location = 'home.php'"><span class="cartspanc">Coninue to shopping</span></button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-5 offset-lg-1 col-12 p-2">
                        <div class="row justify-content-center">

                            <div class="col-12 mt-3 mb-3">
                                <div class="row justify-content-center">
                                    <div class="col-3 d-grid">
                                        <button class="btn-edit btn-purple" onclick="invoicePrint();">
                                            <i class="bi bi-printer-fill"></i> &nbsp;
                                            Print
                                        </button>
                                    </div>
                                    <div class="col-5 d-grid">
                                        <button class="btn-edit btn-purple">
                                            <i class="bi bi-filetype-pdf"></i> &nbsp;
                                            Export as PDF
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <div class="row justify-content-center">
                                            <div class="container-social">
                                                <div class="social instagram"></div>
                                            </div>
                                            <div class="container-social">
                                                <div class="social facebook"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="advertisement-container border border-opacity-50  rounded">
                                <div class="advertisement-box">Advertisement here!</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="Js/script.js"></script>
</body>

</html>