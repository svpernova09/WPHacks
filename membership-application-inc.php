<?php
ini_set ('display_errors', 1);
error_reporting (E_ALL & ~E_NOTICE);
require_once ('/www/midsouthmakers.org/config.php'); // make sure config.php is in same folder or change to path to config.php
mysql_connect("$dbhost","$dbuser","$dbpass") or die ("Unable to connect to the database");
@mysql_select_db("mm_members") or die ("Unable To Select Database");
//$query = "SELECT * FROM current_projects WHERE 1 ORDER BY Project ASC";
//$result = mysql_query ($query);
$action = $_GET['action'];
//echo("$action<br />");
if ($action == "add"){
//require_once('/www/midsouthmakers/midsouthmakers.org/recaptchalib.php');
$privatekey = "6LfF2sASAAAAAP1IMGv0piz4Z8JfFdywqTbQkdhq ";
/*
$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
 die ("The reCAPTCHA wasn't entered correctly.
 Go back and try it again." .
 "(reCAPTCHA said: " . $resp->error . ")");

    // Your code here to handle a successful verification
    $action = "add";	
  }
*/  
 }
if(empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	$action = "bot";
}
switch($action){
case "bot":
    //echo Bot
    echo("I think you're a bot<BR>");
break;
case "add":
//echo("Action = add <BR>");
//print_r($_POST);
 if (isset($_POST['submit'])) {
//echo("Form submitted, begin validation<BR>");
        if ($_POST['first_name'] != "") {
            $_POST['first_name'] = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
            if ($_POST['first_name'] == "") {
                $errors .= 'Please enter a valid first name.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter your first name.<br/>';
        }
        if ($_POST['last_name'] != "") {
            $_POST['last_name'] = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
            if ($_POST['last_name'] == "") {
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
        if ($_POST['username'] != "") {
            $_POST['username'] = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            if ($_POST['username'] == "") {
                $errors .= 'Please enter a valid user name.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter a valid user name.<br/>';
        }
        if ($_POST['password'] != "") {
            $_POST['password'] = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            if ($_POST['password'] == "") {
                $errors .= 'Please enter a valid password.<br/><br/>';
            }
        } else {
            $errors .= 'Please enter a valid password.<br/>';
        }
        if ($_POST['referral'] != "") {
            $_POST['referral'] = filter_var($_POST['referral'], FILTER_SANITIZE_STRING);
            if ($_POST['referral'] == "") {
                $errors .= 'Please let us know how you found us.<br/><br/>';
            }
        } else {
            $errors .= 'Please let us know how you found us.<br/>';
        }
        if (!$errors) {
            //echo("No errors, do some action<br>");

			$addquery = "INSERT INTO member_info (first_name, last_name, phone, email, emergency_name, emergency_phone, username, membership, referral) VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[phone]', '$_POST[email]', '$_POST[emergency_name]', '$_POST[emergency_phone]', '$_POST[username]', '$_POST[membership]', '$_POST[referral]')";
//echo("$addquery");
	//echo("query: $addquery<br />");
	//var_dump($_POST);
	mysql_query($addquery) or die(mysql_error());
//Email the board on the new member application
$to = "board@midsouthmakers.org";
$subject =  $_POST['first_name'] . " " . $_POST['last_name'] . " - " . $_POST['username'] . " has filled out a membership application";
$message =  "\nFirst Name: " . $_POST['first_name'] . "\nLast Name: " . $_POST['last_name'] . "\nPhone: " . $_POST['phone'] . "\nEmail: " . $_POST['email'] . "\nUsername: " . $_POST['username'] . "\nMembership: " . $_POST['membership'];
$mail = wp_mail($to, $subject, $message);

	echo ("<table width=\"75%\" border=\"0\" cellpadding=\"5\">
  <tr>
    <th align=\"left\" valign=\"top\" scope=\"row\"><p>We're processing your application.</p>
    <p>Please use the Pay Now button on the right to process your application payment securely via PayPal. If you need to make other payment arrangements please contact <a href=\"mailto:board@midsouthmakers.org\">board@midsouthmakers.org</a>. Your probationary membership will not begin until payment has been arranged.</p></th>
    <td align=\"left\" valign=\"top\"><form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
<input type=\"hidden\" name=\"hosted_button_id\" value=\"MAYVQCKB9HCFC\">
<input type=\"image\" src=\"https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">
<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">
</form>
</td>
  </tr>
</table>");
            
        } else {
            echo '<div style="color: red">' . $errors . '<br/></div>';
			echo("<form id=\"membershipapplication\" name=\"membershipapplication\" method=\"post\" action=\"https://www.midsouthmakers.org/membership-application/?action=add\">
  <table width=\"500\" border=\"0\" cellpadding=\"2\">
    <tr>
      <th scope=\"row\">First Name</th>
      <td><input name=\"first_name\" type=\"text\" id=\"first_name\" size=\"25\" value=\"$_POST[first_name]\" /></td>
    </tr>
    <tr>
      <th width=\"40%\" scope=\"row\">Last Name</th>
      <td width=\"60%\"><label for=\"last_name\">
        <input name=\"last_name\" type=\"text\" id=\"last_name\" size=\"25\" value=\"$_POST[last_name]\" />
      </label></td>
    </tr>
    <tr>
      <th scope=\"row\">Phone Number</th>
      <td><label for=\"phone\"></label>
      <input name=\"phone\" type=\"text\" id=\"phone\" size=\"25\" maxlength=\"12\" value=\"$_POST[phone]\" /></td>
    </tr>
    <tr>
      <th scope=\"row\">Email</th>
      <td><label for=\"email\">
        <input name=\"email\" type=\"text\" id=\"email\" value=\"$_POST[email]\" size=\"25\" maxlength=\"250\">
      </label></td>
    </tr>
    <tr>
      <th scope=\"row\">Emergency Contact Name</th>
      <td><label for=\"Status\"></label>
      <input name=\"emergency_name\" type=\"text\" id=\"emergency_name\" value=\"$_POST[emergency_name]\" size=\"25\" maxlength=\"250\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Emergency Contact Phone</th>
      <td><label for=\"emergency_phone\"></label>
      <input name=\"emergency_phone\" type=\"text\" id=\"emergency_phone\" value=\"$_POST[emergency_phone]\" size=\"25\" maxlength=\"12\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Desired Username / Handle</th>
      <td><label for=\"username\"></label>
      <input name=\"username\" type=\"text\" id=\"username\" value=\"$_POST[username]\" size=\"25\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Create Password:</th>
      <td><label for=\"passworde\"></label>
      <input name=\"password\" type=\"password\" id=\"password\" value=\"$_POST[password]\" size=\"25\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Membership Type</th>
      <td><select name=\"membership\" id=\"membership\">
        <option value=\"Family\">$75 - Family (2 Adults + any dependents)</option>
        <option value=\"Single\" selected=\"selected\">$45 - Single Adult Membership </option>
        <option value=\"Student\">$25 - Student or Learning Institution Faculty </option>
      </select></td>
    </tr>
    <tr>
      <th scope=\"row\">How did you find us?</th>
      <td><label for=\"referral\"></label>
      <textarea name=\"referral\" id=\"referral\" cols=\"35\" rows=\"5\">$_POST[referral]</textarea></td>
    </tr>
    <tr>
      <th scope=\"row\">&nbsp;</th>
      <td><label for=\"Image\">

	  
	  </label></td>
    </tr>
    <tr>
      <th scope=\"row\">&nbsp;</th>
      <td><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" />
      <input type=\"reset\" name=\"Reset\" id=\"Reset\" value=\"Reset\" /></td>
    </tr>
  </table>
</form>");
        }
    }


	
break;
case "edit":
break;
default:
	echo("<form id=\"membershipapplication\" name=\"membershipapplication\" method=\"post\" action=\"https://www.midsouthmakers.org/membership-application/?action=add\">
  <table width=\"500\" border=\"0\" cellpadding=\"2\">
    <tr>
      <th scope=\"row\">First Name</th>
      <td><input name=\"first_name\" type=\"text\" id=\"first_name\" size=\"25\" /></td>
    </tr>
    <tr>
      <th width=\"40%\" scope=\"row\">Last Name</th>
      <td width=\"60%\"><label for=\"last_name\">
        <input name=\"last_name\" type=\"text\" id=\"last_name\" size=\"25\" />
      </label></td>
    </tr>
    <tr>
      <th scope=\"row\">Phone Number</th>
      <td><label for=\"phone\"></label>
      <input name=\"phone\" type=\"text\" id=\"phone\" size=\"25\" maxlength=\"12\" /></td>
    </tr>
    <tr>
      <th scope=\"row\">Email</th>
      <td><label for=\"email\">
        <input name=\"email\" type=\"text\" id=\"email\" value=\"\" size=\"25\" maxlength=\"250\">
      </label></td>
    </tr>
    <tr>
      <th scope=\"row\">Emergency Contact Name</th>
      <td><label for=\"Status\"></label>
      <input name=\"emergency_name\" type=\"text\" id=\"emergency_name\" value=\"\" size=\"25\" maxlength=\"250\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Emergency Contact Phone</th>
      <td><label for=\"emergency_phone\"></label>
      <input name=\"emergency_phone\" type=\"text\" id=\"emergency_phone\" value=\"\" size=\"25\" maxlength=\"12\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Desired Username / Handle</th>
      <td><label for=\"username\"></label>
      <input name=\"username\" type=\"text\" id=\"username\" value=\"\" size=\"25\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Create Password:</th>
      <td><label for=\"passworde\"></label>
      <input name=\"password\" type=\"password\" id=\"password\" size=\"25\"></td>
    </tr>
    <tr>
      <th scope=\"row\">Membership Type</th>
      <td><select name=\"membership\" id=\"membership\">
        <option value=\"Family\">$75 - Family (2 Adults + any dependents)</option>
        <option value=\"Single\" selected=\"selected\">$45 - Single Adult Membership </option>
        <option value=\"Student\">$25 - Student or Learning Institution Faculty </option>
      </select></td>
    </tr>
    <tr>
      <th scope=\"row\">How did you find us?</th>
      <td><label for=\"referral\"></label>
      <textarea name=\"referral\" id=\"referral\" cols=\"35\" rows=\"5\"></textarea></td>
    </tr>
    <tr>
      <th scope=\"row\">&nbsp;</th>
      <td><label for=\"Image\">

	  </label></td>
    </tr>
    <tr>
      <th scope=\"row\">&nbsp;</th>
      <td><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" />
      <input type=\"reset\" name=\"Reset\" id=\"Reset\" value=\"Reset\" /></td>
    </tr>
  </table>
</form>");
break;
}
mysql_close();
?>
