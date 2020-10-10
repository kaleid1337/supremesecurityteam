$("#password").keyup(function(event){
    if(event.keyCode == 13){
        login();
    }
});

function login()
{
var user=$('#username').val();
var password=$('#password').val();
var remember=$('input:checkbox:checked').val();
document.getElementById("alert").style.display="none";
document.getElementById("loader").style.display="inline";
document.getElementById("hidebtn").style.display="none";
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
  document.getElementById("hidebtn").style.display="inline";
	if (xmlhttp.responseText.search("Redirecting") != -1)
	{
	setInterval(function(){window.location="index.php"},3000);
    }
    }
  }
xmlhttp.open("POST","ajax/login.php?type=login",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("user=" + user + "&password=" + password + "&remember=" + remember);
}