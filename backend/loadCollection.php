<?php

require "connection.php";

session_start();

$json = $_POST["json"];

$reqOb = json_decode($json);

$id = $reqOb->cid;

if ($id != 0) {

?>
   <div class="row justify-content-center">
      <?php
      $collection_rs = Database::search("SELECT * FROM `collection` WHERE `category_id`='" . $id . "'");
      $collection_num = $collection_rs->num_rows;
      ?>
      <div class="col-12">
         <span class="newProductL">Select Category Item</span>
      </div>
      <div class="col-12 mb-3">
         <select class="form-select mt-3 mb-3 ViewSelect select-edit select_edit_p select_edit_pc" id="collectionSelect" required multiple>
            <option value="0">None</option>
            <?php
            for ($c = 0; $c < $collection_num; $c++) {

               $collection_data = $collection_rs->fetch_assoc();

            ?>
               <option value="<?php echo ($collection_data["id"]); ?>"><?php echo ($collection_data["name"]); ?></option>
            <?php

            }
            ?>
         </select>
      </div>
   </div>
<?php

}

?>