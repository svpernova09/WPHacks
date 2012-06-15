<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# http://wphacks.midsouthmakers.org                                           #
# Branch: pabst                                                               #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: finances-inc-inc.php                                                  #
# Description: This is the includes for fincances-inc.php                     #
#                                                                             #
###############################################################################
function viewalltransactions(){
	showmenu();
	$viewalltransactions = "select * from transactions where 1 order by date desc, transaction_id desc";
	if ($debug == 1){ echo("viewalltransactions: $viewalltransactions<BR>"); }
	$searchtransresults = mysql_query($viewalltransactions);
	echo("<p><strong>Here are all transactions for 2011</strong></p>
<table width=\"100%\" border=\"0\" cellpadding=\"5\">
  <tr>
	<td><strong>id</strong></td>
	<td><strong>member id</strong></td>
    <td><strong>Payee</strong></td>
    <td><strong>Amount</strong></td>
    <td><strong>Account ID</strong></td>
    <td><strong>Date</strong></td>
    <td><strong>Donation</strong></td>
    <td><strong>Notes</strong></td>
  </tr>");
	while($viewallrow = mysql_fetch_array($searchtransresults)){
		//print out transactions	
		echo("<tr>
  <td><a href=\"http://www.midsouthmakers.org/finances/?action=EditTransaction&trans_id=$viewallrow[transaction_id]\">$viewallrow[transaction_id]</a></td>
  <td>$viewallrow[memberID]</td>
  <td>$viewallrow[payee]</td>
  <td>$ $viewallrow[amount]</td>
  <td><p>$viewallrow[accountid]</p></td>
  <td>$viewallrow[date]</td><td>$viewallrow[purchase]</td><td>$viewallrow[notes]</td></tr>");
	}
	echo("</table>");
}
function addtransaction_form(){
	showmenu();
	echo("
<script type=\"text/javascript\">
function docalcfees(selectedValue){
	//alert(selectedValue);
	if (selectedValue == 'Paypal') {
		var amount;
		var process;
		amount = document.addtransaction.amount.value;
		process = (amount * .029);
		process = Math.round((process + .30)*100)/100;
		process = (process * -1);
		//Math.round(process*100)/100;
		document.addtransaction.processamount.value = process;
	}
	if (selectedValue == 'SquareUp') {
		var amount;
		var process;
		amount = document.addtransaction.amount.value;
		process = Math.round((amount * .0275)*100)/100;
		process = (process * -1);
		//Math.round(process*100)/100;
		document.addtransaction.processamount.value = process;
	}	
	if (selectedValue == 'Clear') {
		process = 0;
		document.addtransaction.processamount.value = process;
	}
}
</script>
	
	<form name=\"addtransaction\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=DoAddTransaction\">
  <table width=\"450px\" border=\"0\">
    <tr>
    <td align=\"right\" valign=\"top\"><strong>Payee:</strong>
	<a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewPayee\">Create New Payee</a></td>
    <td valign=\"top\">");
	listpayees(blank);
      echo("</td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Amount:</strong></td>
    <td valign=\"top\">
      <input name=\"amount\" type=\"text\" id=\"amount\" value=\"0.00\" size=\"12\">
    </td>
  </tr>
      <tr>
    <td align=\"right\" valign=\"top\"><strong>Processing Fees:</strong>
	<select name=\"processingfees\" id=\"processingfees\" onchange=\"docalcfees(this.value);\">
<option value=\"clear\" selected>none</option>
<option value=\"Paypal\">PayPal</option>
<option value=\"SquareUp\">Square Up</option>
    </select></td>
    <td valign=\"top\"> Amount: <input name=\"processamount\" type=\"text\" id=\"processamount\" value=\"0.00\" size=\"12\"></td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Account ID:</strong>
	<a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewAccount\">Create New Account</a></td>
    <td valign=\"top\">");
	listaccounts(blank);
      echo("</td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Date:</strong></td>
    <td valign=\"top\"><input name=\"date\" type=\"text\" id=\"date\" value=\"" . date(Y) . "/" . date(m) . "/" . date(d) . "\"> </td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Donation:</strong></td>
    <td valign=\"top\"><input name=\"donation\" type=\"text\" id=\"donation\" size=\"40\"></td>
  </tr>
  <tr>
    <td width=\"50%\" align=\"right\" valign=\"top\"><strong>Notes:</strong></td>
    <td valign=\"top\"><input name=\"notes\" type=\"text\" id=\"notes\" size=\"40\"></td>
  </tr>
  <tr>
    <td colspan=\"2\" valign=\"top\"><center><input type=\"submit\" name=\"Submit\" id=\"Submit\" value=\"Submit\"></center></td>
  </tr>
</table></form>");
}
function createnewpayee_form(){
	showmenu();
	echo("<form id=\"addpayeeform\" name=\"selectpayeeform\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=EditPayee\">
  <table width=\"25%\" border=\"0\">
  <tr>
  	<td>
	Edit Payee
	</td>
	</tr>
    <tr>
      <td>"); 
	  listpayees(blank); 
	  echo("</td>
      <td><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Edit\" /></td>
    </tr>
  </table>
</form>");
	echo("<form id=\"addpayeeform\" name=\"addpayeeform\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=DoCreateNewPayee\">
  <table width=\"50%\" border=\"0\">
    <tr>
      <td colspan=\"2\"><strong>Create New Payee</strong></td>
    </tr>
    <tr>
      <td>First Name</td>
      <td><input type=\"text\" name=\"first_name\" id=\"first_name\" /></td>
    </tr>
    <tr>
      <td>Last Name</td>
      <td><input type=\"text\" name=\"last_name\" id=\"last_name\" /></td>
    </tr>
    <tr>
      <td>Membership</td>
      <td><select name=\"membership\" id=\"membership\">
        <option value=\"Guest\" selected=\"selected\">Guest</option>
        <option value=\"Adult\">Adult</option>
        <option value=\"Family\">Family</option>
        <option value=\"Student\">Student</option>
        <option value=\"Special - Board\">Special - Board</option>
        <option value=\"Vendor\">Vendor</option>
      </select></td>
    </tr>
    <tr>
      <td>Phone</td>
      <td><input type=\"text\" name=\"phone\" id=\"phone\" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type=\"text\" name=\"email\" id=\"email\" /></td>
    </tr>
    <tr>
      <td>Emergency Name</td>
      <td><input type=\"text\" name=\"emergency_name\" id=\"emergency_name\" value=\"$findpayeerow[emergency_name]\" /></td>
    </tr>
    <tr>
      <td>Emergency Phone</td>
      <td><input type=\"text\" name=\"emergency_phone\" id=\"emergency_phone\" value=\"$findpayeerow[emergency_phone]\" /></td>
    </tr>
    <tr>
      <td>Username</td>
      <td>$findpayeerow[username]</td>
    </tr>
    <tr>
      <td>Referral</td>
      <td><input type=\"text\" name=\"referral\" id=\"referral\" value=\"$findpayeerow[referral]\" /></td>
    </tr>
    <tr>
      <td>Usergroup</td>
      <td><input type=\"text\" name=\"usergroup\" id=\"usergroup\" value=\"$findpayeerow[usergroup]\" /></td>
    </tr>
    <tr>
      <td>Birthday (YYYY-MM-DD)</td>
      <td><input type=\"text\" name=\"birthday\" id=\"birthday\" value=\"$findpayeerow[birthday]\" /></td>
    </tr>
    <tr>
      <td>Join Date (YYYY-MM-DD)</td>
      <td><input type=\"text\" name=\"joindate\" id=\"joindate\" value=\"$findpayeerow[joindate]\" /></td>
    </tr>
    <tr>
      <td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" /></td>
    </tr>
  </table>
</form>");
}
function docreatenewpayee(){
showmenu();
if ($_POST['first_name'] != "") {
	$_POST['first_name'] = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
	if ($_POST['first_name'] == "") {
		$errors .= 'Please enter a valid first name.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your first name.<br/>';
}
if ($_POST['last_name'] != "") {
	$_POST['lastt_name'] = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
	if ($_POST['lastt_name'] == "") {
		$errors .= 'Please enter a valid last name.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your last name.<br/>';
}
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
if ($_POST['referral'] != "") {
	$_POST['referral'] = filter_var($_POST['referral'], FILTER_SANITIZE_STRING);
	if ($_POST['referral'] == "") {
		$errors .= 'Please enter a valid referral.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your referral.<br/>';
}
if ($_POST['usergroup'] != "") {
	$_POST['usergroup'] = filter_var($_POST['usergroup'], FILTER_SANITIZE_STRING);
	if ($_POST['usergroup'] == "") {
		$errors .= 'Please enter a valid usergroup.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your usergroup.<br/>';
}
$_POST['phone'] = str_replace("(", "", $_POST['phone']);
$_POST['phone'] = str_replace(")", "", $_POST['phone']);
$_POST['phone'] = str_replace("-", "", $_POST['phone']);
$newpayee = "insert into member_info (first_name, last_name, phone, email, emergency_name, emergency_phone, username, membership, referral, usergroup, birthday, contactdate, joindate) VALUEs ('$_POST[first_name]', '$_POST[last_name]', '$_POST[phone]', '$_POST[email]', '$_POST[emergency_name]', '$_POST[emergency_phone]', '$_POST[username]', '$_POST[membership]', '$_POST[referral]', '$_POST[usergroup]', '$_POST[birthday]', '$_POST[joindate]', '$_POST[joindate]')";
	if (mysql_query($newpayee)){
		echo("Payee $_POST[first_name] $_POST[last_name] Added. <a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewPayee\">Add Another?</a>");
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $newpayee<BR>");
	}
}
function createnewaccount_form(){
	showmenu();
	echo("<form id=\"addaccountform\" name=\"addaccountform\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=DoCreateNewAccount\">
  <table width=\"25%\" border=\"0\">
    <tr>
      <td colspan=\"2\">Create New Account</td>
    </tr>
    <tr>
      <td>Account Name</td>
      <td><input type=\"text\" name=\"account\" id=\"account\" /></td>
    </tr>
    <tr>
      <td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" /></td>
    </tr>
  </table>
</form>");
}
function docreatenewaccount(){
showmenu();
	if ($_POST['account'] != "") {
            $_POST['account'] = filter_var($_POST['account'], FILTER_SANITIZE_STRING);
            if ($_POST['account'] == "") {
                $errors .= 'Please enter a valid account name.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your account name.<br/>';
        }
$newaccount = "insert into bank_accounts (account) VALUEs ('$_POST[account]')";
	if (mysql_query($newaccount)){
		echo("Account $_POST[account] Added. <a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewAccount\">Add Another?</a>");
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $newaccount<BR>");
	}
}
function doaddtransaction(){
showmenu();
global $debug;
$debug = 0;
	if ($_POST['donation'] != "") {
            $_POST['donation'] = filter_var($_POST['donation'], FILTER_SANITIZE_STRING);
            if ($_POST['donation'] == "") {
                $errors .= 'Please enter a valid donation.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your donation.<br/>';
        }
        if ($_POST['notes'] != "") {
            $_POST['notes'] = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
            if ($_POST['notes'] == "") {
                $errors .= 'Please enter a valid notes.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your notes.<br/>';
        }
	$memberidname = explode('|', $_POST['payee']);
	$inserttransaction = "insert into transactions (memberID, payee, amount, accountid, date, purchase, notes) VALUEs ('$memberidname[0]','$memberidname[1]','$_POST[amount]','$_POST[accountid]','$_POST[date]','$_POST[donation]','$_POST[notes]')";
	if ($debug == 1){ echo("inserttransaction: $inserttransaction<br>"); }
	$memberemailgrabsql = "select email from member_info where memberid = $memberidname[0]";
	if ($debug == 1){ echo("memberemailgrabsql: $memberemailgrabsql<BR>"); }
	$memberemailgrabresult = mysql_query($memberemailgrabsql);
	$memberemailgrabrow = mysql_fetch_array($memberemailgrabresult);
	$memberemailgrabnum_rows = mysql_num_rows($memberemailgrabresult);
	if (mysql_query($inserttransaction)){
		echo("Transaction Added. <a href=\"http://www.midsouthmakers.org/finances/?action=AddTransForm\">Add Another?</a>");
		if ($debug == 1){ echo("memberemailgrabnum_rows: $memberemailgrabnum_rows<BR>"); }
		/*
		if ($memberemailgrabnum_rows > 0){
			$EmailPayee = $memberidname['1'];
			$EmailPurchase = $_POST['donation'];
			$EmailAmount = $_POST['amount'];
			$EmailDate = $_POST['date'];
			$to = $memberemailgrabrow['0'];
			$receiptemailsql = "SELECT * FROM email_templates where template = 'receiptemail'";
			$receiptemailresult = mysql_query($receiptemailsql);
			$receiptemailrow = mysql_fetch_array($receiptemailresult);
			$subject = $receiptemailrow['subject'];
			$message = $receiptemailrow['body'];
			$message = str_replace("<EmailPayee>", $EmailPayee, $message);
			$message = str_replace("<EmailPurchase>", $EmailPurchase, $message);
			$message = str_replace("<EmailAmount>", $EmailAmount, $message);
			$message = str_replace("<EmailDate>", $EmailDate, $message);
			//$mail = wp_mail($to, $subject, $message);
			if ($debug == 1){ echo("to: $to<BR>"); }
			if ($debug == 1){ echo("EmailAmount: $EmailAmount<BR>"); }
			if ($debug == 1){ echo("EmailPurchase: $EmailPurchase<BR>"); }
			if ($debug == 1){ echo("EmailPayee: $EmailPayee<BR>"); }
			if ($debug == 1){ echo("subject: $subject<BR>"); }
			if ($debug == 1){ echo("message: $message<BR>"); }
		}
		*/
		
		
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $inserttransaction<BR>");
	}
	$isprocessingfee = $_POST['processingfees'];
    switch($isprocessingfee){
    case "Paypal":
    	$inserttransactionPayPal = "insert into transactions (memberID, payee, amount, accountid, date, purchase, notes) VALUEs ('109','PayPal','$_POST[processamount]', 'Transaction Fees', '$_POST[date]','PayPal Fee','PayPal Fee')";
		if ($debug == 1){ echo("inserttransactionPayPal: $inserttransactionPayPal<br>"); }
		if (mysql_query($inserttransactionPayPal)){
			echo("<BR>Paypal Transaction Added.");
		} else {
			echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $inserttransactionPayPal<BR>");
		}
    break;
    case "SquareUp":
    	$inserttransactionsquareup = "insert into transactions (memberID, payee, amount, accountid, date, purchase, notes) VALUEs ('109','square up','$_POST[processamount]', 'Transaction Fees', '$_POST[date]','square up Fee','square up Fee')";
		if ($debug == 1){ echo("inserttransactionsquareup: $inserttransactionsquareup<br>"); }
		if (mysql_query($inserttransactionsquareup)){
			echo("<BR>Square Up Transaction Added.");
		} else {
			echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $inserttransactionsquareup<BR>");
		}
    break;
	default:
		//do nothing there are no fees
    }
}
function listpayees($currentpayee){
	$getpayees = "select memberid, first_name, last_name from member_info where 1 ORDER BY first_name ASC";
	$payeeresults = mysql_query($getpayees);
	echo("<select name=\"payee\" id=\"payee\">");
	while ($payeerow = mysql_fetch_array($payeeresults)){
		$thispayee = $payeerow['first_name'] . " " . $payeerow['last_name'];
		echo("thispayee: $thispayee - currentpayee: $currentpayee");
		if(trim($currentpayee) == trim($thispayee)){
			echo("<option value=\"$payeerow[memberid]|$payeerow[first_name] $payeerow[last_name]\" selected>$payeerow[first_name] $payeerow[last_name]</option>");
		} else {
			echo("<option value=\"$payeerow[memberid]|$payeerow[first_name] $payeerow[last_name]\">$payeerow[first_name] $payeerow[last_name]</option>");
		}
	}
	echo("</select> ");
}
function listaccounts($currentaccount){
	//echo("Current Account: $currentaccount - ");
	$getaccounts = "select account from bank_accounts where 1 ORDER BY account ASC";
	$accountresults = mysql_query($getaccounts);
	echo("<select name=\"accountid\" id=\"accountid\">");
	while ($accountrow = mysql_fetch_array($accountresults)){
		//echo("Current Account: $currentaccount - Current: $accountrow[account]");
		if(trim($currentaccount) == trim($accountrow['account'])){
			echo("<option value=\"$accountrow[account]\" selected>$accountrow[account]</option>");
		} else {
			echo("<option value=\"$accountrow[account]\">$accountrow[account]</option>");
		}
	}
	echo("</select> ");
}
function showmenu(){
	echo("<strong><a href =\"http://www.midsouthmakers.org/finances/\">Finances Home</a></strong> | <a href =\"http://www.midsouthmakers.org/finances/?action=ViewAllTrans\">View All Transactions</a></strong> | <a href =\"http://www.midsouthmakers.org/finances/?action=AddTransForm\">Add a Transaction</a></strong> | <a href =\"http://www.midsouthmakers.org/finances/?action=CreateNewPayee\">Payee Maintenance</a></strong> | <a href =\"http://www.midsouthmakers.org/finances/?action=CreateNewAccount\">Account Maintenance</a></strong><BR><HR>");
}
function edittrans_form(){
	showmenu();
	$trans_id = $_GET['trans_id'];
	$edittranssql = "select * from transactions where transaction_id = '$trans_id'";
	$edittransresults = mysql_query($edittranssql);
	echo("");
	while ($edittransrow = mysql_fetch_array($edittransresults)){
		echo("<form name=\"addtransaction\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=DoEditTransaction&trans_id=$trans_id\">
  <table width=\"450px\" border=\"0\">
    <tr>
    <td align=\"right\" valign=\"top\"><strong>Payee:</strong>
	<a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewPayee\">Create New Payee</a></td>
    <td valign=\"top\">");
	listpayees($edittransrow['payee']);
      echo("</td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Amount:</strong></td>
    <td valign=\"top\">
      <input name=\"amount\" type=\"text\" id=\"amount\" value=\"$edittransrow[amount]\" size=\"12\">
    </td>
  </tr>
      <tr>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Account ID:</strong>
	<a href=\"http://www.midsouthmakers.org/finances/?action=CreateNewAccount\">Create New Account</a></td>
    <td valign=\"top\">");
	listaccounts($edittransrow['accountid']);
      echo("</td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Date:</strong></td>
    <td valign=\"top\"><input name=\"date\" type=\"text\" id=\"date\" value=\"$edittransrow[date]\" size=\"40\"></td>
  </tr>
  <tr>
    <td align=\"right\" valign=\"top\"><strong>Donation:</strong></td>
    <td valign=\"top\"><input name=\"donation\" type=\"text\" id=\"donation\" value=\"$edittransrow[purchase]\" size=\"40\"></td>
  </tr>
  <tr>
    <td width=\"50%\" align=\"right\" valign=\"top\"><strong>Notes:</strong></td>
    <td valign=\"top\"><input name=\"notes\" type=\"text\" id=\"notes\" value=\"$edittransrow[notes]\" size=\"40\"></td>
  </tr>
  <tr>
    <td colspan=\"2\" valign=\"top\"><center><input type=\"submit\" name=\"Submit\" id=\"Submit\" value=\"Submit\"></center></td>
  </tr>
</table></form>");
	}
	echo("");
}
function doedittrans(){
showmenu();
global $debug;
$trans_id = $_GET['trans_id'];
	if ($_POST['donation'] != "") {
            $_POST['donation'] = filter_var($_POST['donation'], FILTER_SANITIZE_STRING);
            if ($_POST['donation'] == "") {
                $errors .= 'Please enter a valid donation.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your donation.<br/>';
        }
        if ($_POST['notes'] != "") {
            $_POST['notes'] = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
            if ($_POST['notes'] == "") {
                $errors .= 'Please enter a valid notes.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your notes.<br/>';
        }
	$memberidname = explode('|', $_POST['payee']);
	$updatetransaction = "UPDATE transactions SET memberID ='$memberidname[0]', payee = '$memberidname[1]', amount = '$_POST[amount]', accountid = '$_POST[accountid]', date = '$_POST[date]', purchase = '$_POST[donation]', notes = '$_POST[notes]' WHERE transaction_id = $trans_id";
	if ($debug == 1){ echo("updatetransaction: $updatetransaction<br>"); }
	if (mysql_query($updatetransaction)){
		if(mysql_affected_rows() > 0){
			echo("Transaction Updated.");
		} else {
			echo("There were no changes to the transaction. No MySQL Errors.");
		}
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $updatetransaction<BR>");
	}
}
function thismonthsdata($thismonth){
global $debug;	
$monthlydatasql = "select * from transactions where date like '$thismonth%'";
$monthlydataresults = mysql_query($monthlydatasql);
echo("$monlthdatasql");
$find_memberssql = "Select first_name, last_name, membership from member_info where membership != 'Guest' AND membership != 'Vendor'";
$find_membersresults = mysql_query($find_memberssql);
$current_members = array();
$total_dues_expected = 0;
while ($find_membersrow = mysql_fetch_array($find_membersresults)){
	$current_members[] = $find_membersrow['0'] . " " . $find_membersrow['1'] . "|" . $find_membersrow['2'];
	switch($find_membersrow['2']){
	case "Student":
		$this_expected = 25;
	break;
	case "Adult":
		$this_expected = 45;
	break;
	case "Family":
		$this_expected = 37.50;
	break;
	default:
		$special_amount = explode('|', $find_membersrow['2']);
		//print_r($special_amount);
		$this_expected = $this_expected + $special_amount['1'];
	break;
	}
	$total_dues_expected = $total_dues_expected + $this_expected;
}
//init variables to count
$monthly_transactions = 0;
$dues_collected = 0;
$additional_income = 0;
$total_income = 0;
$total_expenditures = 0;
$net_income = 0;
$payed_members = array();
while ($monthlydatarow = mysql_fetch_array($monthlydataresults)){
	$monthly_transactions = $monthly_transactions + 1;
	if ($monthlydatarow['purchase'] == "Monthly Dues"){
		$dues_collected = $dues_collected + $monthlydatarow['amount'];
		$payed_members[] = $monthlydatarow['payee'];
	}
	if ($monthlydatarow['amount'] > 0 AND $monthlydatarow['purchase'] != "Monthly Dues"){
		$additional_income = $additional_income + $monthlydatarow['amount'];
	}
	if ($monthlydatarow['amount'] < 0){
		$total_expenditures = $total_expenditures + $monthlydatarow['amount'];
	}
	$total_income = $dues_collected + $additional_income;
}
$net_income = $total_expenditures + $total_income;
$remaining_income = $total_dues_expected - $dues_collected;
//echo("<pre>"); print_r($payed_members); echo("</pre>");
//echo("<pre>"); print_r($current_members); echo("</pre>");
$number_current_members = count($current_members);
$number_payed_members = count($payed_members);
$number_unpayed_members = $number_current_members - $number_payed_members;
$predictedsql = "SELECT sum( `amount` ) FROM `transactions` WHERE 1 ";
$predictedresult = mysql_query($predictedsql);
$predictedrow = mysql_fetch_array( $predictedresult );
$predictedfunds = $remaining_income + $predictedrow['0'];
echo("Number of Current Members: $number_current_members<BR>Number of Unpaid Members: $number_unpayed_members
<table width=\"400\" border=\"0\">
  <tr>
    <td colspan=\"2\" align=\"center\" valign=\"top\"><strong>This Month's Data</strong></td>
  </tr>
  <tr>
    <td width=\"196\" align=\"center\" valign=\"top\">Monthly Transactions</td>
    <td width=\"194\" align=\"center\" valign=\"top\">$monthly_transactions</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Dues Collected</td>
    <td align=\"center\" valign=\"top\">$$dues_collected</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Additional Income</td>
    <td align=\"center\" valign=\"top\">$$additional_income</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Total Income</td>
    <td align=\"center\" valign=\"top\">$$total_income</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Predicted Income Remaining</td>
    <td align=\"center\" valign=\"top\">$$remaining_income</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Predicted Total Funds After This Month</td>
    <td align=\"center\" valign=\"top\">$$predictedfunds</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Current Total</td>
    <td align=\"center\" valign=\"top\">$$predictedrow[0]</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Total Expenditures</td>
    <td align=\"center\" valign=\"top\">$$total_expenditures</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\">Net Income</td>
    <td align=\"center\" valign=\"top\">$$net_income</td>
  </tr>
</table>");
foreach ($current_members as $key => $person){
	$member_name = explode('|', $person);
	//echo("<tr><td align=\"center\" valign=\"top\">Key is $key, Value is $person. Member Name: $member_name[0]</td></tr>");
	foreach ($payed_members as $key2 => $personpaid){
		//echo("<BR><BR>Person: $member_name[0] - Person Paid: $personpaid");
		if ($member_name['0'] == $personpaid){
			//echo("<BR><BR>Person: $member_name[0] - Person Paid: $personpaid");
			unset($current_members[$key]);
		}
	}
}
echo("<table width=\"400\" border=\"0\"><tr><td align=\"center\" valign=\"top\"><strong>Unpaid Dues This Month</strong></td></tr>");
foreach ($current_members as $unpaid => $unpaidperson){
	$unpaidname = explode('|', $unpaidperson);
	echo("<tr><td align=\"center\" valign=\"top\">$unpaidname[0]</td></tr>");
}
echo("</table>");
}
function editpayee_form(){
showmenu();
	$payeename = explode('|', $_POST['payee']);
	$payee = explode(' ',$payeename['1']);
	$findpayeesql = "select * from member_info where first_name = '$payee[0]' AND last_name = '$payee[1]'";
	$findpayeeresults = mysql_query($findpayeesql);
	while ($findpayeerow = mysql_fetch_array($findpayeeresults)){
	echo("<form id=\"editpayeeform\" name=\"editpayeeform\" method=\"post\" action=\"http://www.midsouthmakers.org/finances/?action=DoEditPayee\">
  <table width=\"25%\" border=\"0\">
    <tr>
      <td>First Name</td>
      <td><input type=\"text\" name=\"first_name\" id=\"first_name\" value=\"$findpayeerow[first_name]\" />
	  <input type=\"hidden\" name=\"payeeid\" id=\"payeeid\" value=\"$payeename[0]\" />
	  </td>
    </tr>
    <tr>
      <td>Last Name</td>
      <td><input type=\"text\" name=\"last_name\" id=\"last_name\" value=\"$findpayeerow[last_name]\" /></td>
    </tr>
    <tr>
      <td>Membership</td>
      <td><select name=\"membership\" id=\"membership\">");
	  switch($findpayeerow['membership']){
		  case "Guest":
		  	echo("<option value=\"Guest\" selected=\"selected\">Guest</option>
	        		<option value=\"Adult\">Adult</option>
			        <option value=\"Family\">Family</option>
			        <option value=\"Student\">Student</option>
			        <option value=\"Special - Board\">Special - Board</option>
			        <option value=\"Vendor\">Vendor</option>");
		  break;
		  case "Adult":
		  	echo("<option value=\"Guest\">Guest</option>
	        		<option value=\"Adult\" selected=\"selected\">Adult</option>
			        <option value=\"Family\">Family</option>
			        <option value=\"Student\">Student</option>
			        <option value=\"Special - Board\">Special - Board</option>
			        <option value=\"Vendor\">Vendor</option>");
		  break;
		  case "Family":
		  	echo("<option value=\"Guest\">Guest</option>
	        		<option value=\"Adult\">Adult</option>
			        <option value=\"Family\" selected=\"selected\">Family</option>
			        <option value=\"Student\">Student</option>
			        <option value=\"Special - Board\">Special - Board</option>
			        <option value=\"Vendor\">Vendor</option>");
		  break;
		  case "Student":
		  	echo("<option value=\"Guest\">Guest</option>
	        		<option value=\"Adult\">Adult</option>
			        <option value=\"Family\">Family</option>
			        <option value=\"Student\" selected=\"selected\">Student</option>
			        <option value=\"Special - Board\">Special - Board</option>
			        <option value=\"Vendor\">Vendor</option>");
		  break;
		  case "Vendor":
		  	echo("<option value=\"Guest\">Guest</option>
	        		<option value=\"Adult\">Adult</option>
			        <option value=\"Family\">Family</option>
			        <option value=\"Student\">Student</option>
			        <option value=\"Special - Board\">Special - Board</option>
			        <option value=\"Vendor\" selected=\"selected\">Vendor</option>");
		  break;
		  default:
		  	echo("<option value=\"Guest\">Guest</option>
	        		<option value=\"Adult\">Adult</option>
			        <option value=\"Family\">Family</option>
			        <option value=\"Student\">Student</option>
			        <option value=\"" . $findpayeerow['membership'] . "\" selected=\"selected\">" . $findpayeerow['membership'] . "</option>
			        <option value=\"Vendor\">Vendor</option>");
		  break;
		
	  }
      echo("</select></td>
    </tr>
    <tr>
      <td>Phone</td>
      <td><input type=\"text\" name=\"phone\" id=\"phone\" value=\"$findpayeerow[phone]\" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type=\"text\" name=\"email\" id=\"email\" value=\"$findpayeerow[email]\" /></td>
    </tr>
    <tr>
      <td>Emergency Name</td>
      <td><input type=\"text\" name=\"emergency_name\" id=\"emergency_name\" value=\"$findpayeerow[emergency_name]\" /></td>
    </tr>
    <tr>
      <td>Emergency Phone</td>
      <td><input type=\"text\" name=\"emergency_phone\" id=\"emergency_phone\" value=\"$findpayeerow[emergency_phone]\" /></td>
    </tr>
    <tr>
      <td>Username</td>
      <td>$findpayeerow[username]</td>
    </tr>
    <tr>
      <td>Referral</td>
      <td><input type=\"text\" name=\"referral\" id=\"referral\" value=\"$findpayeerow[referral]\" /></td>
    </tr>
    <tr>
      <td>Usergroup</td>
      <td><input type=\"text\" name=\"usergroup\" id=\"usergroup\" value=\"$findpayeerow[usergroup]\" /></td>
    </tr>
    <tr>
      <td>Birthday</td>
      <td><input type=\"text\" name=\"birthday\" id=\"birthday\" value=\"$findpayeerow[birthday]\" /></td>
    </tr>
    <tr>
      <td>Join Date</td>
      <td><input type=\"text\" name=\"joindate\" id=\"joindate\" value=\"$findpayeerow[joindate]\" /></td>
    </tr>
    <tr>
      <td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" /></td>
    </tr>
  </table>
</form>");
	}//end sql while
}
function doeditpayee(){
showmenu();
global $debug;
if ($_POST['first_name'] != "") {
	$_POST['first_name'] = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
	if ($_POST['first_name'] == "") {
		$errors .= 'Please enter a valid first name.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your first name.<br/>';
}
if ($_POST['last_name'] != "") {
	$_POST['lastt_name'] = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
	if ($_POST['lastt_name'] == "") {
		$errors .= 'Please enter a valid last name.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your last name.<br/>';
}
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
if ($_POST['referral'] != "") {
	$_POST['referral'] = filter_var($_POST['referral'], FILTER_SANITIZE_STRING);
	if ($_POST['referral'] == "") {
		$errors .= 'Please enter a valid referral.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your referral.<br/>';
}
if ($_POST['usergroup'] != "") {
	$_POST['usergroup'] = filter_var($_POST['usergroup'], FILTER_SANITIZE_STRING);
	if ($_POST['usergroup'] == "") {
		$errors .= 'Please enter a valid usergroup.<br/><br/>';
	}
} else {
	$errors .= 'Please enter your usergroup.<br/>';
}
$_POST['phone'] = str_replace("(", "", $_POST['phone']);
$_POST['phone'] = str_replace(")", "", $_POST['phone']);
$_POST['phone'] = str_replace("-", "", $_POST['phone']);
$updatepayee = "UPDATE member_info SET first_name = '$_POST[first_name]', last_name = '$_POST[last_name]', phone = '$_POST[phone]', email = '$_POST[email]', emergency_name = '$_POST[emergency_name]', emergency_phone = '$_POST[emergency_phone]', membership = '$_POST[membership]', referral = '$_POST[referral]', usergroup = '$_POST[usergroup]', birthday = '$_POST[birthday]', joindate = '$_POST[joindate]' WHERE memberid = '$_POST[payeeid]'";
	if ($debug == 1){ echo("updatepayee: $updatepayee<br>"); }
	if (mysql_query($updatepayee)){
		if(mysql_affected_rows() > 0){
			echo("payee Updated.");
		} else {
			echo("There were no changes to the payee. No MySQL Errors.");
		}
	} else {
		echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $updatepayee<BR>");
	}
}
?>
