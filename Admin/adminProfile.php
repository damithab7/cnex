<?php

session_start();

if (isset($_SESSION["au"])) {

   require "../backend/connection.php";

   $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["au"]["email"] . "'");
   $user_data = $user_rs->fetch_assoc();

   $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id INNER JOIN `district` ON city.district_id=district.id INNER JOIN `province` ON province.id = district.province_id WHERE `user_email`='" . $user_data["email"] . "'");

?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>CneX | Profile</title>
      <link rel="icon" href="../style/resources/cnex.png" />
      <link rel="stylesheet" href="../style/bootstrap.css" />
      <link rel="stylesheet" href="../style/style.css" />
   </head>

   <body>
      <div class="container-fluid">
         <div class="row justify-content-center">

            <div class="col-12">
               <div class="row justify-content-center p-2" style="background-color: rgb(247, 247, 247);">
                  <div class="logo logo-hw mt-1 mb-1" onclick="window.location = 'home.php';">CneX</div>
               </div>
            </div>

            <div class="col-12">
               <div class="row justify-content-center gap-3">

                  <div class="col-3 col-lg-2 mt-4">
                     <div class="row justify-content-center">
                        <nav id="navbar-example2" class="navbar nav-bar-profile mb-3">
                           <ul class="nav nav-pills gap-2 justify-content-center">
                              <li class="nav-item">
                                 <a class="nav-link singleCL active" id="accountLink" onclick="changeAccount();">Account</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link singleCL" id="addressLink" onclick="changeAddress();">Address</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link singleCL" id="securityLink" onclick="changeSecurity();">Security</a>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>

                  <div class="col-8 mt-4">
                     <div class="row justify-content-center">

                        <div class="col-12 profile-div mb-2">
                           <div class="row align-items-center justify-content-center">
                              <div class="avatar-upload">
                                 <div class="avatar-edit">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" class="d-none" onclick="changeProfileImage();" />
                                    <label for="imageUpload" class="adminImageLabel"></label>
                                 </div>
                                 <div class="avatar-preview selectDisable">
                                    <?php
                                    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `user_email`='" . $_SESSION["au"]["email"] . "'");
                                    if ($admin_rs->num_rows == 0) {
                                    ?>
                                       <img src="../style/resources/avatar.svg" class="profile_image selectDisable" id="imagePreview" />
                                    <?php
                                    } else {
                                       $admin_data = $admin_rs->fetch_assoc();
                                    ?>
                                       <img src="<?php echo ($admin_data["path"]); ?>" class="profile_image" id="imagePreview" />
                                    <?php
                                    }
                                    ?>
                                 </div>
                                 <div class="col-12 d-grid position-absolute d-none mt-1" id="imageSave">
                                    <button class="btn-edit btn-purple-v2" onclick="saveImagePath();">Save Image</button>
                                 </div>

                              </div>
                              <div class="col-12 col-lg-6 text-lg-start text-center mb-3">
                                 <span class="delius fw-semibold p-p"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></span></br>
                                 <span class="p-p mont">Memeber Since</br>
                                    <?php
                                    $rdate = $user_data["registered_date"];
                                    $date = explode(" ", $rdate);
                                    ?>
                                    <span><?php echo $date[0]; ?></span>
                                 </span>
                              </div>
                           </div>

                        </div>

                        <div class="col-12 profile-div mt-4 mb-4">
                           <div class="row">
                              <div class="col-12">
                                 <div class="row justify-content-center">
                                    <div class="col-12" id="accountDiv">
                                       <div class="row g-3 justify-content-center">
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">First Name</label>
                                             <input type="text" class="form-control form-control-edit" value="<?php echo $user_data["fname"]; ?>" id="pfname" />
                                          </div>
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">Last Name</label>
                                             <input type="text" class="form-control form-control-edit" value="<?php echo $user_data["lname"]; ?>" id="plname" />
                                          </div>
                                          <div class="col-12 col-lg-10">
                                             <label class="form-lable pfm mb-2">Email</label>
                                             <input type="email" class="form-control form-control-edit" disabled value="<?php echo $user_data["email"]; ?>" />
                                          </div>
                                          <div class="col-lg-5 d-none d-lg-block mb-3"></div>
                                          <div class="col-lg-5 col-12 d-grid mb-3">
                                             <button class="btn-purple" onclick="adminChangeProfileAccount();">Save Changes</button>
                                          </div>
                                       </div>
                                    </div>

                                    <?php
                                    $city_rs = Database::search("SELECT * FROM `city`");
                                    $district_rs = Database::search("SELECT * FROM `district`");
                                    $province_rs = Database::search("SELECT * FROM `province`");

                                    $city_num = $city_rs->num_rows;
                                    $district_num = $district_rs->num_rows;
                                    $province_num = $province_rs->num_rows;

                                    $user_address_rs = Database::search("SELECT *,city.id AS cid,district.id AS did,province.id AS pid FROM `user_has_address` INNER JOIN `city` ON city.id=user_has_address.city_id INNER JOIN `district` ON district.id=city.district_id INNER JOIN `province` ON district.province_id=province.id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                                    $user_address_num = $user_address_rs->num_rows;
                                    $user_address_data = $user_address_rs->fetch_assoc();

                                    ?>

                                    <div class="col-12 d-none" id="addressDiv">
                                       <div class="row g-3 justify-content-center">
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">City</label>
                                             <select class="form-select profile-select" id="city">
                                                <option value="0">City</option>
                                                <?php
                                                for ($c = 0; $c < $city_num; $c++) {
                                                   $city_data = $city_rs->fetch_assoc();

                                                   if (!empty($user_address_data["city_id"])) {
                                                ?>
                                                      <option value="<?php echo ($city_data["id"]); ?>" <?php
                                                                                                         if ($city_data["id"] == $user_address_data["city_id"]) {
                                                                                                         ?>selected <?php
                                                                                                               }
                                                                                                                  ?>>
                                                         <?php echo ($city_data["cname"]); ?>
                                                      </option>
                                                   <?php
                                                   } else {
                                                   ?>
                                                      <option value="<?php echo ($city_data["id"]); ?>"><?php echo ($city_data["cname"]); ?></option>
                                                <?php
                                                   }
                                                }
                                                ?>
                                             </select>
                                          </div>
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">District</label>
                                             <select class="form-select profile-select">
                                                <option value="0">District</option>
                                                <?php
                                                for ($d = 0; $d < $district_num; $d++) {
                                                   $district_data = $district_rs->fetch_assoc();

                                                   if (!empty($user_address_data["city_id"])) {
                                                ?>
                                                      <option value="<?php echo ($district_data["id"]); ?>" <?php
                                                                                                            if ($user_address_data["did"] == $district_data["id"]) {
                                                                                                            ?>selected <?php
                                                                                                                  }
                                                                                                                     ?>>
                                                         <?php echo ($district_data["dname"]); ?>
                                                      </option>
                                                   <?php
                                                   } else {
                                                   ?>
                                                      <option value="<?php echo ($district_data["id"]); ?>"><?php echo ($district_data["dname"]); ?></option>
                                                <?php
                                                   }
                                                }
                                                ?>
                                             </select>
                                          </div>
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">Province</label>
                                             <select class="form-select profile-select">
                                                <option value="0">Province</option>
                                                <?php
                                                for ($p = 0; $p < $province_num; $p++) {
                                                   $province_data = $province_rs->fetch_assoc();
                                                   if (!empty($user_address_data["city_id"])) {
                                                ?>
                                                      <option value="<?php echo ($district_data["id"]); ?>" <?php
                                                                                                            if ($user_address_data["pid"] == $province_data["id"]) {
                                                                                                            ?>selected <?php
                                                                                                                  }
                                                                                                                     ?>>
                                                         <?php echo ($province_data["pname"]); ?>
                                                      </option>
                                                   <?php
                                                   } else {
                                                   ?>
                                                      <option value="<?php echo ($province_data["id"]); ?>"><?php echo ($province_data["pname"]); ?></option>
                                                <?php
                                                   }
                                                }
                                                ?>
                                             </select>
                                          </div>
                                          <?php
                                          if ($user_address_num == 1) {
                                             if (!empty($user_address_data["postal"])) {
                                          ?>
                                                <div class="col-6 col-lg-5">
                                                   <label class="form-lable pfm mb-2">Postal Code</label>
                                                   <input type="text" class="form-control form-control-edit" id="postCode" value="<?php echo ($user_address_data['postal']); ?>" />
                                                </div>
                                             <?php
                                             } else {
                                             ?>
                                                <div class="col-6 col-lg-5">
                                                   <label class="form-lable pfm mb-2">Postal Code</label>
                                                   <input type="text" class="form-control form-control-edit" id="postCode" />
                                                </div>
                                             <?php
                                             }

                                             if (!empty($user_address_data["line1"])) {
                                             ?>
                                                <div class="col-12 col-lg-10">
                                                   <label class="form-lable pfm mb-2">Line 1</label>
                                                   <input type="text" class="form-control form-control-edit" id="line1" value="<?php echo ($user_address_data['line1']); ?>" />
                                                </div>
                                             <?php
                                             } else {
                                             ?>
                                                <div class="col-12 col-lg-10">
                                                   <label class="form-lable pfm mb-2">Line 1</label>
                                                   <input type="text" class="form-control form-control-edit" id="line1" />
                                                </div>
                                             <?php
                                             }
                                             if (!empty($user_address_data["line2"])) {
                                             ?>
                                                <div class="col-12 col-lg-10">
                                                   <label class="form-lable pfm mb-2">Line 2</label>
                                                   <input type="text" class="form-control form-control-edit" id="line2" value="<?php echo ($user_address_data['line2']); ?>" />
                                                </div>
                                             <?php
                                             } else {
                                             ?>
                                                <div class="col-12 col-lg-10">
                                                   <label class="form-lable pfm mb-2">Line 2</label>
                                                   <input type="text" class="form-control form-control-edit" id="line2" />
                                                </div>
                                             <?php
                                             }
                                          } else {
                                             ?>
                                             <div class="col-6 col-lg-5">
                                                <label class="form-lable pfm mb-2">Postal Code</label>
                                                <input type="text" class="form-control form-control-edit" id="postCode" />
                                             </div>
                                             <div class="col-12 col-lg-10">
                                                <label class="form-lable pfm mb-2">Line 1</label>
                                                <input type="text" class="form-control form-control-edit" id="line1" />
                                             </div>
                                             <div class="col-12 col-lg-10">
                                                <label class="form-lable mb-2">Line 2</label>
                                                <input type="text" class="form-control form-control-edit" id="line2" />
                                             </div>
                                          <?php
                                          }
                                          ?>
                                          <div class="col-6 col-lg-5"></div>
                                          <div class="col-6 col-lg-5">
                                             <label class="form-lable pfm mb-2">Mobile</label>
                                             <input type="text" class="form-control form-control-edit" value="<?php echo $user_data["mobile"]; ?>" id="mobile" />
                                          </div>
                                          <div class="col-lg-5 d-none d-lg-block mb-3 mb-3"></div>
                                          <div class="col-lg-5 col-12 d-grid mb-3 mb-3">
                                             <button class="btn-purple" onclick="adminSaveAddresss();">Save Changes</button>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-12 d-none" id="profileSecurity">
                                       <div class="row gap-3 justify-content-center">
                                          <div class="col-12 col-lg-10">
                                             <label class="form-lable pfm mb-2">Old Password</label>
                                             <input type="password" class="form-control form-control-edit" id="o_password" />
                                          </div>
                                          <div class="col-12 col-lg-10">
                                             <label class="form-lable pfm mb-2">New Password</label>
                                             <input type="password" class="form-control form-control-edit" id="n_password" />
                                          </div>
                                          <div class="col-lg-4 col-6 d-grid mb-4">
                                             <button class="btn-purple" onclick="adminChangePassword();">change</button>
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
            </div>
         </div>

      </div>

      <script src="../Js/script.js"></script>
      <script src="../Js/pathChange.js"></script>

   </body>

   </html>

<?php
} else {
   header("Location:home.php");
}
?>