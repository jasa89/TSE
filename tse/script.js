/*side navin toiminnallisuus funktio*/
function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
  }
  
/*side navin toiminnallisuus funktio*/
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
  }
/*salasanan näyttö/ piilotus funktio*/
  function passFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
 /* topnavin piilotus ja näyttö funktio*/
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
/*toggle arrow*/
function my2Function(x) {
  x.classList.toggle("fa-arrow-up");
  x.classList.toggle("fa-arrow-down");
}