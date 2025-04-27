<?php

session_start();

require "backend/connection.php";

if (isset($_GET["id"])) {

   $pid = $_GET["id"];

   $product_rs = Database::search("SELECT *,product.id AS 'pid',`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `product`.`collection_id`=`collection`.`id` INNER JOIN `category` ON `collection`.`category_id`=`category`.`id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE product.id='" . $pid . "'");

   if ($product_rs->num_rows == 1) {

      $product_data = $product_rs->fetch_assoc();

?>
      <!DOCTYPE html>

      <html>

      <head>
         <meta charset="UTF-8" />
         <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0" />
         <title>CneX | <?php echo ($product_data["title"]); ?></title>
         <link rel="stylesheet" href="style/bootstrap.css" />
         <link rel="stylesheet" href="style/style.css" />
         <link rel="icon" href="style/resources/cnex.png" />
      </head>

      <body>

         <div class="container-fluid">
            <div class="row">
               <?php

               include "header.php";

               ?>
               <div class="col-12 m140">
                  <div class="row justify-content-center spwHeight">

                     <!-- product details -->
                     <div class="col-12">
                        <div class="row justify-content-center align-items-center gap-2">

                           <div class="carousel-inner-spw mt-4 mb-4">

                              <div class="carousel-item-spw">
                                 <img src="<?php echo $product_data["path"]; ?>" class="d-block carousel-image" id="mainImage" />
                              </div>

                           </div>


                           <div class="col-lg-6 col-12 mt-3 mb-3">
                              <div class="row justify-content-center">
                                 <div class="col-12 text-center">
                                    <span class="text-title fw-semibold"><?php echo $product_data["title"]; ?></span>
                                 </div>
                                 <div class="col-12 text-center mb-3">
                                    <span class="fw-semibold">Rs <?php echo $product_data["price"]; ?></span>
                                 </div>
                                 <div class="col-12 text-center">
                                    <span><?php echo $product_data["description"]; ?></span>
                                 </div>
                                 <?php
                                 if ($product_data["qty"] > 0) {
                                 ?>
                                    <div class="col-12">
                                       <div class="row justify-content-center">
                                          <div class="col-5 d-grid mt-4">

                                             <button class="btn-edit btn-purple-v2" onclick="showBuyModal(<?php echo $product_data['pid']; ?>);">Buy it now</button>

                                          </div>
                                          <div class="col-5 d-grid mt-4">
                                             <button class="btn-edit" onclick="saveProductCookie(<?php echo $product_data['pid']; ?>);">Add to cart</button>
                                          </div>

                                       </div>
                                    </div>
                                 <?php
                                 } else {
                                 ?>
                                    <div class="col-12">
                                       <div class="row justify-content-center">
                                          <div class="col-12 text-center">
                                             <span class="text-danger fw-semibold">Out of stock</span>
                                          </div>
                                       </div>
                                       <div class="row justify-content-center">
                                          <div class="col-6 d-grid mt-4">
                                             <button class="btn-edit btn-purple btn-disabled" disabled>Add to cart</button>
                                          </div>

                                          <?php
                                          if (isset($_SESSION["u"])) {

                                             $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND `product_id`='" . $product_data['pid'] . "'");
                                             $watchlist_num = $watchlist_rs->num_rows;

                                             if ($watchlist_num == 1) {
                                          ?>
                                                <div class="col-1 d-grid mt-4">
                                                   <button class="btn-edit btn-purple" onclick="addToWishlist(<?php echo $product_data['pid']; ?>);"><i class="bi bi-heart-fill" id="watchlist_heart<?php echo $product_data['pid']; ?>"></i></button>
                                                </div>
                                             <?php
                                             } else {
                                             ?>
                                                <div class="col-1 d-grid mt-4">
                                                   <button class="btn-edit btn-purple" onclick="addToWishlist(<?php echo $product_data['pid']; ?>);"><i class="bi bi-heart" id="watchlist_heart<?php echo $product_data['pid']; ?>"></i></button>
                                                </div>
                                             <?php
                                             }
                                          } else {
                                             ?>
                                             <div class="col-1 d-grid mt-4">
                                                <button class="btn-edit btn-purple" onclick="window.location = 'wishlist.php';"><i class="bi bi-heart-fill" ?></i></button>
                                             </div>
                                          <?php
                                          }
                                          ?>
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

                     $images_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $pid . "'");

                     $images_num = $images_rs->num_rows;

                     $img = array();

                     ?>

                     <div class="col-12">
                        <div class="row justify-content-center">
                           <div class="col-8 mt-4 mb-4">
                              <div class="row justify-content-center">

                                 <div class="img-container">
                                    <img src="<?php echo $product_data["path"]; ?>" class="img-bottom-swp" id="otherImages<?php echo $images_num + 1; ?>" onclick="changeMainImage(<?php echo $images_num + 1; ?>);" />
                                 </div>
                                 <?php
                                 if ($images_num > 0) {
                                    for ($i = 0; $i < $images_num; $i++) {
                                       $images_data = $images_rs->fetch_assoc();

                                       $img[$i] = $images_data["image_path"];
                                 ?>

                                       <div class="img-container">
                                          <img src="<?php echo $img[$i]; ?>" class="img-bottom-swp" id="otherImages<?php echo $i; ?>" onclick="changeMainImage(<?php echo $i; ?>);" />
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
                        </div>
                     </div>

                     <?php
                     $c_rs = Database::search("SELECT *,`category`.`name` AS cname,`collection`.`name` AS coname FROM `collection` INNER JOIN `category` ON `category`.`id`=`collection`.`category_id` WHERE collection.id='" . $product_data["collection_id"] . "'");
                     $c_data = $c_rs->fetch_assoc();

                     ?>

                     <div class="modal fade modal-index" id="buyModal<?php echo $product_data['pid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-width">
                           <div class="modal-content modal-content-spw">

                              <div class="modal-header m-header-edit justify-content-between align-items-center">
                                 <h1 class="modal-title fs-4 rocksalt" id="orderModalLabel">Product Order</h1>
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

                                                      <div class="col-12 text-center mb-3 user-select-none">
                                                         <span class="fw-semibold">
                                                            <span>Rs </span>
                                                            <span id="priceTag<?php echo $product_data['pid']; ?>"><?php echo $product_data["price"]; ?></span><span>.00</span>
                                                         </span>
                                                      </div>
                                                      <div class="col-12 text-center">
                                                         <span><?php echo $product_data["description"]; ?></span>
                                                      </div>

                                                      <?php
                                                      $product_has_size_rs = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $product_data['pid'] . "'");
                                                      $phs_num = $product_has_size_rs->num_rows;
                                                      ?>

                                                      <?php

                                                      if ($phs_num > 0) {

                                                         $phs_data = $product_has_size_rs->fetch_assoc();


                                                         if ($phs_data["qty"] == 0) {
                                                      ?>
                                                            <div class="col-6 col-lg-5 mt-3 text-start">

                                                               <label class="form-lable rocksalt mb-2">Qty</label>


                                                               <div class="input-group mb-3 qty-input">

                                                                  <input type="number" class="form-control control-edit control-qty disabled" aria-label="Amount (to the nearest LKR)" value="0" min="0" max="0" disabled oninput="changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);" id="qtySelectorspw<?php echo $product_data['pid']; ?>" />

                                                                  <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTYspw(<?php echo $product_data['pid']; ?>);changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);">-</button>

                                                                  <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTYspw(<?php echo $product_data['qty']; ?><?php echo $product_data['pid']; ?>);changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);">+</button>

                                                               </div>

                                                               <span class="insspw oos" id="oosn"> Out of stock </span><span class="insspw2" id="insvalue"></span>

                                                            </div>


                                                         <?php
                                                         } else {
                                                         ?>

                                                            <div class="col-6 col-lg-5 mt-3 text-start">

                                                               <label class="form-lable rocksalt mb-2">Qty</label>

                                                               <div class="input-group mb-3 qty-input">

                                                                  <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="1" min="1" max="<?php echo $phs_data['qty']; ?>" oninput="changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);" id="qtySelectorspw<?php echo $product_data['pid']; ?>" />

                                                                  <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTYspw(<?php echo $product_data['pid']; ?>);changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);">-</button>

                                                                  <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTYspw(<?php echo $product_data['qty']; ?>,<?php echo $product_data['pid']; ?>);changeQTYsize(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>);">+</button>
                                                               </div>

                                                               <span class="insspw" id="oosn<?php echo $product_data['pid']; ?>"> In stock: </span><span class="insspw2" id="insvalue<?php echo $product_data['pid']; ?>"><?php echo $phs_data["qty"]; ?></span>
                                                            </div>

                                                         <?php
                                                         }

                                                         $product_has_size_rs2 = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $product_data['pid'] . "'");
                                                         $phs_num2 = $product_has_size_rs2->num_rows;
                                                         ?>
                                                         <div class="col-6 col-lg-5 mt-3">

                                                            <div class="row justify-content-center">

                                                               <?php
                                                               for ($z = 0; $z < $phs_num2; $z++) {

                                                                  $phs_data2 = $product_has_size_rs2->fetch_assoc();

                                                                  if ($z == 0) {

                                                               ?>
                                                                     <div class="btn-p-size d-grid mt-3 mb-1">
                                                                        <button class="btn-edit btn-purple-v2 a_csk<?php echo $phs_data2['product_id']; ?> btn-purple-size" id="qtySbtn<?php echo $phs_data2["size_id"]; ?><?php echo $phs_data2['product_id']; ?>" onclick="showSpwQTY(<?php echo $product_data['price']; ?>,<?php echo $phs_data2['size_id']; ?>,<?php echo $phs_data2['product_id']; ?>);"><?php echo $phs_data2["name"]; ?></button>
                                                                     </div>

                                                                  <?php
                                                                  } else {
                                                                  ?>
                                                                     <div class="btn-p-size d-grid mt-3 mb-1">
                                                                        <button class="btn-edit a_csk<?php echo $phs_data2['product_id']; ?> btn-purple-v2" id="qtySbtn<?php echo $phs_data2["size_id"]; ?><?php echo $phs_data2['product_id']; ?>" onclick="showSpwQTY(<?php echo $product_data['price']; ?>,<?php echo $phs_data2['size_id']; ?>,<?php echo $phs_data2['product_id']; ?>);"><?php echo $phs_data2["name"]; ?></button>
                                                                     </div>
                                                                  <?php
                                                                  }
                                                                  ?>

                                                               <?php

                                                               }
                                                               ?>

                                                            </div>

                                                         </div>
                                                         <div class="col-6 col-lg-5 mt-3 d-grid align-items-end mb-3">
                                                            <button class="btn-edit btn-purple-v2" onclick="savePriceSize(<?php echo $product_data['pid']; ?>,<?php echo $phs_data['size_id']; ?>);" id="buyNowSPW<?php echo $product_data['pid']; ?>">Buy</button>
                                                         </div>
                                                      <?php
                                                      } else {
                                                      ?>
                                                         <div class="col-6 col-lg-5 mt-3 text-start">

                                                            <label class="form-lable rocksalt mb-2">Qty</label>

                                                            <div class="input-group mb-3 qty-input">
                                                               <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="1" min="1" max="<?php echo $product_data['qty']; ?>" oninput="changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);" id="qtySelectorspw<?php echo $product_data['product_id']; ?>" />

                                                               <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTY(<?php echo $product_data['pid']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">-</button>

                                                               <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTY(<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">+</button>
                                                            </div>
                                                            <span class="insspw"> In stock: <span class="insspw2" id="insvalue<?php echo $product_data['pid']; ?>"><?php echo $product_data["qty"]; ?></span></span>

                                                         </div>

                                                         <div class="col-6 col-lg-5 mt-3"></div>
                                                         <div class="col-6 col-lg-5 mt-3 d-grid align-items-end mb-3">
                                                            <button class="btn-edit btn-purple-v2" onclick="savePrice(<?php echo $product_data['pid']; ?>);">Buy</button>
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
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>


                     <div class="modal fade" id="singleProductMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="singleProductMessage" aria-hidden="true">
                        <div class="modal-dialog">
                           <div class="modal-content bg-black" style="border-radius: 0px;">

                              <div class="modal-header" style="border-bottom: none;">
                              </div>

                              <div class="modal-body text-center">
                                 <p class="mont fs-3 text-light" id="messageQTYspw"></p>
                              </div>

                              <div class="modal-footer" style="border-top: none;">
                                 <button type="button" class="btn-edit btn-purple-v2" data-bs-target="#orderModal" data-bs-toggle="modal" id="spvButton">Order</button>
                                 <button type="button" class="btn-edit btn-purple-v2 d-none" data-bs-dismiss="modal" id="spvButton2">OK</button>
                              </div>

                           </div>
                        </div>
                     </div>

                  </div>
                  <div class="row justify-content-center">

                  </div>
               </div>

               <?php
               $feedback_rs = Database::search("SELECT * FROM `feedback` INNER JOIN `user` ON feedback.user_email=user.email WHERE `product_id`='" . $pid . "'");
               $feedback_num = $feedback_rs->num_rows;
               ?>

               <div class="col-12">
                  <div class="row justify-content-center">
                     <div class="col-10">
                        <div class="row">
                           <div class="col-12 mb-3">
                              <span class="spw-title rocksalt user-select-none">Reviews</span>
                           </div>
                           <?php
                           if ($feedback_num > 0) {
                           ?>
                              <div class="col-12 mb-4 mt-2 user-select-none">
                                 <div class="row gap-2 justify-content-center">

                                    <?php
                                    for ($f = 0; $f < $feedback_num; $f++) {

                                       $feedback_data = $feedback_rs->fetch_assoc();

                                       $d_d = $feedback_data["date"];
                                       $strd = strtotime($d_d);
                                       $new_date = date("d/m/Y", $strd);
                                    ?>

                                       <div class="card" style="width: 100%;">
                                          <div class="card-body">
                                             <h5 class="card-feedback-name"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?></h5>
                                             <h6 class="feedback-date mb-2 text-muted"><?php echo $new_date; ?></h6>
                                             <p class="card-text-feedback"><?php echo $feedback_data["feedback"]; ?></p>
                                             <?php
                                             if ($feedback_data["type"] == 1) {
                                             ?>
                                                <div class="star-div">
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                </div>

                                             <?php
                                             } else if ($feedback_data["type"] == 2) {
                                             ?>
                                                <div class="star-div">
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                </div>
                                             <?php
                                             } else if ($feedback_data["type"] == 3) {
                                             ?>
                                                <div class="star-div">
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                </div>
                                             <?php
                                             } else if ($feedback_data["type"] == 4) {
                                             ?>
                                                <div class="star-div">
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star"></i></span>
                                                </div>
                                             <?php
                                             } else if ($feedback_data["type"] == 5) {
                                             ?>
                                                <div class="star-div">
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                   <span ><i class="bi bi-star-fill"></i></span>
                                                </div>
                                             <?php
                                             }
                                             ?>
                                          </div>
                                       </div>

                                    <?php
                                    }
                                    ?>

                                 </div>
                              </div>
                           <?php
                           } else {
                           ?>
                              <div class="card mb-3 user-select-none" style="width: 100%;">
                                 <div class="card-body">

                                    <div class="col-12 text-center">
                                       <span class="fs-2 delius">No Reviews</span>
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
               include "footer.php";
               ?>

            </div>

         </div>

      <?php
   } else {
      ?>
         <div class="col-12">
            <div class="row vh-100 align-items-center">
               <div class="col-12 text-center">
                  <h1 class="mont">Nice Try : )</h1>
               </div>
            </div>
         </div>

      </body>

      <script src="Js/script.js"></script>
      </body>

      </html>

<?php
   }
} else {
   header("Location:home.php");
}
?>