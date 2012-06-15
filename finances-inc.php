<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# http://wphacks.midsouthmakers.org                                           #
# Branch: pabst                                                               #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: finances-inc.php                                                      #
# Description: main app for fincances. Calls finances-inc-inc.php             #
#                                                                             #
###############################################################################
ini_set ('display_errors', 1);
error_reporting (E_ALL & ~E_NOTICE);
$debug = 0;
if ($debug == 1){ echo("<h4>Debug is On</h4><BR>You may see some development information below<BR>"); }
require_once ('/www/dev.midsouthmakers.org/config.php');
require_once ('/www/midsouthmakers.org/wphacks/finances-inc-inc.php');
mysql_connect("$dbhost","$dbuser","$dbpass") or die ("Unable to connect to the database");
@mysql_select_db("mm_members") or die ("Unable To Select Database");

if ( is_user_logged_in() ) { 
	global $current_user;
      get_currentuserinfo();
	$findname =  $current_user->user_firstname .  $current_user->user_lastname;
	$first_name = $current_user->user_firstname;
	$last_name = $current_user->user_lastname;
	if ($debug == 1){ echo("Current User ID: " . $current_user->ID . "<br>Current User ID:$first_name $last_name<br><br><br><br>"); }
	$findusergroupquery = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
	$usergroupresult = mysql_query($findusergroupquery);
	$usergrouprow = mysql_fetch_row($usergroupresult);
	//if ($debug == 1){ echo("<pre>"); print_r($usergrouprow); echo("</pre>"); }
	
if ($usergrouprow['10'] == 'Board'){
	$action = $_GET['action'];
	switch($action){
		case "ViewAllTrans":
			viewalltransactions();
		break;
		case "AddTransForm":
			addtransaction_form();
		break;
		case "CreateNewPayee":
			createnewpayee_form();
		break;
		case "DoCreateNewPayee":
			docreatenewpayee();
		break;
		case "CreateNewAccount":
			createnewaccount_form();
		break;
		case "DoCreateNewAccount":
			docreatenewaccount();
		break;
		case "DoAddTransaction":
			doaddtransaction();
		break;
		case "EditTransaction":
			edittrans_form();
		break;
		case "DoEditTransaction":
			doedittrans();
		break;
		case "EditPayee":
			 editpayee_form();
		break;
		case "DoEditPayee":
			doeditpayee();
		break;
		default:
			showmenu();
			echo("");
			if($_GET['thismonth'] == ''){
				$thismonth = date('Y-m');
			} else {
				$thismonth = $_GET['thismonth'];
			}
			$thismonthnumber = date('n');
			$thismonthnumber = $thismonthnumber -1;
			while ($thismonthnumber > 0){
				$lastmonth = mktime(0, 0, 0, date("m")-"$thismonthnumber", date("d"),   date("Y"));
				$lastmonthnumberdate = date("Y-m", $lastmonth);
				$lastmonth = date("F", $lastmonth);
				echo("<a href=\"?thismonth=$lastmonthnumberdate\">$lastmonth</a> - ");
				$thismonthnumber = $thismonthnumber -1;
			}
			echo("<BR><BR>");
			thismonthsdata($thismonth);
	}
} else {
	//User is not joe or dan
	echo("Sorry, you do not have access to this page.");	
}
} else {
	echo("<p>You are not logged in.");
}
mysql_close();
?>
