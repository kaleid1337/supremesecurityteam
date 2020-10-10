function register(cC)
{
var username=$('#username').val();
var email=$('#email').val();
var password=$('#password').val();
var rpassword=$('#rpassword').val();
var question=$('#question').val();
var terms=$('input:checkbox:checked').val();
var response=$('#g-recaptcha-response').val();

document.getElementById("alert").style.display="none";
document.getElementById("loader").style.display="inline"; 
var xmlhttp;
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("alert").innerHTML=xmlhttp.responseText;
  document.getElementById("loader").style.display="none";
  document.getElementById("alert").style.display="inline";
  if (xmlhttp.responseText.search("Redirecting") != -1)
  {
  setInterval(function(){window.location="index.php"},3000);
    }
    }
  }
xmlhttp.open("POST","ajax/login.php?type=register",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("username=" + username + "&email=" + email + "&password=" + password + "&rpassword=" + rpassword + "&question=" + question + "&answer=" + answer + "&terms=" + terms + "&d=" + response);
}