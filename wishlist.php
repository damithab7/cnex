<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
   <title>CneX | Wishlist</title>
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
   <link rel="icon" href="style/resources/cnex.png" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">


         <?php include "header.php";

         if (isset($_SESSION["u"])) {

            $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
            $watchlist_num = $watchlist_rs->num_rows;

            if ($watchlist_num > 0) {

         ?>

               <div class="col-12 m140">
                  <div class="row justify-content-center gap-4 p-3">
                     <div class="col-12 text-center">
                        <span class="delius fs-1 user-select-none">Wishlist</span>
                     </div>
                     <div class="col-lg-10 col-12">
                        <div class="row">


                           <?php
                           $wishlist_rs = Database::search("SELECT *,product.id AS pid FROM `product` INNER JOIN `watchlist` ON product.id=watchlist.product_id INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `collection`.`id` = product.collection_id WHERE watchlist.user_email='" . $_SESSION["u"]["email"] . "'");
                           $wishlist_num = $wishlist_rs->num_rows;

                           for ($w = 0; $w < $wishlist_num; $w++) {

                              $wishlist_data = $wishlist_rs->fetch_assoc();

                           ?>

                              <div class="col-12 mb-3 border border-opacity-50 rounded">
                                 <div class="row">
                                    <div class="col-3 border-end border-opacity-50">
                                       <div class="img-container-cart">
                                          <img src="<?php echo ($wishlist_data["path"]); ?>" class="img-edit-cart user-select-none" alt="<?php echo ($wishlist_data["name"]); ?>" />
                                       </div>
                                    </div>
                                    <div class="col-9">

                                       <div class="row">
                                          <div class="col-12">
                                             <div class="row">
                                                <div class="col-8 mt-2">
                                                   <span class="delius fs-5"><?php echo ($wishlist_data["title"]); ?></span>
                                                </div>
                                                <div class="col-4 text-end mt-2">
                                                   <?php
                                                   if ($wishlist_data["qty"] != 0) {
                                                   ?>
                                                      <p class="inter fw-semibold text-success">
                                                         In Stock
                                                      </p>
                                                   <?php
                                                   } else {
                                                   ?>
                                                      <p class="inter fw-semibold text-warning">
                                                         Out of stock
                                                      </p>
                                                   <?php
                                                   }
                                                   ?>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-12 mt-3">
                                             <div class="row align-items-end">
                                                <div class="col-6 mt-3">
                                                   <div class="row">

                                                      <div class="col-12">
                                                         <span class="rocksalt mb-2">Price :</span>
                                                         <p class="inter fw-semibold">
                                                            <span>Rs.</span>
                                                            <span><?php echo $wishlist_data["price"]; ?></span>
                                                            <span>.00</span>
                                                         </p>
                                                      </div>

                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="row">
                                                      <div class="col-12 text-end mb-2 user-select-none">
                                                         <?php
                                                         if ($wishlist_data["qty"] != 0) {
                                                         ?>
                                                            <button class="btn-purple me-2" onclick="addToCart(<?php echo ($wishlist_data['pid']); ?>);">Add to cart</button>
                                                         <?php
                                                         } else {
                                                         ?>
                                                            <button class="btn-purple btn-disabled me-2" disabled>Add to cart</button>
                                                         <?php
                                                         }
                                                         ?>
                                                         <button class="btn-purple-v2" onclick="removeFromWatchlist(<?php echo ($wishlist_data['pid']); ?>);">Remove</button>
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
                           ?>

                        </div>
                     </div>

                  </div>
               </div>

            <?php
            } else {
            ?>
               <div class="col-12 m140">
                  <div class="row emptyviewRow">
                     <div class="col-12">
                        <div class="row justify-content-center">
                           <div class="col-12 emptyWatchlist"></div>
                           <div class="btn-empty mb-3">
                              <a href="home.php" class="btn-edit btn-purple-v2 empty-text-cw">SHOP</a>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
            <?php
            }
         } else {
            ?>
            <div class="col-12 m140">
               <div class="row emptyviewRow">
                  <div class="col-12">

                     <div class="row justify-content-center">
                        <div class="col-12 smileFace"></div>
                        <div class="col-12 col-lg-4 d-grid mb-3">
                           <a href="index.php" class="btn btn-light fs-5">SIGN INTO CONTINUE</a>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         <?php
         }
         include "footer.php";
         ?>

      </div>
   </div>

   <script src="Js/script.js"></script>
</body>

</html>