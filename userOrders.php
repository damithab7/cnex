<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>
<html>

<head>
   <link rel="icon" href="resources/Logo.png" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
   <title>CneX | productOrders</title>
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
   <link rel="icon" href="style/resources/cnex.png" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">

         <?php include "header.php";

         if (isset($_SESSION["u"])) {

            $order_rs = Database::search("SELECT * FROM `order` WHERE `order_email`='" . $_SESSION["u"]["email"] . "'");
            $watchlist_num = $watchlist_rs->num_rows;

            if ($watchlist_num > 0) {

         ?>

               <div class="col-12 mt-4">
                  <div class="row justify-content-start p-4">

                     <table class="cart-table">
                        <tr class="tr-header">
                           <th></th>
                           <th></th>
                           <th>Title</th>
                           <th>Status</th>
                           <th>Unit Price</th>
                           <th></th>
                        </tr>
                        <?php
                        $wishlist_rs = Database::search("SELECT *,product.id AS pid FROM `product` INNER JOIN `watchlist` ON product.id=watchlist.product_id INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `category` ON category.id = product.category_id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                        $wishlist_num = $wishlist_rs->num_rows;

                        for ($w = 0; $w < $wishlist_num; $w++) {

                           $wishlist_data = $wishlist_rs->fetch_assoc();

                        ?>
                           <tr class="tr-body tr-body-wishlist">

                              <td class="d-lg-table-cell d-none text-center">
                                 <button class="btn-purple btn-edit-cart2" onclick="removeFromWatchlist(<?php echo ($wishlist_data['pid']); ?>);">X</button>
                              </td>
                              <td>

                                 <img src="<?php echo $wishlist_data["path"]; ?>" class="img-edit-cart" alt="cake" />

                              </td>
                              <td>
                                 <nobr class="cart-description"> &nbsp;
                                    <?php echo $wishlist_data["description"]; ?>
                                 </nobr>
                              </td>
                              <?php
                              if ($wishlist_data["qty"] != 0) {
                              ?>
                                 <td>
                                    <span class="text-success wishlist-text fw-semibold">In Stock</span>
                                 </td>

                                 <td>
                                    <span class="wishlist-text">Rs. <?php echo $wishlist_data["price"]; ?></span>
                                 </td>

                                 <td>
                                    <div class="col-12 d-grid">
                                       <button class="btn-edit btn-wishlist" onclick="addToCart(<?php echo ($wishlist_data['pid']); ?>);">Add to cart</button>
                                    </div>
                                 </td>

                              <?php
                              } else {
                              ?>

                                 <td>
                                    <span class="text-danger wishlist-text fw-semibold">Out of Stock</span>
                                 </td>

                                 <td>
                                    <span class="wishlist-text">Rs. <?php echo $wishlist_data["price"]; ?></span>
                                 </td>

                                 <td>
                                    <div class="col-12 d-grid">
                                       <button class="btn-edit btn-wishlist" disabled onclick="addToCart(<?php echo ($wishlist_data['pid']); ?>);">Add to cart</button>
                                    </div>
                                 </td>

                              <?php
                              }
                              ?>

                           </tr>
                        <?php
                        }
                        ?>
                     </table>

                  </div>
               </div>

               <!--empty view-->
            <?php
            } else {
            ?>

               <div class="col-12 mt-4">
                  <div class="row">
                     <div class="col-12 emptyWatchlist"></div>
                     <div class="col-12 text-center mb-2">
                        <span class="empty-text-cw">You have no items in your watchlist</span>
                     </div>
                     <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                        <a href="home.php" class="btn btn-light fs-5">ADD ITEMS</a>
                     </div>
                  </div>
               </div>

            <?php
            }
         } else {
            ?>
            <div class="col-12 mt-4">
               <div class="row">
                  <div class="col-12 smileFace"></div>
                  <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                     <a href="home.php" class="btn btn-light fs-5">SIGN INTO CONTINUE</a>
                  </div>
               </div>
            </div>
         <?php
         }
         ?>
         <!--empty view-->

      </div>
   </div>
   <script src="Js/script.js"></script>
</body>

</html>