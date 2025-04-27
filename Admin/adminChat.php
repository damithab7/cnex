<?php

session_start();

?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <title>Admin | Chat</title>

   <link rel="stylesheet" href="../style/bootstrap.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
   <link rel="stylesheet" href="../style/style.css" />
   <link rel="icon" href="../style/resources/cnex.png" />

</head>

<body>

   <div class="container-fluid">
      <div class="row">
         <?php
         include "sideMenu.php";
         ?>

         <div class="col-12 menu-on menu-off" id="contentA">
            <div class="row">

               <?php include "header.php";

               if (isset($_SESSION["au"])) {

                  $mail = $_SESSION["au"]["email"];

               ?>

                  <div class="col-12 py-5 px-4">
                     <div class="row overflow-hidden gap-3">

                        <div class="col-12 col-lg-4 px-0">
                           <div class="row">
                              <div class="col-12">

                                 <div class="px-4">
                                    <div class="col-12 bg-lightblue">
                                       <h5 class="mb-2 pt-2 py-1 rocksalt">Recents</h5>
                                    </div>
                                    <div class="col-12">

                                       <?php

                                       $msg_rs = Database::search("SELECT DISTINCT `content`,`date_time`,`status`,`from` FROM `chat` WHERE `to`='" . $mail . "' ORDER BY `date_time` DESC");
                                       $em_rs = Database::search("SELECT DISTINCT `from`,`date_time` FROM `chat` WHERE `to`='" . $mail . "' ORDER BY `date_time` DESC LIMIT 1");
                                       $msg_num = $em_rs->num_rows;

                                       ?>

                                       <!--  -->
                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                          <li class="nav-item" role="presentation">
                                             <button class="nav-link nav-link-chat active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Received</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                             <button class="nav-link nav-link-chat" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sent</button>
                                          </li>
                                       </ul>
                                       <div class="tab-content" id="myTabContent">
                                          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                             <div class="message_box" id="message_box">
                                                <?php

                                                for ($x = 0; $x < $msg_num; $x++) {

                                                   $msg_data = $msg_rs->fetch_assoc();

                                                   $d_d = $msg_data["date_time"];
                                                   $strtd = strtotime($d_d);
                                                   $new_date = date("H:i A", $strtd);

                                                   if ($msg_data["status"] == 0) {

                                                ?>
                                                      <div class="list-group rounded-0" onclick="viewMessages('<?php echo $msg_data['from']; ?>');">
                                                         <a href="#" class="list-group-item list-group-item-action text-dark rounded-0 bg-lightblue list-group-chat chat-receive-0">
                                                            <?php

                                                            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $msg_data["from"] . "'");
                                                            $user_data = $user_rs->fetch_assoc();

                                                            ?>
                                                            <div class="media">

                                                               <img src="../style/resources/avatar.svg" width="50px" class="rounded-circle">

                                                               <div class="me-4">
                                                                  <div class="d-flex align-items-center justify-content-between mb-1 ">
                                                                     <h6 class="mb-0 fw-bold delius"><?php echo $user_data["fname"]; ?></h6>
                                                                     <small class="small fw-bold mont"><?php echo $new_date; ?></small>

                                                                  </div>
                                                                  <p class="mb-0 inter"><?php echo $msg_data["content"]; ?></p>
                                                               </div>
                                                            </div>
                                                         </a>

                                                      </div>
                                                   <?php

                                                   } else {
                                                   ?>
                                                      <div class="list-group rounded-0" onclick="viewMessages('<?php echo $msg_data['from']; ?>');">
                                                         <a href="#" class="list-group-item list-group-item-action text-dark rounded-0 bg-body list-group-chat">
                                                            <?php

                                                            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $msg_data["from"] . "'");
                                                            $user_data = $user_rs->fetch_assoc();

                                                            ?>
                                                            <div class="media">

                                                               <img src="../style/resources/avatar.svg" width="50px" class="rounded-circle">

                                                               <div class="me-4">
                                                                  <div class="d-flex align-items-center justify-content-between mb-1 ">
                                                                     <h6 class="mb-0 fw-bold delius"><?php echo $user_data["fname"]; ?></h6>
                                                                     <small class="small fw-bold mont"><?php echo $new_date; ?></small>

                                                                  </div>
                                                                  <p class="mb-0 inter"><?php echo $msg_data["content"]; ?></p>
                                                               </div>
                                                            </div>
                                                         </a>

                                                      </div>
                                                <?php
                                                   }
                                                }

                                                ?>

                                             </div>
                                          </div>
                                          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                             <div class="message_box" id="message_box">

                                                <?php

                                                $msg_rs2 = Database::search("SELECT DISTINCT `content`,`date_time`,`status`,`to` 
                                                FROM `chat` WHERE `from`='" . $mail . "' ORDER BY `date_time` DESC");
                                                $em_rs2 = Database::search("SELECT DISTINCT `from`,`date_time` FROM `chat` WHERE `from`='" . $mail . "' ORDER BY `date_time` DESC LIMIT 1");
                                                $msg_num2 = $em_rs2->num_rows;   

                                                for ($y = 0; $y < $msg_num2; $y++) {

                                                   $msg_data2 = $msg_rs2->fetch_assoc();

                                                   $d_d = $msg_data2["date_time"];
                                                   $strtd = strtotime($d_d);
                                                   $new_date = date("H:i A", $strtd);

                                                ?>
                                                   <div class="list-group rounded-0" onclick="viewMessages('<?php echo $msg_data['from']; ?>');">
                                                      <a href="#" class="list-group-item list-group-item-action text-black rounded-0 bg-body list-group-chat">
                                                         <div class="media">
                                                            <?php

                                                            $user_rs2 = Database::search("SELECT * FROM `user` WHERE `email`='" . $msg_data2["to"] . "'");
                                                            $user_data2 = $user_rs2->fetch_assoc();

                                                            $img_rs2 = Database::search("SELECT * FROM `admin` WHERE `user_email`='" . $msg_data2["to"] . "'");
                                                            $img_data2 = $img_rs2->fetch_assoc();

                                                            if (isset($img_data2["path"])) {
                                                            ?>
                                                               <img src="<?php echo $img_data2["path"]; ?>" width="50px" class="rounded-circle">
                                                            <?php
                                                            } else {
                                                            ?>
                                                               <img src="../style/resources/avatar.svg" width="50px" class="rounded-circle">
                                                            <?php
                                                            }

                                                            ?>
                                                            <div class="me-4">
                                                               <div class="d-flex align-items-center justify-content-between mb-1 ">
                                                                  <h6 class="mb-0 fw-bold delius"> Me</h6>
                                                                  <small class="small fw-bold mont"><?php echo $new_date; ?></small>
                                                               </div>
                                                               <p class="mb-0 inter"><?php echo $msg_data2["content"]; ?></p>
                                                            </div>
                                                         </div>
                                                      </a>

                                                   </div>
                                                <?php
                                                }

                                                ?>

                                             </div>


                                          </div>
                                       </div>
                                       <!--  -->
                                    </div>
                                 </div>

                              </div>
                           </div>

                        </div>

                        <div class="col-12 col-lg-7 px-0">
                           <div class="row justify-content-center border border-opacity-25">


                              <div class="col-12 bg-lightblue text-center">
                                 <h5 class="mb-2 pt-2 py-1 rocksalt">Chat</h5>
                              </div>

                              <div class="px-4">
                                 <div class="col-12 py-5">
                                    <div class="row text-dark chat_box" id="chat_box">

                                       <!-- view area -->

                                    </div>
                                 </div>
                              </div>
                              <!-- txt -->
                              <div class="px-4">
                                 <div class="col-12">

                                    <div class="input-group input-chat-group mb-3">
                                       <input type="text" class="form-control control-edit input-chat" placeholder="Type a message ..." aria-describedby="send_btn" id="msg_txt" />
                                       <button class="btn-edit btn-purple-v2 input-chat-send" id="send_btn" onclick="send_msg();" onkeyup="send_a_msg();"><i class="bi bi-send-fill"></i></button>

                                    </div>
                                    <div class="invalid-feedback" id="adminmsg"></div>

                                 </div>
                              </div>
                              <!-- txt -->
                           </div>

                        </div>

                     </div>
                  </div>

               <?php
               } else {
                  header("Location:../index.php");
               }

               ?>
            </div>
         </div>
      </div>
   </div>

</body>

</html>