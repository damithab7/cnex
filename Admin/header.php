<?php
require "../backend/connection.php";
?>
<!DOCTYPE html>
<html>

<head>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
</head>

<body>

   <nav class="admin-nav">
      <div class="logo" onclick="window.location='home.php';">CneX</div>
      <div class="admin-menu">

      </div>
      <!-- <div class="notify">
        
      </div> -->
      <div class="profile-admin">

         <?php
         $admin_rs = Database::search("SELECT * FROM `admin` WHERE `user_email`='" . $_SESSION["au"]["email"] . "'");
         $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_type` ON `user_type`.`id`=`user`.`user_type_id` WHERE `email`='" . $_SESSION["au"]["email"] . "'");
         $user_data = $user_rs->fetch_assoc();

         if ($admin_rs->num_rows == 0) {
         ?>
            <img src="../style/resources/avatar.svg" class="rounded-circle" width="45px" />
         <?php
         } else {
            $admin_data = $admin_rs->fetch_assoc();
         ?>
            <img src="<?php echo ($admin_data["path"]); ?>" class="header-image" />
         <?php
         }
         ?>

         <div class="dropdown-edit dropdown-profile">
            <span class="delius">
               <?php echo ($_SESSION["au"]["fname"]); ?>
               (<?php echo ($user_data["name"]); ?>)
            </span>
            <div class="dropdown-content-profile dropdown-content-profile-admin">
               <a class="dropdown-item" href="adminProfile.php">Profile &nbsp;<i class="bi bi-person-fill"></i></a>
               <a class="dropdown-item" onclick="adminSignOut();">Sign out &nbsp;<i class="bi bi-box-arrow-right"></i></a>
            </div>
            
         </div>

         <div class="arrd"><i class="bi bi-chevron-down"></i></div>

      </div>
   </nav>

   <script src="../Js/script.js"></script>
   <script src="../Js/bootstrap.bundle.js"></script>
</body>

</html>