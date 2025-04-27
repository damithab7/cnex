<?php

session_start();

if (isset($_SESSION["au"])) {

?>
   <!DOCTYPE html>

   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin | manageContacts</title>
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

                  $contact_rs = Database::search("SELECT * FROM `contact`;");

                  $contact_num = $contact_rs->num_rows;

                  $results_per_page = 5;

                  $page_results = ($pageno - 1) * $results_per_page;

                  $selected_rs = Database::search("SELECT * FROM `contact` LIMIT $results_per_page OFFSET $page_results ");

                  $selected_num = $selected_rs->num_rows;

                  $number_of_pages = ceil($contact_num / $results_per_page);

                  ?>
                  <div class="col-12 manageAdmin">
                     <div class="row">
                        <div class="col-6 offset-3 text-center p-3">
                           <span class="title-edit-lg fs-1 text-blue mont">ManageContacts</span>
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
                                       <th class="tableManageHeader">Name</th>
                                       <th class="tableManageHeader">Message</th>
                                       <th class="tableManageHeader">Date</th>
                                       <th class="tableManageHeader">Time</th>
                                       <th class="tableManageHeader"></th>
                                    </tr>
                                    <?php

                                    for ($x = 1; $x <= $selected_num; $x++) {

                                       $contact_data = $selected_rs->fetch_assoc();

                                       $dd = $contact_data["date"];
                                       $strd = strtotime($dd);
                                       $ndate = date("Y-m-d", $strd);
                                       $ntime = date("H:i A", $strd);

                                    ?>
                                       <tr>
                                          <td><?php echo $x; ?></td>
                                          <td><?php echo $contact_data["user_email"]; ?></td>
                                          <td><?php echo $contact_data["name"]; ?></td>
                                          <td><?php echo $contact_data["message"]; ?></td>
                                          <td><?php echo $ndate; ?></td>
                                          <td><?php echo $ntime; ?></td>
                                          <td>
                                             <button class="btn-edit btn-edit-manage offset-lg-2 mb-2 mt-2" onclick="deleteContactM('<?php echo $contact_data['id']; ?>');" id="contactDeleteBtn'<?php echo $contact_data["id"]; ?>'">Delete</button>
                                          </td>

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
                        if ($contact_num == 0) {
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
} else {
   header("Location:../index.php");
}
?>