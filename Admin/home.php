<?php

session_start();

if (isset($_SESSION["au"])) {

?>
   <!DOCTYPE html>

   <html>

   <head>

      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width initial-scale=1.0" />
      <link rel="icon" href="../style/resources/cnex.png" />
      <link rel="stylesheet" href="../style/bootstrap.css" />
      <link rel="stylesheet" href="../style/style.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
      <title>Admin | Home</title>

   </head>

   <body>

      <div class="container-fluid">
         <div class="row">

            <?php
            include "sideMenu.php";
            ?>

            <div class="col-12 menu-on menu-off" id="contentA">
               <div class="row">
                  <?php
                  include "header.php";
                  ?>
                  <div class="col-12">
                     <div class="row rowAdH">
                        <div class="col-12">
                           <div class="row">
                              <div class="col-12">
                                 <div class="row">
                                    <div class="col-3">
                                       <input type="date" class="btn-edit btn-purple btn-calender" tabindex="1" value="2023-03-24" />
                                    </div>
                                    <div class="col-3 offset-6 d-none d-lg-block">
                                       <span class="admin-home-titles fs-4 fw-bolder">Recent Updates</span>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-lg-9 col-12">
                                 <div class="row">

                                    <!-- total div -->

                                    <div class="col-4">
                                       <div class="box-edit mt-4">
                                          <div class="row justify-content-center">
                                             <div class="col-12">
                                                <i class="bi bi-grid-1x2-fill fs-2 padding-edit text-primary"></i>
                                             </div>
                                             <div class="col-12">
                                                <p><span class="text-edit fw-bold padding-edit">Total Sales</span></br>
                                                   <span class=" admin-home-titles fw-bolder padding-edit">Rs. 27,726,873</span>
                                                </p>
                                             </div>
                                             <div class="col-10">
                                                <div class="progress">
                                                   <div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 77%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">77%</div>
                                                </div>
                                             </div>
                                             <div class="col-12 mt-4">
                                                <span class="title-edit fw-bold padding-edit" style="font-size: 10px;">Last 24 hours</span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <!-- expenses div -->

                                    <div class="col-4">
                                       <div class="box-edit mt-4">
                                          <div class="row justify-content-center">
                                             <div class="col-12">
                                                <i class="bi bi-bar-chart-line-fill fs-2 padding-edit text-warning"></i>
                                             </div>
                                             <div class="col-12">
                                                <p><span class="text-edit fw-bold padding-edit">Total Expenses</span></br>
                                                   <span class=" admin-home-titles fw-bolder padding-edit">Rs. 12,456,977</span>
                                                </p>
                                             </div>
                                             <div class="col-10">
                                                <div class="progress">
                                                   <div class="progress-bar bg-warning" role="progressbar" aria-label="Example with label" style="width: 69%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">69%</div>
                                                </div>
                                             </div>
                                             <div class="col-12 mt-4">
                                                <span class="title-edit fw-bold padding-edit" style="font-size: 10px;">Last 24 hours</span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <!-- income div -->

                                    <div class="col-4">
                                       <div class="box-edit mt-4">
                                          <div class="row justify-content-center">
                                             <div class="col-12">
                                                <i class="bi bi-graph-up fs-2 padding-edit text-success"></i>
                                             </div>
                                             <div class="col-12">
                                                <p><span class="text-edit fw-bold padding-edit">Total Income</span></br>
                                                   <span class=" admin-home-titles fw-bolder padding-edit">Rs. 15,269,896</span>
                                                </p>
                                             </div>
                                             <div class="col-10">
                                                <div class="progress">
                                                   <div class="progress-bar bg-success" role="progressbar" aria-label="Example with label" style="width: 54%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">54%</div>
                                                </div>
                                             </div>
                                             <div class="col-12 mt-4">
                                                <span class="title-edit fw-bold padding-edit" style="font-size: 10px;">Last 24 hours</span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row">
                                          <div class="col-12 mt-3">
                                             <span class="admin-home-titles fs-3 fw-bolder">Recent Orders</span>
                                          </div>
                                          <?php
                                          $invoice_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `checkout` ON `checkout`.`order_id`=`invoice`.`checkout_order_id`;");
                                          $invoice_num = $invoice_rs->num_rows;
                                          ?>
                                          <div class="col-12">
                                             <div class="box-edit mt-3 mb-3 p-2">
                                                <div class="row">
                                                   <!-- recent orders -->
                                                   <div class="col-12">
                                                      <div class="row justify-content-center">
                                                         <div class="col-3">
                                                            <span class="title-edit" style="font-size: 12px;">Product Name</span>
                                                         </div>
                                                         <div class="col-3">
                                                            <span class="title-edit" style="font-size: 12px;">Product Number</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="title-edit" style="font-size: 12px;">Payment</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="title-edit" style="font-size: 12px;">Status</span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <?php
                                                   for($i = 0;$i < $invoice_num;$i++){
                                                      $invoice_data = $invoice_rs->fetch_assoc();
                                                   ?>
                                                   <div class="col-12">
                                                      <div class="row justify-content-center">
                                                         <div class="col-3">
                                                            <span class="text-edit" style="font-size: 12px;">Apple iPhone 14 Pro</span>
                                                         </div>
                                                         <div class="col-3">
                                                            <span class="text-edit" style="font-size: 12px;">236578</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="text-edit text-succes" style="font-size: 12px;">Paid</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="text-edit text-primary" style="font-size: 12px;">Delivered</span>
                                                         </div>
                                                      </div>

                                                      <div class="row justify-content-center">
                                                         <div class="col-3">
                                                            <span class="text-edit" style="font-size: 12px;">Apple iPhone 12 Pro</span>
                                                         </div>
                                                         <div class="col-3">
                                                            <span class="text-edit" style="font-size: 12px;">226377</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="text-edit text-success" style="font-size: 12px;">Paid</span>
                                                         </div>
                                                         <div class="col-2">
                                                            <span class="text-edit text-warning" style="font-size: 12px;">Pending</span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <?php
                                                   }
                                                   ?>
                                                   <!-- recent orders -->
                                                </div>
                                             </div>
                                          </div>

                                          <div class="col-10 d-block d-lg-none">
                                             <span class="admin-home-titles fs-3 fw-bolder">Recent Updates</span>
                                          </div>

                                          <!-- mobile recent updates -->
                                          <div class="col-6 d-block d-lg-none mb-4">
                                             <div class="box-edit mt-4">
                                                <div class="row justify-content-center">
                                                   <div class="col-10">
                                                      <div class="ruText">
                                                         <span class="fw-bold" style="font-size: 14px;">Damitha</span>
                                                         Recieved his order of
                                                         <span>iPhone 14</span><br />
                                                         <span class="title-edit fw-bold" style="font-size: 10px;">15 minutes ago</span>
                                                      </div>
                                                      <hr />
                                                      <div class="ruText">
                                                         <span class="fw-bold" style="font-size: 14px;">Sahan</span>
                                                         Recieved his order of
                                                         <span>iPhone 12</span><br />
                                                         <span class="title-edit fw-bold" style="font-size: 10px;">37 minutes ago</span>
                                                      </div>
                                                      <hr />
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                 </div>
                              </div>

                              <!-- recent updates -->

                              <div class="col-3 d-none d-lg-block">
                                 <div class="box-edit mt-4">
                                    <div class="row justify-content-center">
                                       <div class="col-10">

                                          <div class="ruText">
                                             <span class="fw-bold" style="font-size: 14px;">Damitha</span>
                                             Recieved his order of
                                             <span class="ruTextTitle">&nbsp;iPhone 14</span><br />
                                             <span class="title-edit fw-bold" style="font-size: 10px;">15 minutes ago</span>
                                          </div>
                                          <hr />
                                          <div class="ruText">
                                             <span class="fw-bold" style="font-size: 14px;">Damitha</span>
                                             Recieved his order of
                                             <span>iPhone 14</span><br />
                                             <span class="title-edit fw-bold" style="font-size: 10px;">15 minutes ago</span>
                                          </div>
                                          <hr />
                                          <div class="ruText">
                                             <span class="fw-bold" style="font-size: 14px;">Damitha</span>
                                             Recieved his order of
                                             <span>iPhone 14</span><br />
                                             <span class="title-edit fw-bold" style="font-size: 10px;">15 minutes ago</span>
                                          </div>
                                          <hr />

                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <!-- recent updates -->
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

      <script src="../Js/script.js"></script>
      <script src="../Js/pathChange.js"></script>

   </body>

   </html>

<?php
} else {
   header("Location:../index.php");
}
?>