<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# https://github.com/svpernova09/WPHacks                                      #
# Branch: killians                                                            #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: finances-inc.php                                                      #
# Description: main app for Member Services. Calls member-services-inc.php    #
#                                                                             #
###############################################################################
ini_set ('display_errors', 1);
error_reporting (E_ALL & ~E_NOTICE);
global $debug;
global $current_user;
get_currentuserinfo();

//if ($debug == 1){ echo("<pre>"); print_r($usergrouprow); echo("</pre>"); }
$debug = 0;
if ($debug == 1){ echo("<h4>Debug is On</h4><BR>You may see some development information below<BR>"); }
require_once ('/www/dev.midsouthmakers.org/config.php'); // make sure config.php is in same folder or change to path to config.php
require_once ('/www/midsouthmakers.org/wphacks/member-services-inc-inc.php');
mysql_connect("$dbhost","$dbuser","$dbpass") or die ("Unable to connect to the database");
@mysql_select_db("mm_members") or die ("Unable To Select Database");
$findname =  $current_user->user_firstname .  $current_user->user_lastname;
$first_name = $current_user->user_firstname;
$last_name = $current_user->user_lastname;
if ($debug == 1){ echo("Current User ID: " . $current_user->ID . "<br>Current User ID:$first_name $last_name<br><br><br><br>"); }
$findusergroupquery = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
$usergroupresult = mysql_query($findusergroupquery);
$usergrouprow = mysql_fetch_row($usergroupresult);
$action = $_GET['action'];
if ( is_user_logged_in() ) { 
	switch($action){
	case "DisplayInfo":
		displayinfo();
	break;
	case "DoEditInfo":
		doeditinfo();
	break;
	case "DisplayTransactions":
		displaytransactions();
	break;
	case "DisplayEditForm":	
		showeditform();
	break;
	default:
		showmenu();
		memberinfodefault();
}
} else {
	echo("<p>You are not logged in.");
}
mysql_close();
?>
