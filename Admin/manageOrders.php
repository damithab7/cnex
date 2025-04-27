<?php

session_start();

if (isset($_SESSION["au"])) {

$pageno;

?>
<!DOCTYPE html>

<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | Orders</title>
   <link rel="stylesheet" href="../style/bootstrap.css" />
   <link rel="stylesheet" href="../style/style.css" />
   <link rel="icon" href="../style/resources/cnex.png" />
</head>

<body>
   <div class="container-fluid">
      <div class="row">

         <?php

         include "sideMenu.php";

         if (isset($_GET["page"])) {
            $pageno = $_GET["page"];
         } else {
            $pageno = 1;
         }

         ?>

         <div class="col-12 menu-on menu-off" id="contentA">
            <div class="row">
               <?php
               include "header.php";

               $query = "SELECT *,`orders`.`qty` AS oqty,`orders`.`id` AS `oid` FROM `orders` INNER JOIN `product` ON `orders`.`product_id`=`product`.`id` ORDER BY `date` DESC";

               $order_rs = Database::search("SELECT *,`orders`.`qty` AS oqty,`orders`.`id` AS `oid` FROM `orders` INNER JOIN `product` ON `orders`.`product_id`=`product`.`id` ORDER BY `date` DESC");

               $order_num = $order_rs->num_rows;

               $results_per_page = 5;

               $page_results = ($pageno - 1) * $results_per_page;

               $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

               $selected_num = $selected_rs->num_rows;

               $number_of_pages = ceil($order_num / $results_per_page);

               ?>
               <div class="col-12 manageAdmin">
                  <div class="row">
                     <div class="col-6 offset-3 text-center p-3">
                        <span class="title-edit-lg fs-1 text-blue mont">ManageOrders</span>
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     <div class="col-lg-3 col-9 mt-4">

                        <div class="input-group">
                           <i class="bi bi-search input-g-item"></i>
                           <input type="text" class="form-control control-edit input-edit-pv input-products" placeholder="Search..." aria-label="Search products" aria-describedby="searchProduct" oninput="productSearch();" id="productSearch" />
                        </div>

                     </div>
                  </div>
                  <div class="row justify-content-center">
                     <div class="col-12 mt-4">

                        <div class="row">
                           <div class="manageDiv mt-3">
                              <table class="manageTables">
                                 <tr>
                                    <th class="tableManageHeader">Product Name</th>
                                    <th class="tableManageHeader">quantity</th>
                                    <th class="tableManageHeader">Email</th>
                                    <th class="tableManageHeader">Requested Date</th>
                                    <th class="tableManageHeader">Requested Time</th>
                                    <th class="tableManageHeader">Mobile</th>
                                    <th class="tableManageHeader">Name</th>
                                    <th class="tableManageHeader">Status</th>
                                 </tr>
                                 <?php

                                 for ($x = 0; $x < $selected_num; $x++) {

                                    $order_data = $selected_rs->fetch_assoc();

                                    $date = $order_data["date"];
                                    $strD = strtotime($date);
                                    $new_date = date("Y-m-d", $strD);
                                    $new_time = date("H:i A", $strD);

                                 ?>
                                    <tr>
                                       <td><?php echo $order_data["title"]; ?></td>
                                       <td><?php echo $order_data["oqty"]; ?></td>
                                       <td><?php echo $order_data["order_email"]; ?></td>
                                       <td><?php echo $new_date; ?></td>
                                       <td><?php echo $new_time; ?></td>
                                       <td><?php echo $order_data["mobile"]; ?></td>
                                       <td>
                                          <?php echo $order_data["fname"] . " " . $order_data["lname"]; ?>
                                       </td>
                                       <?php

                                       if ($order_data["status"] == 1) {

                                       ?>
                                          <td>
                                             <button class="btn-edit offset-lg-2 mb-2 mt-2 responded-btn" onclick="orderResponded(<?php echo $order_data['oid']; ?>);" id="orderResBtn<?php echo $order_data['oid']; ?>">Responded?</button>
                                          </td>
                                       <?php

                                       } else if ($order_data["status"] == 2) {

                                       ?>

                                          <td>
                                             <button class="btn-edit btn-edit-manage offset-lg-2 mb-2 mt-2" onclick="orderResponded(<?php echo $order_data['oid']; ?>);" id="orderCanBtn<?php echo $order_data['oid']; ?>">Cancel</button>
                                          </td>

                                       <?php

                                       } else {

                                       ?>
                                          <td>
                                             <button class="btn-edit btn-edit-manage offset-lg-2 mb-2 mt-2 btn-manage-active" onclick="orderResponded(<?php echo $order_data['oid']; ?>);" id="orderActBtn<?php echo $order_data['oid']; ?>">Activate</button>
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

                     </div>

                     <!-- pagination -->
                     <?php
                     if ($order_num == 0) {
                     ?>
                        <div class="col-12 mb-3 d-none">
                        <?php
                     } else {
                        ?>
                           <div class="col-12 mb-5 mt-1">
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
                                          <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span>
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
                                          <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
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

</body>

</html>

<?php
}else{
   header("Location:../index.php");
}
?>