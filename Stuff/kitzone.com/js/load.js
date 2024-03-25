

var loader = document.getElementById('loader');
var page = document.getElementById('boo');
page.style.opacity = '0';
var myFunc = function() {
  page.style.opacity  = '1';
   loader.style.display = 'none';
}
window.onload = function() {
  setTimeout(myFunc, 200);
}
