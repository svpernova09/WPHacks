<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# http://wphacks.midsouthmakers.org                                           #
# Branch: pabst                                                               #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: events-inc.php                                                        #
# Description: events listing and signup form                                 #
#                                                                             #
###############################################################################
ini_set ('display_errors', 1);
error_reporting (E_ALL & ~E_NOTICE);
$debug = 0;
require_once ('/www/dev.midsouthmakers.org/config.php'); // make sure config.php is in same folder or change to path to config.php
mysql_connect("$dbhost","$dbuser","$dbpass") or die ("Unable to connect to the database");
@mysql_select_db("mm_members") or die ("Unable To Select Database");
if ($debug == 1){ echo("<h4>Debug is On</h4><BR>You may see some development information below<BR>"); }
if ($debug == 1){ echo("<pre>"); print_r($_GET); echo("</pre>"); }
$action = $_GET['action'];
if ($debug == 1){ echo("Action: $action<BR>"); }
get_currentuserinfo();
$findname =  $current_user->user_firstname .  $current_user->user_lastname;
$first_name = $current_user->user_firstname;
$last_name = $current_user->user_lastname;
if ($debug == 1){ echo("Current User ID: " . $current_user->ID . "<br>Current User ID:$first_name $last_name<br><br><br><br>"); }
$findusergroupquery = "select * from member_info where first_name = '$first_name' AND last_name = '$last_name'";
$usergroupresult = mysql_query($findusergroupquery);
$usergrouprow = mysql_fetch_row($usergroupresult);
echo("<div class=\"post-bodycopy clearfix\"><p>From time to time we&#8217;ll hold different events and you&#8217;ll find info about them here.  If you&#8217;ve got an event that you would like to see attempted, feel free to <a href=\"http://www.midsouthmakers.org/contact/\">drop us a line and tell us all about it.</a></p>");
//if ($debug == 1){ echo("<pre>"); print_r($usergrouprow); echo("</pre>"); }
switch($action){
	case "DoSignUp":
		$eventstring = $_POST['formevent'];
		$eventstrarray = explode('|', $eventstring);
		$eventname = $eventstrarray['0'];
		$eventid = $eventstrarray['1'];
		$inserteventsignup = "insert into events_signups (eventid, event_name, attendee_name) VALUES ('$eventid', '$eventname', '$_POST[formname]')";
		if ($debug == 1){ echo("inserteventsignup: $inserteventsignup<br>"); }
		if (mysql_query($inserteventsignup)){
			echo("<BR>You have been signed up for $eventname.");
		} else {
			echo("<BR>There wasn an error: " . mysql_error() . "<BR>Query: $inserteventsignup<BR>");
		}
	break;
	case "test":
		echo("Test");
	break;
	default:
		$today = date("Y-m-d");

		echo("<h4>Upcoming Events</h4>");
		
		$getevents = "select * from events where date > now() OR date = '$today' ORDER BY date ASC";
		$eventsresults = mysql_query($getevents);
		echo("<table width=\"100%\" border=\"0\" cellpadding=\"1\">
  <tr>
    <td align=\"left\" scope=\"row\"><strong>Event</strong></td>
    <td align=\"left\"><strong>Sign ups</strong></td>
    <td align=\"left\"><strong>Cost</strong></td>
    <td align=\"left\" width=\"60px\"><strong>Date</strong></td>
    <td align=\"left\"><strong>Location</strong></td>
  </tr>");
		while ($eventsrow = mysql_fetch_array($eventsresults)){
		//find out how many signups for this event
		$getsignups = "Select * from events_signups where event_name = '$eventsrow[event_name]'";
		$signupsresults = mysql_query($getsignups);
		$signups = mysql_num_rows($signupsresults);
		if ($debug == 1){ echo("signups: $signups<br>Query: $getsignups<BR>"); }
		echo("  <tr>
    <td align=\"left\" scope=\"row\">$eventsrow[event_name]</td>
    <td align=\"left\">$signups </td>
    <td align=\"left\">$eventsrow[cost] </td>
    <td align=\"left\">$eventsrow[date]</td>
    <td align=\"left\">$eventsrow[location] </td>
  </tr>");
		}
		echo("</table>
		<h4>Sign Up For An Event</h4>
		<form id=\"eventsignup\" name=\"eventsignup\" method=\"post\" action=\"http://www.midsouthmakers.org/events/?action=DoSignUp\">
  <table width=\"36%\" border=\"0\" cellpadding=\"3\">
    <tr>
      <th scope=\"row\">Name</th>
      <td><label for=\"name\"></label>");
if ( is_user_logged_in() ) { 
	global $current_user;
	get_currentuserinfo();
	$thisusersname = $current_user->user_firstname . ' ' . $current_user->user_lastname;
	if ($debug == 1){ echo("thisusersname: $thisusersname<BR>"); }
	echo("<input type=\"text\" name=\"formname\" id=\"formname\" value=\"$thisusersname\" /></td>");
} else {
	echo("<input type=\"text\" name=\"formname\" id=\"formname\" /></td>");
}
    echo("</tr>
    <tr>
      <th scope=\"row\">Event</th>
      <td><label for=\"formevent\"></label>");
$getevents = "select * from events where date > now() OR date = '$today' ORDER BY date ASC";
//echo("$getevents");
$eventsresults = mysql_query($getevents);
echo("<select name=\"formevent\" id=\"formevent\">");
while ($eventsrow = mysql_fetch_array($eventsresults)){
echo("<option value=\"$eventsrow[event_name]|$eventsrow[id]\">$eventsrow[event_name] - $$eventsrow[cost] - $eventsrow[date] - $eventsrow[location]</option>");
}
echo("</select> 
      </td>
    </tr>
    <tr>
      <td colspan=\"2\" scope=\"row\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" /></td>
    </tr>
  </table>
</form>");
echo("<H1>Midsouth Maker's Calendar</h1>
<p><iframe src=\"https://www.google.com/calendar/b/0/embed?mode=AGENDA&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=midsouthmakers.org_vtfpunalt6vfc0fuh8jpitspoc%40group.calendar.google.com&amp;color=%23060D5E&amp;ctz=America%2FChicago\" style=\" border:solid 1px #777 \" width=\"450\" height=\"600\" frameborder=\"0\" scrolling=\"no\"></iframe></p>
</div>");
	break;
}
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
	if ($usergrouprow['10'] == 'Board'){
		//echo("Board");	
		$findsignupssql = "select * from events_signups ORDER BY event_name ASC";
		$findsignupsresults = mysql_query($findsignupssql);
		
		while ($findsignupsrow = mysql_fetch_array($findsignupsresults)){
		echo("$findsignupsrow[event_name] - $findsignupsrow[attendee_name]<br />");
		}

		
		
		
	}
}


?>