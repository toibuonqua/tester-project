function password_show_hide(idInput="", showEye="show_eye", hideEye="hide_eye") {
    var x = document.getElementById(idInput);
    var show_eye = document.getElementById(showEye);
    var hide_eye = document.getElementById(hideEye);
    show_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    } else {
      x.type = "password";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    }
  }
