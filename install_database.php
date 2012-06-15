
<?php
###############################################################################
#                                                                             #
# Wordpress Hacks                                                             #
# http://wphacks.midsouthmakers.org                                           #
# Branch: pabst                                                               #
# Contact: #MidsouthMakers irc.freenode.net                                   #
# File: install_database                                                      #
# Description: installs database schema DELETE THIS FILE AFTER USE            #
#                                                                             #
###############################################################################
ini_set ('display_errors', 1);
error_reporting (E_ALL & ~E_NOTICE);
$debug = 1;
if ($debug == 1){ echo("<h4>Debug is On</h4><BR>You may see some development information below<BR>"); }
//require_once ('../wp-config.php');

if (is_readable('../wp-config.php')){
	echo("Configuration Readable<BR><BR>");
	$wpconfig = file('../wp-config.php');
	//if ($debug == 1){ echo("<pre>"); print_r($wpconfig); echo("</pre>"); }
	//$dbnamekey = array_search('define(\'DB_NAME\', %', $wpconfig);
	//echo("<BR>$dbnamekey<BR>");
	$dbname_array = preg_grep('/.*DB_NAME.*/', $wpconfig);
	//echo '<pre>'; print_r($dbname_array); echo '</pre>';
	$dbname_string = implode('define(\'DB_NAME\', ', $dbname_array);
	//echo '<pre>'; print 'String version: ' . $dbname_string; echo '</pre>';
	$dbname = explode('define(\'DB_NAME\', ', $dbname_string);
	//echo '<pre>'; print_r($dbname); echo '</pre>';
	//print '<BR>' . $dbname['1'];
	$dbname['1'] = str_replace('\'', '', $dbname['1']);
	$dbname['1'] = str_replace(')', '', $dbname['1']);
	$dbname['1'] = str_replace(';', '', $dbname['1']);
	//echo("Database: $dbname[1]<BR>");
	$dbuser_array = preg_grep('/.*DB_USER.*/', $wpconfig);
	$dbuser_string = implode('define(\'DB_USER\', ', $dbuser_array);
	$dbuser = explode('define(\'DB_USER\', ', $dbuser_string);
	$dbuser['1'] = str_replace('\'', '', $dbuser['1']);
	$dbuser['1'] = str_replace(')', '', $dbuser['1']);
	$dbuser['1'] = str_replace(';', '', $dbuser['1']);
	//echo("User: $dbuser[1]<BR>");
	$dbpass_array = preg_grep('/.*DB_PASSWORD.*/', $wpconfig);
	$dbpass_string = implode('define(\'DB_PASSWORD\', ', $dbpass_array);
	$dbpass = explode('define(\'DB_PASSWORD\', ', $dbpass_string);
	$dbpass['1'] = str_replace('\'', '', $dbpass['1']);
	$dbpass['1'] = str_replace(')', '', $dbpass['1']);
	$dbpass['1'] = str_replace(';', '', $dbpass['1']);
	//echo("Pass: $dbpass[1]<BR>");
	$dbhost_array = preg_grep('/.*DB_HOST.*/', $wpconfig);
	$dbhost_string = implode('define(\'DB_HOST\', ', $dbhost_array);
	$dbhost = explode('define(\'DB_HOST\', ', $dbhost_string);
	$dbhost['1'] = str_replace('\'', '', $dbhost['1']);
	$dbhost['1'] = str_replace(')', '', $dbhost['1']);
	$dbhost['1'] = str_replace(';', '', $dbhost['1']);
	//echo("Host: $dbhost[1]<BR>");
	//echo("
	<p>Below is your database values for WordPress. The default values is to install the database into the existing Wordpress database so you will not need to create another database. If this is what you want then simply click Install Database. If you want WPHacks to use another database, change the appropriate information here. You will also need to edit the database values in config.php.
	<form id=\"form1\" name=\"form1\" method=\"post\" action=\"\">
  <table width=\"400\" border=\"0\">
    <tr>
      <td>Database Name</td>
      <td><input name=\"dbname\" type=\"text\" id=\"dbname\" value=\"$dbname[1]\" /></td>
    </tr>
    <tr>
      <td>User</td>
      <td><input name=\"dbuser\" type=\"text\" id=\"dbuser\" value=\"$dbuser[1]\" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name=\"dbpass\" type=\"text\" id=\"dbpass\" value=\"$dbpass[1] \" /></td>
    </tr>
    <tr>
      <td>host</td>
      <td><input name=\"host\" type=\"text\" id=\"host\" value=\"$dbhost[1]\" /></td>
    </tr>
    <tr>
      <td>Table Prefix</td>
      <td><input type=\"text\" name=\"prefix\" id=\"prefix\" /></td>
    </tr>
    <tr>
      <td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Install Database\" /></td>
    </tr>
  </table>
</form>");
} else {
	echo("Configuration File is not readable");
	die();	
}