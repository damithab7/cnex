var descriptionLink = document.getElementById("descriptionLink");
var contactLink = document.getElementById("contactLink");
var reviewsLink = document.getElementById("reviewsLink");
var singleWDescription = document.getElementById("singleWDescription");
var singleWContact = document.getElementById("singleWContact");
var singleWReviews = document.getElementById("singleWReviews");

function changeDescription(){
   descriptionLink.classList.add("active");
   contactLink.classList.remove("active");
   reviewsLink.classList.remove("active");

   singleWDescription.classList.remove("d-none");
   singleWContact.classList.add("d-none");
   singleWReviews.classList.add("d-none");
}

function changeContact(){
   descriptionLink.classList.remove("active");
   contactLink.classList.add("active");
   reviewsLink.classList.remove("active");

   singleWDescription.classList.add("d-none");
   singleWContact.classList.remove("d-none");
   singleWReviews.classList.add("d-none");
}

function changeReviews(){
   descriptionLink.classList.remove("active");
   contactLink.classList.remove("active");
   reviewsLink.classList.add("active");

   singleWDescription.classList.add("d-none");
   singleWContact.classList.add("d-none");
   singleWReviews.classList.remove("d-none");
}

var signInContent = document.getElementById("signInContent");
var signUpContent = document.getElementById("signUpContent");
var forgotPContent = document.getElementById("forgotPContent");
var navsi = document.getElementById("indexSI");
var navri = document.getElementById("indexRI");

function changeRegister(){
   signInContent.classList.add("d-none");
   forgotPContent.classList.add("d-none");
   signUpContent.classList.remove("d-none"); 
   navsi.classList.remove("active-navh");
   navri.classList.add("active-navh");
}

function changeSi(){
   signInContent.classList.remove("d-none");
   forgotPContent.classList.add("d-none");
   signUpContent.classList.add("d-none"); 
   navsi.classList.add("active-navh");
   navri.classList.remove("active-navh");
}

function changeForP(){
   forgotPContent.classList.remove("d-none");
   signInContent.classList.add("d-none");
   signUpContent.classList.add("d-none"); 
}

var accountDiv = document.getElementById("accountDiv");
var addressDiv = document.getElementById("addressDiv");
var profileSecurity = document.getElementById("profileSecurity");
var accountLink = document.getElementById("accountLink");
var addressLink = document.getElementById("addressLink");
var securityLink = document.getElementById("securityLink");

function changeAccount(){
   accountDiv.classList.remove("d-none");
   addressDiv.classList.add("d-none");
   profileSecurity.classList.add("d-none");
   accountLink.classList.add("active");
   addressLink.classList.remove("active");
   securityLink.classList.remove("active");
}

function changeAddress(){
   accountDiv.classList.add("d-none");
   addressDiv.classList.remove("d-none");
   profileSecurity.classList.add("d-none");
   accountLink.classList.remove("active");
   addressLink.classList.add("active");
   securityLink.classList.remove("active");
}

function changeSecurity(){
   accountDiv.classList.add("d-none");
   addressDiv.classList.add("d-none");
   profileSecurity.classList.remove("d-none");
   accountLink.classList.remove("active");
   addressLink.classList.remove("active");
   securityLink.classList.add("active");
}

function changePsL(){
   var input = document.getElementById("signInPassword");
   var eye = document.getElementById("rLPseye");

   if(input.type == "password"){
      input.type = "text";
      eye.classList = "bi bi-eye-slash-fill";
   }else{
      input.type = "password";
      eye.classList = "bi bi-eye-fill";
   }
}

function changeAdminPs(){
   var input = document.getElementById("adminSignInPassword");
   var eye = document.getElementById("adminPsEye");

   if(input.type == "password"){
      input.type = "text";
      eye.classList = "bi bi-eye-slash-fill";
   }else{
      input.type = "password";
      eye.classList = "bi bi-eye-fill";
   }
}

function changeCheckoutPs(){
   var input = document.getElementById("checkoutPassword");
   var eye = document.getElementById("checkEye");

   if(input.type == "password"){
      input.type = "text";
      eye.classList = "bi bi-eye-slash-fill";
   }else{
      input.type = "password";
      eye.classList = "bi bi-eye-fill";
   }
}

function changePs(){
   var input = document.getElementById("rPassword");
   var eye = document.getElementById("rPseye");

   if(input.type == "password"){
      input.type = "text";
      eye.classList = "bi bi-eye-slash-fill";
   }else{
      input.type = "password";
      eye.classList = "bi bi-eye-fill";
   }
}

function changeRtypePs(){
   var input = document.getElementById("rRePassword");
   var eye = document.getElementById("rRePseye");

   if(input.type == "password"){
      input.type = "text";
      eye.classList = "bi bi-eye-slash-fill";
   }else{
      input.type = "password";
      eye.classList = "bi bi-eye-fill";
   }
}

function changeAdminMenu(){

   var labels = document.querySelectorAll(".menu-t-text");

   var menu = document.getElementById("a-menu");
   menu.classList.toggle("ab-menu");

   var padding = document.getElementById("contentA");
   padding.classList.toggle("menu-off");

   var icon = document.getElementById("admin-m-icon");
   icon.classList.toggle("justify-content-center");

   var i;
   for(var i = 0;i < labels.length;i++){
      labels[i].classList.toggle("d-none");
   }

}

function changeAllMenu(){
   
   var menu = document.getElementById("all-menu");
   menu.classList.toggle("aball-menu");

}

function openSearch(){
   var input = document.getElementById("headerSearch");
   input.classList.toggle("header-search-i-on");
}

function changeHomeNavA(id,num){

   var btn = document.getElementById("homeNavA"+id);
   var div = document.getElementById("homeNavDiv"+id);

   for(var x = 1;x <= num;x++){
      var btnall = document.getElementById("homeNavA"+x);
      var divall = document.getElementById("homeNavDiv"+x);

      btnall.classList.remove("active-navh");
      divall.classList.add("d-none");

      if(btn == btnall && div == divall){
      
         btn.classList.add("active-navh");
         div.classList.remove("d-none");

      }

   }

}