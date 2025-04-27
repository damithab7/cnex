<?php

session_start();

if (isset($_SESSION["au"])) {

?>
<!DOCTYPE html>

<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | manageUsers</title>
   <link rel="stylesheet" href="../style/bootstrap.css" />
   <link rel="stylesheet" href="../style/style.css" />
   <link rel="icon" href="../style/resources/cnex.png" />
</head>

<body>
   <div class="container-fluid">
      <div class="row">

         <?php

         $pageno;

         if (isset($_GET["page"])) {
            $pageno = $_GET["page"];
         } else {
            $pageno = 1;
         }

         include "sideMenu.php";

         ?>

         <div class="col-12 menu-on menu-off" id="contentA">
            <div class="row">
               <?php
               include "header.php";

               $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_type` ON `user`.`user_type_id`=`user_type`.`id`");

               $user_num = $user_rs->num_rows;

               $results_per_page = 5;

               $page_results = ($pageno - 1) * $results_per_page;

               $selected_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_type` ON `user`.`user_type_id`=`user_type`.`id` LIMIT $results_per_page OFFSET $page_results ");

               $selected_num = $selected_rs->num_rows;

               $number_of_pages = ceil($user_num / $results_per_page);

               ?>
               <div class="col-12 manageAdmin">
                  <div class="row">
                     <div class="col-6 offset-3 text-center p-3">
                        <span class="title-edit-lg fs-1 text-blue mont">ManageUsers</span>
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
                                    <th class="tableManageHeader">#</th>
                                    <th class="tableManageHeader">Email</th>
                                    <th class="tableManageHeader">Registered Date</th>
                                    <th class="tableManageHeader">Mobile</th>
                                    <th class="tableManageHeader">Name</th>
                                    <th class="tableManageHeader">Type</th>
                                    <th class="tableManageHeader">City</th>
                                    <th class="tableManageHeader">Address Line</th>
                                    <th class="tableManageHeader">Status</th>
                                 </tr>
                                 <?php

                                 for ($x = 1; $x <= $selected_num; $x++) {

                                    $user_data = $selected_rs->fetch_assoc();

                                    $user_address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` WHERE `user_email`='" . $user_data["email"] . "' ;");

                                 ?>
                                    <tr>
                                       <td><?php echo $x; ?></td>
                                       <td><?php echo $user_data["email"]; ?></td>
                                       <td><?php echo $user_data["registered_date"]; ?></td>
                                       <td>
                                          <?php
                                          if (empty($user_data["mobile"])) {
                                          ?>
                                             -

                                          <?php
                                          } else {
                                          ?>
                                             <?php echo $user_data["mobile"]; ?>

                                          <?php
                                          }
                                          ?>
                                       </td>
                                       <td>
                                          <?php echo $user_data["fname"] . " " . $user_data["lname"]; ?>
                                       </td>
                                       <td><?php echo $user_data["name"]; ?></td>
                                       <?php
                                       if ($user_address_rs->num_rows == 0) {
                                       ?>
                                          <td></td>
                                          <td></td>
                                       <?php
                                       } else {

                                          $user_address_data = $user_address_rs->fetch_assoc();
                                       ?>
                                          <td><?php echo $user_address_data["cname"]; ?></td>
                                          <td><?php echo $user_address_data["line1"]; ?></td>

                                       <?php
                                       }
                                       if ($user_data["status"] == 1) {

                                       ?>
                                          <td>
                                             <button class="btn-edit btn-edit-manage offset-lg-2 mb-2 mt-2" onclick="userStatus('<?php echo $user_data['email']; ?>');" id="userBlockbtn'<?php echo $user_data["email"]; ?>'">Block</button>
                                          </td>
                                       <?php

                                       } else {

                                       ?>
                                          <td>
                                             <button class="btn-edit offset-lg-2 mb-2 mt-2 btn-manage-active" onclick="userStatus('<?php echo $user_data['email']; ?>');" id="userActBtn'<?php echo $user_data["email"]; ?>'">Activate</button>
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
                     if ($user_num == 0) {
                     ?>
                        <div class="col-12 mb-3 d-none">
                        <?php
                     } else {
                        ?>
                           <div class="col-12 mb-5 mt-4">
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
                                       <a class="page-link page-l-edit" href="<?php

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
   <script src="../Js/script.js"></script>
</body>

</html>

<?php
}else{
   header("Location:../index.php");
}
?>