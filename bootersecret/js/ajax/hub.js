function attack()
{
var host=$('#host').val();
var time=$('#time').val();
var method=$('#method').val();
var port=$('#port').val();
document.getElementById("attackalert").style.display="none";
document.getElementById("attackloader").style.display="inline";
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
    document.getElementById("attackalert").innerHTML=xmlhttp.responseText;
	document.getElementById("attackloader").style.display="none";
	document.getElementById("attackalert").style.display="inline";
	if (xmlhttp.responseText.search("Attack sent successfully") != -1)
	{

    }
    }
  }
xmlhttp.open("POST","ajax/hub.php?type=start",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("host=" + host + "&time=" + time + "&port=" + port + "&method=" + method);
}

function renew(id)
{
document.getElementById("attackalert").style.display="none";
document.getElementById("attackloader").style.display="inline";
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
    document.getElementById("attackalert").innerHTML=xmlhttp.responseText;
	document.getElementById("attackloader").style.display="none";
	document.getElementById("attackalert").style.display="inline";
	if (xmlhttp.responseText.search("Attack sent successfully") != -1)
	{
	attacks();
    }
    }
  }
xmlhttp.open("POST","ajax/hub.php?type=renew",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id=" + id);
}

function stop(id)
{
document.getElementById("attackalert").style.display="none";
document.getElementById("attackloader").style.display="inline";
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
    document.getElementById("attackalert").innerHTML=xmlhttp.responseText;
	document.getElementById("attackloader").style.display="none";
	document.getElementById("attackalert").style.display="inline";
	if (xmlhttp.responseText.search("Attack Has Been Stopped By Tuna!") != -1)
	{
	attacks();
    }
    }
  }
xmlhttp.open("POST","ajax/hub.php?type=stop",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
}

function resolve(type)
{
var resolve=$('#resolve').val();
document.getElementById("resolvealert").style.display="none";
document.getElementById("resolveloader").style.display="inline";
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
    document.getElementById("resolvealert").innerHTML=xmlhttp.responseText;
	document.getElementById("resolveloader").style.display="none";
	document.getElementById("resolvealert").style.display="inline";
    }
  }
xmlhttp.open("POST","ajax/tools.php?type="+type,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("resolve=" + resolve);
}

function resolve(type)
{
var resolve=$("#"+type).val();
document.getElementById("toolsalert").style.display="none";
document.getElementById("resolveloader").style.display="inline";
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
    document.getElementById("toolsalert").innerHTML=xmlhttp.responseText;
	document.getElementById("resolveloader").style.display="none";
	document.getElementById("toolsalert").style.display="inline";
    }
  }
xmlhttp.open("POST","ajax/tools.php?type="+type,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("resolve=" + resolve);
}