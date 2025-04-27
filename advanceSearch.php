<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Advanced Search | carslk</title>
   <link rel="stylesheet" href="style/bootstrap.css" />
   <link rel="stylesheet" href="style/style.css" />
   <link rel="icon" href="style/resources/cnex.png" />
</head>

<body>
   <div class="container-fluid">
      <div class="row">
         <?php include "header.php"; ?>
         <div class="col-12" style="margin-top: 100px;">
            <div class="row justify-content-center gap-3">
               <!-- first_filter -->
               <div class="border border-dark" style="width: 30rem;">
                  <div class="row p-3">
                     <div class="col-6 mb-3">
                        <label class="form-label">Model</label>
                        <select class="form-select">
                           <option value="0">Select Model</option>
                        </select>
                     </div>
                     <div class="col-6 mb-3">
                        <label class="form-label">Brand</label>
                        <select class="form-select">
                           <option value="0">Select Brand</option>
                        </select>
                     </div>
                     <div class="col-12 mb-3">
                        <label class="form-label">Location</label>
                        <select class="form-select">
                           <option value="0">Select Location</option>
                        </select>
                     </div>
                     <div class="col-6 mb-3">
                        <label class="form-label">Transmission</label>
                        <select class="form-select">
                           <option value="0">Select Transmission</option>
                        </select>
                     </div>
                     <div class="col-6 mb-3">
                        <label class="form-label">Drive Train</label>
                        <select class="form-select">
                           <option value="0">Select Drive Train</option>
                        </select>
                     </div>
                     <div class="col-12 mb-3">
                        <label class="form-label">Engine No.</label>
                        <select class="form-select">
                           <option value="0">Select Engine</option>
                        </select>
                     </div>
                  </div>
               </div>
               <!-- second_filter -->
               <div class="border border-dark" style="width: 30rem;">
                  <div class="row p-3">
                     <div class="col-6 mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select">
                           <option value="0">Select Type</option>
                        </select>
                     </div>
                     <div class="col-6 mb-3">
                        <label class="form-label">Condition</label>
                        <select class="form-select">
                           <option value="0">Select Condition</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="col-lg-4 col-7 d-grid mt-3 mb-4">
                  <button class="btn-purple btn-home btn-search">Search</button>
               </div>

            </div>
         </div>
      </div>
   </div>
</body>

</html>