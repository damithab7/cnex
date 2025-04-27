<!DOCTYPE html>

<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>CneX | Admin</title>
   <link rel="icon" href="../style/resources/cnex.png" />
   <link rel="stylesheet" href="../style/bootstrap.css" />
   <link rel="stylesheet" href="../style/style.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="row min-vh-100 justify-content-center">

               <div class="col-12 col-lg-6 align-items-center d-flex">

                  <div class="row justify-content-center">

                     <div class="logo mb-5">Admin</div>
                     <div class="col-12" id="signInContent">
                        <div class="row justify-content-center">

                           <?php

                           $email = "";
                           $password = "";

                           if (isset($_COOKIE["email"])) {
                              $email = $_COOKIE["email"];
                           }

                           if (isset($_COOKIE["password"])) {
                              $password = $_COOKIE["password"];
                           }

                           ?>
                           <div class="col-10 mt-3">
                              <div class="form-floating">
                                 <input type="email" class="form-control control-edit" id="adminSignInEmail" placeholder="Email" value="<?php echo $email; ?>" />
                                 <label for="adminSignInEmail" class="floating-edit">Email</label>
                                 <div class="invalid-feedback" id="adminSe"></div>
                              </div>
                           </div>
                           <div class="col-10 mt-3">
                              <div class="input-group">

                                 <div class="form-floating">
                                    <input type="password" class="form-control control-edit" id="adminSignInPassword" placeholder="Password" value="<?php echo $password ?>" />
                                    <label for="adminSignInPassword" class="floating-edit">Password</label>
                                    <div class="invalid-feedback" id="adminSp"></div>
                                 </div>
                                 <span class="input-group-text btn-purple btn-ps" onclick="changeAdminPs();"><i class="bi bi-eye-fill" id="adminPsEye"></i></span>

                              </div>
                           </div>
                           <div class="col-5 text-start col-md-5 col-lg-5 mt-2">
                              <div class="form-check">
                                 <input type="checkbox" value="1" class="form-check-input check-edit" id="rememberme" />
                                 <label for="rememberme" class="form-check-label forgot-p remember-me"> Remember me</label>
                              </div>
                           </div>
                           <div class="col-5 text-end col-md-5 col-lg-5 mt-2">
                              <a href="#" class="forgot-p">Forgot password?</a>
                           </div>
                           <div class="col-10 d-grid mt-3 mb-2 col-md-7 col-lg-10">
                              <button class="btn-purple btn-improved" type="button" onclick="adminSignIn();" id="signInButton">Sign In</button>
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