<?php

session_start();

require "backend/connection.php";

if (isset($_SESSION["shipping"]["total"])) {

?>
    <!DOCTYPE html>

    <html>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CneX | Shipping</title>
        <link rel="icon" href="style/resources/cnex.png" />
        <link rel="stylesheet" href="style/bootstrap.css" />
        <link rel="stylesheet" href="style/style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php

                include "header.php";

                if (!isset($_SESSION["buy"]) && isset($_SESSION["u"])) {

                ?>

                    <div class="col-12 m140">
                        <div class="row justify-content-center gap-4">

                            <div class="col-lg-6 col-12 p-5 p-lg-0">
                                <div class="row">

                                    <div class="col-12 border border-opacity-50 mt-4 mb-4 rounded-3">

                                        <?php

                                        $cart_rs = Database::search("SELECT * FROM `cart` INNER JOIN `product` ON product.id=cart.product_id INNER JOIN `product_image` ON product.id=product_image.product_id WHERE cart.user_email='" . $_SESSION["u"]["email"] . "'");
                                        $cart_num = $cart_rs->num_rows;

                                        ?>
                                        <div class="row mt-3 mb-2">
                                            <div class="col-6 text-start">
                                                <span class="delius fw-semibold"><i class="bi bi-bag fs-5"></i>&nbsp; Quick Buy Itmes</span></br>
                                                <span class="cart-total delius">Total Rs <?php echo $_SESSION["shipping"]["total"]; ?>.00</span>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button class="btn-purple-v2" onclick="window.location='cart.php';">Edit</button>
                                            </div>
                                            <?php
                                            $to = $_SESSION["shipping"]["new_date"];

                                            $date = explode("-", $to);

                                            $month = str_split($date[1]);
                                            $new_month = "";

                                            for ($m = 0; $m < 3; $m++) {
                                                $new_month = $new_month . $month[$m];
                                            }

                                            ?>
                                            <div class="col-12 text-start mt-4">
                                                <span class="text-success fw-semibold arrive-text">Arrives before <?php echo $date[2]; ?>, <?php echo $new_month; ?> <?php echo $date[3]; ?></span></br>
                                                <?php
                                                for ($c = 0; $c < $cart_num; $c++) {
                                                    $cart_data = $cart_rs->fetch_assoc();
                                                ?>
                                                    <img src="<?php echo $cart_data["path"]; ?>" class="img-cart" />
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <?php
                                            $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                                            $address_num = $address_rs->num_rows;

                                            $city_rs = Database::search("SELECT * FROM `city`");
                                            $district_rs = Database::search("SELECT * FROM `district`");
                                            $province_rs = Database::search("SELECT * FROM `province`");

                                            $city_num = $city_rs->num_rows;
                                            $district_num = $district_rs->num_rows;
                                            $province_num = $province_rs->num_rows;

                                            ?>
                                            <div class="col-12">
                                                <div class="row mt-2 mb-2">
                                                    <hr class="border-purple" />
                                                </div>
                                            </div>

                                            <div class="col-12 p-3 mt-2 rounded-3">
                                                <div class="row">
                                                    <div class="col-6 text-start">
                                                        <span class="delius fw-semibold"><i class="bi bi-truck fs-5"></i>&nbsp; Address</span>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button class="btn-purple-v2" onclick="window.location='userProfile.php';">Edit</button>
                                                    </div>
                                                    <!-- signInShipping -->
                                                    <div class="col-12">
                                                        <div class="row justify-content-center">

                                                            <?php

                                                            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["u"]["email"] . "'");
                                                            $user_data = $user_rs->fetch_assoc();
                                                            ?>

                                                            <div class="col-12 p-4">
                                                                <div class="row">

                                                                    <div class="col-12 mt-2 mb-2">
                                                                        <label class="form-label">Name*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="shipping-name" value="<?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?>" id="s_name" />
                                                                    </div>

                                                                    <?php
                                                                    if ($address_num == 1) {

                                                                        $address_data = $address_rs->fetch_assoc();

                                                                        $user_address_rs = Database::search("SELECT city.id AS cid,district.id AS did,province.id AS pid FROM `city` INNER JOIN `district` ON city.district_id=district.id INNER JOIN `province` ON district.province_id=province.id WHERE city.id ='" . $address_data["city_id"] . "'; ");
                                                                        $user_address_data = $user_address_rs->fetch_assoc();

                                                                    ?>
                                                                        <div class="col-12 mt-2 mb-2">
                                                                            <label class="form-label">Street*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" value="<?php echo ($address_data["line1"]); ?>" id="s_line1" />
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">City*</label>
                                                                            <select class="form-select form-select-shipping" id="s_city">
                                                                                <option value="0">City</option>
                                                                                <?php
                                                                                for ($cd = 0; $cd < $city_num; $cd++) {
                                                                                    $city_data = $city_rs->fetch_assoc();
                                                                                ?>
                                                                                    <option value="<?php echo ($city_data["id"]); ?>" <?php
                                                                                                                                        if ($user_address_data["cid"] == $city_data["id"]) {
                                                                                                                                        ?> selected <?php
                                                                                                                                                }
                                                                                                                                                    ?>><?php echo ($city_data["cname"]); ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">District</label>
                                                                            <select class="form-select form-select-shipping">
                                                                                <option value="0">District</option>
                                                                                <?php
                                                                                for ($dd = 0; $dd < $district_num; $dd++) {
                                                                                    $district_data = $district_rs->fetch_assoc();
                                                                                ?>
                                                                                    <option value="<?php echo ($district_data["id"]); ?>" <?php
                                                                                                                                            if ($user_address_data["did"] == $district_data["id"]) {
                                                                                                                                            ?> selected <?php
                                                                                                                                                    }
                                                                                                                                                        ?>><?php echo ($district_data["dname"]); ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">Province</label>
                                                                            <select class="form-select form-select-shipping">
                                                                                <option value="0">Province</option>
                                                                                <?php
                                                                                for ($pd = 0; $pd < $province_num; $pd++) {
                                                                                    $province_data = $province_rs->fetch_assoc();
                                                                                ?>
                                                                                    <option value="<?php echo ($province_data["id"]); ?>" <?php
                                                                                                                                            if ($user_address_data["pid"] == $province_data["id"]) {
                                                                                                                                            ?> selected <?php
                                                                                                                                                    }
                                                                                                                                                        ?>><?php echo ($province_data["pname"]); ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">Postal Code*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="postal-code" value="<?php echo ($address_data["postal"]); ?>" id="s_postal" />
                                                                        </div>
                                                                        <div class="col-12 mt-2 mb-2">
                                                                            <label class="form-label">Phone*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="phone-number" value="<?php echo ($user_data["mobile"]); ?>" id="s_mobile" />
                                                                        </div>
                                                                        <div class="col-3 d-grid">
                                                                            <button class="btn-edit btn-purple-v2 mt-4 mb-3" onclick="ShippingAddressChange();">Save</button>
                                                                        </div>
                                                                        <div class="col-3 d-grid">
                                                                            <button class="btn-edit btn-purple btn-not-colored mt-4 mb-3" onclick="window.location.reload();">Discard</button>
                                                                        </div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="col-12 mt-2 mb-2">
                                                                            <label class="form-label">Street*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" />
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">City*</label>
                                                                            <select class="form-select form-select-shipping">
                                                                                <option value="0">City</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">District</label>
                                                                            <select class="form-select form-select-shipping">
                                                                                <option value="0">District</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">Province</label>
                                                                            <select class="form-select form-select-shipping">
                                                                                <option value="0">Province</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mt-2 mb-2">
                                                                            <label class="form-label">Postal Code*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="postal-code" />
                                                                        </div>
                                                                        <div class="col-12 mt-2 mb-2">
                                                                            <label class="form-label">Phone*</label>
                                                                            <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="phone-number" />
                                                                        </div>
                                                                        <div class="col-3 d-grid">
                                                                            <button class="btn-edit btn-purple-v2 mt-4 mb-3" onclick="ShippingAddressChange();">Save</button>
                                                                        </div>
                                                                        <div class="col-3 d-grid">
                                                                            <button class="btn-edit btn-purple btn-not-colored mt-4 mb-3" onclick="window.location.reload();">Discard</button>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- guestShipping -->
                                                </div>


                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="row">
                                    <div class="col-12 bg-lightblue p-3 mt-4 mb-4 rounded-3">
                                        <div class="row">
                                            <div class="col-12 text-start">
                                                <span class="delius fw-semibold"><i class="bi bi-credit-card fs-5"></i>&nbsp;PAYMENT</span></br>
                                                <span class="mt-2 mb-2 mont">All transactions are secure and encrypted.</span>
                                                <div class="row justify-content-start mt-2">
                                                    <div class="img-container-p">
                                                        <div class="img-payment img-payment-1"></div>
                                                    </div>
                                                    <div class="img-container-p">
                                                        <div class="img-payment img-payment-2"></div>
                                                    </div>
                                                    <div class="img-container-p">
                                                        <div class="img-payment img-payment-3"></div>
                                                    </div>
                                                    <div class="img-container-p">
                                                        <div class="img-payment img-payment-4"></div>
                                                    </div>
                                                    <div class="img-container-p">
                                                        <div class="img-payment img-payment-5"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row mt-2 mb-2">
                                                    <hr class="border-purple" />
                                                </div>
                                            </div>
                                            <div class="col-12 mb-4">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="text" placeholder="Gift card or discount code" class="form-control control-edit contorl-edit-payment" style="height: 40px; border-radius: 0px;" />
                                                    </div>
                                                    <div class="col-4 d-grid">
                                                        <button class="btn-edit btn-purple btn-not-colored btn-colored-on
                                                ">Apply</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row mt-2 mb-2">
                                                    <hr class="border-purple" />
                                                </div>
                                            </div>
                                            <?php
                                            $address_rs1 = Database::search("SELECT *,district.id AS did FROM `user_has_address` INNER JOIN `city` ON `user_has_address`.`city_id`=city.id INNER JOIN `district` ON district.id=city.district_id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                                            $address_num1 = $address_rs1->num_rows;

                                            $d_fee;
                                            ?>
                                            <div class="col-12 mb-2">
                                                <div class="row">
                                                    <div class="col-6 text-start">
                                                        <span class="shipping-t-1">subtotal</span></br>
                                                        <span class="shipping-t-1">shipping</span></br>
                                                        <span class="shipping-t-1">taxes</span>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <span class="shipping-text">Rs. <?php echo $_SESSION["shipping"]["total"]; ?></span></br>

                                                        <?php

                                                        $text;

                                                        if ($cart_num == 1) {

                                                            if ($address_num1 == 1) {

                                                                $address_data1 = $address_rs1->fetch_assoc();

                                                                if ($address_data1["did"] == 1) {
                                                                    if ($cart_data["delivery_fee_badulla"] == "Free") {
                                                                        $text = "Free";
                                                                        $d_fee = 0;
                                                                    } else {
                                                                        $text = $cart_data["delivery_fee_badulla"];
                                                                        $d_fee = $cart_data["delivery_fee_badulla"];
                                                                    }
                                                                } else {
                                                                    if ($cart_data["delivery_fee_other"] == "Free") {
                                                                        $text = "Free";
                                                                        $d_fee = 0;
                                                                    } else {
                                                                        $text = $cart_data["delivery_fee_other"];
                                                                        $d_fee = $cart_data["delivery_fee_other"];
                                                                    }
                                                                }
                                                        ?>

                                                                <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>

                                                            <?php
                                                            } else {
                                                                if ($cart_data["delivery_fee_other"] == "Free") {
                                                                    $text = "Free";
                                                                    $d_fee = 0;
                                                                } else {
                                                                    $text = $cart_data["delivery_fee_other"];
                                                                    $d_fee = $cart_data["delivery_fee_other"];
                                                                }
                                                            ?>

                                                                <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>

                                                            <?php
                                                            }
                                                        } else {
                                                            if ($cart_data["delivery_fee_other"] == "Free") {
                                                                $text = "Free";
                                                                $d_fee = 0;
                                                            } else {
                                                                $text = $cart_data["delivery_fee_other"];
                                                                $d_fee = $cart_data["delivery_fee_other"];
                                                            }
                                                            ?>
                                                            <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>
                                                        <?php
                                                        }
                                                        ?>

                                                        <span class="shipping-text">Rs. 0</span>

                                                    </div>
                                                </div>
                                                <?php
                                                $total = $_SESSION["shipping"]["total"];
                                                $new_total = $total + $d_fee;
                                                ?>
                                                <div class="col-12">
                                                    <div class="row mt-2 mb-2">
                                                        <hr class="border-purple" />
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <div class="row">
                                                        <div class="col-6 text-start">
                                                            <span class="total-shipping delius">Total</span></br>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <span>Rs</span>
                                                            <span class="shipping_total"><?php echo $new_total ?>.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2 mb-2 d-grid">
                                                    <button class="btn-edit btn-purple-v2 fw-normal cart-check-btn" id="shipping_pay" onclick="payProducts(<?php echo $new_total ?>);"><span class="cartspanc">Pay Now</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {

                    if (isset($_SESSION["buy"])) {


                    ?>
                        <div class="col-12 m140">
                            <div class="row justify-content-center gap-4">
                                <div class="col-lg-6 col-12 p-5 p-lg-0">
                                    <div class="row">

                                        <div class="col-12 border border-opacity-50 mt-4 mb-4 rounded-3">

                                            <?php

                                            $cart_rs = Database::search("SELECT * FROM  `product` INNER JOIN `product_image` ON product.id=product_image.product_id WHERE product.id='" . $_SESSION["buy"]["id"] . "'");
                                            $cart_num = $cart_rs->num_rows;

                                            ?>

                                            <div class="row mt-3 mb-2">
                                                <div class="col-12 text-start">
                                                    <span class="delius fw-semibold"><i class="bi bi-bag fs-5"></i>&nbsp; Quick Buy Itmes</span></br>
                                                    <span class="cart-total delius">Total Rs <?php echo $_SESSION["buy"]["total"]; ?>.00</span>
                                                </div>
                                                <?php
                                                $to = $_SESSION["shipping"]["new_date"];

                                                $date = explode("-", $to);

                                                $month = str_split($date[1]);
                                                $new_month = "";

                                                for ($m = 0; $m < 3; $m++) {
                                                    $new_month = $new_month . $month[$m];
                                                }

                                                ?>
                                                <div class="col-12 text-start mt-4">
                                                    <div class="row align-items-center">
                                                        <div class="col-12">
                                                            <span class="text-success fw-semibold arrive-text">Arrives before <?php echo $date[2]; ?>, <?php echo $new_month; ?> <?php echo $date[3]; ?></span>
                                                        </div>
                                                        <div class="col-2">
                                                            <?php
                                                            for ($c = 0; $c < $cart_num; $c++) {
                                                                $cart_data = $cart_rs->fetch_assoc();
                                                            ?>
                                                                <img src="<?php echo $cart_data["path"]; ?>" class="img-cart" />
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-8">
                                                            <span class="delius"><?php echo $cart_data["title"] ?></span>
                                                            <?php
                                                            if (isset($_SESSION["buy"]["sizeid"])) {
                                                                $siz_rs = Database::search("SELECT * FROM `size` WHERE `id`='".$_SESSION["buy"]["sizeid"]."'");
                                                                $siz_data = $siz_rs->fetch_assoc();
                                                                $size = $siz_data["name"];
                                                            ?>
                                                                <span class="inter fw-semibold shipping-size">(<?php echo $size; ?>)</span>
                                                            <?php
                                                            }
                                                            ?>
                                                            </br><span class="delius">Rs.<?php echo $cart_data["price"] ?> x <?php echo $_SESSION["buy"]["qty"]; ?></span></br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <?php

                                                $city_rs = Database::search("SELECT * FROM `city`");
                                                $district_rs = Database::search("SELECT * FROM `district`");
                                                $province_rs = Database::search("SELECT * FROM `province`");

                                                $city_rs1 = Database::search("SELECT * FROM `city`");
                                                $district_rs1 = Database::search("SELECT * FROM `district`");
                                                $province_rs1 = Database::search("SELECT * FROM `province`");

                                                $city_num = $city_rs->num_rows;
                                                $district_num = $district_rs->num_rows;
                                                $province_num = $province_rs->num_rows;

                                                ?>
                                                <div class="col-12">
                                                    <div class="row mt-2 mb-2">
                                                        <hr class="border-purple" />
                                                    </div>
                                                </div>

                                                <div class="col-12 p-3 mt-2 mb-4 rounded-3">
                                                    <div class="row">
                                                        <div class="col-6 text-start">
                                                            <span class="delius fw-semibold"><i class="bi bi-truck fs-5"></i>&nbsp; Address</span>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <button class="btn-purple-v2" onclick="window.location='userProfile.php';">Edit</button>
                                                        </div>
                                                        <!-- signInShipping -->
                                                        <div class="col-12">
                                                            <div class="row justify-content-center">

                                                                <?php
                                                                if (isset($_SESSION["u"])) {

                                                                    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                                    $address_num = $address_rs->num_rows;

                                                                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["u"]["email"] . "'");
                                                                    $user_data = $user_rs->fetch_assoc();
                                                                ?>

                                                                    <div class="col-12 p-4">
                                                                        <div class="row">

                                                                            <div class="col-12 mt-2 mb-2">
                                                                                <label class="form-label">Name*</label>
                                                                                <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="shipping-name" value="<?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?>" id="s_name" />
                                                                            </div>

                                                                            <?php
                                                                            if ($address_num == 1) {

                                                                                $address_data = $address_rs->fetch_assoc();

                                                                                $user_address_rs = Database::search("SELECT city.id AS cid,district.id AS did,province.id AS pid FROM `city` INNER JOIN `district` ON city.district_id=district.id INNER JOIN `province` ON district.province_id=province.id WHERE city.id ='" . $address_data["city_id"] . "'; ");
                                                                                $user_address_data = $user_address_rs->fetch_assoc();

                                                                            ?>
                                                                                <div class="col-12 mt-2 mb-2">
                                                                                    <label class="form-label">Street*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" value="<?php echo ($address_data["line1"]); ?>" id="s_line1" />
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">City*</label>
                                                                                    <select class="form-select form-select-shipping" id="s_city">
                                                                                        <option value="0">City</option>
                                                                                        <?php
                                                                                        for ($cd = 0; $cd < $city_num; $cd++) {
                                                                                            $city_data = $city_rs->fetch_assoc();
                                                                                        ?>
                                                                                            <option value="<?php echo ($city_data["id"]); ?>" <?php if ($user_address_data["cid"] == $city_data["id"]) { ?> selected <?php } ?>><?php echo ($city_data["cname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">District</label>
                                                                                    <select class="form-select form-select-shipping">
                                                                                        <option value="0">District</option>
                                                                                        <?php
                                                                                        for ($dd = 0; $dd < $district_num; $dd++) {
                                                                                            $district_data = $district_rs->fetch_assoc();
                                                                                        ?>
                                                                                            <option value="<?php echo ($district_data["id"]); ?>" <?php if ($user_address_data["did"] == $district_data["id"]) { ?> selected <?php } ?>><?php echo ($district_data["dname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">Province</label>
                                                                                    <select class="form-select form-select-shipping">
                                                                                        <option value="0">Province</option>
                                                                                        <?php
                                                                                        for ($pd = 0; $pd < $province_num; $pd++) {
                                                                                            $province_data = $province_rs->fetch_assoc();
                                                                                        ?>
                                                                                            <option value="<?php echo ($province_data["id"]); ?>" <?php if ($user_address_data["pid"] == $province_data["id"]) { ?> selected <?php } ?>><?php echo ($province_data["pname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">Postal Code*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="postal-code" value="<?php echo ($address_data["postal"]); ?>" id="s_postal" />
                                                                                </div>
                                                                                <div class="col-12 mt-2 mb-2">
                                                                                    <label class="form-label">Phone*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="phone-number" value="<?php echo ($user_data["mobile"]); ?>" id="s_mobile" />
                                                                                </div>
                                                                                <div class="col-3 d-grid">
                                                                                    <button class="btn-edit btn-purple-v2 mt-4 mb-3" onclick="ShippingAddressChange();">Save</button>
                                                                                </div>
                                                                                <div class="col-3 d-grid">
                                                                                    <button class="btn-edit btn-purple btn-not-colored mt-4 mb-3" onclick="window.location.reload();">Discard</button>
                                                                                </div>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <div class="col-12 mt-2 mb-2">
                                                                                    <label class="form-label">Street*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" id="s_line1" />
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">City*</label>
                                                                                    <select class="form-select form-select-shipping" id="s_city">
                                                                                        <option value="0">City</option>
                                                                                        <?php
                                                                                        for ($cd = 0; $cd < $city_num; $cd++) {
                                                                                            $city_data = $city_rs1->fetch_assoc();
                                                                                        ?>
                                                                                            <option><?php echo ($city_data["cname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">District</label>
                                                                                    <select class="form-select form-select-shipping">
                                                                                        <option value="0">District</option>
                                                                                        <?php
                                                                                        for ($dd = 0; $dd < $district_num; $dd++) {
                                                                                            $district_data = $district_rs1->fetch_assoc();
                                                                                        ?>
                                                                                            <option><?php echo ($district_data["dname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">Province</label>
                                                                                    <select class="form-select form-select-shipping">
                                                                                        <option value="0">Province</option>
                                                                                        <?php
                                                                                        for ($pd = 0; $pd < $province_num; $pd++) {
                                                                                            $province_data = $province_rs1->fetch_assoc();
                                                                                        ?>
                                                                                            <option><?php echo ($province_data["pname"]); ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6 mt-2 mb-2">
                                                                                    <label class="form-label">Postal Code*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="postal-code" id="s_postal" />
                                                                                </div>
                                                                                <div class="col-12 mt-2 mb-2">
                                                                                    <label class="form-label">Phone*</label>
                                                                                    <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="phone-number" value="<?php echo ($user_data["mobile"]); ?>" id="s_mobile" />
                                                                                </div>
                                                                                <div class="col-3 d-grid">
                                                                                    <button class="btn-edit btn-purple-v2 mt-4 mb-3" onclick="ShippingAddressChange();">Save</button>
                                                                                </div>
                                                                                <div class="col-3 d-grid">
                                                                                    <button class="btn-edit btn-purple btn-not-colored mt-4 mb-3" onclick="window.location.reload();">Discard</button>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="col-12 mt-2 mb-2">
                                                                        <label class="form-label">Email*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" id="email_s" />
                                                                    </div>
                                                                    <div class="col-12 mt-2 mb-2">
                                                                        <label class="form-label">Name*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="shipping-name" id="s_name" />
                                                                    </div>
                                                                    <div class="col-12 mt-2 mb-2">
                                                                        <label class="form-label">Street*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="street-name" id="s_line1" />
                                                                    </div>
                                                                    <div class="col-6 mt-2 mb-2">
                                                                        <label class="form-label">City*</label>
                                                                        <select class="form-select form-select-shipping" id="s_city">
                                                                            <option value="0">City</option>
                                                                            <?php
                                                                            for ($cd = 0; $cd < $city_num; $cd++) {
                                                                                $city_data = $city_rs1->fetch_assoc();
                                                                            ?>
                                                                                <option><?php echo ($city_data["cname"]); ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6 mt-2 mb-2">
                                                                        <label class="form-label">District</label>
                                                                        <select class="form-select form-select-shipping">
                                                                            <option value="0">District</option>
                                                                            <?php
                                                                            for ($dd = 0; $dd < $district_num; $dd++) {
                                                                                $district_data = $district_rs1->fetch_assoc();
                                                                            ?>
                                                                                <option><?php echo ($district_data["dname"]); ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6 mt-2 mb-2">
                                                                        <label class="form-label">Province</label>
                                                                        <select class="form-select form-select-shipping">
                                                                            <option value="0">Province</option>
                                                                            <?php
                                                                            for ($pd = 0; $pd < $province_num; $pd++) {
                                                                                $province_data = $province_rs1->fetch_assoc();
                                                                            ?>
                                                                                <option><?php echo ($province_data["pname"]); ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6 mt-2 mb-2">
                                                                        <label class="form-label">Postal Code*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="postal-code" id="s_postal" />
                                                                    </div>
                                                                    <div class="col-12 mt-2 mb-2">
                                                                        <label class="form-label">Phone*</label>
                                                                        <input type="text" class="form-control control-edit contorl-edit-shipping" aria-label="phone-number" id="s_mobile" />
                                                                    </div>
                                                                    <div class="col-3 d-grid">
                                                                        <button class="btn-edit btn-purple-v2 mt-4 mb-3" onclick="ShippingAddressChange();">Save</button>
                                                                    </div>
                                                                    <div class="col-3 d-grid">
                                                                        <button class="btn-edit btn-purple btn-not-colored mt-4 mb-3" onclick="window.location.reload();">Discard</button>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <!-- guestShipping -->
                                                    </div>


                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-12">
                                    <div class="row">
                                        <div class="col-12 bg-lightblue p-3 mt-4 mb-4 rounded-3">
                                            <div class="row">
                                                <div class="col-12 text-start">
                                                    <span class="delius fw-semibold"><i class="bi bi-credit-card fs-5"></i>&nbsp;PAYMENT</span></br>
                                                    <span class="mt-2 mb-2 mont">All transactions are secure and encrypted.</span>
                                                    <div class="row justify-content-start mt-2">
                                                        <div class="img-container-p">
                                                            <div class="img-payment img-payment-1"></div>
                                                        </div>
                                                        <div class="img-container-p">
                                                            <div class="img-payment img-payment-2"></div>
                                                        </div>
                                                        <div class="img-container-p">
                                                            <div class="img-payment img-payment-3"></div>
                                                        </div>
                                                        <div class="img-container-p">
                                                            <div class="img-payment img-payment-4"></div>
                                                        </div>
                                                        <div class="img-container-p">
                                                            <div class="img-payment img-payment-5"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row mt-2 mb-2">
                                                        <hr class="border-purple" />
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <input type="text" placeholder="Gift card or discount code" class="form-control control-edit contorl-edit-payment" style="height: 40px; border-radius: 0px;" />
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn-edit btn-purple btn-not-colored btn-colored-on">Apply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row mt-2 mb-2">
                                                        <hr class="border-purple" />
                                                    </div>
                                                </div>
                                                <?php

                                                if (isset($_SESSION["u"])) {
                                                    $address_rs1 = Database::search("SELECT *,district.id AS did FROM `user_has_address` INNER JOIN `city` ON `user_has_address`.`city_id`=city.id INNER JOIN `district` ON district.id=city.district_id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                    $address_num1 = $address_rs1->num_rows;

                                                    $d_fee;
                                                ?>
                                                    <div class="col-12 mb-2">
                                                        <div class="row">
                                                            <div class="col-6 text-start">
                                                                <span class="shipping-t-1">subtotal</span></br>
                                                                <span class="shipping-t-1">shipping</span></br>
                                                                <span class="shipping-t-1">taxes</span>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <span class="shipping-text">Rs. <?php echo $_SESSION["buy"]["total"]; ?></span></br>

                                                                <?php

                                                                $text;

                                                                if ($cart_num == 1) {

                                                                    if ($address_num1 == 1) {

                                                                        $address_data1 = $address_rs1->fetch_assoc();

                                                                        if ($address_data1["did"] == 1) {
                                                                            if ($cart_data["delivery_fee_badulla"] == "Free") {
                                                                                $text = "Free";
                                                                                $d_fee = 0;
                                                                            } else {
                                                                                $text = $cart_data["delivery_fee_badulla"];
                                                                                $d_fee = $cart_data["delivery_fee_badulla"];
                                                                            }
                                                                        } else {
                                                                            if ($cart_data["delivery_fee_other"] == "Free") {
                                                                                $text = "Free";
                                                                                $d_fee = 0;
                                                                            } else {
                                                                                $text = $cart_data["delivery_fee_other"];
                                                                                $d_fee = $cart_data["delivery_fee_other"];
                                                                            }
                                                                        }
                                                                ?>

                                                                        <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>

                                                                    <?php
                                                                    } else {
                                                                        if ($cart_data["delivery_fee_other"] == "Free") {
                                                                            $text = "Free";
                                                                            $d_fee = 0;
                                                                        } else {
                                                                            $text = $cart_data["delivery_fee_other"];
                                                                            $d_fee = $cart_data["delivery_fee_other"];
                                                                        }
                                                                    ?>

                                                                        <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>

                                                                    <?php
                                                                    }
                                                                } else {
                                                                    if ($cart_data["delivery_fee_other"] == "Free") {
                                                                        $text = "Free";
                                                                        $d_fee = 0;
                                                                    } else {
                                                                        $text = $cart_data["delivery_fee_other"];
                                                                        $d_fee = $cart_data["delivery_fee_other"];
                                                                    }
                                                                    ?>
                                                                    <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>
                                                                <?php
                                                                }
                                                                ?>

                                                                <span class="shipping-text">Rs. 0</span>

                                                            </div>
                                                        </div>
                                                        <?php
                                                        $total = $_SESSION["shipping"]["total"];
                                                        $new_total = $total + $d_fee;
                                                        ?>
                                                        <div class="col-12">
                                                            <div class="row mt-2 mb-2">
                                                                <hr class="border-purple" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <div class="row">
                                                                <div class="col-6 text-start">
                                                                    <span class="total-shipping delius">Total</span></br>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <span>Rs</span>
                                                                    <span class="shipping_total"><?php echo $new_total ?>.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2 mb-2 d-grid">
                                                            <button class="btn-edit btn-purple-v2 fw-normal cart-check-btn" id="shipping_pay" onclick="payProducts(<?php echo $new_total ?>);"><span class="cartspanc">Pay Now</span></button>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-12 mb-2">
                                                        <div class="row">
                                                            <div class="col-6 text-start">
                                                                <span class="shipping-t-1">subtotal</span></br>
                                                                <span class="shipping-t-1">shipping</span></br>
                                                                <span class="shipping-t-1">taxes</span>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <span class="shipping-text">Rs. <?php echo $_SESSION["buy"]["total"]; ?></span></br>

                                                                <?php

                                                                $text;

                                                                if ($cart_data["delivery_fee_other"] == "Free") {
                                                                    $text = "Free";
                                                                    $d_fee = 0;
                                                                } else {
                                                                    $text = $cart_data["delivery_fee_other"];
                                                                    $d_fee = $cart_data["delivery_fee_other"];
                                                                }

                                                                ?>

                                                                <span class="text-edit text-success fw-semibold shipping-text"><?php echo $text; ?></span></br>

                                                                <span class="shipping-text">Rs. 0</span>

                                                            </div>
                                                        </div>
                                                        <?php
                                                        $total = $_SESSION["shipping"]["total"];
                                                        $new_total = $total + $d_fee;
                                                        ?>
                                                        <div class="col-12">
                                                            <div class="row mt-2 mb-2">
                                                                <hr class="border-purple" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <div class="row">
                                                                <div class="col-6 text-start">
                                                                    <span class="total-shipping delius">Total</span></br>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <span>Rs</span>
                                                                    <span class="shipping_total"><?php echo $new_total ?>.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2 mb-2 d-grid">
                                                            <button class="btn-edit btn-purple-v2 fw-normal cart-check-btn" id="shipping_pay" onclick="payProducts(<?php echo $new_total ?>);"><span class="cartspanc">Pay Now</span></button>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>

            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            <script src="Js/script.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:cart.php");
}
?>