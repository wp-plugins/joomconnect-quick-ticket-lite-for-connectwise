<?php

$pretext = isset( $instance['pretext'] ) ? $instance['pretext'] : '';
$posttext = isset( $instance['posttext'] ) ? $instance['posttext'] : '';
if(empty($instance['fullnamelabel']))
	$fullnamelabel = 'Full Name';
else
	$fullnamelabel = $instance['fullnamelabel'];
if(empty($instance['emaillabel']))
	$emaillabel = 'Email';
else
	$emaillabel = $instance['emaillabel'];
$showbuttonimage = isset( $instance['showbuttonimage'] ) ? $instance['showbuttonimage'] : 'Button';
if(empty($instance['subjectlabel']))
	$subjectlabel = 'Subject';
else
	$subjectlabel = $instance['subjectlabel'];
if(empty($instance['descriptionlabel']))
	$descriptionlabel = 'Problem Description';
else
	$descriptionlabel = $instance['descriptionlabel'];
$serviceboard = isset( $instance['serviceboard'] ) ? $instance['serviceboard'] : '';
$imagepath = isset( $instance['imagepath'] ) ? $instance['imagepath'] : '';
if(empty($instance['buttontext']))
	$buttontext = 'Submit';
else
	$buttontext = $instance['buttontext'];
if(empty($instance['successmessage']))
	$successmessage = 'Email has been sent';
else
	$successmessage = $instance['successmessage'];
$textsize = isset( $instance['textsize'] ) ? $instance['textsize'] : '25';
$rowsfortextarea = isset( $instance['rowsfortextarea'] ) ? $instance['rowsfortextarea'] : '5';
$colsfortextarea = isset( $instance['colsfortextarea'] ) ? $instance['colsfortextarea'] : '';
$fieldlayout = isset( $instance['fieldlayout'] ) ? $instance['fieldlayout'] : '2';

$styletextarea = '';
if(isset($colsfortextarea) && $colsfortextarea == ''){
	$colsfortextarea = '18';
	$styletextarea = 'style="width:100%;"';
}
$array_emailids = explode("\n",$serviceboard);

$user = wp_get_current_user();
//echo '<pre>'; print_r($user); //user_login
$userid = $user->ID;

$emailids .= ',';
//$uniqueid = rand();
$widgetID = $args['widget_id'];
$widgetID = explode('-', $widgetID);
$uniqueid = $widgetID[1];
$string = '<div class="free_emailconnector_div"><div class="jcemailconnector_pos1">'.$pretext.'</div>';
if($fieldlayout == '1' || $fieldlayout == 1){
	$string .= '<form name="free_emailconnector_form_'.$uniqueid.'" action="#" method="post">';
	$string .= '<table cellspacing="2px" cellpadding="2px" border="0" width="100%"><tbody>';
	$string .= '<tr class="row"><td class="column_1">Select Service Board<span class="red">*</span></td>
	<td class="column_2"><select name="service_board_emailid_'.$uniqueid.'" id="service_board_emailid_'.$uniqueid.'"><option value="all">Choose Service Board</option>';
	foreach($array_emailids as $k => $v){
		$exp2 = explode("-",$v);
		if(isset($exp2) && is_array($exp2) && count($exp2) > 1){
			$string .= '<option value="'.base64_encode(trim($exp2[1])).'">'.trim($exp2[0]).'</option>';
			$admin_emails[] = base64_encode(trim($exp2[1]));
		}
		else{
			$string .= '<option value="'.base64_encode(trim($exp2[0])).'">'.trim($exp2[0]).'</option>';
			$admin_emails[] = base64_encode(trim($exp2[0]));
		}
	}
	$string .= '</select><input type="hidden" name="free_emailconnector_emailid_'.$uniqueid.'" id="free_emailconnector_emailid_'.$uniqueid.'" value="'.implode(",",$admin_emails).','.'" /></td></tr>';
	if($userid > 0){
		$name = $user->user_firstname.' '.$user->user_lastname;
		if($name == ' '){
			$string .= '<div class="row"><input type="hidden" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" value="'.$user->user_login.'" /><input type="hidden" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" value="'.$user->user_email.'" /></div>';
		}else{
			$string .= '<div class="row"><input type="hidden" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" value="'.$name.'" /><input type="hidden" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" value="'.$user->user_email.'" /></div>';
		}
	}
	else{
		$string .= '<tr class="row"><td class="column_1">'.$fullnamelabel.'<span class="red">*</span></td><td class="column_2"><input type="text" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" /></td></tr>';
		$string .= '<tr class="row"><td class="column_1">'.$emaillabel.'<span class="red">*</span></td><td class="column_2"><input type="text" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" /></td></tr>';
	}
	$string .= '<tr class="row"><td class="column_1">'.$subjectlabel.'<span class="red">*</span></td><td class="column_2"><input type="text" size="'.$textsize.'" name="subject_emailconnector_'.$uniqueid.'" id="subject_emailconnector_'.$uniqueid.'" /></td></tr>';
	$string .= '<tr class="row"><td class="column_1">'.$descriptionlabel.'<span class="red">*</span></td><td class="column_2"><textarea id="message_emailconnector_'.$uniqueid.'" name="message_emailconnector_'.$uniqueid.'" cols="'.$colsfortextarea.'" '.$styletextarea.' rows="'.$rowsfortextarea.'"></textarea></td></tr>';
	$string .= '<tr class="row"><td class="column_1">
<input type="hidden" name="successmessage_'.$uniqueid.'" id="successmessage_'.$uniqueid.'" value="'.$successmessage.'" /></td><td class="column_2">';
	if($showbuttonimage == '1' || $showbuttonimage == 1)
	{
		$string .= '<input type="button" name="free_emailconnector_button_'.$uniqueid.'" onclick="return callAjax('.$uniqueid.')" value="'.$buttontext.'" />';
	}
	else{
		if($imagepath == ''){
			$string .= '<input type="button" name="free_emailconnector_button_'.$uniqueid.'" onclick="return callAjax('.$uniqueid.')" value="'.$buttontext.'" />';
		}
		else{
			$string .= '<img src="'.$imagepath.'" onclick="return callAjax('.$uniqueid.')" />';
		}
	}
	$string .= '<div class="loadingimg_free_'.$uniqueid.'" style="display:none;"><img src="/wp-content/plugins/joomconnect-quick-ticket-lite/images/loading3.gif" /></td></tr>';
	$string .= '</tbody></table>';

}
else{
	$string .= '<form name="free_emailconnector_form_'.$uniqueid.'" action="#" method="post">';
	$string .= '<div class="row"><div class="column_1">Select Service Board<span class="red">*</span></div><div class="column_2"><select name="service_board_emailid_'.$uniqueid.'" id="service_board_emailid_'.$uniqueid.'"><option value="all">Choose Service Board</option>';
	foreach($array_emailids as $k => $v){
		$exp2 = explode("-",$v);
		if(isset($exp2) && is_array($exp2) && count($exp2) > 1){
			$string .= '<option value="'.base64_encode(trim($exp2[1])).'">'.trim($exp2[0]).'</option>';
			$admin_emails[] = base64_encode(trim($exp2[1]));
		}
		else{
			$string .= '<option value="'.base64_encode(trim($exp2[0])).'">'.trim($exp2[0]).'</option>';
			$admin_emails[] = base64_encode(trim($exp2[0]));
		}
	}
	$string .= '</select><input type="hidden" name="free_emailconnector_emailid_'.$uniqueid.'" id="free_emailconnector_emailid_'.$uniqueid.'" value="'.implode(",",$admin_emails).','.'" />';
	$string .= '</div>
					</div>';
	if($userid > 0){
		$name = $user->user_firstname.' '.$user->user_lastname;
		if($name == ' '){
			$string .= '<div class="row"><input type="hidden" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" value="'.$user->user_login.'" /><input type="hidden" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" value="'.$user->user_email.'" /></div>';
		}else{
			$string .= '<div class="row"><input type="hidden" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" value="'.$name.'" /><input type="hidden" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" value="'.$user->user_email.'" /></div>';
		}
	}
	else{
		$string .= '<div class="row">
						<div class="column_1">'.$fullnamelabel.'
							<span class="red">*</span>
						</div>
						<div class="column_2">
							<input type="text" size="'.$textsize.'" name="username_'.$uniqueid.'" id="username_'.$uniqueid.'" />
						</div>
					</div>';
		$string .= '<div class="row">
						<div class="column_1">'.$emaillabel.'
							<span class="red">*</span>
						</div>
						<div class="column_2">
							<input type="text" size="'.$textsize.'" name="email_'.$uniqueid.'" id="email_'.$uniqueid.'" />
						</div>
					</div>';
	}
	$string .= '<div class="row">
					<div class="column_1">'.$subjectlabel.'
						<span class="red">*</span>
					</div>
					<div class="column_2">
						<input type="text" size="'.$textsize.'" name="subject_emailconnector_'.$uniqueid.'" id="subject_emailconnector_'.$uniqueid.'" />
					</div>
				</div>';
	$string .= '<div class="row">
					<div class="column_1">'.$descriptionlabel.'
						<span class="red">*</span>
					</div>
					<div class="column_2">
	<textarea id="message_emailconnector_'.$uniqueid.'" name="message_emailconnector_'.$uniqueid.'" cols="'.$colsfortextarea.'" '.$styletextarea.' rows="'.$rowsfortextarea.'"></textarea>
					</div>
				</div>';
	$string .= '<div class="row">
					<div class="column_1">
						<input type="hidden" name="free_emailconnector_emailid_'.$uniqueid.'" id="free_emailconnector_emailid_'.$uniqueid.'" value="'.$emailids.'" />
						<input type="hidden" name="successmessage_'.$uniqueid.'" id="successmessage_'.$uniqueid.'" value="'.$successmessage.'" />
					</div>
					<div class="column_2">';
	if($showbuttonimage == '1' || $showbuttonimage == 1){
		$string .= '<input type="button" name="free_emailconnector_button_'.$uniqueid.'" onclick="return callAjax('.$uniqueid.')" value="'.$buttontext.'" />';
	}
	else{
		if($imagepath == ''){
			$string .= '<input type="button" name="free_emailconnector_button_'.$uniqueid.'" onclick="return callAjax('.$uniqueid.')" value="'.$buttontext.'" />';
		}
		else{
			$string .= '<img src="'.$imagepath.'" onclick="return callAjax('.$uniqueid.')" />';
		}
	}
	$string .= '<div class="loadingimg_free_'.$uniqueid.'" style="display:none;"><img src="/wp-content/plugins/joomconnect-quick-ticket-lite/images/loading3.gif" /></div></div></div>';
}
$string .= '</form><div class="success_msg_'.$uniqueid.'"></div><div class="jcemailconnector_pos1">'.$posttext.'</div></div>';
echo $string;
?>