function Clickp()
{
var cpassword=$('#cpassword').val();
var npassword=$('#npassword').val();
var rpassword=$('#rpassword').val();


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
xmlhttp.open("POST","ajax/profile.php?type=updatePassBtn",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("cpassword=" + cpassword + "&npassword=" + npassword + "&rpassword=" + rpassword);
}


function Clicks()
{
var 2step=$('#2step').val();
var apis=$('#apis').val();
var email=$('#email').val();
var currentcode=$('#currentcode').val();
var checkpassword=$('#checkpassword').val();


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
xmlhttp.open("POST","ajax/profile.php?type=updateSMBtn",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("cpassword=" + cpassword + "&npassword=" + npassword + "&rpassword=" + rpassword);
}

