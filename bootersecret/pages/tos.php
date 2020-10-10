<?php
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if (!($user -> LoggedIn()))
{
    header('location: index.php?page=Login');
    die();
}
if (!($user -> notBanned($odb)))
{
    header('location: index.php?page=logout');
    die();
}

include("header.php");
?>
<div style="color:white" id="page-content">
<div class="panel-body">
<b>
<center> <b><H3 style="color:white">TERMS OF SERVICE</b></H3></b></center>

Welcome to Booter.com By visiting our website and accessing the information, resources, services, products, and tools we provide, you understand and agree to accept and adhere to the following terms and conditions as stated in this policy (hereafter referred to as 'User Agreement'), along with the terms and conditions as stated in our Privacy Policy (please refer to the Privacy Policy section below for more information). 
<br><br>
This agreement is in effect as of Jan 01 2020. 
<br><br>
We reserve the right to change this User Agreement from time to time without notice. You acknowledge and agree that it is your responsibility to review this User Agreement periodically to familiarize yourself with any modifications. Your continued use of this site after such modifications will constitute acknowledgment and agreement of the modified terms and conditions. 
<br><br>

<b><H3>1. Responsible Use and Conduct </b></H3></b> 
By visiting our website and accessing the information, resources, services, products, and tools we provide for you, either directly or indirectly (hereafter referred to as 'Resources'), you agree to use these Resources only for the purposes intended as permitted by (a) the terms of this User Agreement, and (b) applicable laws, regulations and generally accepted online practices or guidelines. 
a. Attempting to copy, duplicate, reproduce, sell, trade, or resell our Resources is strictly prohibited. 
b. Under no circumstances shall any user attack any government or government affiliated entity. 
<br><br>
<b><H3>2. Terms </b></H3></b> 
By accessing this web site, you are agreeing to be bound by these Terms and Conditions of Use, all applicable laws and regulations; and agree that you are responsible for compliance with any applicable local, state, and federal laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained within this web site are protected by applicable copyright and trademark law.
<br><br>
<b><H3>3. Use License </b></H3></b> 
You are liable for what you do at Booter.com, and if you break any of these terms; you may be banned without notice, and/or subjected to prosecution of applicable European Union laws if necessary. <br> In the event of a payment dispute, the account of the User will be immediately suspended and avenues to retain the payment will be taken. <br>We reserve the right to provide any and all IP logs, Contact Information, and Stress Logs to the Government in violation of these Terms of Service.<br>
You are prohibited from stressing internet connections and/or servers that You <b>do not</b> have ownership of or authorization to test.<br>
You are prohibited from posting or transmitting to or from this website any material that others would deem threatening or discriminatory.<br>
You are prohibited from distributing any information or downloadable content, freely or for profit, on any other websites or medium.<br>
You are prohibited from using our services for causing damage to internet connections/servers. <br> We provide legal Server Stress Testing services. Use the service only in/on your own server or only with authorization. This is your only warning.
<br><br>
<b><H3>4. Disclaimer </b></H3></b> 
The materials on Booter's web site are provided "as is". Booter.com makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. <br> Further, Booter.com does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.
<br><br>
<b><H3>5. Limitations </b></H3></b> 
In no event shall Booter.com or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on Booter.com's Internet site, even if Booter.com or a Booter.com authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.
<br><br>
<b><H3>6. Revisions and Errata</b></H3></b> 
The materials appearing on Booter.com's web site could include technical, typographical, or photographic errors. Booter.com does not warrant that any of the materials on its web site are accurate, complete, or current. Booter.com may make changes to the materials contained on its web site at any time without notice. Booter.com does not, however, make any commitment to update the materials.
<br><br>
<b><H3>7. Site Terms of Use Modifications</b></H3></b> 
Booter.com reserves the right at any time to modify this Agreement and to add new or additional terms or conditions on your use of the Services. Such modifications and additional terms and conditions will be effective immediately and incorporated into this Agreement. <br>Your continued using of this web site will be deemed acceptance thereof.
<br><br>
<b><H3>8. Liability</b></H3></b> 
In no event shall Booter.Com be held liable for any special, incidental or consequential damages or any nature due to the use of our Services and/or any information found with our Services. <br>This includes, but is not limited to, damages resulting in loss of profit or revenue, installation costs, damage to property, personal injury, death and legal expenses.<br>
You acknowledge that Booter.Com and the manufacturer or supplier of any products or information found on our Services are not to be held responsible for any claim or damage resulting from use.<br>
Any statements or advice offered or given to You is given without charge. <br>Booter.com assumes no liability for such statements or advice and the use of such.<br>
You must agree to indemnify, defend and hold us and our partners, attorneys, staff and affiliates harmless from any liability, loss, claim and expense, including resultant attorney fees, related to your violation of this Agreement and/or use of our Services.
<br><br>
<b><H3>10. Privacy</b></H3></b> 

Your privacy is very important to us. Accordingly, we have developed this Policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.
<br><br>
By agreeing to this Agreement, You acknowledge that You have read and agree to our Privacy Policy </a><br>


<br><br>
<b><H3>11. Governing Law</b></H3></b> 
Any claim relating to Booter.com's web site shall be governed by the European Union laws without regard to its conflict of law provisions.
<br><br>
General Terms and Conditions applicable to Use of a Web Site.
<br><br>
Before or at the time of collecting personal information, we will identify the purposes for which information is being collected.<br>
We will collect and use of personal information solely with the objective of fulfilling those purposes specified by us and for other compatible purposes, unless we obtain the consent of the individual concerned or as required by law.<br>
We will only retain personal information as long as necessary for the fulfilment of those purposes.<br>
We will collect personal information by lawful and fair means.<br>
Personal data should be relevant to the purposes for which it is to be used, and, to the extent necessary for those purposes, should be accurate, complete, and up-to-date.<br>
We will protect personal information by reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification.<br>
We will make readily available to customers information about our policies and practices relating to the management of personal information.<br>
We are committed to conducting our business in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.<br>
Any attacks sent to government website will result in a permanent suspension<br>
<b><H3>12. OTHER PROVISIONS</b></H3></b> 
Children under the age of majority should review this Agreement with their parent or guardian to ensure that the child and parent or legal guardian understand it.
<br><br><br>
Last Update: September 04, 2018
</b>

<center>
<b><br><h3> In case you want to report any type of abuse PLEASE send us an email to <br> admin@booter.com<b></h3>

</font>
</pre>

<hr>

</div>
</div>
</div>
</div>
</div>
</div>
