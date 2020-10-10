function updateTickets()
{
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
    document.getElementById("ticketsdiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/support.php?type=update",true);
xmlhttp.send();
}

window.setInterval(function(){updateTickets();}, 60000);
updateTickets();


function submitTicket()
{
var subject=$('#subject').val();
var message=$('#message').val();
var department=$('#department').val();
var ppp=$('#priority').val();

document.getElementById("newticketalert").style.display="none";
document.getElementById("newticketloader").style.display="inline";
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
    document.getElementById("newticketalert").innerHTML=xmlhttp.responseText;
	document.getElementById("newticketloader").style.display="none";
	document.getElementById("newticketalert").style.display="inline";
	if (xmlhttp.responseText.search("Ticket has been created.") != -1)
	{
	updateTickets();
    }
    }
  }
xmlhttp.open("POST","ajax/support.php?type=submit",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("message=" + message + "&subject=" + subject + "&department=" + department + "&ppp=" + ppp);
}