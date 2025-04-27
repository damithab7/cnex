<?php

session_start();

require "./backend/connection.php";

?>
<!DOCTYPE html>

<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="icon" href="./style/resources/cnex.png">
   <title>CneX | updateProduct</title>
   <link rel="stylesheet" href="./style/bootstrap.css" />
   <link rel="stylesheet" href="./style/style.css" />

</head>

<body>

   <?php

   if (isset($_GET["pid"]) && isset($_SESSION["u"])) {
      $pid = $_GET["pid"];
   } else {
      header("Location:manageProducts.php");
   }

   ?>

   <div class="container-fluid">
      <div class="row justify-content-center">

         <div class="col-12 p-3">
            <div class="row justify-content-center">
               <div class="logo" onclick="window.location='home.php';"></div>
            </div>
         </div>

         <?php
         $product_rs = Database::search("SELECT *,`collection`.`id` AS coid,`category`.`id` AS cid FROM `product` INNER JOIN `collection` ON `product`.`collection_id`=`collection`.`id` INNER JOIN `category` ON `collection`.`category_id`=`category`.`id` INNER JOIN `product_image` ON `product_image`.`product_id`=`product`.`id` WHERE `product`.`id`='" . $pid . "'");
         if ($product_rs->num_rows == 1) {
            $product_data = $product_rs->fetch_assoc();
         ?>

            <div class="col-12">
               <div class="row gy-3 justify-content-center">

                  <div class="rounded p-2 mt-5 text-div">
                     <span class="text-dark fw-light rancho fs-1 user-select-none">Update Product</span>
                  </div>

                  <div class="col-11 mt-4 mb-3 border border-opacity-50 rounded-3 p-3">
                     <div class="row justify-content-center">

                        <div class="col-12 mb-4">
                           <div class="row justify-content-center">
                              <div class="col-12">
                                 <span class="newProductL">Select Product Category</span>
                              </div>
                              <div class="col-12 mt-3 mb-3">
                                 <select class="form-select mt-3 mb-3 ViewSelect select-edit select_edit_p" id="productViewC" multiple onchange="loadUpdateCollectionAdmin();">
                                    <option value="0">None</option>
                                    <?php

                                    $category_rs = Database::search("SELECT * FROM `category`");

                                    $category_num = $category_rs->num_rows;

                                    for ($c = 0; $c < $category_rs->num_rows; $c++) {

                                       $category_data = $category_rs->fetch_assoc();

                                    ?>
                                       <option value="<?php echo $category_data["id"]; ?>" <?php if ($category_data["id"] == $product_data["cid"]) { ?>selected<?php } ?>><?php echo $category_data["name"]; ?></option>
                                    <?php

                                    }
                                    ?>
                                 </select>
                                 <div class="invalid-feedback" id="cintext"></div>

                              </div>
                           </div>
                        </div>

                        <div class="col-12 col-lg-12">
                           <div class="row justify-content-center">
                              <?php
                              $collection_rs = Database::search("SELECT * FROM `collection` WHERE `category_id`='" . $product_data["cid"] . "'");
                              $collection_num = $collection_rs->num_rows;
                              ?>
                              <div class="col-12">
                                 <span class="newProductL">Select Category Item</span>
                              </div>
                              <div class="col-12 mb-3">
                                 <select class="form-select mt-3 mb-3 ViewSelect select-edit select_edit_p select_edit_pc" id="collectionSelect" required multiple>
                                    <option value="0">None</option>
                                    <?php
                                    for ($c = 0; $c < $collection_num; $c++) {

                                       $collection_data = $collection_rs->fetch_assoc();

                                    ?>
                                       <option value="<?php echo $collection_data["id"]; ?>" <?php if ($collection_data["id"] == $product_data["coid"]) { ?>selected<?php } ?>><?php echo $collection_data["name"]; ?></option>
                                    <?php

                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">
                              <div class="col-10 mt-3">
                                 <span class="newProductL">
                                    Add a title to your product
                                 </span>
                              </div>
                              <div class="col-10 mt-3 mb-3">
                                 <input type="text" class="form-control control-edit contorl-edit-admin" id="putitle" placeholder="Product Title" value="<?php echo ($product_data["title"]); ?>" />
                              </div>
                           </div>
                        </div>

                        <?php

                        $size_rs = Database::search("SELECT * FROM `size`");

                        $size_rs1 = Database::search("SELECT * FROM `size`");

                        ?>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">

                              <div class="col-12 mt-3">
                                 <span class="newProductL">Add Product Sizes</span>
                              </div>

                              <div class="btn-p-size d-grid mt-3 mb-1">
                                 <button class="btn-edit btn-purple-v2" id="qtySbtn0" onclick="hideSQTYupdate(<?php echo $size_rs->num_rows; ?>);">None</button>
                              </div>

                              <?php
                              for ($z = 0; $z < $size_rs->num_rows; $z++) {

                                 $size_data = $size_rs->fetch_assoc();

                                 $phs_rs1 = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $pid . "' AND `size_id`='".$size_data["id"]."'");

                                 $phs_data1 = $phs_rs1->fetch_assoc();

                                 if (isset($phs_data1["size_id"])) {
                              ?>
                                    <div class="btn-p-size d-grid mt-3 mb-1">
                                       <button class="btn-edit btn-purple-v2 btn-purple-size" id="qtySbtn<?php echo $size_data['id']; ?>" onclick="showSQTYupdate(<?php echo $size_data['id']; ?>,<?php echo $size_rs->num_rows; ?>);"><?php echo $size_data["name"]; ?></button>
                                    </div>
                                 <?php
                                 } else {
                                 ?>
                                    <div class="btn-p-size d-grid mt-3 mb-1">
                                       <button class="btn-edit btn-purple-v2" id="qtySbtn<?php echo $size_data['id']; ?>" onclick="showSQTYupdate(<?php echo $size_data['id']; ?>,<?php echo $size_rs->num_rows; ?>);"><?php echo $size_data["name"]; ?></button>
                                    </div>
                              <?php
                                 }
                              }
                              ?>

                           </div>
                        </div>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">

                              <div class="col-12 mt-3">
                                 <span class="newProductL">Add Product Quantity</span>
                              </div>

                              <div class="col-10 mt-3 mb-3 d-none" id="sizeQTY0">
                                 <input type="number" class="form-control control-edit contorl-edit-admin" value="0" min="1" id="puqty" />
                                 <div class="invalid-feedback" id="addSqty0"></div>
                              </div>

                              <div class="col-12" id="qtyDiv">
                                 <div class="row justify-content-center align-items-start">

                                    <?php
                                    for ($p = 0; $p < $size_rs1->num_rows; $p++) {
                                       $size_data1 = $size_rs1->fetch_assoc();

                                       $phs_rs = Database::search("SELECT * FROM `product_has_size` INNER JOIN `size` ON `size`.`id`=`product_has_size`.`size_id` WHERE `product_id`='" . $pid . "' AND `size_id`='".$size_data1["id"]."'");

                                       $phs_data = $phs_rs->fetch_assoc();
                                       if (isset($phs_data["size_id"])) {
                                    ?>
                                          <div class="input-group mt-3 mb-1 control-qty-p" id="sizeQTY<?php echo $phs_data['id']; ?>">
                                             <span id="psqtyspan<?php echo $phs_data['id']; ?>"><?php echo $phs_data["name"]; ?></span>
                                             <input type="number" class="form-control control-edit contorl-edit-admin" value="<?php echo $phs_data["qty"]; ?>" min="1" id="psqty<?php echo $phs_data['id']; ?>" onchange="qtyValueCheck(<?php echo $phs_data['id']; ?>);" />
                                             <div class="invalid-feedback" id="addSqty<?php echo $phs_data['id']; ?>"></div>
                                          </div>
                                       <?php
                                       } else {
                                       ?>
                                          <div class="input-group mt-3 mb-1 control-qty-p d-none" id="sizeQTY<?php echo $size_data1['id']; ?>">
                                             <span id="psqtyspan<?php echo $size_data1['id']; ?>"><?php echo $size_data1["name"]; ?></span>
                                             <input type="number" class="form-control control-edit contorl-edit-admin" value="0" min="1" id="psqty<?php echo $size_data1['id']; ?>" onchange="qtyValueCheck(<?php echo $size_data1['id']; ?>);" />
                                             <div class="invalid-feedback" id="addSqty<?php echo $size_data1['id']; ?>"></div>
                                          </div>
                                    <?php
                                       }
                                    }
                                    ?>
                                 </div>
                              </div>

                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row">

                              <div class="col-6">
                                 <div class="row justify-content-center">
                                    <div class="col-12">
                                       <span class="newProductL">Cost Per Item</span>
                                    </div>
                                    <div class="col-12 col-lg-8 mt-3 mb-3">
                                       <div class="input-group mb-2 mt-2">
                                          <span class="input-group-text igt-ap">Rs.</span>
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="pucost" placeholder="Product Price" value="<?php echo ($product_data["price"]); ?>" />
                                          <span class="input-group-text igt-ap">.00</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-6">
                                 <div class="row">
                                    <div class="col-12">
                                       <span class="newProductL">Approved Payment Methods</span>
                                    </div>
                                    <div class="col-12 mt-3 mb-3">
                                       <div class="row justify-content-center mt-2">
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
                                 </div>
                              </div>

                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row">
                              <div class="col-12">
                                 <span class="newProductL">Delivery Cost</span>
                              </div>
                              <div class="col-12 col-lg-6 mt-3 mb-3">
                                 <div class="row justify-content-center">
                                    <div class="col-12 col-lg-4">
                                       <span class="form-label fw-bold mont">Delivery cost Within Badulla</span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                       <div class="input-group mb-2 mt-2">
                                          <span class="input-group-text igt-ap">Rs.</span>
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="udca" placeholder="Delivery Cost Badulla" value="<?php echo ($product_data["delivery_fee_badulla"]); ?>" />
                                          <span class="input-group-text igt-ap">.00</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-12 col-lg-6 mt-3 mb-3">
                                 <div class="row justify-content-center">
                                    <div class="col-12 col-lg-4">
                                       <span class="form-label fw-bold mont">Delivery cost out of Badulla</span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                       <div class="input-group mb-2 mt-2">
                                          <span class="input-group-text igt-ap">Rs.</span>
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="udcoa" placeholder="Out of Badulla" value="<?php echo ($product_data["delivery_fee_other"]); ?>" />
                                          <span class="input-group-text igt-ap">.00</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12">
                           <span class="newProductL">Product Description</span>
                        </div>

                        <div class="col-12 mt-3 mb-3">
                           <textarea cols="30" rows="5" class="form-control control-edit contorl-edit-admin" id="udesc" title="Product Description"><?php echo $product_data["description"]; ?></textarea>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">
                              <div class="col-12">
                                 <span class="newProductL">Add Cover Image*</span>
                              </div>
                              <div class="col-12 mt-4">
                                 <div class="row justify-content-center">
                                    <div class="col-12">
                                       <div class="row justify-content-center">

                                          <div class="image-container-pu image-container-pu-main">
                                             <img src="<?php echo $product_data["path"] ?>" class="img-fluid img-pu" id="pimage1" />
                                          </div>

                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-12 mb-3">
                                 <div class="row justify-content-center">
                                    <div class="col-12 col-lg-8 d-grid mt-3">
                                       <input type="file" class="d-none" id="imagesUploader" />
                                       <label for="imagesUploader" class="btn-edit" onclick="changeProductImage();">Upload Cover Image</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-12 d-lg-none d-block">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>
                        <?php
                        $images_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $pid . "'");
                        $images_num = $images_rs->num_rows;
                        ?>
                        <div class="col-12 col-lg-8">
                           <div class="row">
                              <div class="col-12">
                                 <span class="newProductL">Add Product Images(Upto 4 Images)</span>
                              </div>
                              <div class="col-12 mt-4">
                                 <div class="row gap-2 justify-content-center">
                                    <?php
                                    if ($images_num == 0) {
                                    ?>
                                       <div class="image-container-pu">
                                          <img src="./style/resources/imagesUpload2.svg" class="img-fluid img-pu" id="i0" />
                                       </div>
                                       <div class="image-container-pu">
                                          <img src="./style/resources/imagesUpload2.svg" class="img-fluid img-pu" id="i1" />
                                       </div>
                                       <div class="image-container-pu">
                                          <img src="./style/resources/imagesUpload2.svg" class="img-fluid img-pu" id="i2" />
                                       </div>
                                       <div class="image-container-pu">
                                          <img src="./style/resources/imagesUpload2.svg" class="img-fluid img-pu" id="i3" />
                                       </div>
                                       <?php
                                    } else {
                                       $x = 4;
                                       $x = $x - $images_num;
                                       for ($i = 0; $i < $images_num; $i++) {
                                          $images_data = $images_rs->fetch_assoc();
                                       ?>
                                          <div class="image-container-pu">
                                             <img src="./<?php echo ($images_data["image_path"]); ?>" class="img-fluid img-pu" id="i<?php echo $i; ?>" />
                                          </div>
                                       <?php
                                       }
                                       for ($images_num; $images_num <= $x; $images_num++) {

                                       ?>
                                          <div class="image-container-pu">
                                             <img src="./style/resources/imagesUpload2.svg" class="img-fluid img-pu" id="i<?php echo $images_num; ?>" />
                                          </div>
                                    <?php
                                       }
                                    }
                                    ?>
                                 </div>
                              </div>
                              <div class="col-12 offset-lg-3 col-12 col-lg-6 d-grid mt-3">
                                 <input type="file" class="d-none" id="productImageUploader" multiple />
                                 <label for="productImageUploader" class="col-12 btn btn-outline-dark" onclick="changeProductImages();">Upload Images</label>
                              </div>
                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12 col-lg-4 d-grid mt-3 mb-3">
                           <button class="btn-edit btn-purple-v2" onclick="updateProduct(<?php echo ($pid); ?>,<?php echo $images_num; ?>,<?php echo $size_rs->num_rows; ?>);">Save Product</button>
                        </div>

                     </div>
                  </div>

               </div>
            </div>

         <?php
         } else {
            header("Location:myProducts.php");
         }
         ?>

         <div class="modal fade" id="addPMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPMessage" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content bg-black" style="border-radius: 0px;">

                  <div class="modal-header" style="border-bottom: none;">
                  </div>

                  <div class="modal-body text-center">
                     <p class="mont fs-3 text-light" id="addPmsgP"></p>
                  </div>

                  <div class="modal-footer" style="border-top: none;">
                     <button type="button" class="btn-edit btn-purple-v2" id="addPclose" data-bs-dismiss="modal">Close</button>
                  </div>

               </div>
            </div>
         </div>

      </div>
   </div>

   <script src="./Js/script.js"></script>
   <script src="./Js/bootstrap.bundle.js"></script>
</body>

</html>