
// window.addEventListener("mouseenter", function (e) {
//    var menu = this.document.getElementById("dropdown-auto");
//    var menuAfter = this.window.getComputedStyle(menu, ":hover");
//    var dropdown_content = this.document.getElementById("dropdown-content");

//    if (e == menuAfter) {
//       dropdown_content.classList.toggle("show");
//    } else {
//       dropdown_content.classList.toggle("hide");
//    }
// })

// if (document.getElementById("home-page")) {

//    window.onscroll = function () {
//       scrollHeader();
//    }

//    var header = document.getElementById("header");
//    var mainheader = document.getElementById("main-header");

//    var ca = document.getElementById("home-page");

//    var sticky = header.offsetTop;


//    // function scrollHeader() {
//    //    if (window.pageYOffset > sticky) {
//    //       header.classList.add("sticky");
//    //       ca.classList.add("m70");

//    //    } else {
//    //       header.classList.remove("sticky");
//    //       ca.classList.remove("m70");
//    //    }

//    // }

// }

window.addEventListener("keyup",function(event){
   var k =event.which;
   if(k == 13){
      send_msg();
   }
})

window.onscroll = function(){
   scrollbtn();
}

function scrollbtn(){
   var btn = document.getElementById("btntop");

   if(document.body.scrollTop > 300 || document.documentElement.scrollTop > 770){
      btn.style.display = "block";
   }else{
      btn.style.display = "none";
   }
}


function goTop(){
   document.body.scrollTop = 0;
   document.documentElement.scrollTop = 0;
}