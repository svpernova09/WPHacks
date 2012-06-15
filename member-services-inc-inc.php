<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# https://github.com/svpernova09/WPHacks                                      #
# Branch: killians                                                            #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: finances-inc.php                                                      #
# Description: This is the includes for member-services-inc.php               #
#                                                                             #
###############################################################################
if ($debug == 1){ echo("Included: wphacks/member-services-inc-inc.php<BR>"); }
function displaytransactions(){
	global $debug; // Get value from main script
	global $current_user; // Get value from main script
	showmenu();
    if ($debug == 1){ echo($current_user->display_name . "'s email address is: " . $current_user->user_email . "<br>"); }
	if ($debug == 1){ echo("First Name: " . $current_user->user_firstname . " Last Name: " . $current_user->user_lastname . "<BR>"); }
	$findname =  $current_user->user_firstname .  $current_user->user_lastname;
	$first_name = $current_user->user_firstname;
	$last_name = $current_user->user_lastname;
	if ($debug == 1){ echo("First Name: $first_name Last Name: $last_name"); }
	//find Our User ID
	$searchid = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
	if ($debug == 1){ echo("<BR>searchid: $searchid<BR>"); }
	$result = mysql_query($searchid);
	$row = mysql_fetch_array($result);
	if ($debug == 1){ echo("User ID: $row[0]<BR>"); }
	$ouruserid = $row['0'];
	$searchtransactions = "select * from transactions where memberID = '$ouruserid'";
	if ($debug == 1){ echo("searchtransactions: $searchtransactions<BR>"); }
	$searchtransresults = mysql_query($searchtransactions);
	echo("<p><strong>Here are your transactions for 2011</strong></p>
	<table width=\"100%\" border=\"0\" cellpadding=\"5\">
  <tr>
    <td><strong>Amount</strong></td>
    <td><strong>Date</strong></td>
    <td><strong>Donation</strong></td>
    <td><strong>Notes</strong></td>
  </tr>");
	$ytdcontributions = 0;
	while($transrow = mysql_fetch_array($searchtransresults)){
		//print out transactions	
		$ytdcontributions = $ytdcontributions + $transrow[amount];
		echo("<tr><td>$ $transrow[amount]</td><td>$transrow[date]</td><td>$transrow[purchase]</td><td>$transrow[notes]</td></tr>");
	}
	echo("<tr><td align=\"left\" colspan=\"4\">Year to Date Contributions: $$ytdcontributions</td></tr>");
	echo("</table>");
}
function displayinfo(){
	showmenu();
	global $debug; // Get value from main script
	global $current_user; // Get value from main script
    if ($debug == 1){ echo($current_user->display_name . "'s email address is: " . $current_user->user_email . "<br>"); }
	if ($debug == 1){ echo("First Name: " . $current_user->user_firstname . " Last Name: " . $current_user->user_lastname . "<BR>"); }
	$findname =  $current_user->user_firstname .  $current_user->user_lastname;
	$first_name = $current_user->user_firstname;
	$last_name = $current_user->user_lastname;
	if ($debug == 1){ echo("First Name: $first_name Last Name: $last_name"); }
	//find Our User ID
	$searchid = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
	if ($debug == 1){ echo("<BR>searchid: $searchid<BR>"); }
	$result = mysql_query($searchid);
	$row = mysql_fetch_array($result);
	if ($debug == 1){ echo("User ID: $row[0]<BR>"); }
	$ouruserid = $row['0'];
	$searchinfo = "select * from member_info where memberID = '$ouruserid'";
	if ($debug == 1){ echo("searchtransactions: $searchtransactions<BR>"); }
	$searchinforesults = mysql_query($searchinfo);
	echo("<table width=\"500\" border=\"0\">");
	while($searchinforow = mysql_fetch_array($searchinforesults)){
		//print out transactions	
		echo("<tr>
    <td>&nbsp;</td>
    <td>$searchinforow[first_name] $searchinforow[last_name]</td>
  </tr>
  <tr>
    <td><strong>Phone:</strong></td>
    <td>$searchinforow[phone]</td>
  </tr>
  <tr>
    <td><strong>Email:</strong></td>
    <td>$searchinforow[email]</td>
  </tr>
  <tr>
    <td><strong>Emergency Contact:</strong></td>
    <td>$searchinforow[emergency_name] - $searchinforow[emergency_phone]</td>
  </tr>
  <tr>
    <td><strong>Birthday:</strong></td>
    <td>$searchinforow[birthday]</td>
  </tr>
  <tr>
    <td><strong>Username:</strong></td>
    <td>$searchinforow[username]</td>
  </tr>
  <tr>
    <td><strong>Membership Type</strong>:</td>
    <td>$searchinforow[membership]</td>
  </tr>
  <tr>
    <td><strong>Contact Date</strong>:</td>
    <td>$searchinforow[contactdate]</td>
  </tr>
  <tr>
    <td><strong>Join Date</strong>:</td>
    <td>$searchinforow[joindate]</td>
  </tr>");
	}
	echo("</table>");

}
function showeditform(){
global $current_user; // Get value from main script
if ($debug == 1){ echo($current_user->display_name . "'s email address is: " . $current_user->user_email . "<br>"); }
if ($debug == 1){ echo("First Name: " . $current_user->user_firstname . " Last Name: " . $current_user->user_lastname . "<BR>"); }
$findname =  $current_user->user_firstname .  $current_user->user_lastname;
$first_name = $current_user->user_firstname;
$last_name = $current_user->user_lastname;
if ($debug == 1){ echo("First Name: $first_name Last Name: $last_name"); }
//find Our User ID
$searchid = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
if ($debug == 1){ echo("<BR>searchid: $searchid<BR>"); }
$result = mysql_query($searchid);
$row = mysql_fetch_array($result);
if ($debug == 1){ echo("User ID: $row[0]<BR>"); }
$ouruserid = $row['0'];
$searchouruser = "select * from member_info where memberID = '$ouruserid'";
if ($debug == 1){ echo("searchtransactions: $searchtransactions<BR>"); }
$searchouruserresults = mysql_query($searchouruser);
while($searchouruserrow = mysql_fetch_array($searchouruserresults)){
showmenu();
echo("<form id=\"edituserform\" name=\"edituserform\" method=\"post\" action=\"http://www.midsouthmakers.org/member-services/?action=DoEditInfo\">
  <table width=\"618\" border=\"0\">
    <tr>
      <td colspan=\"2\" align=\"center\" valign=\"top\">Edit Your User Information
	  <input name=\"memberid\" type=\"hidden\" id=\"memberid\" value=\"$ouruserid\" />
	  </td>
    </tr>
    <tr>
      <td width=\"212\" align=\"center\" valign=\"top\"><strong>Name:</strong></td>
      <td width=\"396\" align=\"center\" valign=\"top\">$searchouruserrow[first_name] $searchouruserrow[last_name]</td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Phone:</strong></td>
      <td align=\"center\" valign=\"top\"><input name=\"phone\" type=\"text\" id=\"phone\" value=\"$searchouruserrow[phone]\" /></td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Email:</strong></td>
      <td align=\"center\" valign=\"top\"><input name=\"email\" type=\"text\" id=\"email\" value=\"$searchouruserrow[email]\" size=\"30\" /></td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Emergency Contact:</strong></td>
      <td align=\"center\" valign=\"top\"><input name=\"emergency_name\" type=\"text\" id=\"emergency_name\" value=\"$searchouruserrow[emergency_name]\" size=\"30\"/></td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Emergency Phone:</strong></td>
      <td align=\"center\" valign=\"top\"><input name=\"emergency_phone\" type=\"text\" id=\"emergency_phone\" value=\"$searchouruserrow[emergency_phone]\" /></td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Birthday:</strong> (YYYY-MM-DD)</td>
      <td align=\"center\" valign=\"top\"><input name=\"birthday\" type=\"text\" id=\"birthday\" value=\"$searchouruserrow[birthday]\" /></td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Username:</strong></td>
      <td align=\"center\" valign=\"top\">$searchouruserrow[username]</td>
    </tr>
    <tr>
      <td align=\"center\" valign=\"top\"><strong>Membership Type:</strong></td>
      <td align=\"center\" valign=\"top\">$searchouruserrow[membership]
	  </td>
    </tr>
    <tr>
      <td colspan=\"2\" align=\"center\" valign=\"top\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" /></td>
    </tr>
  </table>
</form>");
}

}
function doeditinfo(){
	showmenu();
        if ($_POST['phone'] != "") {
            $_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
            if ($_POST['phone'] == "") {
                $errors .= 'Please enter a valid phone number.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your phone number.<br/>';
        }
        if ($_POST['email'] != "") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors .= "$email is <strong>NOT</strong> a valid email address.<br/><br/>";
            }
        } else {
            $errors .= 'Please enter your email address.<br/>';
        }
        if ($_POST['emergency_name'] != "") {
            $_POST['emergency_name'] = filter_var($_POST['emergency_name'], FILTER_SANITIZE_STRING);
            if ($_POST['emergency_name'] == "") {
                $errors .= 'Please enter a valid emergency contact name.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your emergency contact name.<br/>';
        }
        if ($_POST['emergency_phone'] != "") {
            $_POST['emergency_phone'] = filter_var($_POST['emergency_phone'], FILTER_SANITIZE_STRING);
            if ($_POST['emergency_phone'] == "") {
                $errors .= 'Please enter a valid emergency contact phone.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your emergency contact phone.<br/>';
        }
		$_POST['phone'] = str_replace("(", "", $_POST['phone']);
		$_POST['phone'] = str_replace(")", "", $_POST['phone']);
		$_POST['phone'] = str_replace("-", "", $_POST['phone']);
		$infoupdatequery = "UPDATE member_info SET phone = '$_POST[phone]', email = '$_POST[email]', emergency_name = '$_POST[emergency_name]', emergency_phone = '$_POST[emergency_phone]', birthday = '$_POST[birthday]' WHERE memberid = '$_POST[memberid]'";
		//echo("<BR>$infoupdatequery<BR>");
		if (mysql_query($infoupdatequery)){
		if(mysql_affected_rows() > 0){
			echo("Information Updated.");
			displayinfo();
		} else {
			echo("There were no changes to your information.");
			displayinfo();
		}
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $updatetransaction<BR>");
	}
}
function showmenu(){
	echo("<a href=\"http://www.midsouthmakers.org/member-services/\">Member Home</a> | <a href =\"http://www.midsouthmakers.org/member-services/?action=DisplayTransactions\">View Transactions</a> | <a href =\"http://www.midsouthmakers.org/member-services/?action=DisplayInfo\">Display Your Info</a></strong> | <a href =\"http://www.midsouthmakers.org/member-services/?action=DisplayEditForm\">Edit Your Info</a></strong><BR>");
}	
function memberinfodefault(){
	global $debug; // Get value from main script
	global $current_user; // Get value from main script
	if ($debug == 1){ echo($current_user->display_name . "'s email address is: " . $current_user->user_email . "<br>"); }
	if ($debug == 1){ echo("First Name: " . $current_user->user_firstname . " Last Name: " . $current_user->user_lastname . "<BR>"); }
	$findname =  $current_user->user_firstname .  $current_user->user_lastname;
	$first_name = $current_user->user_firstname;
	$last_name = $current_user->user_lastname;
	if ($debug == 1){ echo("First Name: $first_name Last Name: $last_name"); }
	//find Our User ID
	$searchid = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
	if ($debug == 1){ echo("<BR>searchid: $searchid<BR>"); }
	$result = mysql_query($searchid);
	$row = mysql_fetch_array($result);
	if ($debug == 1){ echo("User ID: $row[0]<BR>"); }
	$ouruserid = $row['0'];
	$membershiplevel = $row['membership'];
	//find transactions from current month
	$currentmonth = date("Y-m") . "-%";
	$findsignupssql = "select * from events_signups WHERE `attendee_name` LIKE  '%$last_name'";
	if ($debug == 1){ echo("findsignups sql:$findsignups<br />"); }
	$findsignupsresults = mysql_query($findsignupssql);
	echo("<p><strong>Here are the events you've signed up for:</p>
	<table width=\"100%\" border=\"0\" cellpadding=\"5\">
  <tr>
    <td><strong>Event Name</strong></td>
    <td><strong>Date</strong></td>
  </tr>");
	$allsignups = array();
	while($findsignupsrow = mysql_fetch_array($findsignupsresults)){
		$allsignups[] = $findsignupsrow['eventid'] . "|" . $findsignupsrow['event_name'];

	}
	if ($debug == 1){ print_r($allsignups); }
	foreach($allsignups as $key => $value){
		if ($debug == 1){ echo("Key: $key Value: $value<br />"); }
		$eventvalues = explode('|', $value);
		$eventid = $eventvalues["0"];
		$eventname = $eventvalues["1"];
		$findeventdetailssql = "select * from events WHERE `id` ='$eventid'";
		if ($debug == 1){ echo("findeventdetailssql sql:$findeventdetailssql<br />"); }
		$findeventdetailsresults = mysql_query($findeventdetailssql);
		while($findeventdetailsrow = mysql_fetch_array($findeventdetailsresults)){
			echo("<tr><td>$findeventdetailsrow[event_name]</td><td>$findeventdetailsrow[date]</td></tr>");
		}
	}
	echo("</table>");
	$membercurrenttranssql = "select * from transactions where memberID = $ouruserid AND date like '$currentmonth'";
	if ($debug == 1){ echo("membercurrenttranssql: $membercurrenttranssql<BR>"); }
	$membercurrenttransresults = mysql_query($membercurrenttranssql);
	$haspaidcurrentdues = 0;
	echo("<p><strong>Here are your transactions for " . date("F") . "</strong></p>
	<table width=\"100%\" border=\"0\" cellpadding=\"5\">
  <tr>
    <td><strong>Amount</strong></td>
    <td><strong>Date</strong></td>
    <td><strong>Donation</strong></td>
    <td><strong>Notes</strong></td>
  </tr>");
	while($membercurrenttransrow = mysql_fetch_array($membercurrenttransresults)){
		echo("<tr><td>$ $membercurrenttransrow[amount]</td><td>$membercurrenttransrow[date]</td><td>$membercurrenttransrow[purchase]</td><td>$membercurrenttransrow[notes]</td></tr>");
		if ($membercurrenttransrow['purchase'] == "Monthly Dues"){
			$haspaidcurrentdues = 1;
		}
	}
	echo("</table>");
	if (!$haspaidcurrentdues){
		echo("Please pay your dues for this month<br />
		<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
<input type=\"hidden\" name=\"hosted_button_id\" value=\"CE79LYZL33GGQ\">
<table>
<tr><td><input type=\"hidden\" name=\"on0\" value=\"Membership Type\">Membership Type</td></tr><tr><td><select name=\"os0\">
	<option value=\"Single Maker\">Single Maker $45.00</option>
	<option value=\"Family Makers\">Family Makers $75.00</option>
	<option value=\"Starving Maker\">Starving Maker $25.00</option>
</select> </td></tr>
</table>
<input type=\"hidden\" name=\"currency_code\" value=\"USD\">
<input type=\"image\" src=\"https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">
<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">
</form>
");
	}
}
?>
