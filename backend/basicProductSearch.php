<?php

session_start();
require "connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$s = $reqOb->search;

$resOb = new stdClass();

$query1 = " AND `title` LIKE '%" . $s . "%' ";

$s_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $s . "%' AND NOT `status_id`='1'");

if ($s_rs->num_rows > 0) {

   $pageno;

   if (isset($_GET["page"])) {
      $pageno = $_GET["page"];
   } else {
      $pageno = 1;
   }

?>
   <div class="col-12">
      <div class="row justify-content-center gap-3 pt-3 ">

         <?php

         $query;

         if (isset($_GET["cid"])) {

            $cid = $_GET["cid"];

            if ($cid == 0) {
               $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'");

               $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'";
            } else {
               $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1' AND category.id='" . $cid . "'");

               $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1' AND category.id='" . $cid . "'";
            }
         } else {
            $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'");

            $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` INNER JOIN `category` ON category.id=`collection`.`category_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE NOT `status_id`='1'";
         }

         $product_num = $products_rs->num_rows;

         $pageno;

         $results_per_page = 8;

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
   <?php


} else {
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
}

   ?>