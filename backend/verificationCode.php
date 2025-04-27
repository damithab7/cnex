<?php

session_start();

require "connection.php";

require "phpMailer/SMTP.php";
require "phpMailer/PHPMailer.php";
require "phpMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$json = $_POST["json"];

$phpObj = json_decode($json);

$code = $phpObj->vcode;
$email = $phpObj->email;

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
$user_num = $user_rs->num_rows;

if ($user_num == 1) {
   $phpObj->fText = "This user alreay registerd!";
} else {

   $code = uniqid();

   $_SESSION["su"]["verification_code"] = $code;

   $mail = new PHPMailer;
   $mail->IsSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'wdsb.inc@gmail.com';
   $mail->Password = 'vhbdfzlvkeaajtbl';
   $mail->SMTPSecure = 'ssl';
   $mail->Port = 465;
   $mail->setFrom('wdsb.inc@gmail.com', 'CneX');
   $mail->addReplyTo('wdsb.inc@gmail.com', '');
   $mail->addAddress($email);
   $mail->isHTML(true);
   $mail->Subject = "Your CneX verification code";
   $bodyContent = "
   <div style='display:grid;'>
      <div style='width: 130px;'>
         <img src='https://lh3.googleusercontent.com/D3P5LNob7GUUZTgoySiv8svnnOkACPptC7IQn4hT01i4kvBCkKfdSf_CZcMyxIeB2140f3b5mUHcEvEDosDPP01Ebp1yAsWD9tWH_dO5bgd-mVQIDmtE1bY53SSip0ZXOp6faxklfb7RJ6oi3wIza61zfYwb5ukZQ_3ZN0FZAppdYEUqq8jEiXUoPMwecjDPPkGJSZOhsja9b68SP2Ko3o5aH_IIZrinsxXlMPIDYFnKHPZ_zzBSR6UMc8o744vnUXP5PESrPeK5tJI7Oer39-67w8S61WitDCf-RGqCvc8b7LPpzlkZPmeiDoq1NHwoNmtAKhiym0EzLnKP7JxRgpz6SuUhDwFTBWJCjV3Bv7ho_-T7RlBqtN7AYTgD4ARIdGaKxBD9Hw6JhZEwc4MdN6y957fzJXBjpxS3SjU5dBOv-suuLpwrWfGbCITj5HrT7kHzLl-9pxuvbhXL7gKbXLrDsgD4ZXxEc9PHF67uyJyCEfSTnS2Qd7Fw9BaMyrgnMRQ0bQChtns7v9h1kwvpb9oRVgdmL9SnL_23aDzRE5WyFb3Itm8rHslNGLkgd_1hDIsZ07aSlX7_oi8Mmc_yLsNYMBKrGgjyaNdD6jUihl120PX9e_RQNWilB7NbLCHM1XUAugODVmactX82GhK9WipYV0UaNiwCDPfSMKXAH2DaP20dpIHHrWmNrACK419R2cHWv-9WMpmkftIGdTw9E1fZa6m1NiQjQHnhutsxoYl7OeNZtSKGn8IE9gJud_87-0tzoP2UXJFdo2TZE8-wn57N9FG32I-Rq08JzdsIDdF77k7YPxzmmgeO4PDJ3dlA2SZ3DxQrSzUK8JGPF0xNOfS-gXr0DFNz6B9UM7XWrv5luofb2chLBnrpq48wQ4sQZosuUReP0HJTYr4mQ_E7w0OzEXaDM9DdrpQ1cR6Rl5xeo_2NK5cGz2pv8uUj4x20XaffL3gBf-31kK8JeKFZuaKxATxUgheiPJWSdDbv-BrN8c2fUaZtiQkD8OZquDek2UJ5tlA2qUCE9gqAPL42vUcTAVmu5QZuV81ROpFdOWaVTNxPiT4pqYIb9i9zUhA=w1482-h890-s-no?authuser=2' width='110px' alt='logo' />

      </div>
      <p style='font-size:17px; font-family:'Rancho', cursive;'>Continue register using this verification code!</p></br>
      <p style='font-size: 40px; padding:6px; background:#f5f6f7; color:#000; border-radius:5px;text-align:center;width:500px;height:50px;margin-top:-10px;'>".$code."</p>
   </div>

   ";
   $mail->Body = $bodyContent;

   if (!$mail->send()) {

      $phpObj->fText = "Verification Code sending fail!";

   } else {

      $phpObj->sText = "Verification Code has sent to your email.";

   }
}

$json = json_encode($phpObj);
echo ($json);
