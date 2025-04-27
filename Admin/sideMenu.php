<?php

if (isset($_SESSION["au"])) {

?>
<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>

   <div class="a-menu ab-menu" id="a-menu">
      <div class="menu-i justify-content-end justify-content-center" id="admin-m-icon">
         <i class="bi bi-list fs-4" onclick="changeAdminMenu();"></i>
      </div>
      <div class="menu-t" onclick="window.location='home.php';">
         <i class="bi bi-speedometer2"></i>
         <label class="menu-t-text d-none">Dashboard</label>
      </div>
      <div class="menu-t" onclick="window.location='manageProducts.php';">
         <i class="bi bi-ui-checks-grid"></i>
         <label class="menu-t-text d-none">Products</label>
      </div>
      <div class="menu-t" onclick="window.location='manageUsers.php';">
         <i class="bi bi-person-lines-fill"></i>
         <label class="menu-t-text d-none">Users</label>
      </div>
      <div class="menu-t" onclick="window.location='manageOrders.php';">
         <i class="bi bi-wrench-adjustable-circle"></i>
         <label class="menu-t-text d-none">Orders</label>
      </div>
      <div class="menu-t" onclick="window.location='manageContacts.php';">
         <i class="bi bi-envelope-paper-fill"></i>
         <label class="menu-t-text d-none">Contacts</label>
      </div>
      <div class="menu-t" onclick="window.location='adminChat.php';">
         <i class="bi bi-send-fill"></i>
         <label class="menu-t-text d-none">Messages</label>
      </div>
   </div>

   <script src="../Js/pathChange.js"></script>
</body>

</html>
<?php
}else{
   header("Location:../index.php");
}
?>