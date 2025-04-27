<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>CneX | Cart</title>
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
   <link rel="icon" href="style/resources/cnex.png" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">

         <?php

         include "header.php";

         if (isset($_SESSION["u"])) {

            $total = 0;
            $new_total = 0;
            $t_array = array();

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");

            $cart_num = $cart_rs->num_rows;

            if ($cart_num > 0) {
         ?>

               <div class="col-12 m140 py-5">
                  <div class="row justify-content-center gap-4 p-3">
                     <div class="col-12 text-center">
                        <span class="delius fs-1 user-select-none">Cart</span>
                     </div>
                     <div class="col-lg-7 col-12">
                        <div class="row">

                           <?php
                           for ($c = 0; $c < $cart_num; $c++) {

                              $cart_data = $cart_rs->fetch_assoc();

                              $product_rs = Database::search("SELECT *,product.id AS pid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` WHERE product.id='" . $cart_data["product_id"] . "'");
                              $product_data = $product_rs->fetch_assoc();

                              $total = $cart_data["qty"] * $product_data["price"];

                              $t_array[$product_data["pid"]] = $total;

                              $new_total = $new_total + $total;

                           ?>

                              <div class="col-12 mb-3 border border-opacity-50 rounded">
                                 <div class="row">
                                    <div class="col-3 border-end border-opacity-50 cart-image-div">
                                       <div class="img-container-cart">
                                          <img src="<?php echo ($product_data["path"]); ?>" class="img-edit-cart user-select-none" alt="<?php echo ($product_data["title"]); ?>" />
                                       </div>
                                    </div>
                                    <div class="col-9 align-items-center">

                                       <div class="row">
                                          <div class="col-12">
                                             <div class="row">
                                                <div class="col-8 mt-2">
                                                   <span class="delius fs-5"><?php echo ($product_data["title"]); ?></span>
                                                </div>
                                                <div class="col-4 text-end mt-2">
                                                   <p class="inter fw-semibold">
                                                      <span>Rs.</span>
                                                      <span id="priceTag<?php echo $product_data["pid"]; ?>"><?php echo ($t_array[$product_data["pid"]]); ?></span><span>.00</span>
                                                   </p>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="row align-items-end">
                                                <div class="col-6 mt-3">
                                                   <div class="row">

                                                      <div class="col-12">
                                                         <span class="rocksalt mb-2">Qty :</span>
                                                         <div class="input-group mt-1 mb-3 qty-input">

                                                            <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="<?php echo $cart_data['qty']; ?>" min="1" max="<?php echo $product_data['qty']; ?>" oninput="changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);" id="qtySelector<?php echo ($product_data["pid"]); ?>" />

                                                            <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTY(<?php echo $product_data['pid']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">-</button>

                                                            <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTY(<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">+</button>

                                                         </div>
                                                      </div>


                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="row">
                                                      <div class="col-12 text-end mb-2">
                                                         <a class="cartRemove" onclick="removeFromCart(<?php echo ($product_data['pid']); ?>);">Remove</a>
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
                     <div class="col-lg-3 col-12">
                        <div class="row">
                           <?php
                           $address_rs = Database::search("SELECT *,district.id AS did FROM `user_has_address` INNER JOIN `city` ON `user_has_address`.`city_id`=city.id INNER JOIN `district` ON district.id=city.district_id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                           $address_num = $address_rs->num_rows;
                           ?>
                           <div class="col-12 bg-lightblue rounded">
                              <!--checkout-box-->

                              <div class="row">

                                 <div class="col-12">
                                    <span class="small-caps-titles fs-4 summary-text">Summary</span>
                                 </div>
                                 <div class="col-6 mt-4">
                                    <span class="text-edit">items (<?php echo $cart_num; ?>)</span>
                                 </div>

                                 <div class="col-6 text-end mt-4">
                                    <span class="fs-5 delius">Rs. <span id="a_total" class="fs-5 delius"><?php echo $new_total; ?></span></span>
                                 </div>

                                 <div class="col-6">
                                    <span class="text-edit">Shipping</span>
                                 </div>
                                 <?php

                                 $text;

                                 if ($address_num == 1) {

                                    $address_data = $address_rs->fetch_assoc();

                                    if($address_data["did"] == 1){
                                       if($product_data["delivery_fee_badulla"] == "Free"){
                                          $text = "Free";
                                       }else{
                                          $text = $product_data["delivery_fee_badulla"];
                                       }
                                    }else{
                                       $text = $product_data["delivery_fee_other"];
                                    }
                                 ?>
                                    <div class="col-6 text-end">
                                       <span class="text-edit text-success fw-semibold"><?php echo $text;?></span>
                                    </div>
                                 <?php
                                 } else {
                                 ?>
                                    <div class="col-6 text-end">
                                       <span class="text-edit text-success fw-semibold"><?php echo $product_data["delivery_fee_other"];?></span>
                                    </div>
                                 <?php
                                 }
                                 ?>
                                 <hr class="mt-2" />
                                 <div class="col-12">
                                    <span class="fs-5 delius">Subtotal</span>
                                 </div>
                                 <div class="col-12 text-end">
                                    <span class="fs-3">රු. <span class="fs-3 checkout-span delius" id="subtotal"><?php echo $new_total; ?></span>.00</span>
                                 </div>
                              </div>

                              <div class="row justify-content-center mt-3 mb-3">
                                 <div class="col-12 d-grid">
                                    <button class="btn-edit btn-purple-v2 fw-normal cart-check-btn" onclick="savePriceCart(<?php echo $product_data['pid']; ?>);"><span class="cartspanc">Checkout</span></button>
                                 </div>
                              </div>

                              <span class="d-none hide-item" id="get_total" hidden><?php echo $new_total; ?></span>

                              <!--checkout-box-->
                           </div>
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
                           <div class="col-12 emptyCart"></div>
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

            if (isset($_SESSION["cart"])) {

               $total = 0;
               $new_total = 0;
               $t_array = array();

               $cart_num = $_SESSION["cart"]["num"];

               if ($cart_num > 0) {

               ?>
                  <div class="col-12 m140">
                     <div class="row justify-content-center gap-4 p-3">
                        <div class="col-12 text-center">
                           <span class="delius fs-1 user-select-none">Cart</span>
                        </div>
                        <div class="col-lg-7 col-12">
                           <div class="row">

                              <?php

                              for ($c = 1; $c <= $cart_num; $c++) {

                                 $p_rs = Database::search("SELECT * FROM `product`");
                                 $p_data = $p_rs->fetch_assoc();

                                 if ($_SESSION["cart"]["id" . $p_data["id"]]["id"] == $p_data["id"]) {

                                    $pid = $_SESSION["cart"]["id" . $p_data["id"]]["id"];

                                    $product_rs = Database::search("SELECT *,product.id AS pid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON product.collection_id=`collection`.`id` WHERE product.id='" . $pid . "'");

                                    $product_data = $product_rs->fetch_assoc();

                                    $pqty = $_SESSION["cart"]["id" . $product_data["pid"]]["qty"];

                                    $total = $pqty * $product_data["price"];

                                    $t_array[$product_data["pid"]] = $total;

                                    $new_total = $new_total + $total;
                                 }

                              ?>

                                 <div class="col-12 mb-3 border border-opacity-50 rounded">
                                    <div class="row">
                                       <div class="col-3 border-end border-opacity-50 cart-image-div">
                                          <div class="img-container-cart">
                                             <img src="<?php echo ($product_data["path"]); ?>" class="img-edit-cart user-select-none" alt="<?php echo ($product_data["title"]); ?>" />
                                          </div>
                                       </div>
                                       <div class="col-9 align-items-center">

                                          <div class="row">
                                             <div class="col-12">
                                                <div class="row">
                                                   <div class="col-8 mt-2">
                                                      <span class="delius fs-5"><?php echo ($product_data["title"]); ?></span>
                                                   </div>
                                                   <div class="col-4 text-end mt-2">
                                                      <p class="inter fw-semibold">
                                                         <span>Rs.</span>
                                                         <span id="priceTag<?php echo $product_data["pid"]; ?>"><?php echo ($t_array[$product_data["pid"]]); ?></span><span>.00</span>
                                                      </p>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-12">
                                                <div class="row align-items-end">
                                                   <div class="col-6 mt-3">
                                                      <div class="row">

                                                         <div class="col-12">
                                                            <span class="rocksalt mb-2">Qty :</span>
                                                            <div class="input-group mt-1 mb-3 qty-input">

                                                               <input type="number" class="form-control control-edit control-qty" aria-label="Amount (to the nearest LKR)" value="<?php echo $pqty; ?>" min="1" max="<?php echo $product_data['qty']; ?>" oninput="changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);" id="qtySelector<?php echo ($product_data["pid"]); ?>" />

                                                               <button class="btn-edit btn-purple-v2 purple-v3" onclick="reduceQTY(<?php echo $product_data['pid']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">-</button>

                                                               <button class="btn-edit btn-purple-v2 purple-v4" onclick="addQTY(<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);changeQTY(<?php echo $product_data['price']; ?>,<?php echo $product_data['pid']; ?>,<?php echo $product_data['qty']; ?>);">+</button>

                                                            </div>
                                                         </div>


                                                      </div>
                                                   </div>
                                                   <div class="col-6">
                                                      <div class="row">
                                                         <div class="col-12 text-end mb-2">
                                                            <a class="cartRemove" onclick="removeFromCart(<?php echo ($product_data['pid']); ?>);">Remove</a>
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
                        <div class="col-lg-3 col-12">
                           <div class="row">
                              <div class="col-12 bg-lightblue rounded">
                                 <!--checkout-box-->

                                 <div class="row">

                                    <div class="col-12">
                                       <span class="small-caps-titles fs-4 summary-text">Summary</span>
                                    </div>
                                    <div class="col-6 mt-4">
                                       <span class="text-edit">items (<?php echo $cart_num; ?>)</span>
                                    </div>

                                    <div class="col-6 text-end mt-4">
                                       <span class="fs-5 mont">Rs. <span id="a_total" class="fs-5 mont"><?php echo $new_total; ?></span></span>
                                    </div>

                                    <div class="col-6">
                                       <span class="text-edit">Shipping</span>
                                    </div>
                                    <div class="col-6 text-end">
                                       <span class="text-edit text-success fw-semibold">Free</span>
                                    </div>
                                    <hr class="mt-2" />
                                    <div class="col-12">
                                       <span class="fs-5 delius">Subtotal</span>
                                    </div>
                                    <div class="col-12 text-end">
                                       <span class="fs-3">Rs. <span class="fs-3 checkout-span" id="subtotal"><?php echo $new_total; ?></span></span>
                                    </div>
                                 </div>

                                 <div class="row justify-content-center mt-3 mb-3">
                                    <div class="col-12 d-grid">
                                       <button class="btn-edit btn-purple-v2 fw-normal cart-check-btn" onclick="savePriceCart(<?php echo $product_data['pid']; ?>);"><span class="cartspanc">Checkout</span></button>
                                    </div>
                                 </div>

                                 <span class="d-none hide-item" id="get_total" hidden><?php echo $new_total; ?></span>

                                 <!--checkout-box-->
                              </div>
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
                              <div class="col-12 emptyCart"></div>
                              <div class="btn-empty mb-3">
                                 <a href="home.php" class="btn-edit btn-purple-v2 empty-text-cw">SHOP</a>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               <?php
               }
               ?>
            <?php
            } else {
            ?>
               <div class="col-12 m140">
                  <div class="row emptyviewRow">
                     <div class="col-12">
                        <div class="row justify-content-center">
                           <div class="col-12 emptyCart"></div>
                           <div class="btn-empty mb-3">
                              <a href="home.php" class="btn-edit btn-purple-v2 empty-text-cw">SHOP</a>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
         <?php
            }
         }

         include "footer.php";
         ?>

      </div>
   </div>

   <script src="Js/script.js"></script>

</body>

</html>