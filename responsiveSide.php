<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>

   <div class="a-menu bg-black" id="all-menu">
      <div class="menu-t" onclick="window.location='home.php';">
         <i class="bi bi-speedometer2"></i>
         <label class="menu-t-text">Dashboard</label>
      </div>
      <div class="menu-t" onclick="window.location='myProducts.php';">
         <i class="bi bi-ui-checks-grid"></i>
         <label class="menu-t-text">MyProducts</label>
      </div>
      <div class="menu-t" onclick="window.location='manageUsers.php';">
         <i class="bi bi-person-lines-fill"></i>
         <label class="menu-t-text">Users</label>
      </div>
      <div class="menu-t" onclick="window.location='manageOrders.php';">
         <i class="bi bi-wrench-adjustable-circle"></i>
         <label class="menu-t-text">Orders</label>
      </div>
      <div class="menu-t" onclick="window.location='manageContacts.php';">
         <i class="bi bi-send-fill"></i>
         <label class="menu-t-text">Messages</label>
      </div>
   </div>

   <script src="../Js/pathChange.js"></script>
</body>

</html>