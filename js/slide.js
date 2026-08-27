function toLeft() {
  var x = document.getElementById("slide-item");
  x.className = "slide-item toleft";

  var y = document.getElementById("form1");
  y.className = "form toleft";

  var z = document.getElementById("form2");
  z.className = "form toleft2";
}
function toRight() {
  var x = document.getElementById("slide-item");
  x.className = "slide-item toright";

  var y = document.getElementById("form1");
  y.className = "form toright2";

  var z = document.getElementById("form2");
  z.className = "form toright2";
}