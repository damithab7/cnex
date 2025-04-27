<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="style/resources/cnex.png" />
    <title>CneX | Products</title>
    <link rel="stylesheet" href="style/bootstrap.css" />
    <link rel="stylesheet" href="style/style.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php

            include "header.php";

            $pageno;

            if (isset($_GET["page"])) {
                $pageno = $_GET["page"];
            } else {
                $pageno = 1;
            }

            $category_rs = Database::search("SELECT * FROM `category`");

            ?>
            <div class="col-12 text-center pt-3 mb-3 m140">
                <span class="fs-1 delius">Products</span>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">

                    <div class="col-lg-5 col-md-8 col-8 mt-3 mb-3">
                        <div class="input-group productSearch">
                            <i class="bi bi-search input-g-item"></i>
                            <input type="text" class="form-control control-edit input-edit-pv input-products" placeholder="Search Products..." aria-label="Search products" aria-describedby="searchProduct" oninput="productSearch();" id="productSearch" />
                            <button class="btn-purple-v2" style="font-size: 13px;"><div class="search-plus"></div></button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="row justify-content-center gap-3 py-5">

                    <div class="col-lg-2 col-11 mb-3">
                        <div class="row justify-content-center bg-lightblue gap-1 pt-3 rounded">
                            <div class="col-7 text-start">
                                <span class="mont fs-3">Filter</span>
                            </div>
                            <div class="col-4 text-end">
                                <i class="bi bi-funnel fs-3"></i>
                            </div>

                            <hr />

                            <div class="col-12">
                                <label class="form-label fw-semibold">Sort Products</label>
                                <select class="form-select ViewSelect" id="sortProductView" onchange="sortPData();" size="4" multiple>
                                    <option value="0">None</option>
                                    <option value="1">Date</option>
                                    <option value="2">A-Z</option>
                                    <option value="3">Price</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-11 mb-3">
                        <div class="row rounded" id="showAllHere">
                            <div class="col-12">
                                <div class="row justify-content-center gap-3 pt-3 ">

                                    <?php

                                    $query;

                                    if (isset($_GET["cid"])) {

                                        $cid = $_GET["cid"];

                                        if ($cid == 0) {
                                            $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'");

                                            $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'";
                                        } else {
                                            $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1' AND category.id='" . $cid . "'");

                                            $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1' AND category.id='" . $cid . "'";
                                        }
                                    } else {
                                        $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'");

                                        $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'";
                                    }

                                    $product_num = $products_rs->num_rows;

                                    $pageno;

                                    $results_per_page = 12;

                                    $page_results = ($pageno - 1) * $results_per_page;

                                    $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

                                    $selected_num = $selected_rs->num_rows;

                                    $number_of_pages = ceil($product_num / $results_per_page);

                                    if ($selected_num == 0) {

                                    ?>

                                        <div class="col-12 mt-4">
                                            <div class="row align-items-center">
                                                <div class="col-12 searchIco"></div>
                                                <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-5 mt-4">
                                                    <button class="btn-purple fs-5">NO RESULTS</button>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                    } else {

                                        for ($p = 0; $p < $selected_num; $p++) {

                                            $product_data = $selected_rs->fetch_assoc();

                                            if (isset($_SESSION["u"])) {

                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND `product_id`='" . $product_data["pid"] . "'");
                                                $watchlist_num = $watchlist_rs->num_rows;

                                        ?>

                                                <div class="card card-home-height card-product">

                                                    <div class="card-img-container">
                                                        <img src="<?php echo ($product_data["path"]); ?>" alt="<?php echo ($product_data["name"]); ?>" class="card-image" />
                                                    </div>

                                                    <?php
                                                    if ($product_data["stid"] == 2) {
                                                    ?>

                                                    <?php
                                                    } else if ($product_data["stid"] == 3) {
                                                    ?>
                                                        <span class="card-tags card-tags-blue"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 4) {
                                                    ?>
                                                        <span class="card-tags card-tags-purple"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 5) {
                                                    ?>
                                                        <span class="card-tags card-tags-orange"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 6) {
                                                    ?>
                                                        <span class="card-tags card-tags-red"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    }
                                                    ?>

                                                    <div class="card-body card-intro card-intro-home" onclick="window.location='singleProductView.php?id=<?php echo ($product_data['pid']); ?>';">

                                                    </div>
                                                    <div class="col-12 card-button-intro">
                                                        <div class="row justify-content-center g-2 p-4">
                                                            <?php
                                                            if ($watchlist_num == 1) {
                                                            ?>
                                                                <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="addToWishlist(<?php echo $product_data['pid']; ?>);"><i class="bi bi-heart-fill" id="watchlist_heart<?php echo $product_data['pid']; ?>"></i></button>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="addToWishlist(<?php echo $product_data['pid']; ?>);"><i class="bi bi-heart" id="watchlist_heart<?php echo $product_data['pid']; ?>"></i></button>
                                                            <?php
                                                            }
                                                            ?>
                                                            <button class="btn-edit btn-purple btn-cart-edit btn-product-card btn-home-card" onclick="addToCart(<?php echo $product_data['pid']; ?>);">Add to cart &nbsp;<i class="bi bi-cart"></i> </button>
                                                            <button class="btn-edit btn-purple btn-card btn-selected btn-product-card btn-home-card" onclick="showBuyModal(<?php echo $product_data['pid']; ?>);">Buy Now</button>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer card-footer-edit">
                                                        <h5 class="card-title-edit"><?php echo ($product_data["title"]); ?> - Rs. <span class="fw-semibold delius"><?php echo ($product_data["price"]); ?></span></h5>
                                                    </div>

                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="card card-home-height card-product">

                                                    <div class="card-img-container">
                                                        <img src="<?php echo ($product_data["path"]); ?>" alt="<?php echo ($product_data["name"]); ?>" class="card-image" />
                                                    </div>

                                                    <?php
                                                    if ($product_data["stid"] == 2) {
                                                    ?>

                                                    <?php
                                                    } else if ($product_data["stid"] == 3) {
                                                    ?>
                                                        <span class="card-tags card-tags-blue"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 4) {
                                                    ?>
                                                        <span class="card-tags card-tags-purple"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 5) {
                                                    ?>
                                                        <span class="card-tags card-tags-orange"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    } else if ($product_data["stid"] == 6) {
                                                    ?>
                                                        <span class="card-tags card-tags-red"><?php echo ($product_data["sname"]); ?></span>
                                                    <?php
                                                    }
                                                    ?>

                                                    <div class="card-body card-intro card-intro-home" onclick="window.location='singleProductView.php?id=<?php echo ($product_data['pid']); ?>';">

                                                    </div>

                                                    <div class="col-12 card-button-intro">
                                                        <div class="row justify-content-center g-2 p-4">

                                                            <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="window.location='wishlist.php';"><i class="bi bi-heart"></i></button>

                                                            <button class="btn-edit btn-purple btn-product-card btn-cart-edit btn-home-card" onclick="toProductView(<?php echo $product_data['pid']; ?>);">Add to cart &nbsp;<i class="bi bi-cart"></i> </button>
                                                            <button class="btn-edit btn-purple btn-card btn-selected btn-product-card btn-home-card" onclick="showBuyModal(<?php echo $product_data['pid']; ?>);">Buy Now</button>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer card-footer-edit">
                                                        <h5 class="card-title-edit"><?php echo ($product_data["title"]); ?> - Rs. <span class="fw-semibold delius"><?php echo ($product_data["price"]); ?></span></h5>
                                                    </div>

                                                </div>

                                            <?php
                                            }
                                            ?>

                                            <div class="modal fade modal-index" id="buyModal<?php echo $product_data['pid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-width">
                                                    <div class="modal-content modal-content-spw">

                                                        <div class="modal-header m-header-edit justify-content-between align-items-center">
                                                            <h1 class="modal-title fs-4 delius" id="orderModalLabel">Product Order</h1>
                                                            <button type="button" class="btn-edit btn-spw-close" data-bs-dismiss="modal"> <i class="bi bi-x-lg"></i></button>
                                                        </div>

                                                        <?php

                                                        $images_rs1 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $product_data["pid"] . "'");

                                                        $images_num1 = $images_rs1->num_rows;

                                                        $img1 = array();

                                                        ?>

                                                        <div class="modal-body modal-body-spw">
                                                            <div class="col-12">
                                                                <div class="row justify-content-center">

                                                                    <div class="col-lg-3 col-12 mt-3">
                                                                        <div class="img-container-cart image-container-spw mb-3">
                                                                            <img src="<?php echo ($product_data["path"]); ?>" class="img-edit-spw user-select-none" alt="<?php echo ($product_data["title"]); ?>" id="mainImageSpw" />
                                                                        </div>
                                                                        <div class="row justify-content-center">

                                                                            <div class="img-container image-b-spw">
                                                                                <img src="<?php echo $product_data["path"]; ?>" class="img-bottom-swp image-b-spw" id="otherImagesSpw<?php echo $images_num1 + 1; ?>" onclick="changeMainImageSpw(<?php echo $images_num1 + 1; ?>);" />
                                                                            </div>
                                                                            <?php
                                                                            if ($images_num1 > 0) {
                                                                                for ($i = 0; $i < $images_num1; $i++) {
                                                                                    $images_data1 = $images_rs1->fetch_assoc();

                                                                                    $img1[$i] = $images_data1["image_path"];
                                                                            ?>

                                                                                    <div class="img-container image-b-spw">
                                                                                        <img src="<?php echo $img1[$i]; ?>" class="img-bottom-swp image-b-spw" id="otherImagesSpw<?php echo $i; ?>" onclick="changeMainImageSpw(<?php echo $i; ?>);" />
                                                                                    </div>

                                                                                <?php
                                                                                }
                                                                            } else {
                                                                                ?>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8 col-12 border-start border-opacity-50">
                                                                        <div class="col-12 p-3">
                                                                            <div class="row justify-content-center">

                                                                                <div class="col-12 mt-2 mb-3 text-start">
                                                                                    <span class="delius spw-mtext"><?php echo ($product_data["cname"]); ?> /</span>
                                                                                    <span class="delius spw-mtext"><?php echo ($product_data["coname"]); ?></span>
                                                                                </div>

                                                                                <div class="col-12 mt-3">
                                                                                    <div class="row justify-content-center">
                                                                                        <div class="col-12 mt-2 mb-3 fw-semibold text-center">
                                                                                            <span class="delius spw-mtext"><?php echo ($product_data["title"]); ?></span>
                                                                                        </div>

                                                                                        <div class="col-12 text-center mb-3">
                                                                                            <span class="fw-semibold">
                                                                                                <span>Rs </span>
                                                                                                <span id="priceTag<?php echo $product_data['pid']; ?>"><?php echo $product_data["price"]; ?></span>
                                                                                                <span>.00</span>
                                                                                            </span>
                                                                                        </div>
                                                                                        <div class="col-12 text-center">
                                                                                            <span><?php echo $product_data["description"]; ?></span>
                                                                                        </div>


                                                                                        <div class="col-6 col-lg-5 mt-3 text-start">

                                                                                            <label class="form-lable rocksalt mb-2">Qty</label>

                                                                                            <div class="input-group mb-3 qty-input">

                                                                                                <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="1" min="1" max="<?php echo $product_data['qty']; ?>" oninput="changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);" id="qtySelector<?php echo ($product_data["pid"]); ?>" />

                                                                                                <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTY(<?php echo $product_data['pid']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">-</button>

                                                                                                <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTY(<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">+</button>

                                                                                            </div>
                                                                                            <span class="insspw"> In stock: <span class="insspw2"><?php echo $product_data["qty"]; ?></span></span>
                                                                                        </div>
                                                                                        <div class="col-6 col-lg-5 mt-3">

                                                                                        </div>
                                                                                        <div class="col-6 col-lg-5 mt-3 d-grid align-items-end mb-3">
                                                                                            <button class="btn-edit btn-purple-v2" onclick="savePrice(<?php echo $product_data['pid']; ?>);">Buy</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                            </div>

                            <!-- pagination -->
                            <?php
                            if ($product_num == 0) {
                            ?>
                                <div class="col-12 mb-3 d-none">
                                <?php
                            } else {
                                ?>
                                    <div class="col-12 mb-3 mt-3">
                                    <?php
                                }
                                    ?>
                                    <div class="row justify-content-center">

                                        <nav aria-label="Page navigation example" style="width: max-content;">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link" href="<?php

                                                                                if ($pageno <= 1) {

                                                                                    echo "#";
                                                                                } else {

                                                                                    echo ("?page=" . ($pageno - 1));
                                                                                }

                                                                                if (isset($_GET["cid"])) {
                                                                                    echo ("&cid=" . $_GET["cid"]);
                                                                                }

                                                                                ?>" aria-label="Previous">
                                                        <span aria-hidden="true">Previous</span>
                                                    </a>
                                                </li>
                                                <?php

                                                for ($x = 1; $x <= $number_of_pages; $x++) {

                                                    if ($x == $pageno) {
                                                ?>

                                                        <li class="page-item active pag-act"><a class="page-link" href="<?php echo "?page=" . ($x);
                                                                                                                        if (isset($_GET["cid"])) {
                                                                                                                            echo ("&cid=" . $_GET["cid"]);
                                                                                                                        }
                                                                                                                        ?>"><?php echo $x; ?></a></li>

                                                    <?php

                                                    } else {
                                                    ?>

                                                        <li class="page-item"><a class="page-link" href="<?php echo "?page=" . ($x);
                                                                                                            if (isset($_GET["cid"])) {
                                                                                                                echo ("&cid=" . $_GET["cid"]);
                                                                                                            }
                                                                                                            ?>"><?php echo $x; ?></a></li>

                                                <?php

                                                    }
                                                }

                                                ?>

                                                <li class="page-item">
                                                    <a class="page-link" href="<?php

                                                                                if ($pageno >= $number_of_pages) {

                                                                                    echo "#";
                                                                                } else {

                                                                                    echo ("?page=" . ($pageno + 1));
                                                                                }

                                                                                if (isset($_GET["cid"])) {
                                                                                    echo ("&cid=" . $_GET["cid"]);
                                                                                }

                                                                                ?>" aria-label="Next">
                                                        <span aria-hidden="true">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>

                                    </div>

                                    </div>

                                </div>

                                <!-- pagination -->

                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="homeMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="homeMessage" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-black" style="border-radius: 0px;">

                        <div class="modal-header" style="border-bottom: none;">
                        </div>

                        <div class="modal-body text-center">
                            <p class="mont fs-3 text-light" id="homeQTYmessage"></p>
                        </div>

                        <div class="modal-footer" style="border-top: none;">
                            <button type="button" class="btn-edit btn-improved text-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn-edit btn-purple-v2" onclick="loadOrder();" id="btnOrder">Order</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php
        include "footer.php";
        ?>
    </div>

    <script src="Js/script.js"></script>
</body>

</html>