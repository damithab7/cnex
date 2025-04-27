<?php

session_start();
require "connection.php";

$receiver_mail = $_SESSION["u"]["email"];
$sender_mail = $_GET["e"];

$msg_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $sender_mail . "' OR `to`='" . $sender_mail . "'");
$msg_num = $msg_rs->num_rows;

for ($x = 0; $x < $msg_num; $x++) {

   $msg_data = $msg_rs->fetch_assoc();

   $d_d = $msg_data["date_time"];
   $strtd = strtotime($d_d);
   $new_date = date("H:i A",$strtd);

   if ($msg_data["from"] == $sender_mail && $msg_data["to"] == $receiver_mail) {

      $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $msg_data["from"] . "'");
      $user_data = $user_rs->fetch_assoc();

      $img_rs = Database::search("SELECT * FROM `admin` WHERE `user_email`='" . $sender_mail . "'");
      $img_data = $img_rs->fetch_assoc();

      Database::iud("UPDATE `chat` SET `status`='1' WHERE `from`='".$msg_data["from"]."' AND `to`='".$msg_data["to"]."'");

?>
      <!-- sender -->

      <div class="media mb-3 w-75">
         <?php

         if (isset($img_data["path"])) {
            $path = substr($img_data["path"],1);

            $n_path = $path."\n";
         ?>
            <img src="<?php echo $n_path; ?>" width="50px" class="rounded-circle" />
         <?php
         } else {
         ?>
            <img src="./style/resources/avatar.svg" width="50px" class="rounded-circle">
         <?php
         }

         ?>

         <div class="media-body me-4">
            <div class="bg-light rounded py-2 px-3 mb-2">
               <p class="mb-0 text-black-50"> <?php echo $msg_data["content"]; ?></p>
            </div>
            <p class="small fw-bold text-black-50 text-end delius"><?php echo $new_date; ?></p>
            <p class="invisible" id="rmail"><?php echo $msg_data["from"]; ?></p>
         </div>
      </div>
      <!-- sender -->
   <?php

   } else if ($msg_data["to"] == $sender_mail && $msg_data["from"] == $receiver_mail) {

      Database::iud("UPDATE `chat` SET `status`='1' WHERE `from`='".$msg_data["from"]."' AND `to`='".$msg_data["to"]."'");

   ?>
      <!-- receiver -->

      <div class="offset-3 col-9 media mb-3 w-75">
         <div class="media-body">
            <div class="bg-lightblue rounded py-2 px-3 mb-2">
               <p class="mb-0 text-dark inter"><?php echo $msg_data["content"]; ?></p>
            </div>
            <p class="small fw-bold text-black-50 text-end delius"><?php echo $new_date; ?></p>
         </div>
      </div>
      <!-- receiver -->
<?php
   }
}
