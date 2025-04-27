<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>CneX | purchaseHistory</title>
   <link rel="icon" href="style/resources/cnex.png" />
   <link rel="stylesheet" href="./style/bootstrap.css" />
   <link rel="stylesheet" href="./style/style.css" />
   <link rel="stylesheet" href="./style/stars.css" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">


         <?php include "header.php";

         if (isset($_SESSION["u"])) {

            $purchasec_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `checkout` ON `invoice`.`checkout_order_id`=`checkout`.`order_id` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
            $purchasec_num = $purchasec_rs->num_rows;

            if ($purchasec_num > 0) {

         ?>

               <div class="col-12 m140">
                  <div class="row justify-content-center gap-4 p-3">
                     <div class="col-12 text-center">
                        <span class="delius fs-1 user-select-none">Purchased Items</span>
                     </div>
                     <div class="col-lg-10 col-12">
                        <div class="row">


                           <?php
                           $purchase_rs = Database::search("SELECT *,product.id AS pid,invoice.qty AS iqty,invoice.total AS itotal,product.qty AS pqty,checkout.total AS ctotal FROM `product` INNER JOIN `invoice` ON product.id=invoice.product_id INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `collection`.`id` = product.collection_id INNER JOIN `checkout` ON `invoice`.`checkout_order_id`=`checkout`.`order_id` WHERE checkout.user_email='" . $_SESSION["u"]["email"] . "'");
                           $purchase_num = $purchase_rs->num_rows;

                           for ($w = 0; $w < $purchase_num; $w++) {

                              $purchase_data = $purchase_rs->fetch_assoc();

                           ?>

                              <div class="col-12 mb-3 border border-opacity-50 rounded">
                                 <div class="row">
                                    <div class="col-12 mt-2 text-start ptitle mt-2">
                                       <span class="mont fs-5"><?php echo ($purchase_data["title"]); ?></span>
                                       <?php
                                       if ($purchase_data["size"] != '') {
                                          $size = $purchase_data["size"];
                                       ?>
                                          <span class="mont fs-5">(<?php echo $size; ?>)</span>
                                       <?php
                                       }
                                       ?>
                                    </div>

                                    <div class="col-3">
                                       <div class="img-container-cart">
                                          <img src="<?php echo ($purchase_data["path"]); ?>" class="img-edit-cart user-select-none" alt="<?php echo ($purchase_data["name"]); ?>" />
                                       </div>
                                    </div>
                                    <div class="col-9">

                                       <div class="row">

                                          <div class="col-12">
                                             <div class="row align-items-end">
                                                <div class="col-6">
                                                   <div class="row">

                                                      <div class="col-12">
                                                         <span class="rocksalt mb-2">Price :</span>
                                                         <span class="inter fw-semibold">
                                                            <span>Rs.</span>
                                                            <span><?php echo $purchase_data["price"]; ?><span>.00</span> x <?php echo $purchase_data["iqty"]; ?></span>
                                                         </span>
                                                      </div>
                                                      <?php
                                                      $feedback_rs = Database::search("SELECT * FROM `feedback` INNER JOIN `user` ON feedback.user_email=user.email WHERE `product_id`='" . $purchase_data["pid"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");

                                                      $feedback_num = $feedback_rs->num_rows;

                                                      if ($feedback_num > 0) {

                                                         for ($f = 0; $f < $feedback_num; $f++) {

                                                            $feedback_data = $feedback_rs->fetch_assoc();

                                                            if ($feedback_data["type"] == 1) {

                                                      ?>
                                                               <div class="col-12 mt-1 mb-2 text-start">
                                                                  <span class="delius mb-2">Rate this</span>
                                                                  <div class="star-wrapper">
                                                                     <a class="fas fa-star s1 starph" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s2 starph" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s3 starph" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s4 starph" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s5 starph star-back" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                  </div>
                                                               </div>
                                                            <?php
                                                            } else if ($feedback_data["type"] == 2) {
                                                            ?>
                                                               <div class="col-12 mt-1 mb-2 text-start">
                                                                  <span class="delius mb-2">Rate this</span>
                                                                  <div class="star-wrapper">
                                                                     <a class="fas fa-star s1 starph" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s2 starph" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s3 starph" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s4 starph star-back" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s5 starph" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                  </div>
                                                               </div>
                                                            <?php
                                                            } else if ($feedback_data["type"] == 3) {
                                                            ?>
                                                               <div class="col-12 mt-1 mb-2 text-start">
                                                                  <span class="delius mb-2">Rate this</span>
                                                                  <div class="star-wrapper">
                                                                     <a class="fas fa-star s1 starph" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s2 starph" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s3 starph star-back" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s4 starph" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s5 starph" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                  </div>
                                                               </div>
                                                            <?php
                                                            } else if ($feedback_data["type"] == 4) {
                                                            ?>
                                                               <div class="col-12 mt-1 mb-2 text-start">
                                                                  <span class="delius mb-2">Rate this</span>
                                                                  <div class="star-wrapper">
                                                                     <a class="fas fa-star s1 starph" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s2 starph star-back" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s3 starph" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s4 starph" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s5 starph" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                  </div>
                                                               </div>
                                                            <?php
                                                            } else if ($feedback_data["type"] == 5) {
                                                            ?>
                                                               <div class="col-12 mt-1 mb-2 text-start">
                                                                  <span class="delius mb-2">Rate this</span>
                                                                  <div class="star-wrapper">
                                                                     <a class="fas fa-star s1 starph star-back" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s2 starph" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,);"></a>
                                                                     <a class="fas fa-star s3 starph" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s4 starph" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                     <a class="fas fa-star s5 starph" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                                  </div>
                                                               </div>
                                                            <?php
                                                            }
                                                            ?>


                                                         <?php
                                                         }
                                                      } else {
                                                         ?>
                                                         <div class="col-12 mt-1 mb-2 text-start">
                                                            <span class="delius mb-2">Rate this</span>
                                                            <div class="star-wrapper">
                                                               <a class="fas fa-star s1 starph" id="star5<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                               <a class="fas fa-star s2 starph" id="star4<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                               <a class="fas fa-star s3 starph" id="star3<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                               <a class="fas fa-star s4 starph" id="star2<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                               <a class="fas fa-star s5 starph" id="star1<?php echo $purchase_data["pid"]; ?>" onclick="setRate(this.id,<?php echo $purchase_data['pid']; ?>);"></a>
                                                            </div>
                                                         </div>

                                                      <?php
                                                      }
                                                      ?>


                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="row">
                                                      <div class="col-12 text-end">
                                                         <span>#<?php echo ($purchase_data["order_id"]); ?></span>
                                                         <?php
                                                         if ($purchase_data["pqty"] != 0) {
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
                                                      <div class="col-12 text-end mb-2 user-select-none">
                                                         <span class="rocksalt mb-2">Total :</span>
                                                         <span class="delius"><span class="fw-semibold fs-5">රු</span> <?php echo ($purchase_data["ctotal"]); ?>.00</span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                       </div>


                                    </div>
                                 </div>
                              </div>

                              <div class="modal fade modal-index" id="feedbackModal<?php echo $purchase_data['pid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered modal-dialog-width">
                                    <div class="modal-content modal-content-spw">

                                       <div class="modal-header m-header-edit justify-content-between align-items-center">
                                          <h1 class="modal-title fs-4 rocksalt" id="feedbackModal">Review Item</h1>
                                          <button type="button" id="ph_close<?php echo $purchase_data['pid']; ?>" class="btn-edit btn-spw-close" data-bs-dismiss="modal"> <i class="bi bi-x-lg"></i></button>
                                       </div>

                                       <div class="modal-body modal-body-spw">
                                          <div class="col-12">
                                             <div class="row justify-content-center">
                                                <div class="col-10 mt-2 text-start ptitle mt-2">
                                                   <span class="mont fs-5"><?php echo ($purchase_data["title"]); ?></span>
                                                </div>
                                                <div class="col-10 mt-3 user-select-none">
                                                   <div class="form-floating">
                                                      <input type="email" class="form-control control-edit input-ph disabled" placeholder="Email" value="<?php echo $_SESSION["u"]["email"];?>" disabled/>
                                                      <label class="floating-edit">Email</label>
                                                      <div class="invalid-feedback"></div>
                                                   </div>
                                                </div>
                                                <div class="col-10 mt-3 mb-3">
                                                   <label for="textph" class="floating-edit">Feedback</label>
                                                   <textarea rows="10" class="form-control control-edit input-ph" id="textph"></textarea>
                                                   <div class="invalid-feedback" id="textphInv"></div>
                                                </div>

                                                <div class="col-10 d-grid mt-3 mb-3">
                                                   <button class="btn-edit fw-normal cart-check-btn btn-invoice" onclick="saveFeedback(<?php echo $purchase_data['pid']; ?>);" id="fphsbtn<?php echo $purchase_data['pid']; ?>"><span class="cartspanc">SUBMIT</span></button>
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
                           <div class="col-12 emptyHistory"></div>
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
                           <a href="home.php" class="btn btn-light fs-5">SIGN INTO CONTINUE</a>
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

   <script src="./Js/script.js"></script>
   <script src="https://kit.fontawesome.com/5ea815c1d0.js"></script>
</body>

</html>