<?php

session_start();

if (isset($_SESSION["u"])) {
   header("Location:home.php");
} else {

?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="icon" href="style/resources/cnex.png" style="width: 100px;" />
      <title>CneX</title>
      <link rel="stylesheet" href="style/bootstrap.css" />
      <link rel="stylesheet" href="style/style.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
   </head>

   <body>

      <div class="container-fluid">
         <div class="row">

            <div class="col-12">
               <div class="row min-vh-100">

                  <div class="carousel slide col-6 d-none d-lg-block" style="padding: 0;" data-bs-ride="carousel">
                     <div class="carousel-inner carousel-inner-index">
                        <div class="carousel-item active carousel-item-index" data-bs-interval="4000">
                           <div class="index-images front-image1"></div>
                        </div>
                        <div class="carousel-item">
                           <div class="index-images front-image2"></div>
                        </div>
                        <div class="carousel-item">
                           <div class="index-images front-image3"></div>
                        </div>
                     </div>
                  </div>

                  <div class="col-12 col-lg-6 align-items-center d-flex">
                     <div class="row justify-content-center">
                        <div class="logo mb-5">CneX</div>

                        <div class="col-11 mb-3 text-center">
                           <nav id="navbar-example2" class="navbar px-1 mb-2 mt-2 justify-content-center">
                              <ul class="nav home-nav">

                                 <li class="nav-item home-nav-item">
                                    <a class="nav-link singleCL active-navh" id="indexSI" onclick="changeSi();">Sign In</a>
                                 </li>
                                 <li class="nav-item home-nav-item">
                                    <a class="nav-link singleCL" id="indexRI" onclick="changeRegister();">Create an Account</a>
                                 </li>

                              </ul>
                           </nav>

                           <div class="row">
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

                                    <div class="col-lg-10 col-11 col-md-8 mt-3">
                                       <div class="form-floating text-start">
                                          <input type="email" class="form-control control-edit" id="signInEmail" placeholder="Email" value="<?php echo $email; ?>" />
                                          <label for="signInEmail" class="floating-edit">Email</label>
                                          <div class="invalid-feedback" id="signIEf"></div>
                                       </div>
                                    </div>
                                    <div class="col-lg-10 col-11 col-md-8 mt-3">
                                       <div class="input-group">

                                          <div class="form-floating text-start">
                                             <input type="password" class="form-control control-edit" id="signInPassword" placeholder="Password" value="<?php echo $password ?>" />
                                             <label for="signInPassword" class="floating-edit">Password</label>
                                             <div class="invalid-feedback" id="signIPf"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps" onclick="changePsL();"><i class="bi bi-eye-fill" id="rLPseye"></i></span>

                                       </div>
                                    </div>
                                    <div class="col-lg-10 col-11 col-md-8">
                                       <div class="row">
                                          <div class="col-6 text-start mt-2">
                                             <div class="form-check">
                                                <input type="checkbox" value="1" class="form-check-input check-edit" id="rememberme" />
                                                <label for="rememberme" class="form-check-label forgot-p remember-me"> Remember me</label>
                                             </div>
                                          </div>
                                          <div class="col-6 text-end mt-2">
                                             <a href="#" class="forgot-p" onclick="changeForP();">Forgot password?</a>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="d-grid mt-3 mb-2 col-lg-10 col-11 col-md-8">
                                       <button class="btn-edit fw-normal cart-check-btn btn-invoice" onclick="signIn();"><span class="cartspanc">Sign In</span></button>
                                    </div>

                                 </div>
                              </div>

                              <div class="col-12 d-none" id="signUpContent">
                                 <div class="row justify-content-center">

                                    <div class="col-11  mt-3 col-md-8 col-lg-10">
                                       <div class="row">
                                          <div class="col-6">
                                             <div class="form-floating text-start">
                                                <input type="text" class="form-control control-edit" id="rFname" placeholder="First Name" />
                                                <label for="rFname" class="floating-edit">First name</label>
                                                <div class="invalid-feedback" id="registerFN"></div>
                                             </div>
                                          </div>
                                          <div class="col-6">
                                             <div class="form-floating text-start">
                                                <input type="text" class="form-control control-edit" id="rLname" placeholder="Last Name" />
                                                <label for="rLname" class="floating-edit">Last name</label>
                                                <div class="invalid-feedback" id="registerLN"></div>
                                             </div>
                                          </div>
                                       </div>

                                    </div>

                                    <div class="col-11 mt-3 col-md-8 col-lg-10">
                                       <div class="form-floating text-start">
                                          <input type="email" class="form-control control-edit" id="rEmail" placeholder="Email" />
                                          <label for="rEmail" class="floating-edit">Email</label>
                                          <div class="invalid-feedback" id="registerEmail"></div>
                                       </div>
                                    </div>
                                    <div class="col-11 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="password" class="form-control control-edit" id="rPassword" placeholder="Password" />
                                             <label for="rPassword" class="floating-edit">Password</label>
                                             <div class="invalid-feedback" id="registerPassword"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps" onclick="changePs();"><i class="bi bi-eye-fill" id="rPseye"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-11 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="password" class="form-control control-edit" id="rRePassword" placeholder="Re-type password" />
                                             <label for="rRePassword" class="floating-edit">Re-type password</label>
                                             <div class="invalid-feedback" id="registerRePassword"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps" onclick="changeRtypePs();"><i class="bi bi-eye-fill" id="rRePseye"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-11 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="text" class="form-control control-edit" id="vcode" placeholder="Verification Code" />
                                             <label for="vcode" class="floating-edit">Verification Code</label>
                                             <div class="invalid-feedback" id="registerVcode"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps btn-improved" onclick="sendVCode();">Send Code</span>

                                       </div>
                                    </div>
                                    <div class="col-11 mt-3 col-md-8 col-lg-10">
                                       <div class="form-floating text-start">
                                          <input type="text" class="form-control control-edit" id="mobile" placeholder="Mobile" />
                                          <label for="mobile" class="floating-edit">Mobile</label>
                                          <div class="invalid-feedback" id="registerMobile"></div>
                                       </div>
                                    </div>

                                    <div class="d-grid mt-3 mb-2 col-md-8 col-lg-10 col-11">
                                       <button class="btn-edit fw-normal cart-check-btn btn-invoice" onclick="userRegister();"><span class="cartspanc">Create Account</span></button>
                                    </div>

                                 </div>
                              </div>

                              <div class="col-12 d-none" id="forgotPContent">
                                 <div class="row justify-content-center">

                                    <div class="col-10 mt-3 col-md-8 col-lg-10">
                                       <div class="form-floating text-start">
                                          <input type="email" class="form-control control-edit" id="fpEmail" placeholder="Email" />
                                          <label for="fpEmail" class="floating-edit">Email</label>
                                          <div class="invalid-feedback" id="fpEmail"></div>
                                       </div>
                                    </div>
                                    <div class="col-10 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="password" class="form-control control-edit" id="fpPassword" placeholder="Password" />
                                             <label for="fpPassword" class="floating-edit">Password</label>
                                             <div class="invalid-feedback" id="fpPassword"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps" onclick="changePs();"><i class="bi bi-eye-fill" id="rPseye"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-10 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="password" class="form-control control-edit" id="fpRePassword" placeholder="Re-type password" />
                                             <label for="fpRePassword" class="floating-edit">Re-type password</label>
                                             <div class="invalid-feedback" id="fpRePassword"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps" onclick="changeRtypePs();"><i class="bi bi-eye-fill" id="rRePseye"></i></span>
                                       </div>
                                    </div>

                                    <div class="col-10 mt-3 col-md-8 col-lg-10">
                                       <div class="input-group">
                                          <div class="form-floating text-start">
                                             <input type="text" class="form-control control-edit" id="vcode" placeholder="Verification Code" />
                                             <label for="vcode" class="floating-edit">Verification Code</label>
                                             <div class="invalid-feedback" id="fpVcode"></div>
                                          </div>
                                          <span class="input-group-text btn-purple btn-ps btn-improved" onclick="sendVCode();">Send Code</span>
                                       </div>
                                    </div>

                                    <div class="col-10 d-grid mt-3 mb-2 col-md-7 col-lg-10">
                                       <button type="button" class="btn-purple btn-improved" onclick="userForgotPassword();">Reset Password</button>
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

      <div class="modal fade" id="signInUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signInUpModal" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black" style="border-radius: 0px;">

               <div class="modal-header" style="border-bottom: none;">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>

               <div class="modal-body text-center">
                  <p class="mont fs-3 text-light" id="indexSiuMessage"></p>
               </div>

               <div class="modal-footer" style="border-top: none;">
                  <button type="button" class="btn-edit btn-purple-v2" data-bs-dismiss="modal" id="signInUpbtn">Close</button>
               </div>

            </div>
         </div>
      </div>

      <script src="Js/bootstrap.bundle.js"></script>
      <script src="Js/script.js"></script>
      <script src="Js/events.js"></script>
      <script src="Js/pathChange.js"></script>

   </body>

   </html>
<?php
}
?>