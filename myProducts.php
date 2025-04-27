<?php

session_start();

require "backend/connection.php";

?>
<!DOCTYPE html>

<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>CneX | myProducts</title>
   <link rel="icon" href="style/resources/cnex.png" />
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">

         <?php

         include "header.php";

         if (isset($_SESSION["u"])) {

         ?>


            <div class="col-12 m140">
               <div class="row justify-content-center gap-3">

                  <div class="col-lg-2 col-11 mt-4 mb-3 border border-opacity-50 rounded">
                     <div class="row">

                        <div class="col-12 mt-4 mb-4">
                           <div class="row">
                              <div class="col-12 text-end">
                                 <!-- <span class="mont fs-3 text-center">Filter</span> -->
                                 <i class="bi bi-funnel fs-3"></i>
                              </div>
                           </div>
                        </div>
                        <hr />
                        <div class="col-12">
                           <div class="row">
                              <div class="col-12">
                                 <span class="mont fs-3 text-center">Filter</span>
                              </div>

                              <div class="col-12 mt-2 mb-2">
                                 <label for="priceRange" class="form-label">Price Range</label>
                                 <input type="range" class="form-range" min="0" max="5" id="priceRange">
                              </div>

                              <div class="col-12 mt-2 mb-2">
                                 <label class="form-label">QTY</label>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="EmptyQTY">
                                    <label class="form-check-label" for="EmptyQTY">
                                       Empty
                                    </label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="StillQTY" checked>
                                    <label class="form-check-label" for="StillQTY">
                                       Still left
                                    </label>
                                 </div>
                              </div>
                              <hr />
                              <div class="col-12 text-center">
                                 <label class="form-label">Status</label>
                              </div>
                              <div class="col-12 mt-2 mb-2">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="ProductActive" checked>
                                    <label class="form-check-label" for="ProductActive">Active</label>
                                 </div>
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="ProductDeactive" checked>
                                    <label class="form-check-label" for="ProductDeactive">Deactive</label>
                                 </div>
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="ProductExclusive" checked>
                                    <label class="form-check-label" for="ProductExclusive">Exclusive</label>
                                 </div>
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="ProductNew" checked>
                                    <label class="form-check-label" for="ProductNew">New</label>
                                 </div>
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="ProductSales" checked>
                                    <label class="form-check-label" for="ProductSales">Sales</label>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
                  <?php

                  $query = "SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `product`.`collection_id`=`collection`.`id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'";

                  $pageno;

                  if (isset($_GET["page"])) {
                     $pageno = $_GET["page"];
                  } else {
                     $pageno = 1;
                  }

                  $products_rs = Database::search("SELECT *,product.id AS pid,`status`.`name` AS sname,`status`.`id` AS stid FROM `product` INNER JOIN `product_image` ON product.id=product_image.product_id INNER JOIN `collection` ON `product`.`collection_id`=`collection`.`id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");

                  $products_num = $products_rs->num_rows;

                  $results_per_page = 10;
                  $number_of_pages = ceil($products_num / $results_per_page);

                  $page_results = ($pageno - 1) * $results_per_page;

                  $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

                  $selected_num = $selected_rs->num_rows;

                  ?>
                  <div class="col-lg-9 col-11 mt-4 mb-3 border border-1 border-opacity-50 rounded">
                     <div class="row justify-content-center">
                        <div class="col-12 pt-4 pb-4 bg-lightblue">
                           <div class="row justify-content-center">
                              <div class="col-7 col-lg-8 text-start ps-4">
                                 <span class="delius fs-3 text-center">Products</span>&nbsp;
                                 <i class="bi bi-gear fs-3"></i>
                              </div>
                              <div class="col-lg-3 col-md-3 col-4 d-grid">
                                 <button class="btn-edit btn-purple-v2 btn-add" onclick="window.location = 'addProduct.php';"><i class="bi bi-plus-lg"></i> &nbsp;Add Products</button>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-3 col-5 mt-3 mb-3">
                           <div class="input-group">
                              <i class="bi bi-search input-g-item"></i>
                              <input type="text" placeholder="Search Products..." class="form-control control-edit input-edit-pv input-admin" aria-label="search admin" aria-describedby="searchAdmin" />
                           </div>
                        </div>

                        <div class="col-12 mt-4">
                           <div class="row">

                              <div class="col-12 mt-3 mb-3">
                                 <div class="row justify-content-center gap-2">

                                    <?php
                                    for ($p = 0; $p < $selected_num; $p++) {

                                       $product_data = $selected_rs->fetch_assoc();
                                    ?>
                                       <div class="card card-home-height">

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
                                          <div class="card-body card-intro">
                                             <div class="col-12 card-button-intro card-my-intro">
                                                <div class="row justify-content-center g-2 p-4">
                                                   <button class="btn-edit btn-purple btn-product-card" onclick="window.location = 'updateProduct.php?pid=<?php echo $product_data['pid']; ?>';">Edit &nbsp;<i class="bi bi-pencil-fill"></i></button>
                                                   <button class="btn-edit btn-purple btn-card btn-selected btn-product-card" onclick="removeProduct(<?php echo ($product_data['pid']); ?>);">Remove &nbsp<i class="bi bi-trash3-fill"></i></button>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="card-footer card-footer-edit">
                                             <h5 class="card-title-edit"><?php echo ($product_data["title"]); ?></h5>
                                          </div>

                                       </div>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($products_num == 0) {
                                    ?>
                                       <div class="col-12 text-center mb-2">
                                          <span class="empty-text-cw">No products here!</span>
                                       </div>
                                    <?php
                                    }
                                    ?>

                                 </div>
                              </div>
                              <!-- pagination -->
                              <?php
                              if ($products_num == 0) {
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

                                                                           ?>" aria-label="Previous">
                                                   <span aria-hidden="true">Previous</span>
                                                </a>
                                             </li>
                                             <?php

                                             for ($x = 1; $x <= $number_of_pages; $x++) {

                                                if ($x == $pageno) {
                                             ?>

                                                   <li class="page-item active pag-act"><a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a></li>

                                                <?php

                                                } else {
                                                ?>

                                                   <li class="page-item"><a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a></li>

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
               </div>

            </div>

         <?php
         } else {
            header("Location:../index.php");
         }
         ?>
      </div>

      <script src="Js/script.js"></script>
</body>

</html>