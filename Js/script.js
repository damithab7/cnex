function signIn() {
  var loginEmail = document.getElementById("signInEmail");
  var loginPassword = document.getElementById("signInPassword");
  var loginRememberme = document.getElementById("rememberme");

  var obj = {
    email: loginEmail.value,
    password: loginPassword.value,
    rememberme: loginRememberme.checked,
  };

  var json = JSON.stringify(obj);

  var form = new FormData();
  form.append("json", json);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var jsObj = JSON.parse(request.responseText);

      var signIEf = document.getElementById("signIEf");
      var signIPf = document.getElementById("signIPf");

      if (jsObj.lemailText) {
        signIEf.innerHTML = jsObj.lemailText;
        loginEmail.classList.add("is-invalid");

        loginEmail.oninput = function () {
          loginEmail.classList.remove("is-invalid");
        };
      }

      if (jsObj.pText) {
        signIPf.innerHTML = jsObj.pText;
        loginPassword.classList.add("is-invalid");

        loginPassword.oninput = function () {
          loginPassword.classList.remove("is-invalid");
        };
      }

      if (jsObj.epLoginText) {
        signIEf.innerHTML = jsObj.epLoginText;
        signIPf.innerHTML = jsObj.epLoginText;

        loginPassword.classList.add("is-invalid");
        loginEmail.classList.add("is-invalid");

        loginPassword.oninput = function () {
          loginPassword.classList.remove("is-invalid");
        };

        loginEmail.oninput = function () {
          loginEmail.classList.remove("is-invalid");
        };
      }

      if (jsObj.sText) {
        window.location = "home.php";
      }
    }
  };

  request.open("POST", "./backend/signInProcess.php", true);
  request.send(form);
}

var siu;

function userRegister() {
  var rFname = document.getElementById("rFname");
  var rLname = document.getElementById("rLname");
  var rEmail = document.getElementById("rEmail");
  var rPassword = document.getElementById("rPassword");
  var rRePassword = document.getElementById("rRePassword");
  var vcode = document.getElementById("vcode");
  var mobile = document.getElementById("mobile");

  var jsObj = {
    fname: rFname.value,
    lname: rLname.value,
    email: rEmail.value,
    password: rPassword.value,
    rpassword: rRePassword.value,
    vcode: vcode.value,
    mobile: mobile.value,
  };

  var json = JSON.stringify(jsObj);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var signInUpModal = document.getElementById("signInUpModal");
      siu = new bootstrap.Modal(signInUpModal);
      var mMessage = document.getElementById("indexSiuMessage");

      var jsObj2 = JSON.parse(r.responseText);

      var registerFN = document.getElementById("registerFN");
      var registerLN = document.getElementById("registerLN");
      var registerEmail = document.getElementById("registerEmail");
      var registerPassword = document.getElementById("registerPassword");
      var registerRePassword = document.getElementById("registerRePassword");
      var registerVcode = document.getElementById("registerVcode");
      var registerMobile = document.getElementById("registerMobile");

      if (jsObj2.fnameText) {
        registerFN.innerHTML = jsObj2.fnameText;

        rFname.classList.add("is-invalid");
        rFname.oninput = function () {
          rFname.classList.remove("is-invalid");
        };
      }

      if (jsObj2.lnameText) {
        registerLN.innerHTML = jsObj2.lnameText;

        rLname.classList.add("is-invalid");
        rLname.oninput = function () {
          rLname.classList.remove("is-invalid");
        };
      }

      if (jsObj2.emailText) {
        registerEmail.innerHTML = jsObj2.emailText;

        rEmail.classList.add("is-invalid");
        rEmail.oninput = function () {
          rEmail.classList.remove("is-invalid");
        };
      }

      if (jsObj2.passwordText) {
        registerPassword.innerHTML = jsObj2.passwordText;

        rPassword.classList.add("is-invalid");
        rPassword.oninput = function () {
          rPassword.classList.remove("is-invalid");
        };
      }

      if (jsObj2.repasswordText) {
        registerRePassword.innerHTML = jsObj2.repasswordText;

        rRePassword.classList.add("is-invalid");
        rRePassword.oninput = function () {
          rRePassword.classList.remove("is-invalid");
        };
      }

      if (jsObj2.allpasswordText) {
        registerPassword.innerHTML = jsObj2.allpasswordText;
        registerRePassword.innerHTML = jsObj2.allpasswordText;

        rPassword.classList.add("is-invalid");
        rRePassword.classList.add("is-invalid");
        rPassword.oninput = function () {
          rPassword.classList.remove("is-invalid");
          rRePassword.classList.remove("is-invalid");
        };
        rRePassword.oninput = function () {
          rPassword.classList.remove("is-invalid");
          rRePassword.classList.remove("is-invalid");
        };
      }

      if (jsObj2.vcodeText) {
        registerVcode.innerHTML = jsObj2.vcodeText;

        vcode.classList.add("is-invalid");
        vcode.oninput = function () {
          vcode.classList.remove("is-invalid");
        };
      }

      if (jsObj2.mobile) {
        registerMobile.innerHTML = jsObj2.mobile;

        mobile.classList.add("is-invalid");
        mobile.oninput = function () {
          mobile.classList.remove("is-invalid");
        };
      }

      if (jsObj2.sText) {
        mMessage.innerHTML = jsObj2.sText;
        siu.show();
        var btn = document.getElementById("signInUpbtn");
        btn.onclick = function () {
          window.location.reload();
        };
      }
    }
  };
  r.open("POST", "./backend/userRegister.php", true);
  r.send(f);
}

function signOut() {
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      }
    }
  };
  r.open("POST", "./backend/signOut.php", true);
  r.send();
}

function sendVCode() {
  var vcode = document.getElementById("vcode").value;
  var email = document.getElementById("rEmail").value;

  var jsObj = {
    vcode: vcode,
    email: email,
  };

  var json = JSON.stringify(jsObj);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var resText = document.getElementById("indexSiuMessage");

      var jsObj2 = JSON.parse(r.responseText);

      if (jsObj2.fText) {
        resText.innerHTML = jsObj2.fText;
      } else if (jsObj2.sText) {
        resText.innerHTML = jsObj2.sText;
      } else {
        resText.innerHTML = t;
      }

      var modal = document.getElementById("signInUpModal");
      siu = new bootstrap.Modal(modal);
      siu.show();
    }
  };
  r.open("POST", "./backend/verificationCode.php", true);
  r.send(f);
}

function homeRegister() {
  var homeVRegister = document.getElementById("homeVRegister");

  var jsobj = {
    rNo: homeVRegister.value,
  };

  var json = JSON.stringify(jsobj);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var jsObj2 = JSON.parse(r.responseText);

      if (jsObj2.fText) {
        homeVRegister.classList.add("is-invalid");
        homeVRegister.oninput = function () {
          homeVRegister.classList.remove("is-invalid");
        };
      } else if (jsObj2.sText) {
        homeVRegister.classList.add("is-valid");
        homeVRegister.oninput = function () {
          homeVRegister.classList.remove("is-valid");
        };

        var ask1 = confirm("Do you want to continue?");

        if (ask1 == true) {
          window.location = "sell.php";
        } else {
        }
      }

      if (jsObj2.singInText) {
        alert(jsObj2.singInText);
        window.location = "index.php";
      }
    }
  };
  r.open("POST", "./backend/checkRegNo.php", true);
  r.send(f);
}

function checkUserData() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var jsObj2 = JSON.parse(r.responseText);

      if (jsObj2.sText) {
      } else {
      }
    }
  };

  r.open("POST", "./backend/checkUserData.php", true);
  r.send();
}

var hm;

function addToCart(id) {
  const JS_Object = {
    id: id,
  };

  var json = JSON.stringify(JS_Object);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var js_ob2 = JSON.parse(t);

      if (js_ob2.msg) {
        window.location = "cart.php";
      } else if (js_ob2.msg1) {
        if (document.getElementById("homeQTYmessage")) {
          var spwText = document.getElementById("homeQTYmessage");
          spwText.innerHTML = js_ob2.msg1;
        }

        var m = document.getElementById("homeMessage");
        var hm = new bootstrap.Modal(m);
        hm.show();

        return loadOrder(id);
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "./backend/addToCart.php", true);
  r.send(f);
}

function loadOrder(id) {
  var btn = document.getElementById("btnOrder");
  btn.onclick = () => {
    window.location = "singleProductView.php?id=" + id;
  };
}

if (document.getElementById("get_total")) {
  var get_total = document.getElementById("get_total").innerHTML;
}

var total_checkout = get_total;

function changeQTY(price, id, qty) {
  var input = document.getElementById("qtySelector" + id);

  var iqty = input.value;

  if (iqty > qty) {
    input.value = qty;
    iqty = qty;
  } else if (iqty == 0) {
    iqty = 1;
    input.value = iqty;
  } else {
  }

  const new_price = iqty * price;

  document.getElementById("priceTag" + id).innerHTML = new_price;

  const JS_ob = {
    id: id,
    qty: iqty,
    price: price,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);
      if (js_ob2.total) {
        total_checkout = js_ob2.total;

        if (document.getElementById("subtotal")) {
          var subtotal = document.getElementById("subtotal");
          subtotal.innerHTML = total_checkout;
        }

        if (document.getElementById("a_total")) {
          var a_total = document.getElementById("a_total");
          a_total.innerHTML = total_checkout;
        }
      }
    }
  };

  r.open("POST", "./backend/checkCartTotal.php", true);
  r.send(f);
}

function addToWishlist(id) {
  const JS_Object = {
    id: id,
  };

  const json = JSON.stringify(JS_Object);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var JS_ob2 = JSON.parse(t);

      if (JS_ob2.msg == "remove") {
        var heart = document.getElementById("watchlist_heart" + id);
        heart.className = "bi bi-heart";
      } else if (JS_ob2.msg == "add") {
        var heart = document.getElementById("watchlist_heart" + id);
        heart.className = "bi bi-heart-fill";
      }
    }
  };

  r.open("POST", "./backend/addToWatchlist.php", true);
  r.send(f);
}

function removeFromCart(id) {
  const JS_ob = {
    id: id,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);
      if (js_ob2.msg == "success") {
        window.location.reload();
      }
    }
  };

  r.open("POST", "./backend/removeFromCart.php", true);
  r.send(f);
}

function removeFromWatchlist(id) {
  const JS_ob = {
    id: id,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_Ob2 = JSON.parse(t);
      if (js_Ob2.msg == "success") {
        window.location.reload();
      }
    }
  };

  r.open("POST", "./backend/removeFromWatchlist.php", true);
  r.send(f);
}

function changeProfileAccount() {
  var fname = document.getElementById("pfname");
  var lname = document.getElementById("plname");

  const JS_ob = {
    fname: fname.value,
    lname: lname.value,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const JS_ob2 = JSON.parse(t);
      if (JS_ob2.msg) {
        fname.classList.add("is-invalid");
        fname.oninput = function () {
          fname.classList.remove("is-invalid");
        };
      } else if (JS_ob2.msg1) {
        lname.classList.add("is-invalid");
        lname.oninput = function () {
          lname.classList.remove("is-invalid");
        };
      } else if (JS_ob2.success) {
        window.location.reload();
      }
    }
  };

  r.open("POST", "./backend/AccountProfileChange.php", true);
  r.send(f);
}

function adminChangeProfileAccount() {
  var fname = document.getElementById("pfname");
  var lname = document.getElementById("plname");

  const JS_ob = {
    fname: fname.value,
    lname: lname.value,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const JS_ob2 = JSON.parse(t);
      if (JS_ob2.msg) {
        fname.classList.add("is-invalid");
        fname.oninput = function () {
          fname.classList.remove("is-invalid");
        };
      } else if (JS_ob2.msg1) {
        lname.classList.add("is-invalid");
        lname.oninput = function () {
          lname.classList.remove("is-invalid");
        };
      } else if (JS_ob2.success) {
        window.location.reload();
      }
    }
  };

  r.open("POST", "../backend/AccountProfileChange.php", true);
  r.send(f);
}

function saveAddresss() {
  var postCode = document.getElementById("postCode");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var city = document.getElementById("city");
  var mobile = document.getElementById("mobile");

  const js_ob = {
    postcode: postCode.value,
    line1: line1.value,
    line2: line2.value,
    city: city.value,
    mobile: mobile.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      if (js_ob2.city) {
        city.classList.add("is-invalid");
        city.onfocus = function () {
          city.classList.remove("is-invalid");
        };
      } else if (js_ob2.line1) {
        line1.classList.add("is-invalid");
        line1.oninput = function () {
          line1.classList.remove("is-invalid");
        };
      } else if (js_ob2.post) {
        postCode.classList.add("is-invalid");
        postCode.oninput = function () {
          postCode.classList.remove("is-invalid");
        };
      } else if (js_ob2.mobile) {
        mobile.classList.add("is-invalid");
        mobile.oninput = function () {
          mobile.classList.remove("is-invalid");
        };
      } else if (js_ob2.msg1) {
        window.location.reload();
      }
    }
  };

  r.open("POST", "./backend/AccountAddressChange.php", true);
  r.send(f);
}

function adminSaveAddresss() {
  var postCode = document.getElementById("postCode");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var city = document.getElementById("city");
  var mobile = document.getElementById("mobile");

  const js_ob = {
    postcode: postCode.value,
    line1: line1.value,
    line2: line2.value,
    city: city.value,
    mobile: mobile.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      if (js_ob2.city) {
        city.classList.add("is-invalid");
        city.onfocus = function () {
          city.classList.remove("is-invalid");
        };
      } else if (js_ob2.line1) {
        line1.classList.add("is-invalid");
        line1.oninput = function () {
          line1.classList.remove("is-invalid");
        };
      } else if (js_ob2.post) {
        postCode.classList.add("is-invalid");
        postCode.oninput = function () {
          postCode.classList.remove("is-invalid");
        };
      } else if (js_ob2.mobile) {
        mobile.classList.add("is-invalid");
        mobile.oninput = function () {
          mobile.classList.remove("is-invalid");
        };
      } else if (js_ob2.msg1) {
        window.location.reload();
      }
    }
  };

  r.open("POST", "../backend/AccountAddressChange.php", true);
  r.send(f);
}

var bmm;

function saveProductCookie(id) {

  const js_ob = {
    id: id,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      if (js_ob2.msg == "user") {
      } else if (js_ob2.msg == "nouser") {
        window.location = "continueToCheckout.php";
      } else {
        addToCart(id);
      }
    }
  };

  r.open("POST", "./backend/saveProductCookie.php", true);
  r.send(f);
}

var spm;

function cartToBuy(id) {
  const JS_Object = {
    id: id,
  };

  var json = JSON.stringify(JS_Object);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var js_ob2 = JSON.parse(t);
      if (js_ob2.msg) {
        window.location = "cart.php";
      } else if (js_ob2.msg1) {
        var spwText = document.getElementById("messageQTYspw");
        spwText.innerHTML = js_ob2.msg1;

        var m = document.getElementById("singleProductMessage");
        spm = new bootstrap.Modal(m);
        spm.show();
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "./backend/addToCart.php", true);
  r.send(f);
}

function savePrice(id) {
  var qtySelector = document.getElementById("qtySelector" + id);

  if (total_checkout == null) {
    var reqOb = {
      id: id,
      qty: qtySelector.value,
    };
  } else {
    var reqOb = {
      total: total_checkout,
      id: id,
      qty: qtySelector.value,
    };
  }

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      if (r.responseText == "success") {
        window.location = "shipping.php";
      } else {
        alert(r.responseText);
      }
    }
  };

  r.open("POST", "./backend/savePrice.php", true);
  r.send(f);
}

function savePriceCart() {
  const reqOb = {
    total: total_checkout,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      if (r.responseText == "success") {
        window.location = "shipping.php";
      } else {
        alert(r.responseText);
      }
    }
  };

  r.open("POST", "./backend/savePriceCart.php", true);
  r.send(f);
}

function changePassword() {
  var o_password = document.getElementById("o_password");
  var n_password = document.getElementById("n_password");

  const js_ob = {
    op: o_password.value,
    np: n_password.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);
      if (js_ob2.msg == "success") {
        window.location.reload();
      } else if (js_ob2.error) {
        window.location = "index.php";
      } else if (js_ob2.msgn) {
        n_password.classList.add("is-invalid");
        n_password.oninput = function () {
          n_password.classList.remove("is-invalid");
        };
      } else if (js_ob2.msgo) {
        o_password.classList.add("is-invalid");
        o_password.oninput = function () {
          o_password.classList.remove("is-invalid");
        };
      }
    }
  };

  r.open("POST", "./backend/AccountChangePassword.php", true);
  r.send(f);
}

function adminChangePassword() {
  var o_password = document.getElementById("o_password");
  var n_password = document.getElementById("n_password");

  const js_ob = {
    op: o_password.value,
    np: n_password.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);
      if (js_ob2.msg == "success") {
        window.location.reload();
      } else if (js_ob2.error) {
        window.location = "index.php";
      } else if (js_ob2.msgn) {
        n_password.classList.add("is-invalid");
        n_password.oninput = function () {
          n_password.classList.remove("is-invalid");
        };
      } else if (js_ob2.msgo) {
        o_password.classList.add("is-invalid");
        o_password.oninput = function () {
          o_password.classList.remove("is-invalid");
        };
      }
    }
  };

  r.open("POST", "../backend/AccountChangePassword.php", true);
  r.send(f);
}

function ShippingAddressChange() {

  var s_name = document.getElementById("s_name");
  var postCode = document.getElementById("s_postal");
  var line1 = document.getElementById("s_line1");
  var city = document.getElementById("s_city");
  var mobile = document.getElementById("s_mobile");

  if (document.getElementById("email_s")) {

    var email = document.getElementById("email_s");

    var js_ob = {
      "email": email.value,
      "name": s_name.value,
      "postcode": postCode.value,
      "line1": line1.value,
      "city": city.value,
      "mobile": mobile.value,
    };

  } else {
    var js_ob = {
      "name": s_name.value,
      "postcode": postCode.value,
      "line1": line1.value,
      "city": city.value,
      "mobile": mobile.value,
    };
  }

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      if (js_ob2.email) {
        email.classList.add("is-invalid");
        email.onfocus = function () {
          email.classList.remove("is-invalid");
        };
      } else if (js_ob2.name) {
        s_name.classList.add("is-invalid");
        s_name.onfocus = function () {
          s_name.classList.remove("is-invalid");
        };
      } else if (js_ob2.city) {
        city.classList.add("is-invalid");
        city.onfocus = function () {
          city.classList.remove("is-invalid");
        };
      } else if (js_ob2.line1) {
        line1.classList.add("is-invalid");
        line1.oninput = function () {
          line1.classList.remove("is-invalid");
        };
      } else if (js_ob2.post) {
        postCode.classList.add("is-invalid");
        postCode.oninput = function () {
          postCode.classList.remove("is-invalid");
        };
      } else if (js_ob2.mobile) {
        mobile.classList.add("is-invalid");
        mobile.oninput = function () {
          mobile.classList.remove("is-invalid");
        };
      } else if (js_ob2.msg1) {
        window.location.reload();
      }
    }
  };

  r.open("POST", "./backend/shippingAddressChange.php", true);
  r.send(f);
}

function payProducts(total) {

  var f = new FormData();

  f.append("amount",total);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob = JSON.parse(t);
      if (js_ob.msg) {
        alert(js_ob.msg);
        ShippingAddressChange();
      } else {

        var email = js_ob["email"];

        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);
          sendInvoice(orderId, email, total);

          // Note: validate the payment and show success or failure page to the customer
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here

        var payment = {
          "sandbox": true,
          "merchant_id": '1222852',    // Replace your Merchant ID
          "merchant_secret": "MzczMDk1ODg5NjI4ODczODcwNTMzNjc5NDIwNjQ3MzIyNTMxMDEz",
          "return_url": "http://localhost/cnex/shipping.php",     // Important
          "cancel_url": "http://localhost/cnex/shipping.php",     // Important
          "notify_url": "http://sample.com/notify",
          "order_id": js_ob["id"],
          "items": "Cart items",
          "amount": total,
          "currency": "LKR",
          "hash": js_ob["hash"],
          "first_name": js_ob["fname"],
          "last_name": js_ob["lname"],
          "email": email,
          "phone": js_ob["mobile"],
          "address": js_ob["line1"],
          "city": js_ob["district"],
          "country": "Sri Lanka",
          "delivery_address": js_ob["line1"],
          "delivery_city": js_ob["city"],
          "delivery_country": "Sri Lanka",
          "custom_1": "",
          "custom_2": ""
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        // document.getElementById('shipping_pay').onclick = function (e) {
        payhere.startPayment(payment);
        // };
      }
    }
  };
  r.open("POST", "./backend/checkoutProcess.php", true);
  r.send(f);
}

function sendInvoice(orderId, email, total) {
  
  const js_ob = {
    orderId: orderId,
    email: email,
    total: total,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {

      var t = r.responseText;

      var res_ob = JSON.parse(t);
      if(res_ob.msg == "success"){
        window.location = "invoice.php";
      }

    }
  };
  r.open("POST", "./backend/saveInvoice.php", true);
  r.send(f);
}

function invoicePrint() {
  var body = document.body.innerHTML;
  var page = document.getElementById("page").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = body;
}

function submitContact() {
  var coName = document.getElementById("coName");
  var coEmail = document.getElementById("coEmail");
  var text = document.getElementById("coMessage");

  const js_ob = {
    name: coName.value,
    email: coEmail.value,
    message: text.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      $resJs = JSON.parse(t);

      var btn = document.getElementById("btnOrder");
      btn.classList.add("d-none");

      var message = document.getElementById("homeQTYmessage");
      message.innerHTML = $resJs.msg;

      var m = document.getElementById("homeMessage");
      var hm = new bootstrap.Modal(m);
      hm.show();
    }
  };

  r.open("POST", "./backend/submitContact.php", true);
  r.send(f);
}

function adminSignIn() {
  var email = document.querySelector("#adminSignInEmail");
  var password = document.querySelector("#adminSignInPassword");

  const js_ob = {
    email: email.value,
    password: password.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      var adminSe = document.getElementById("adminSe");
      var adminSp = document.getElementById("adminSp");

      if (js_ob2.email) {
        adminSe.innerHTML = js_ob2.email;

        email.classList.add("is-invalid");
        email.oninput = function () {
          email.classList.remove("is-invalid");
        };
      } else if (js_ob2.password) {
        adminSp.innerHTML = js_ob2.password;

        password.classList.add("is-invalid");
        password.oninput = function () {
          password.classList.remove("is-invalid");
        };
      } else if (js_ob2.double) {
        adminSe.innerHTML = js_ob2.double;
        adminSp.innerHTML = js_ob2.double;

        password.classList.add("is-invalid");
        email.classList.add("is-invalid");

        password.oninput = function () {
          password.classList.remove("is-invalid");
        };

        email.oninput = function () {
          email.classList.remove("is-invalid");
        };
      } else if (js_ob2.msg) {
        window.location = "home.php";
      }
    }
  };

  r.open("POST", "../backend/adminSignIn.php", true);
  r.send(f);
}

function changeProductC() {
  var productC = document.getElementById("productViewC").value;

  window.location = "productView.php?cid=" + productC;
}

function sortPData() {
  var sortProductView = document.getElementById("sortProductView");

  const js_ob = {
    value: sortProductView.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
    }
  };
  r.open("POST", "./backend/sortProductData.php", true);
  r.send(f);
}

function changeProfileImage() {
  var view = document.getElementById("imagePreview");
  var input = document.getElementById("imageUpload");
  var button = document.getElementById("imageSave");

  input.onchange = function () {
    var file1 = this.files[0];
    var length = input.files.length;
    var url = window.URL.createObjectURL(file1);
    view.src = url;
    button.classList.remove("d-none");
  };
}

function saveImagePath() {
  var input = document.getElementById("imageUpload");

  var file = input.files[0];

  var f = new FormData();
  f.append("file", file);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob = JSON.parse(t);
      if (js_ob.msg) {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "../backend/updateProfileImage.php");
  r.send(f);
}

function adminSignOut() {
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        window.location.reload();
      }
    }
  };
  r.open("POST", "../backend/adminSignOut.php", true);
  r.send();
}

function toProductView(id) {
  const Js_ob = {
    id: id,
  };

  var json = JSON.stringify(Js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);

      if (js_ob2.msg == "noqty") {
        var m = document.getElementById("homeMessage");
        var hm = new bootstrap.Modal(m);
        hm.show();
        loadOrder(id);
      } else if (js_ob2.msg == "qty") {
        addToCart(id);
      }
    }
  };
  r.open("POST", "backend/toProductProcess.php", true);
  r.send(f);
}

function signInCheckout() {
  var loginEmail = document.getElementById("checkoutEmail1");
  var loginPassword = document.getElementById("checkoutPassword");
  var loginRememberme = document.getElementById("rememberme1");

  var obj = {
    email: loginEmail.value,
    password: loginPassword.value,
    rememberme: loginRememberme.checked,
  };

  var json = JSON.stringify(obj);

  var form = new FormData();
  form.append("json", json);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var jsObj = JSON.parse(request.responseText);

      if (jsObj.lemailText) {
        loginEmail.classList.add("is-invalid");

        loginEmail.oninput = function () {
          loginEmail.classList.remove("is-invalid");
        };
      }

      if (jsObj.pText) {
        loginPassword.classList.add("is-invalid");
        loginPassword.oninput = function () {
          loginPassword.classList.remove("is-invalid");
        };
      }

      if (jsObj.epLoginText) {
        loginPassword.classList.add("is-invalid");
        loginEmail.classList.add("is-invalid");
        loginPassword.oninput = function () {
          loginPassword.classList.remove("is-invalid");
        };
        loginEmail.oninput = function () {
          loginEmail.classList.remove("is-invalid");
        };
      }

      if (jsObj.sText) {
        addToCart(jsObj.sText);
      } else if (jsObj.spText) {
        window.location = "singleProductView.php?id=" + jsObj.spText;
      }
    }
  };

  request.open("POST", "backend/signInCheckoutProcess.php", true);
  request.send(form);
}

function guestIn() {
  var guestCheckoutEmail = document.getElementById("guestCheckoutEmail");

  const Js_ob = {
    email: guestCheckoutEmail.value,
  };

  var json = JSON.stringify(Js_ob);

  var formData = new FormData();
  formData.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      alert(t);
    }
  };
  r.open("POST", "backend/guestLogin.php", true);
  r.send(formData);
}

function changeMainImage(id) {
  var main = document.getElementById("mainImage");
  var img = document.getElementById("otherImages" + id).src;

  main.src = img;
}

function productSearch() {
  var input = document.getElementById("productSearch");

  const Js_ob = {
    search: input.value,
  };

  var json = JSON.stringify(Js_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      var show = document.getElementById("showAllHere");
      show.innerHTML = t;
    }
  };
  r.open("POST", "backend/basicProductSearch.php", true);
  r.send(f);
}

function changeProductImage() {
  var input = document.getElementById("imagesUploader");

  input.onchange = function () {
    var file = input.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("pimage1").src = url;
  };
}

function changeProductImages() {
  var image = document.getElementById("productImageUploader");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count <= 4) {
      for (var i = 0; i < file_count; i++) {
        var file = image.files[i];
        var url = window.URL.createObjectURL(file);
        document.getElementById("i" + i).src = url;
      }
    } else {
      alert("Please select less than 4 images.");
    }
  };
}

var apm;

function addProduct(num) {
  var category = document.getElementById("productViewC");

  if (!document.getElementById("collectionSelect")) {
    category.classList.add("is-invalid");
    var cintext = document.getElementById("cintext");
    cintext.innerHTML = "Please select a category";
  } else {
    var collection = document.getElementById("collectionSelect");
    var title = document.getElementById("ptitle");
    var qty = document.getElementById("pqty");
    var price = document.getElementById("pcost");
    var dca = document.getElementById("dca");
    var dcoa = document.getElementById("dcoa");
    var description = document.getElementById("desc");
    var mainImage = document.getElementById("imagesUploader");

    var images = document.getElementById("productImageUploader");

    var addPtext = document.getElementById("addPtext");
    var addPqty = document.getElementById("addSqty0");
    var addPcost = document.getElementById("addPcost");
    var addPdcost = document.getElementById("addPdcost");
    var addPdocost = document.getElementById("addPdocost");
    var addPdesc = document.getElementById("addPdesc");

    var amodal = document.getElementById("addPMessage");
    apm = new bootstrap.Modal(amodal);

    var js_ob = {
      collection: collection.value,
      title: title.value,
      qty: qty.value,
      price: price.value,
      dca: dca.value,
      dcoa: dcoa.value,
      description: description.value,
    };

    var json = JSON.stringify(js_ob);

    var f = new FormData();
    f.append("json", json);
    f.append("mainImage", mainImage.files[0]);

    var file_count = images.files.length;

    for (var i = 0; i <= file_count; i++) {
      f.append("images" + i, images.files[i]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var t = r.responseText;
        const resJs = JSON.parse(t);

        var msg = document.getElementById("addPmsgP");

        if (resJs.collection) {
          msg.innerHTML = resJs.collection;
          collection.classList.add("is-invalid");
          collection.onchange = function () {
            collection.classList.remove("is-invalid");
          };

          apm.show();
        } else if (resJs.title) {
          addPtext.innerHTML = resJs.title;
          title.classList.add("is-invalid");
          title.oninput = function () {
            title.classList.remove("is-invalid");
          };
        } else if (resJs.qty) {
          addPqty.innerHTML = resJs.qty;
          qty.classList.add("is-invalid");
          qty.oninput = function () {
            qty.classList.remove("is-invalid");
          };
        } else if (resJs.price) {
          addPcost.innerHTML = resJs.price;
          price.classList.add("is-invalid");
          price.oninput = function () {
            price.classList.remove("is-invalid");
          };
        } else if (resJs.dca) {
          addPdcost.innerHTML = resJs.dca;
          dca.classList.add("is-invalid");
          dca.oninput = function () {
            dca.classList.remove("is-invalid");
          };
        } else if (resJs.dcoa) {
          addPdocost.innerHTML = resJs.dcoa;
          dcoa.classList.add("is-invalid");
          dcoa.oninput = function () {
            dcoa.classList.remove("is-invalid");
          };
        } else if (resJs.description) {
          addPdesc.innerHTML = resJs.description;
          description.classList.add("is-invalid");
          description.oninput = function () {
            description.classList.remove("is-invalid");
          };
        } else if (resJs.msg) {
          msg.innerHTML = resJs.msg;
          apm.show();
        } else if (resJs.msg1) {
          submitQTYS(resJs.msg1, num);
        }
      }
    };
    r.open("POST", "./backend/addProduct.php", true);
    r.send(f);
  }
}

function submitQTYS(id, num) {
  const pid = id;
  const numr = num;

  var f = new FormData();
  var msg = document.getElementById("addPmsgP");

  for (var qz = 1; qz <= numr; qz++) {
    var qtysize = document.getElementById("sizeQTY" + qz);

    if (qtysize.className == "input-group mt-3 mb-1 control-qty-p suidp") {
      var sid = qtysize.id;

      var thenum = sid.replace(/^\D+/g, "");

      var input = document.getElementById("psqty" + qz);
      var msg1 = document.getElementById("addSqty" + qz);

      if (input.value > 0) {
        var size = {
          pid: pid,
          sid: thenum,
          qty: input.value,
        };

        var json = JSON.stringify(size);

        f.append("qtysize", json);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
          if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            const resJs = JSON.parse(t);

            if (resJs.msg == "success") {
              msg.innerHTML = resJs.msg;
              var btn = document.getElementById("addPclose");
              btn.onclick = function () {
                window.location = "myProducts.php";
              };
              apm.show();
            }
          }
        };
        r.open("POST", "backend/submitQTYS.php", true);
        r.send(f);
      } else {
        input.classList.add("is-invalid");
        msg1.innerHTML = "Invalid QTY";
      }
    } else {
      msg.innerHTML = "success";
      var btn = document.getElementById("addPclose");
      btn.onclick = function () {
        window.location = "myProducts.php";
      };
      apm.show();
    }
  }
}

function orderResponded(id) {
  const reqOb = {
    id: id,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success0") {
        if (document.getElementById("orderResBtn" + id)) {
          var btn = document.getElementById("orderResBtn" + id);
          btn.classList.remove("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.add("btn-manage-active");
          btn.innerHTML = "Activate";
        } else if (document.getElementById("orderCanBtn" + id)) {
          var btn = document.getElementById("orderCanBtn" + id);
          btn.classList.remove("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.add("btn-manage-active");
          btn.innerHTML = "Activate";
        } else {
          var btn = document.getElementById("orderActBtn" + id);
          btn.classList.remove("btn-manage-active");
          btn.classList.remove("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.add("btn-manage-active");
          btn.innerHTML = "Activate";
        }
      }

      if (t == "success1") {
        if (document.getElementById("orderResBtn" + id)) {
          var btn = document.getElementById("orderResBtn" + id);
          btn.classList.add("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Responded?";
        } else if (document.getElementById("orderCanBtn" + id)) {
          var btn = document.getElementById("orderCanBtn" + id);
          btn.classList.add("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Responded?";
        } else {
          var btn = document.getElementById("orderActBtn" + id);
          btn.classList.add("responded-btn");
          btn.classList.remove("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Responded?";
        }
      }

      if (t == "success2") {
        if (document.getElementById("orderResBtn" + id)) {
          var btn = document.getElementById("orderResBtn" + id);
          btn.classList.remove("responded-btn");
          btn.classList.add("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Cancel";
        } else if (document.getElementById("orderCanBtn" + id)) {
          var btn = document.getElementById("orderCanBtn" + id);
          btn.classList.remove("responded-btn");
          btn.classList.add("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Cancel";
        } else {
          var btn = document.getElementById("orderActBtn" + id);
          btn.classList.remove("responded-btn");
          btn.classList.add("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Cancel";
        }
      }
    }
  };
  r.open("POST", "../backend/orderResponded.php", true);
  r.send(f);
}

function userStatus(email) {
  const resOb = {
    email: email,
  };

  var json = JSON.stringify(resOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success0") {
        if (document.getElementById("userBlockbtn'" + email + "'")) {
          var btn = document.getElementById("userBlockbtn'" + email + "'");
          btn.classList.remove("btn-edit-manage");
          btn.classList.add("btn-manage-active");
          btn.innerHTML = "Activate";
        } else if (document.getElementById("userActBtn'" + email + "'")) {
          var btn = document.getElementById("userActBtn'" + email + "'");
          btn.classList.remove("btn-edit-manage");
          btn.classList.add("btn-manage-active");
          btn.innerHTML = "Activate";
        }
      }

      if (t == "success1") {
        if (document.getElementById("userBlockbtn'" + email + "'")) {
          var btn = document.getElementById("userBlockbtn'" + email + "'");
          btn.classList.add("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Block";
        } else if (document.getElementById("userActBtn'" + email + "'")) {
          var btn = document.getElementById("userActBtn'" + email + "'");
          btn.classList.add("btn-edit-manage");
          btn.classList.remove("btn-manage-active");
          btn.innerHTML = "Block";
        }
      }
    }
  };
  r.open("POST", "../backend/userStatusChange.php", true);
  r.send(f);
}

function loadCollection() {
  var value = document.getElementById("productViewC");
  value.classList.remove("is-invalid");

  const reqOb = {
    cid: value.value,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var div = document.getElementById("collectionS");
      div.innerHTML = t;
    }
  };
  r.open("POST", "backend/loadCollection.php", true);
  r.send(f);
}

function reduceQTY(id) {
  var cartQTY = document.getElementById("qtySelector" + id);

  var value = cartQTY.value;

  var new_v = parseInt(value);

  var q;

  if (new_v == 1) {
  } else {
    q = new_v - 1;
    cartQTY.value = q;
  }
}

function addQTY(id, qty) {
  var cartQTY = document.getElementById("qtySelector" + id);

  var value = cartQTY.value;

  var new_v = parseInt(value);

  var q;

  if (new_v >= qty) {
    cartQTY.value = qty;
  } else {
    q = new_v + 1;
    cartQTY.value = q;
  }
}

var apm;

function addProduct(num) {
  var category = document.getElementById("productViewC");

  if (!document.getElementById("collectionSelect")) {
    category.classList.add("is-invalid");
    var cintext = document.getElementById("cintext");
    cintext.innerHTML = "Please select a category";
  } else {
    var collection = document.getElementById("collectionSelect");
    var title = document.getElementById("ptitle");
    var qty = document.getElementById("pqty");
    var price = document.getElementById("pcost");
    var dca = document.getElementById("dca");
    var dcoa = document.getElementById("dcoa");
    var description = document.getElementById("desc");
    var mainImage = document.getElementById("imagesUploader");

    var images = document.getElementById("productImageUploader");

    var addPtext = document.getElementById("addPtext");
    var addPqty = document.getElementById("addSqty0");
    var addPcost = document.getElementById("addPcost");
    var addPdcost = document.getElementById("addPdcost");
    var addPdocost = document.getElementById("addPdocost");
    var addPdesc = document.getElementById("addPdesc");

    var amodal = document.getElementById("addPMessage");
    apm = new bootstrap.Modal(amodal);

    var js_ob = {
      collection: collection.value,
      title: title.value,
      qty: qty.value,
      price: price.value,
      dca: dca.value,
      dcoa: dcoa.value,
      description: description.value,
    };

    var json = JSON.stringify(js_ob);

    var f = new FormData();
    f.append("json", json);
    f.append("mainImage", mainImage.files[0]);

    var file_count = images.files.length;

    for (var i = 0; i <= file_count; i++) {
      f.append("images" + i, images.files[i]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var t = r.responseText;
        const resJs = JSON.parse(t);

        var msg = document.getElementById("addPmsgP");

        if (resJs.collection) {
          msg.innerHTML = resJs.collection;
          collection.classList.add("is-invalid");
          collection.onchange = function () {
            collection.classList.remove("is-invalid");
          };

          apm.show();
        } else if (resJs.title) {
          addPtext.innerHTML = resJs.title;
          title.classList.add("is-invalid");
          title.oninput = function () {
            title.classList.remove("is-invalid");
          };
        } else if (resJs.qty) {
          addPqty.innerHTML = resJs.qty;
          qty.classList.add("is-invalid");
          qty.oninput = function () {
            qty.classList.remove("is-invalid");
          };
        } else if (resJs.price) {
          addPcost.innerHTML = resJs.price;
          price.classList.add("is-invalid");
          price.oninput = function () {
            price.classList.remove("is-invalid");
          };
        } else if (resJs.dca) {
          addPdcost.innerHTML = resJs.dca;
          dca.classList.add("is-invalid");
          dca.oninput = function () {
            dca.classList.remove("is-invalid");
          };
        } else if (resJs.dcoa) {
          addPdocost.innerHTML = resJs.dcoa;
          dcoa.classList.add("is-invalid");
          dcoa.oninput = function () {
            dcoa.classList.remove("is-invalid");
          };
        } else if (resJs.description) {
          addPdesc.innerHTML = resJs.description;
          description.classList.add("is-invalid");
          description.oninput = function () {
            description.classList.remove("is-invalid");
          };
        } else if (resJs.msg) {
          msg.innerHTML = resJs.msg;
          apm.show();
        } else if (resJs.msg1) {
          submitQTYS(resJs.msg1, num);
        }
      }
    };
    r.open("POST", "./backend/addProduct.php", true);
    r.send(f);
  }
}

function addProductAdmin(num) {
  var category = document.getElementById("productViewC");

  if (!document.getElementById("collectionSelect")) {
    category.classList.add("is-invalid");
    var cintext = document.getElementById("cintext");
    cintext.innerHTML = "Please select a category";
  } else {
    var collection = document.getElementById("collectionSelect");
    var title = document.getElementById("ptitle");
    var qty = document.getElementById("pqty");
    var price = document.getElementById("pcost");
    var dca = document.getElementById("dca");
    var dcoa = document.getElementById("dcoa");
    var description = document.getElementById("desc");
    var mainImage = document.getElementById("imagesUploader");

    var status = 0;

    if (document.getElementById("DeactiveAP").checked) {
      status = 1;
    } else if (document.getElementById("ActiveAP").checked) {
      status = 2;
    } else if (document.getElementById("ExclusiveAP").checked) {
      status = 3;
    } else if (document.getElementById("NewAP").checked) {
      status = 4;
    } else if (document.getElementById("SaleAP").checked) {
      status = 5;
    } else if (document.getElementById("Out of stockAP").checked) {
      status = 6;
    }

    var images = document.getElementById("productImageUploader");

    var addPtext = document.getElementById("addPtext");
    var addPqty = document.getElementById("addPqty");
    var addPcost = document.getElementById("addPcost");
    var addPdcost = document.getElementById("addPdcost");
    var addPdocost = document.getElementById("addPdocost");
    var addPdesc = document.getElementById("addPdesc");

    var amodal = document.getElementById("addPMessage");
    apm = new bootstrap.Modal(amodal);

    var js_ob = {
      collection: collection.value,
      title: title.value,
      qty: qty.value,
      price: price.value,
      dca: dca.value,
      dcoa: dcoa.value,
      description: description.value,
      status: status,
    };

    var json = JSON.stringify(js_ob);

    var f = new FormData();
    f.append("json", json);
    f.append("mainImage", mainImage.files[0]);

    var file_count = images.files.length;

    for (var i = 0; i <= file_count; i++) {
      f.append("images" + i, images.files[i]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var t = r.responseText;
        const resJs = JSON.parse(t);

        var msg = document.getElementById("addPmsgP");

        if (resJs.collection) {
          msg.innerHTML = resJs.collection;
          collection.classList.add("is-invalid");
          collection.onchange = function () {
            collection.classList.remove("is-invalid");
          };

          apm.show();
        } else if (resJs.title) {
          addPtext.innerHTML = resJs.title;
          title.classList.add("is-invalid");
          title.oninput = function () {
            title.classList.remove("is-invalid");
          };
        } else if (resJs.qty) {
          addPqty.innerHTML = resJs.qty;
          qty.classList.add("is-invalid");
          qty.oninput = function () {
            qty.classList.remove("is-invalid");
          };
        } else if (resJs.price) {
          addPcost.innerHTML = resJs.price;
          price.classList.add("is-invalid");
          price.oninput = function () {
            price.classList.remove("is-invalid");
          };
        } else if (resJs.dca) {
          addPdcost.innerHTML = resJs.dca;
          dca.classList.add("is-invalid");
          dca.oninput = function () {
            dca.classList.remove("is-invalid");
          };
        } else if (resJs.dcoa) {
          addPdocost.innerHTML = resJs.dcoa;
          dcoa.classList.add("is-invalid");
          dcoa.oninput = function () {
            dcoa.classList.remove("is-invalid");
          };
        } else if (resJs.description) {
          addPdesc.innerHTML = resJs.description;
          description.classList.add("is-invalid");
          description.oninput = function () {
            description.classList.remove("is-invalid");
          };
        } else if (resJs.msg) {
          msg.innerHTML = resJs.msg;
          apm.show();
        } else if (resJs.msg1) {
          submitAdminQTYS(resJs.msg1, num);
        }
      }
    };
    r.open("POST", "../backend/addProductAdmin.php", true);
    r.send(f);
  }
}

function submitAdminQTYS(id, num) {
  const pid = id;
  const numr = num;

  var f = new FormData();
  var msg = document.getElementById("addPmsgP");

  for (var qz = 1; qz <= numr; qz++) {
    var qtysize = document.getElementById("sizeQTY" + qz);

    if (qtysize.className == "input-group mt-3 mb-1 control-qty-p suidp") {
      var sid = qtysize.id;

      var thenum = sid.replace(/^\D+/g, "");

      var input = document.getElementById("psqty" + qz);
      var msg1 = document.getElementById("addSqty" + qz);

      if (input.value > 0) {
        var size = {
          pid: pid,
          sid: thenum,
          qty: input.value,
        };

        var json = JSON.stringify(size);

        f.append("qtysize", json);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
          if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            const resJs = JSON.parse(t);

            if (resJs.msg == "success") {
              msg.innerHTML = resJs.msg;
              var btn = document.getElementById("addPclose");
              btn.onclick = function () {
                window.location = "manageProducts.php";
              };
              apm.show();
            }
          }
        };
        r.open("POST", "../backend/submitQTYS.php", true);
        r.send(f);
      } else {
        input.classList.add("is-invalid");
        msg1.innerHTML = "Invalid QTY";
      }
    } else {
      msg.innerHTML = "success";
      var btn = document.getElementById("addPclose");
      btn.onclick = function () {
        window.location = "manageProducts.php";
      };
      apm.show();
    }
  }
}

function loadCollectionAdmin() {
  var value = document.getElementById("productViewC");
  value.classList.remove("is-invalid");

  const reqOb = {
    cid: value.value,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var div = document.getElementById("collectionS");
      div.innerHTML = t;
    }
  };
  r.open("POST", "../backend/loadCollection.php", true);
  r.send(f);
}

function showBuyModal(id) {
  var modal = document.getElementById("buyModal" + id);
  bmm = new bootstrap.Modal(modal);
  bmm.show();
}

function showSQTY(id, num) {
  var btn = document.getElementById("qtySbtn" + id);
  var input = document.getElementById("sizeQTY" + id);
  hideSQTYall(num);

  btn.classList.toggle("btn-purple-size");
  input.classList.toggle("d-none");
  input.classList.toggle("suidp");
  input.value = 0;
}

function showSQTYupdate(id, num) {
  var btn = document.getElementById("qtySbtn" + id);
  var input = document.getElementById("sizeQTY" + id);
  hideSQTYall(num);

  btn.classList.toggle("btn-purple-size");
  input.classList.toggle("d-none");
  input.classList.toggle("suidp");
}

function hideSQTY(num) {
  var btnN = document.getElementById("qtySbtn0");
  var div = document.getElementById("qtyDiv");
  div.classList.add("d-none");
  btnN.classList.add("btn-purple-size");
  for (var b = 1; b <= num; b++) {
    var btn = document.getElementById("qtySbtn" + b);
    btn.classList.remove("btn-purple-size");

    var inputdiv = document.getElementById("sizeQTY" + b);
    inputdiv.classList.add("d-none");
    var input = document.getElementById("psqty" + b);
    input.value = 0;
  }
  var input1 = document.getElementById("pqty");
  input1.value = 0;
  var inputdiv1 = document.getElementById("sizeQTY0");
  inputdiv1.classList.remove("d-none");
}

function hideSQTYupdate(num) {
  var btnN = document.getElementById("qtySbtn0");
  var div = document.getElementById("qtyDiv");
  div.classList.add("d-none");
  btnN.classList.add("btn-purple-size");
  for (var b = 1; b <= num; b++) {
    var btn = document.getElementById("qtySbtn" + b);
    btn.classList.remove("btn-purple-size");

    var inputdiv = document.getElementById("sizeQTY" + b);
    inputdiv.classList.add("d-none");
    var input = document.getElementById("psqty" + b);
  }
  var input1 = document.getElementById("pqty");
  input1.value = 0;
  var inputdiv1 = document.getElementById("sizeQTY0");
  inputdiv1.classList.remove("d-none");
}

function hideSQTYall() {
  var btnN = document.getElementById("qtySbtn0");
  var div = document.getElementById("qtyDiv");
  div.classList.remove("d-none");
  btnN.classList.remove("btn-purple-size");

  var inputdiv = document.getElementById("sizeQTY0");
  inputdiv.classList.add("d-none");
}

function qtyValueCheck(id) {
  var input = document.getElementById("psqty" + id);
  var msg = document.getElementById("addSqty" + id);

  const reqJs = {
    qty: input.value,
  };

  var json = JSON.stringify(reqJs);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var resOb = JSON.parse(t);

      if (resOb.msg) {
        input.classList.add("is-invalid");
        msg.innerHTML = resOb.msg;

        input.oninput = function () {
          input.classList.remove("is-invalid");
        };
      }
    }
  };
  r.open("POST", "backend/checkProductQTY.php", true);
  r.send(f);
}

function removeProduct(id) {
  const reqOb = {
    id: id,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var resOb = JSON.parse(t);
      if (resOb.msg == "success") {
        window.location.reload();
      } else {
        alert(resOb.msg);
      }
    }
  };

  r.open("POST", "backend/removeProducts.php", true);
  r.send(f);
}

function changeMainImageSpw(id) {
  var main = document.getElementById("mainImageSpw");
  var image = document.getElementById("otherImagesSpw" + id);

  main.src = image.src;
}

function viewMessages(from) {
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var chatbox = document.getElementById("chat_box");
      chatbox.innerHTML = t;
      chatbox.scrollTop = chatbox.scrollHeight;
    }
  };
  r.open("POST", "../backend/viewAdminMsg.php?e=" + from, true);
  r.send();
}

function viewMessagesUser(from) {
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var chatbox = document.getElementById("chat_box");
      chatbox.innerHTML = t;
      chatbox.scrollTop = chatbox.scrollHeight;
    }
  };
  r.open("POST", "./backend/viewUserMsg.php?e=" + from, true);
  r.send();
}

function send_msg() {
  var msg = document.getElementById("msg_txt");
  var text = document.getElementById("adminmsg");

  if (document.getElementById("rmail")) {
    var rmail = document.getElementById("rmail");

    const reqOb = {
      msg: msg.value,
      rmail: rmail.innerHTML,
    };

    var json = JSON.stringify(reqOb);

    var f = new FormData();
    f.append("json", json);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var t = r.responseText;
        const resObj = JSON.parse(t);

        if (resObj.msg == "success") {
          msg.value = null;
          viewMessages(rmail.innerHTML);
        } else {
          text.innerHTML = resObj.msg;
          msg.classList.add("is-invalid");
          msg.oninput = function () {
            msg.classList.remove("is-invalid");
          };
        }
      }
    };
    r.open("POST", "../backend/sendMessage.php", true);
    r.send(f);
  } else {
  }
}

function send_msg_user() {
  var msg = document.getElementById("msg_txt");
  var text = document.getElementById("adminmsg");

  if (document.getElementById("rmail")) {
    var rmail = document.getElementById("rmail");

    const reqOb = {
      msg: msg.value,
      rmail: rmail.innerHTML,
    };

    var json = JSON.stringify(reqOb);

    var f = new FormData();
    f.append("json", json);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var t = r.responseText;
        const resObj = JSON.parse(t);

        if (resObj.msg == "success") {
          msg.value = null;
          viewMessages(rmail.innerHTML);
        } else {
          text.innerHTML = resObj.msg;
          msg.classList.add("is-invalid");
          msg.oninput = function () {
            msg.classList.remove("is-invalid");
          };
        }
      }
    };
    r.open("POST", "./backend/sendMessageUser.php", true);
    r.send(f);
  } else {
  }
}

window.addEventListener("keyup", function (event) {
  var k = event.which;
  if (k == 13) {
    send_msg();
  }
});

function showSpwQTY(price, sizeid, pid) {
  var input = document.getElementById("qtySelectorspw" + pid);
  var btn = document.getElementById("qtySbtn" + sizeid + pid);
  var stock = document.getElementById("insvalue" + pid);
  var label = document.getElementById("oosn" + pid);

  const reqOb = {
    pid: pid,
    sizeid: sizeid,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const resOb = JSON.parse(t);
      if (resOb.qty) {
        var max = parseInt(resOb.qty);

        var btns = document.querySelectorAll(".a_csk" + pid);

        if (max == 0) {
          input.value = 0;
          stock.innerHTML = null;
          input.classList.add("disabled");
          input.setAttribute("max", 0);
          input.setAttribute("Disabled", "");
          label.classList.add("oos");
          label.innerHTML = " Out of stock ";
        } else {
          input.value = 1;
          stock.innerHTML = max;
          input.classList.remove("disabled");
          input.setAttribute("max", max);
          input.removeAttribute("Disabled");
          label.classList.remove("oos");
          label.innerHTML = " In stock: ";

          var buyNow = document.getElementById("buyNowSPW"+pid);
          buyNow.onclick = function () {
            savePriceSize(pid, sizeid);
          };
        }

        for (const n of btns) {
          n.classList.remove("btn-purple-size");
          btn.classList.add("btn-purple-size");
          changeQTYsize(price, pid);
        }
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "backend/showQTY.php", true);
  r.send(f);
}

function reduceQTYspw(id) {
  var spwQTY = document.getElementById("qtySelectorspw" + id);

  var value = spwQTY.value;

  var new_v = parseInt(value);

  var q;

  if (new_v == 1) {
  } else {
    q = new_v - 1;
    spwQTY.value = q;
  }
}

function addQTYspw(qty, id) {
  var spwQTY = document.getElementById("qtySelectorspw" + id);

  var value = spwQTY.value;

  var new_v = parseInt(value);

  var q;

  if (new_v >= qty) {
  } else {
    q = new_v + 1;
    spwQTY.value = q;
  }
}

function changeQTYsize(price, id) {
  var input = document.getElementById("qtySelectorspw" + id);

  var maxi = input.getAttribute("max");

  var max = parseInt(maxi);

  var iqty = parseInt(input.value);

  var new_price;

  if (iqty <= 0) {
    iqty = 0;
    input.value = iqty;
    new_price = 1 * price;
  } else if (iqty > max) {
    input.value = max;
    iqty = max;
    new_price = iqty * price;
  } else if (max == 0) {
    iqty = 0;
    input.value = iqty;
    new_price = 1 * price;
  } else {
    new_price = iqty * price;
  }

  document.getElementById("priceTag" + id).innerHTML = new_price;

  const JS_ob = {
    id: id,
    qty: iqty,
    price: price,
  };

  var json = JSON.stringify(JS_ob);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const js_ob2 = JSON.parse(t);
      if (js_ob2.total) {
        total_checkout = js_ob2.total;

        if (document.getElementById("subtotal")) {
          var subtotal = document.getElementById("subtotal");
          subtotal.innerHTML = total_checkout;
        }

        if (document.getElementById("a_total")) {
          var a_total = document.getElementById("a_total");
          a_total.innerHTML = total_checkout;
        }
      }
    }
  };

  r.open("POST", "./backend/checkCartTotal.php", true);
  r.send(f);
}

function savePriceSize(id, sizeid) {
  var qtySelector = document.getElementById("qtySelectorspw" + id);

  const reqOb = {
    id: id,
    qty: qtySelector.value,
    sizeid: sizeid,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      if (r.responseText == "success") {
        window.location = "shipping.php";
      } else {
        alert(r.responseText);
      }
    }
  };

  r.open("POST", "./backend/savePriceSize.php", true);
  r.send(f);
}

function userForgotPassword() { }

var fmph;

function setRate(id, pid) {
  var star = document.getElementById(id);

  star.classList.add("star-back");

  var modal = document.getElementById("feedbackModal" + pid);
  var fmph = new bootstrap.Modal(modal);
  fmph.show();

  var btn = document.getElementById("ph_close" + pid);
  btn.onclick = function () {
    star.classList.remove("star-back");
  };

  var submit = document.getElementById("fphsbtn" + pid);
  submit.onclick = function () {
    saveFeedback(id, pid);
  };
}

function saveFeedback(type, id) {
  var msg = document.getElementById("textph");

  var thenum = type.replace(/^\D+/g, "");

  var one = String(thenum).charAt(0);

  var type_num = Number(one);

  const reqOb = {
    id: id,
    msg: msg.value,
    type: type_num,
  };

  var json = JSON.stringify(reqOb);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var resOb = JSON.parse(t);

      if (resOb.msg == "success") {
        window.location.reload();
      } else {
        msg.classList.add("is-invalid");
        msg.oninput = function () {
          msg.classList.remove("is-invalid");
        };
      }
    }
  };
  r.open("POST", "./backend/saveFeedback.php", true);
  r.send(f);
}

function updateProductAdmin(id, img_num, num) {

  var collection = document.getElementById("collectionSelect");
  var title = document.getElementById("putitle");
  var qty = document.getElementById("puqty");

  var status = 0;

  if (document.getElementById("DeactiveUP").checked) {
    status = 1;
  } else if (document.getElementById("ActiveUP").checked) {
    status = 2;
  } else if (document.getElementById("ExclusiveUP").checked) {
    status = 3;
  } else if (document.getElementById("NewUP").checked) {
    status = 4;
  } else if (document.getElementById("SaleUP").checked) {
    status = 5;
  } else if (document.getElementById("Out of stockUP").checked) {
    status = 6;
  }

  var price = document.getElementById("pucost");
  var dca = document.getElementById("udca");
  var dcoa = document.getElementById("udcoa");
  var description = document.getElementById("udesc");
  var mainImage = document.getElementById("imagesUploader");

  var images = document.getElementById("productImageUploader");

  var js_ob = {
    img_num: img_num,
    id: id,
    collection: collection.value,
    title: title.value,
    qty: qty.value,
    status: status,
    price: price.value,
    dca: dca.value,
    dcoa: dcoa.value,
    description: description.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);
  f.append("mainImage", mainImage.files[0]);

  var file_count = images.files.length;

  for (var i = 0; i <= file_count; i++) {
    f.append("images" + i, images.files[i]);
  }

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const resJs = JSON.parse(t);

      var amodal = document.getElementById("addPMessage");
      apm = new bootstrap.Modal(amodal);

      var msg = document.getElementById("addPmsgP");

      if (resJs.collection) {
        msg.innerHTML = resJs.collection;
        collection.classList.add("is-invalid");
        collection.onchange = function () {
          collection.classList.remove("is-invalid");
        };
      } else if (resJs.title) {
        msg.innerHTML = resJs.title;
        title.classList.add("is-invalid");
        title.oninput = function () {
          title.classList.remove("is-invalid");
        };
      } else if (resJs.qty) {
        msg.innerHTML = resJs.qty;
        qty.classList.add("is-invalid");
        qty.oninput = function () {
          qty.classList.remove("is-invalid");
        };
      } else if (resJs.price) {
        msg.innerHTML = resJs.price;
        price.classList.add("is-invalid");
        price.oninput = function () {
          price.classList.remove("is-invalid");
        };
      } else if (resJs.dca) {
        msg.innerHTML = resJs.dca;
        dca.classList.add("is-invalid");
        dca.oninput = function () {
          dca.classList.remove("is-invalid");
        };
      } else if (resJs.dcoa) {
        msg.innerHTML = resJs.dcoa;
        dcoa.classList.add("is-invalid");
        dcoa.oninput = function () {
          dcoa.classList.remove("is-invalid");
        };
      } else if (resJs.description) {
        msg.innerHTML = resJs.description;
        description.classList.add("is-invalid");
        description.oninput = function () {
          description.classList.remove("is-invalid");
        };
      } else if (resJs.msg1) {
        submitQTYSupdateAdmin(id, num);
      } else if (resJs.msg) {
        msg.innerHTML = resJs.msg;
        apm.show();
      }
    }
  };
  r.open("POST", "../backend/updateProductAdmin.php", true);
  r.send(f);
}

function updateProduct(id, img_num, num) {

  var collection = document.getElementById("collectionSelect");
  var title = document.getElementById("putitle");
  var qty = document.getElementById("puqty");

  var price = document.getElementById("pucost");
  var dca = document.getElementById("udca");
  var dcoa = document.getElementById("udcoa");
  var description = document.getElementById("udesc");
  var mainImage = document.getElementById("imagesUploader");

  var images = document.getElementById("productImageUploader");

  var js_ob = {
    img_num: img_num,
    id: id,
    collection: collection.value,
    title: title.value,
    qty: qty.value,
    price: price.value,
    dca: dca.value,
    dcoa: dcoa.value,
    description: description.value,
  };

  var json = JSON.stringify(js_ob);

  var f = new FormData();
  f.append("json", json);
  f.append("mainImage", mainImage.files[0]);

  var file_count = images.files.length;

  for (var i = 0; i <= file_count; i++) {
    f.append("images" + i, images.files[i]);
  }

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      const resJs = JSON.parse(t);

      var amodal = document.getElementById("addPMessage");
      apm = new bootstrap.Modal(amodal);

      var msg = document.getElementById("addPmsgP");

      if (resJs.collection) {
        msg.innerHTML = resJs.collection;
        collection.classList.add("is-invalid");
        collection.onchange = function () {
          collection.classList.remove("is-invalid");
        };
      } else if (resJs.title) {
        msg.innerHTML = resJs.title;
        title.classList.add("is-invalid");
        title.oninput = function () {
          title.classList.remove("is-invalid");
        };
      } else if (resJs.qty) {
        msg.innerHTML = resJs.qty;
        qty.classList.add("is-invalid");
        qty.oninput = function () {
          qty.classList.remove("is-invalid");
        };
      } else if (resJs.price) {
        msg.innerHTML = resJs.price;
        price.classList.add("is-invalid");
        price.oninput = function () {
          price.classList.remove("is-invalid");
        };
      } else if (resJs.dca) {
        msg.innerHTML = resJs.dca;
        dca.classList.add("is-invalid");
        dca.oninput = function () {
          dca.classList.remove("is-invalid");
        };
      } else if (resJs.dcoa) {
        msg.innerHTML = resJs.dcoa;
        dcoa.classList.add("is-invalid");
        dcoa.oninput = function () {
          dcoa.classList.remove("is-invalid");
        };
      } else if (resJs.description) {
        msg.innerHTML = resJs.description;
        description.classList.add("is-invalid");
        description.oninput = function () {
          description.classList.remove("is-invalid");
        };
      } else if (resJs.msg1) {
        submitQTYSupdate(id, num);
      } else if (resJs.msg) {
        msg.innerHTML = resJs.msg;
        apm.show();
      }
    }
  };
  r.open("POST", "./backend/updateProduct.php", true);
  r.send(f);
}

function submitQTYSupdateAdmin(id, num) {

  const pid = id;
  const numr = num;

  var f = new FormData();

  var amodal = document.getElementById("addPMessage");
  apm = new bootstrap.Modal(amodal);
  var msg = document.getElementById("addPmsgP");
  var btn = document.getElementById("pauclose");

  for (var qz = 1; qz <= numr; qz++) {
    var qtysize = document.getElementById("sizeQTY" + qz);

    if (qtysize.className == "input-group mt-3 mb-1 control-qty-p suidp") {
      var sid = qtysize.id;

      var thenum = sid.replace(/^\D+/g, "");

      var input = document.getElementById("psqty" + qz);
      var msg1 = document.getElementById("addSqty" + qz);

      if (input.value > 0) {
        var size = {
          pid: pid,
          sid: thenum,
          qty: input.value,
        };

        var json = JSON.stringify(size);

        f.append("qtysize", json);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
          if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            const resJs = JSON.parse(t);

            if (resJs.msg == "success") {
              msg.innerHTML = resJs.msg;
              btn.onclick = function () {
                window.location = "manageProducts.php";
              };
              apm.show();
            }
          }
        };
        r.open("POST", "../backend/submitQTYSupdate.php", true);
        r.send(f);

      } else {
        input.classList.add("is-invalid");
        msg1.innerHTML = "Invalid QTY";
      }
    } else {

      var sidn = qtysize.id;

      var thenumn = sidn.replace(/^\D+/g, "");

      var dsize = {
        pid: pid,
        sid: thenumn,
      };

      var jsonn = JSON.stringify(dsize);

      f.append("qtysized", jsonn);

      var r2 = new XMLHttpRequest();
      r2.onreadystatechange = function () {
        if (r2.readyState == 4 && r2.status == 200) {

          var t2 = r2.responseText;
          const resJsD = JSON.parse(t2);

          if (resJsD.msg == "success") {
            msg.innerHTML = resJsD.msg;
            btn.onclick = function () {
              window.location = "manageProducts.php";
            };
            apm.show();
          }
        }
      };
      r2.open("POST", "../backend/notSubmitQTYSupdate.php", true);
      r2.send(f);
    }
  }
}

function submitQTYSupdate(id, num) {

  const pid = id;
  const numr = num;

  var f = new FormData();

  var amodal = document.getElementById("addPMessage");
  apm = new bootstrap.Modal(amodal);
  var msg = document.getElementById("addPmsgP");
  var btn = document.getElementById("pauclose");

  for (var qz = 1; qz <= numr; qz++) {
    var qtysize = document.getElementById("sizeQTY" + qz);

    if (qtysize.className == "input-group mt-3 mb-1 control-qty-p suidp") {
      var sid = qtysize.id;

      var thenum = sid.replace(/^\D+/g, "");

      var input = document.getElementById("psqty" + qz);
      var msg1 = document.getElementById("addSqty" + qz);

      if (input.value > 0) {
        var size = {
          pid: pid,
          sid: thenum,
          qty: input.value,
        };

        var json = JSON.stringify(size);

        f.append("qtysize", json);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
          if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            const resJs = JSON.parse(t);

            if (resJs.msg == "success") {
              msg.innerHTML = resJs.msg;
              btn.onclick = function () {
                window.location = "myProducts.php";
              };
              apm.show();
            }
          }
        };
        r.open("POST", "./backend/submitQTYSupdate.php", true);
        r.send(f);
      } else {
        input.classList.add("is-invalid");
        msg1.innerHTML = "Invalid QTY";
      }
    } else {

      var sidn = qtysize.id;

      var thenumn = sidn.replace(/^\D+/g, "");

      var dsize = {
        pid: pid,
        sid: thenumn,
      };

      var jsonn = JSON.stringify(dsize);

      f.append("qtysized", jsonn);

      var r = new XMLHttpRequest();
      r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {

          var t2 = r.responseText;
          const resJsD = JSON.parse(t2);

          if (resJsD.msg == "success") {
            msg.innerHTML = resJsD.msg;
            btn.onclick = function () {
              window.location = "myProducts.php";
            };
            apm.show();
          }
        }
      };
      r.open("POST", "./backend/notSubmitQTYSupdate.php", true);
      r.send(f);
    }
  }
}

function qtyValueCheckAdmin(id) {
  var input = document.getElementById("psqty" + id);
  var msg = document.getElementById("addSqty" + id);

  const reqJs = {
    qty: input.value,
  };

  var json = JSON.stringify(reqJs);

  var f = new FormData();
  f.append("json", json);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      var resOb = JSON.parse(t);

      if (resOb.msg) {
        input.classList.add("is-invalid");
        msg.innerHTML = resOb.msg;

        input.oninput = function () {
          input.classList.remove("is-invalid");
        };
      }
    }
  };
  r.open("POST", "../backend/checkProductQTY.php", true);
  r.send(f);
}
