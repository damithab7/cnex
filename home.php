<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=2.0 ,minimum-scale=2.0">
   <title>CneX | home</title>
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
   <link rel="icon" href="style/resources/cnex.png" />
</head>

<body>

   <div class="container-fluid overflow-hidden">

      <div class="row justify-content-center">

         <button class="btn-purple btntop" id="btntop" onclick="goTop();">Top &uparrow;</button>

         <div class="col-12">
            <div class="row home-page">

               <?php include "header.php";

               $category_rs = Database::search("SELECT * FROM `category`");
               $category_num = $category_rs->num_rows;

               ?>

               <div class="homeview m140" id="home-page">
                  <div class="col-12" style="z-index: 999;">
                     <div class="row home-main align-items-center">

                        <div class="col-12">
                           <div class="row justify-content-start">

                              <div class="offset-lg-2 col-12 col-lg-10">
                                 <span class="home-t">Make a World better place.</span>
                              </div>
                              <div class="offset-lg-2 col-12 col-lg-10">
                                 <a class="btn-purple btn-home btn-home-fe btn-ep btn-home-exp" href="#exNowh">GET START</a>
                              </div>


                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>

         <div class="col-12">
            <div class="row justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
               <div class="col-12">
                  <div class="row justify-content-center">

                     <div class="col-12 text-center">
                        <p class="home-text mt-4" id="exNowh">Explore Now!</p>
                     </div>

                     <!-- ProductMenu -->
                     <div class="col-11 mb-3 text-center">

                        <nav id="navbar-example2" class="navbar px-1 mb-2 mt-2 justify-content-center">
                           <ul class="nav home-nav">
                              <?php
                              for ($m = 0; $m < $category_num; $m++) {

                                 $category_data = $category_rs->fetch_assoc();

                              ?>
                                 <li class="nav-item home-nav-item">
                                    <a class="nav-link singleCL <?php if ($category_data["id"] == 1) { ?>active-navh<?php } ?>" id="homeNavA<?php echo $category_data["id"]; ?>" onclick="changeHomeNavA(<?php echo $category_data['id']; ?>,<?php echo $category_num; ?>);"><?php echo $category_data["name"]; ?></a>
                                 </li>
                              <?php
                              }
                              ?>
                           </ul>
                        </nav>

                        <?php
                        $category_prs = Database::search("SELECT * FROM `category`");
                        $caegory_pnum = $category_prs->num_rows;
                        ?>

                        <div class=" p-3 rounded-4" data-bs-target="#navbar-example2" tabindex="0">
                           <div class="row justify-content-center align-items-center homenrow">

                              <?php
                              for ($m = 0; $m < $caegory_pnum; $m++) {

                                 $category_data = $category_prs->fetch_assoc();

                              ?>

                                 <div class="col-12 <?php if ($category_data["id"] != 1) { ?>d-none<?php } ?>" id="homeNavDiv<?php echo $category_data["id"]; ?>">
                                    <div class="row justify-content-center gap-3">

                                       <!-- Cards -->
                                       <?php

                                       $exclusive_p = Database::search("SELECT *,product.id AS 'pid',`status`.`name` AS sname,`status`.`id` AS stid,`category`.`name` AS cname,`collection`.`name` AS coname FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `product`.`collection_id`=`collection`.`id` INNER JOIN `category` ON `collection`.`category_id`=`category`.`id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE `status_id`='3' AND `category`.`id`='" . $category_data["id"] . "' LIMIT 6");
                                       $exclusive_num = $exclusive_p->num_rows;

                                       if ($exclusive_num >= 1) {

                                          for ($x = 0; $x < $exclusive_num; $x++) {

                                             $exclusive_p_data = $exclusive_p->fetch_assoc();

                                             if (isset($_SESSION["u"])) {

                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND `product_id`='" . $exclusive_p_data["pid"] . "'");
                                                $watchlist_num = $watchlist_rs->num_rows;

                                       ?>

                                                <div class="card card-home-height">

                                                   <div class="card-img-container">
                                                      <img src="<?php echo ($exclusive_p_data["path"]); ?>" alt="<?php echo ($exclusive_p_data["name"]); ?>" class="card-image" />
                                                   </div>

                                                   <span class="card-tags card-tags-blue"><?php echo ($exclusive_p_data["sname"]); ?></span>

                                                   <div class="card-body card-intro card-intro-home" onclick="window.location='singleProductView.php?id=<?php echo ($exclusive_p_data['pid']); ?>';">

                                                   </div>

                                                   <div class="col-12 card-button-intro">
                                                      <div class="row justify-content-center g-2 p-4">
                                                         <?php
                                                         if ($watchlist_num == 1) {
                                                         ?>
                                                            <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="addToWishlist(<?php echo $exclusive_p_data['pid']; ?>);"><i class="bi bi-heart-fill" id="watchlist_heart<?php echo $exclusive_p_data['pid']; ?>"></i></button>
                                                         <?php
                                                         } else {
                                                         ?>
                                                            <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="addToWishlist(<?php echo $exclusive_p_data['pid']; ?>);"><i class="bi bi-heart" id="watchlist_heart<?php echo $exclusive_p_data['pid']; ?>"></i></button>
                                                         <?php
                                                         }
                                                         ?>
                                                         <button class="btn-edit btn-purple btn-cart-edit btn-product-card btn-home-card" onclick="addToCart(<?php echo $exclusive_p_data['pid']; ?>);">Add to cart &nbsp;<i class="bi bi-cart"></i> </button>
                                                         <button class="btn-edit btn-purple btn-card btn-selected btn-product-card btn-home-card" onclick="showBuyModal(<?php echo $exclusive_p_data['pid']; ?>);">Buy Now</button>
                                                      </div>
                                                   </div>

                                                   <div class="card-footer card-footer-edit">
                                                      <h5 class="card-title-edit"><?php echo ($exclusive_p_data["title"]); ?> - Rs. <span class="fw-semibold delius"><?php echo ($exclusive_p_data["price"]); ?></span></h5>
                                                   </div>

                                                </div>

                                             <?php
                                             } else {
                                             ?>

                                                <div class="card card-home-height">

                                                   <div class="card-img-container">
                                                      <img src="<?php echo ($exclusive_p_data["path"]); ?>" alt="<?php echo ($exclusive_p_data["name"]); ?>" class="card-image" />
                                                   </div>

                                                   <span class="card-tags card-tags-blue"><?php echo ($exclusive_p_data["sname"]); ?></span>

                                                   <div class="card-body card-intro card-intro-home" onclick="window.location='singleProductView.php?id=<?php echo ($exclusive_p_data['pid']); ?>';">

                                                   </div>

                                                   <div class="col-12 card-button-intro">
                                                      <div class="row justify-content-center g-2 p-4">

                                                         <button class="btn-edit btn-purple btn-product-card btn-home-card" onclick="window.location='wishlist.php';"><i class="bi bi-heart"></i></button>

                                                         <button class="btn-edit btn-purple btn-product-card btn-cart-edit btn-home-card" onclick="toProductView(<?php echo $exclusive_p_data['pid']; ?>);">Add to cart &nbsp;<i class="bi bi-cart"></i> </button>
                                                         <button class="btn-edit btn-purple btn-card btn-selected btn-product-card btn-home-card" onclick="showBuyModal(<?php echo $exclusive_p_data['pid']; ?>);">Buy Now</button>
                                                      </div>
                                                   </div>

                                                   <div class="card-footer card-footer-edit">
                                                      <h5 class="card-title-edit"><?php echo ($exclusive_p_data["title"]); ?> - Rs. <span class="fw-semibold delius"><?php echo ($exclusive_p_data["price"]); ?></span></h5>
                                                   </div>

                                                </div>

                                             <?php
                                             }
                                             ?>

                                             <div class="modal fade modal-index" id="buyModal<?php echo $exclusive_p_data['pid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-width">
                                                   <div class="modal-content modal-content-spw">

                                                      <div class="modal-header m-header-edit justify-content-between align-items-center">
                                                         <h1 class="modal-title fs-4 rocksalt" id="orderModalLabel">Product Order</h1>
                                                         <button type="button" class="btn-edit btn-spw-close" data-bs-dismiss="modal"> <i class="bi bi-x-lg"></i></button>
                                                      </div>

                                                      <?php

                                                      $images_rs1 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $exclusive_p_data["pid"] . "'");

                                                      $images_num1 = $images_rs1->num_rows;

                                                      $img1 = array();

                                                      ?>

                                                      <div class="modal-body modal-body-spw">
                                                         <div class="col-12">
                                                            <div class="row justify-content-center">

                                                               <div class="col-lg-3 col-12 mt-3">
                                                                  <div class="img-container-cart image-container-spw mb-3">
                                                                     <img src="<?php echo ($exclusive_p_data["path"]); ?>" class="img-edit-spw user-select-none" alt="<?php echo ($exclusive_p_data["title"]); ?>" id="mainImageSpw" />
                                                                  </div>
                                                                  <div class="row justify-content-center">

                                                                     <div class="img-container image-b-spw">
                                                                        <img src="<?php echo $exclusive_p_data["path"]; ?>" class="img-bottom-swp image-b-spw" id="otherImagesSpw<?php echo $images_num1 + 1; ?>" onclick="changeMainImageSpw(<?php echo $images_num1 + 1; ?>);" />
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
                                                                           <span class="delius spw-mtext"><?php echo ($exclusive_p_data["cname"]); ?> /</span>
                                                                           <span class="delius spw-mtext"><?php echo ($exclusive_p_data["coname"]); ?></span>
                                                                        </div>

                                                                        <div class="col-12 mt-3">
                                                                           <div class="row justify-content-center align-items-center">
                                                                              <div class="col-12 mt-2 mb-3 fw-semibold text-center">
                                                                                 <span class="delius spw-mtext"><?php echo ($exclusive_p_data["title"]); ?></span>
                                                                              </div>

                                                                              <div class="col-12 text-center mb-3 user-select-none">
                                                                                 <span class="fw-semibold">
                                                                                    <span>Rs </span>
                                                                                    <span id="priceTag<?php echo $exclusive_p_data['pid']; ?>"><?php echo $exclusive_p_data["price"]; ?></span><span>.00</span>
                                                                                 </span>
                                                                              </div>
                                                                              <div class="col-12 text-center">
                                                                                 <span><?php echo $exclusive_p_data["description"]; ?></span>
                                                                              </div>

                                                                              <?php
                                                                              $product_has_size_rs = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $exclusive_p_data['pid'] . "'");
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

                                                                                          <input type="number" class="form-control control-edit control-qty disabled" aria-label="Amount (to the nearest LKR)" value="0" min="0" max="0" disabled oninput="changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);" id="qtySelectorspw<?php echo $exclusive_p_data['pid']; ?>" />

                                                                                          <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTYspw(<?php echo $exclusive_p_data['pid']; ?>);changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);">-</button>

                                                                                          <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTYspw(<?php echo $exclusive_p_data['qty']; ?><?php echo $exclusive_p_data['pid']; ?>);changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);">+</button>

                                                                                       </div>

                                                                                       <span class="insspw oos" id="oosn"> Out of stock </span><span class="insspw2" id="insvalue"></span>

                                                                                    </div>


                                                                                 <?php
                                                                                 } else {
                                                                                 ?>

                                                                                    <div class="col-6 col-lg-5 mt-3 text-start">

                                                                                       <label class="form-lable rocksalt mb-2">Qty</label>

                                                                                       <div class="input-group mb-3 qty-input">

                                                                                          <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="1" min="1" max="<?php echo $phs_data['qty']; ?>" oninput="changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);" id="qtySelectorspw<?php echo $exclusive_p_data['pid']; ?>" />

                                                                                          <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTYspw(<?php echo $exclusive_p_data['pid']; ?>);changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);">-</button>

                                                                                          <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTYspw(<?php echo $exclusive_p_data['qty']; ?>,<?php echo $exclusive_p_data['pid']; ?>);changeQTYsize(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>);">+</button>
                                                                                       </div>

                                                                                       <span class="insspw" id="oosn<?php echo $exclusive_p_data['pid']; ?>"> In stock: </span><span class="insspw2" id="insvalue<?php echo $exclusive_p_data['pid']; ?>"><?php echo $phs_data["qty"]; ?></span>
                                                                                    </div>

                                                                                 <?php
                                                                                 }

                                                                                 $product_has_size_rs2 = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $exclusive_p_data['pid'] . "'");
                                                                                 $phs_num2 = $product_has_size_rs2->num_rows;
                                                                                 ?>
                                                                                 <div class="col-6 col-lg-5">

                                                                                    <div class="row justify-content-center">

                                                                                       <?php
                                                                                       for ($z = 0; $z < $phs_num2; $z++) {

                                                                                          $phs_data2 = $product_has_size_rs2->fetch_assoc();

                                                                                          if ($z == 0) {

                                                                                       ?>
                                                                                             <div class="btn-p-size d-grid mt-3 mb-1">
                                                                                                <button class="btn-edit btn-purple-v2 a_csk<?php echo $phs_data2['product_id']; ?> btn-purple-size" id="qtySbtn<?php echo $phs_data2["size_id"]; ?><?php echo $phs_data2['product_id']; ?>" onclick="showSpwQTY(<?php echo $exclusive_p_data['price']; ?>,<?php echo $phs_data2['size_id']; ?>,<?php echo $phs_data2['product_id']; ?>,<?php echo $phs_data2['qty']; ?>);"><?php echo $phs_data2["name"]; ?></button>
                                                                                             </div>

                                                                                          <?php
                                                                                          } else {
                                                                                          ?>
                                                                                             <div class="btn-p-size d-grid mt-3 mb-1">
                                                                                                <button class="btn-edit a_csk<?php echo $phs_data2['product_id']; ?> btn-purple-v2" id="qtySbtn<?php echo $phs_data2["size_id"]; ?><?php echo $phs_data2['product_id']; ?>" onclick="showSpwQTY(<?php echo $exclusive_p_data['price']; ?>,<?php echo $phs_data2['size_id']; ?>,<?php echo $phs_data2['product_id']; ?>,<?php echo $phs_num2; ?>);"><?php echo $phs_data2["name"]; ?></button>
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
                                                                                    <button class="btn-edit btn-purple-v2" onclick="savePriceSize(<?php echo $exclusive_p_data['pid']; ?>,<?php echo $phs_data['size_id']; ?>);" id="buyNowSPW<?php echo $exclusive_p_data['pid']; ?>">Buy</button>
                                                                                 </div>
                                                                              <?php
                                                                              } else {
                                                                              ?>
                                                                                 <div class="col-6 col-lg-5 mt-3 text-start">

                                                                                    <label class="form-lable rocksalt mb-2">Qty</label>

                                                                                    <div class="input-group mb-3 qty-input">
                                                                                       <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="1" min="1" max="<?php echo $exclusive_p_data['qty']; ?>" oninput="changeQTY(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>,<?php echo $exclusive_p_data['qty']; ?>);" id="qtySelectorspw<?php echo $exclusive_p_data['product_id']; ?>" />

                                                                                       <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTY(<?php echo $exclusive_p_data['pid']; ?>);changeQTY(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>,<?php echo $exclusive_p_data['qty']; ?>);">-</button>

                                                                                       <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTY(<?php echo $exclusive_p_data['pid']; ?>,<?php echo $exclusive_p_data['qty']; ?>);changeQTY(<?php echo $exclusive_p_data['price']; ?>,<?php echo $exclusive_p_data['pid']; ?>,<?php echo $exclusive_p_data['qty']; ?>);">+</button>
                                                                                    </div>
                                                                                    <span class="insspw"> In stock: <span class="insspw2" id="insvalue<?php echo $exclusive_p_data['pid']; ?>"><?php echo $exclusive_p_data["qty"]; ?></span></span>

                                                                                 </div>

                                                                                 <div class="col-6 col-lg-5 mt-3"></div>
                                                                                 <div class="col-6 col-lg-5 mt-3 d-grid align-items-end mb-3">
                                                                                    <button class="btn-edit btn-purple-v2" onclick="savePrice(<?php echo $exclusive_p_data['pid']; ?>);">Buy</button>
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

                                          <?php
                                          }
                                       } else {
                                          ?>
                                          <span class="cs-home">Coming Soon!</span>

                                       <?php
                                       }
                                       ?>

                                       <!-- Cards -->
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

               <div class="modal fade" id="homeMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="homeMessage" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content bg-black" style="border-radius: 0px;">

                        <div class="modal-header" style="border-bottom: none;">
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-center">
                           <p class="mont fs-3 text-light" id="homeQTYmessage">No qty left order it now!</p>
                        </div>

                        <div class="modal-footer" style="border-top: none;">
                           <button type="button" class="btn-edit btn-improved text-light" data-bs-dismiss="modal">Close</button>
                           <button type="button" class="btn-edit btn-purple-v2" onclick="loadOrder();" id="btnOrder">Order</button>
                        </div>

                     </div>
                  </div>
               </div>

            </div>
         </div>

         <div class="col-12">
            <div class="row justify-content-center design-div">

               <div class="image-con-home">
                  <div class="cool-bg"></div>
               </div>

               <div class="col-12 mb-3 text-center rotate">
                  <div class="row">
                     <span class="home-paragraph h-para">Find out what's here!</span>
                     <div class="col-12">
                        <div class="row justify-content-center">
                           <div class="fixed-btn-home">
                              <button class="btn-edit btn-purple btn-more" onclick="window.location='productView.php';">More</button>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>

            </div>
         </div>

         <!-- Map -->
         <div class="col-12">
            <div class="row align-items-center">
               <div class="pixie-map"></div>
            </div>
         </div>

         <!-- contactUs -->

         <?php include "footer.php" ?>
      </div>
   </div>

   <script src="Js/script.js"></script>
   <script src="Js/pathChange.js"></script>
   <script src="Js/events.js"></script>
   <script>
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
         return new bootstrap.Popover(popoverTriggerEl)
      })
   </script>

</body>

</html>