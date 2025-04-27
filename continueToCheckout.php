<?php

session_start();

require "backend/connection.php";

if (isset($_SESSION["u"])) {

    header("Location:shipping.php");
    
} else {
?>
    <!DOCTYPE html>

    <html>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CneX | Checkout</title>
        <link rel="icon" href="style/resources/cnex.png" />
        <link rel="stylesheet" href="style/bootstrap.css" />
        <link rel="stylesheet" href="style/style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row bg-light">
                <?php

                include "header.php";

                ?>

                <div class="col-12 p-5">
                    <div class="row justify-content-center gap-4">

                        <div class="col-12 text-center mt-4 mb-4">
                            <span class="text-title text-checkout">Continue to checkout</span>
                        </div>

                        <div class="col-lg-4 col-12 sign-in-checkout mb-4">
                            <div class="row p-3">

                                <div class="col-12" id="signInContent">
                                    <div class="row justify-content-center">

                                        <div class="col-12 text-start mb-2 mt-2">
                                            <span class="index-span checkout-span">Already A memeber ? Sign In</span>
                                        </div>

                                        <?php

                                        $email = "";
                                        $password = "";

                                        if (isset($_COOKIE["cemail"])) {
                                            $email = $_COOKIE["cemail"];
                                        }

                                        if (isset($_COOKIE["cpassword"])) {
                                            $password = $_COOKIE["cpassword"];
                                        }

                                        ?>

                                        <div class="col-12 mt-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control control-edit" id="checkoutEmail1" placeholder="Email" value="<?php echo $email; ?>" />
                                                <label for="checkoutEmail1" class="floating-edit">Email</label>
                                                <div class="valid-feedback was-validated">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="input-group">

                                                <div class="form-floating">
                                                    <input type="password" class="form-control control-edit" id="checkoutPassword" placeholder="Password" value="<?php echo $password; ?>" />
                                                    <label for="checkoutPassword" class="floating-edit">Password</label>
                                                </div>
                                                <span class="input-group-text btn-purple btn-ps" onclick="changeCheckoutPs();"><i class="bi bi-eye-fill" id="checkEye"></i></span>

                                            </div>
                                        </div>

                                        <div class="col-6 text-start mt-2">
                                            <input type="checkbox" value="1" class="form-check-input check-edit" id="rememberme1" />
                                            <label for="rememberme1" class="forgot-p remember-me">&nbsp; Remember me</label>
                                        </div>

                                        <div class="col-6 text-end mt-2">
                                            <a href="#" class="forgot-p">Forgot password?</a>
                                        </div>

                                        <div class="col-12 d-grid mt-3 mb-2">
                                            <button class="btn-purple btn-improved btn-checkout" type="button" onclick="signInCheckout();" id="signInButton">SIGN IN</button>
                                        </div>

                                        <div class="col-12 text-center mt-2 mb-5">
                                            <p style="color: rgb(177,177,177); font-weight: 400;">Don't have an account? <a class="sign-i" onclick="changeRegister();">Sign Up</a></p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 d-none" id="signUpContent">
                                    <div class="row justify-content-center">

                                        <div class="col-12 text-start">
                                            <span class="index-span checkout-span">Register</span>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control control-edit" id="rFname" placeholder="First Name" />
                                                <label for="rFname" class="floating-edit">First name</label>
                                            </div>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control control-edit" id="rLname" placeholder="Last Name" />
                                                <label for="rLname" class="floating-edit">Last name</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control control-edit" id="rEmail" placeholder="Email" />
                                                <label for="rEmail" class="floating-edit">Email</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="input-group">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control control-edit" id="rPassword" placeholder="Password" />
                                                    <label for="rPassword" class="floating-edit">Password</label>
                                                </div>
                                                <span class="input-group-text btn-purple btn-ps" onclick="changePs();"><i class="bi bi-eye-fill" id="rPseye"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="input-group">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control control-edit" id="rRePassword" placeholder="Re-type password" />
                                                    <label for="rRePassword" class="floating-edit">Re-type password</label>
                                                </div>
                                                <span class="input-group-text btn-purple btn-ps" onclick="changeRtypePs();"><i class="bi bi-eye-fill" id="rRePseye"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="input-group">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control control-edit" id="vcode" placeholder="Verification Code" />
                                                    <label for="vcode" class="floating-edit">Verification Code</label>
                                                </div>

                                                <span class="input-group-text btn-purple btn-ps btn-improved" onclick="sendVCode();">Send Code</span>
                                            </div>
                                        </div>

                                        <div class="col-12 d-grid mt-3 mb-2">
                                            <button type="button" class="btn-purple btn-improved btn-improved btn-checkout" onclick="userRegister();">REGISTER</button>
                                        </div>

                                        <div class="col-12 text-center mt-2 mb-5">
                                            <p style="color: rgb(177,177,177); font-weight: 400;">Already have an account? <a class="sign-i" onclick="changeRegister();">Sign In</a></p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="row">
                                <div class="col-12 sign-in-checkout" id="checkoutSingup">
                                    <div class="row justify-content-center">

                                        <div class="col-12 text-start mb-2 mt-4">
                                            <span class="index-span checkout-span">Checkout As a guest</span>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control control-edit" id="guestCheckoutEmail" placeholder="Email" value="<?php echo $email; ?>" />
                                                <label for="guestCheckoutEmail" class="floating-edit">Email</label>
                                                <div class="valid-feedback was-validated">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-grid mt-3 mb-4">
                                            <button class="btn-purple btn-improved btn-checkout" type="button" onclick="guestIn();" id="signInButton">GUEST CHECKOUT</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <script src="Js/script.js"></script>
        <script src="Js/bootstrap.bundle.js"></script>
        <script src="Js/pathChange.js"></script>
    </body>

    </html>
<?php
}
?>