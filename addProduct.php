<?php

session_start();

if (isset($_SESSION["u"])) {

   require "backend/connection.php";

?>
   <!DOCTYPE html>

   <html>

   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="icon" href="style/resources/cnex.png">
      <title>CneX | addProduct</title>
      <link rel="stylesheet" href="style/bootstrap.css" />
      <link rel="stylesheet" href="style/style.css" />

   </head>

   <body>

      <div class="container-fluid">
         <div class="row justify-content-center">

            <div class="col-12">
               <div class="row gy-3 justify-content-center">

                  <div class="rounded p-2 mt-5 text-div">
                     <span class="text-dark fw-light rancho fs-1 user-select-none">Add New Product</span>
                  </div>

                  <div class="col-11 mt-4 mb-3 border border-opacity-50 rounded-3 p-3">
                     <div class="row justify-content-center">

                        <div class="col-12 mb-4">
                           <div class="row justify-content-center">
                              <?php
                              $category_rs = Database::search("SELECT * FROM `category`");
                              ?>
                              <div class="col-12">
                                 <span class="newProductL">Select Product Category</span>
                              </div>
                              <div class="col-12 mt-3 mb-3">
                                 <select class="form-select mt-3 mb-3 ViewSelect select-edit select_edit_p" id="productViewC" multiple onchange="loadCollection();">
                                    <option value="0">None</option>
                                    <?php
                                    for ($c = 0; $c < $category_rs->num_rows; $c++) {

                                       $category_data = $category_rs->fetch_assoc();

                                    ?>
                                       <option value="<?php echo ($category_data["id"]); ?>"><?php echo ($category_data["name"]); ?></option>
                                    <?php

                                    }
                                    ?>
                                 </select>
                                 <div class="invalid-feedback" id="cintext"></div>
                              </div>
                           </div>
                        </div>

                        <div class="col-12 col-lg-12" id="collectionS">

                        </div>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">
                              <div class="col-10 mt-3">
                                 <span class="newProductL">
                                    Add a title to your product
                                 </span>
                              </div>
                              <div class="col-10 mt-3 mb-3">
                                 <input type="text" class="form-control control-edit contorl-edit-admin" id="ptitle" placeholder="Product Title" />
                                 <div class="invalid-feedback" id="addPtext"></div>
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
                                 <button class="btn-edit btn-purple-v2 btn-purple-size" id="qtySbtn0" onclick="hideSQTY(<?php echo $size_rs->num_rows;?>);">None</button>
                              </div>

                              <?php
                              for ($z = 0; $z < $size_rs->num_rows; $z++) {
                                 $size_data = $size_rs->fetch_assoc();
                              ?>
                                 <div class="btn-p-size d-grid mt-3 mb-1">
                                    <button class="btn-edit btn-purple-v2" id="qtySbtn<?php echo $size_data['id']; ?>" onclick="showSQTY(<?php echo $size_data['id']; ?>,<?php echo $size_rs->num_rows;?>);"><?php echo $size_data["name"]; ?></button>
                                 </div>
                              <?php
                              }
                              ?>

                           </div>
                        </div>

                        <div class="col-12 col-lg-4">
                           <div class="row justify-content-center">

                              <div class="col-12 mt-3">
                                 <span class="newProductL">Add Product Quantity</span>
                              </div>

                              <div class="col-10 mt-3 mb-3" id="sizeQTY0">
                                 <input type="number" class="form-control control-edit contorl-edit-admin" value="0" min="1" id="pqty" />
                                 <div class="invalid-feedback" id="addSqty0"></div>
                              </div>

                              <div class="col-12" id="qtyDiv">
                                 <div class="row justify-content-center align-items-start">

                                    <?php
                                    for ($z = 0; $z < $size_rs1->num_rows; $z++) {
                                       $size_data1 = $size_rs1->fetch_assoc();
                                    ?>
                                       <div class="input-group mt-3 mb-1 control-qty-p d-none" id="sizeQTY<?php echo $size_data1['id']; ?>">
                                          <span id="psqtyspan<?php echo $size_data1['id']; ?>"><?php echo $size_data1["name"]; ?></span>
                                          <input type="number" class="form-control control-edit contorl-edit-admin" value="0" min="1" id="psqty<?php echo $size_data1['id']; ?>" onchange="qtyValueCheck(<?php echo $size_data1['id']; ?>);"/>
                                          <div class="invalid-feedback" id="addSqty<?php echo $size_data1['id']; ?>"></div>
                                       </div>
                                    <?php
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
                                    <div class="col-12 text-center">
                                       <span class="newProductL">Cost Per Item</span>
                                    </div>
                                    <div class="col-12 col-lg-8 mt-3 mb-3">
                                       <div class="input-group mb-2 mt-2">
                                          <span class="input-group-text igt-ap">Rs.</span>
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="pcost" placeholder="Product Price" />
                                          <span class="input-group-text igt-ap">.00</span>
                                          <div class="invalid-feedback" id="addPcost"></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-6">
                                 <div class="row">
                                    <div class="col-12 text-center">
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
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="dca" placeholder="Delivery Cost Badulla" />
                                          <span class="input-group-text igt-ap">.00</span>
                                          <div class="invalid-feedback" id="addPdcost"></div>
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
                                          <input type="text" class="form-control control-edit contorl-edit-admin" id="dcoa" placeholder="Out of Badulla" />
                                          <span class="input-group-text igt-ap">.00</span>
                                          <div class="invalid-feedback" id="addPdocost"></div>
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
                           <textarea cols="30" rows="5" class="form-control control-edit contorl-edit-admin" id="desc" title="Product Description"></textarea>
                           <div class="invalid-feedback" id="addPdesc"></div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-lg-6 col-12">
                           <div class="row justify-content-center">

                              <div class="col-12">
                                 <span class="newProductL">Add Cover Image*</span>
                              </div>

                              <div class="col-12 mt-4">
                                 <div class="row justify-content-center">
                                    <div class="col-2">
                                       <img src="style/resources/singleImage2.svg" class="img-fluid" style="width: 100px;" id="pimage1" />
                                    </div>
                                 </div>
                              </div>

                              <div class="col-12 col-lg-6 d-grid mt-3 mb-3">
                                 <input type="file" class="d-none" id="imagesUploader" />
                                 <label for="imagesUploader" class="btn-edit" onclick="changeProductImage();">Upload Cover Image</label>
                              </div>

                           </div>
                        </div>


                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-lg-6 col-12">
                           <div class="row justify-content-center">
                              <div class="col-12">
                                 <span class="newProductL">Add Product Images (Upto 4 Images)</span>
                              </div>
                              <div class="col-12 mt-4">
                                 <div class="row justify-content-center">
                                    <div class="col-3">
                                       <img src="style/resources/imagesUpload2.svg" class="img-fluid" style="width: 100px;" id="i0" />
                                    </div>
                                    <div class="col-3">
                                       <img src="style/resources/imagesUpload2.svg" class="img-fluid" style="width: 100px;" id="i1" />
                                    </div>
                                    <div class="col-3">
                                       <img src="style/resources/imagesUpload2.svg" class="img-fluid" style="width: 100px;" id="i2" />
                                    </div>
                                    <div class="col-3">
                                       <img src="style/resources/imagesUpload2.svg" class="img-fluid" style="width: 100px;" id="i3" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12 col-lg-6 d-grid mt-3 mb-3">
                                 <input type="file" class="d-none" id="productImageUploader" multiple />
                                 <label for="productImageUploader" class="btn-edit" onclick="changeProductImages();">Upload Images</label>
                              </div>
                           </div>
                        </div>

                        <div class="col-12">
                           <div class="row mt-2 mb-2">
                              <hr class="border-purple" />
                           </div>
                        </div>

                        <div class="col-12 col-lg-4 d-grid mt-3 mb-3">
                           <button class="btn-edit btn-purple-v2" onclick="addProduct(<?php echo $size_rs->num_rows;?>);">Save Product</button>
                        </div>

                     </div>
                  </div>

               </div>
            </div>

            <div class="modal fade" id="addPMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPMessage" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content modal-content-edit" style="border-radius: 0px;">

                     <div class="modal-header" style="border-bottom: none;">
                     </div>

                     <div class="modal-body text-center">
                        <p class="mont fs-3 text-dark" id="addPmsgP"></p>
                     </div>

                     <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn-edit btn-purple-v2" data-bs-dismiss="modal" id="addPclose">Close</button>
                     </div>

                  </div>
               </div>
            </div>

         </div>
      </div>

      <script src="Js/script.js"></script>
      <script src="Js/bootstrap.bundle.js"></script>
   </body>

   </html>

<?php
}
?>