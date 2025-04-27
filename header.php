<!DOCTYPE html>
<html lang="en">

<head>
   <link rel="stylesheet" href="style/style.css" />
   <link rel="stylesheet" href="style/dropdown.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
</head>

<body>
   <!-- navbar -->
   <?php
   $c_rs = Database::search("SELECT * FROM `category`;");
   $c2_rs = Database::search("SELECT * FROM `category`;");
   $c2_num = $c2_rs->num_rows;
   $c_num = $c_rs->num_rows;
   ?>

   <div id="main-header" class="main-header sticky">
      <div class="navbar-header nav-down">

         <div class="logo" onclick="window.location = 'home.php';">CneX</div>

         <div class="nav-list">

            <div class="dropdown-edit dropdown-category-sbc">
               
               <div class="dropdown-content-category">
                  <?php
                  for ($c = 0; $c < $c_num; $c++) {
                     $c_data = $c_rs->fetch_assoc();
                  ?>
                     <a class="dropdown-item" href="productView.php?cid=<?php echo ($c_data["id"]); ?>"><?php echo ($c_data["name"]); ?></a>

                  <?php
                  }
                  ?>
               </div>
               <a class="dropdown-toggle h-text">Shop by Category</a>
            </div>

            <div class="dropdown-edit dropdown-collection-h">
               
               <div class="dropdown-content">
                  <?php
                  for ($k = 0; $k < $c2_num; $k++) {
                     $c2_data = $c2_rs->fetch_assoc();
                  ?>
                     <div class="section-dropdown">
                        <input class="dropdown-sub checked-hd" type="checkbox" id="dropdown-sub<?php echo ($c2_data["id"]); ?>" name="dropdown-sub" hidden />
                        <label class="for-dropdown-sub" for="dropdown-sub<?php echo ($c2_data["id"]); ?>"><?php echo ($c2_data["name"]); ?> <i class="bi bi-plus"></i></label>
                        <?php
                        $col_rs = Database::search("SELECT * FROM `collection` WHERE `category_id`='" . $c2_data["id"] . "'");
                        $col_num = $col_rs->num_rows;
                        ?>
                        <div class="section-dropdown-sub">
                           <?php
                           for ($co = 0; $co < $col_num; $co++) {
                              $col_data = $col_rs->fetch_assoc();
                           ?>
                              <a class="dropdown-item-2" href="#"><?php echo ($col_data["name"]); ?> <i class="bi bi-arrow-right"></i></a>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
                  ?>

               </div>
               <a class="dropdown-toggle h-text">Collections</a>
            </div>

            <a href="productView.php" class="about nav-a">Items</a>

            <a href="home.php#homeAbout" class="blog nav-a">About</a>

         </div>

         <?php

         if (!isset($_SESSION["u"])) {

         ?>
            <div onclick="window.location = 'index.php';" class="login">Log In <i class="bi bi-arrow-right"></i></div>
         <?php

         } else {

         ?>

            <div onclick="signOut();" class="login">Log out &nbsp;<i class="bi bi-box-arrow-right"></i></div>

         <?php
         }
         ?>

      </div>
      <div class="grid-row-wrapper" id="header">
         <div class="logo logo-h-2" onclick="window.location = 'home.php';">CneX</div>

         <div class="icons">

            <!-- <input type="text" class="header-s-input list-items-menu" placeholder="Search" /> -->

            <span class="list-items-menu">
               <input type="text" class="header-search-i" placeholder="Search" id="headerSearch" />
               <i class="bi bi-search h-icon search-header" onclick="openSearch();"></i>
            </span>

            <span class="list-items-menu" onclick="window.location = 'cart.php';">
               <i class="bi bi-basket2-fill h-icon"> Cart</i>
            </span>

            <?php

            if (isset($_SESSION["u"])) {

               $user_type_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["u"]["email"] . "'");
               $user_type_num = $user_type_rs->num_rows;

            ?>

               <div class="dropdown-edit dropdown-profile">
                 
                  <div class="dropdown-content-profile">
                     <a class="dropdown-item" href="userProfile.php">Account</a>
                     <?php
                     if ($user_type_num == 1) {
                     ?>
                        <a class="dropdown-item" href="myProducts.php">myProducts</a>
                     <?php
                     }
                     ?>
                     <a class="dropdown-item" href="purchaseHistory.php">purchaseHistory</a>
                     <a class="dropdown-item" href="#">Reviews <i class="bi bi-stars"></i></a>
                     <a class="dropdown-item" href="userMessage.php">Message <i class="bi bi-send-fill"></i></a>
                  </div>

                  <i class="bi bi-person-fill h-icon" aria-expanded="false"> Profile</i>

               </div>



            <?php

            }

            if (isset($_SESSION["u"])) {

               $wishlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");

               $watchlist_num = $wishlist_rs->num_rows;

            ?>

               <span class="list-items-menu" onclick="window.location = 'wishlist.php';">
                  <i class="bi bi-suit-heart-fill h-icon"> Wishlist (<?php echo ($watchlist_num); ?>)</i>
               </span>
            <?php
            } else {
            ?>
               <span class="list-items-menu" onclick="window.location = 'wishlist.php';">
                  <i class="bi bi-suit-heart-fill h-icon"> Wishlist (0)</i>
               </span>
            <?php
            }
            ?>

            <span class="list-menu">
               <i class="bi bi-list h-icon h-menu-icon" onclick="changeAllMenu();"></i>
            </span>

         </div>
      </div>
   </div>

   <!-- navbar -->
   <!-- intro -->

   <div class="all-cover"></div>

   <div class="all-menu bg-lightblue" id="all-menu">
      <div class="menu-all">
         <i class="bi bi-list h-icon h-menu-icon" onclick="changeAllMenu();"></i>
      </div>
      <div class="menu-t" onclick="window.location='home.php';">
         <i class="bi bi-speedometer2"></i>
         <label class="menu-t-text">Dashboard</label>
      </div>
      <div class="menu-t" onclick="window.location='cart.php';">
         <i class="bi bi-cart-fill"></i>
         <label class="menu-t-text">Cart</label>
      </div>
      <div class="menu-t" onclick="window.location='wishlist.php';">
         <i class="bi bi-heart-fill"></i>
         <label class="menu-t-text">Wishlist</label>
      </div>
      <div class="menu-t" onclick="window.location='myProducts.php';">
         <i class="bi bi-stars"></i>
         <label class="menu-t-text">myProducts</label>
      </div>
      <div class="menu-t" onclick="window.location='userMessage.php';">
         <i class="bi bi-send-fill"></i>
         <label class="menu-t-text">Messages</label>
      </div>
   </div>
   <!-- intro -->

   <script src="Js/bootstrap.bundle.js"></script>
   <script src="Js/script.js"></script>
   <script src="Js/pathChange.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script src="Js/JQuery.js"></script>

</body>

</html>