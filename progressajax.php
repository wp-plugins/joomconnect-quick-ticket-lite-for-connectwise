<?php

$root = fs_get_wp_config_path();
//include_once($root.'/wp-includes/functions.php');
//include_once($root.'/wp-includes/pluggable.php');
require($root.'/wp-load.php');

$subject = $_POST['subject'];
$message = $_POST['message'];
$emailids = $_POST['emailids'];
$admin_email = explode(",",substr($emailids,0,-1));
foreach($admin_email as $k => $v)
{
	$decode[] = base64_decode($v);
}
$emailids = implode(",",$decode);
$recipient = explode(",",$emailids);
$username = $_POST['username'];
$useremail = $_POST['useremail'];
$successmsg = $_POST['successmsg'];
if($useremail != '')
{
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",$useremail)){
		echo '<span style="color:#483B2D;">Not a valid email id</span>';die();
	}
}

//$success = true;
if(isset($recipient) && is_array($recipient))
{
	$recipient_mailid = $recipient[0];
}
else
{
	$recipient_mailid = $recipient;
}
//$success = JUtility::sendMail($useremail, $username, $recipient_mailid, $subject, $message,1);
$header = 'From: '.$username.' <'.$useremail.'>'."\r\n";
$success = wp_mail($recipient_mailid, $subject, $message, $header);
if($success)
{
	if(isset($successmsg) && $successmsg != '')
	{
		echo $successmsg;
	}
	else
	{
		echo "Email Sent Succesfully";
	}
}

/** Get WP root **/
function fs_get_wp_config_path()
{
    $base = dirname(__FILE__);
    $path = false;

    if (@file_exists(dirname(dirname($base))."/wp-config.php"))
    {
        $path = dirname(dirname($base));
    }
    else
    if (@file_exists(dirname(dirname(dirname($base)))."/wp-config.php"))
    {
        $path = dirname(dirname(dirname($base)));
    }
    else
    $path = false;

    if ($path != false)
    {
        $path = str_replace("\\", "/", $path);
    }
    return $path;
}

?>