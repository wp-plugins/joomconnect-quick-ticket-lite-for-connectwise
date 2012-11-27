<?php

class jc_qtlite_widget extends WP_Widget {
    /** constructor */
    function jc_qtlite_widget() {

		$name =		'JoomConnect Quick Ticket Lite';
		$desc = 		'Offer a form for users to submit tickets using your configured email connectors';
		$id_base = 		'jc_qtlite_widget';
		$css_class = 	'';
		$alt_option = 	'widget_jc_quick_ticket_lite';

		$widget_ops = array(
			'classname' => $css_class,
			'description' => __( $desc, 'jc-quick-ticket-lite' ),
		);
		parent::WP_Widget( 'nav_menu', __('Custom Menu'), $widget_ops );

		$this->WP_Widget($id_base, __($name, 'jcqtlite'), $widget_ops);
		$this->alt_option_name = $alt_option;

		$this->defaults = array(
			'title' => '',
			'pretext' => '',
			'posttext' => '',
			'fullnamelabel' => '',
			'emaillabel' => '',
			'showbuttonimage' => '',
			'subjectlabel' => '',
			'descriptionlabel' => '',
			'serviceboard' => '',
			'imagepath' => '',
			'buttontext' => '',
			'successmessage' => '',
			'textsize' => '',
			'rowsfortextarea' => '',
			'colsfortextarea' => '',
			'fieldlayout' => ''
		);
	}

	function widget($args, $instance) {
 		extract($args);

		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 
		if (!empty($title))
			echo $before_title . $title . $after_title;;
 
		/** Widget actions start **/

		include('joomconnect_quick_ticket_lite_front.php');
 		
		/** End widget actions **/

		echo $after_widget;
	}

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['pretext'] = strip_tags( stripslashes($new_instance['pretext']) );
		$instance['posttext'] = strip_tags( stripslashes($new_instance['posttext']) );
		$instance['fullnamelabel'] = strip_tags( stripslashes($new_instance['fullnamelabel']) );
		$instance['emaillabel'] = strip_tags( stripslashes($new_instance['emaillabel']) );
		$instance['showbuttonimage'] = $new_instance['showbuttonimage'];
		$instance['subjectlabel'] = strip_tags( stripslashes($new_instance['subjectlabel']) );
		$instance['descriptionlabel'] = strip_tags( stripslashes($new_instance['descriptionlabel']) );
		$instance['serviceboard'] = strip_tags( stripslashes($new_instance['serviceboard']) );
		$instance['imagepath'] = strip_tags( stripslashes($new_instance['imagepath']) );
		$instance['buttontext'] = strip_tags( stripslashes($new_instance['buttontext']) );
		$instance['successmessage'] = strip_tags( stripslashes($new_instance['successmessage']) );
		$instance['textsize'] = strip_tags( stripslashes($new_instance['textsize']) );
		$instance['rowsfortextarea'] = strip_tags( stripslashes($new_instance['rowsfortextarea']) );
		$instance['colsfortextarea'] = strip_tags( stripslashes($new_instance['colsfortextarea']) );
		$instance['fieldlayout'] = $new_instance['fieldlayout'];

		return $instance;
	}

    /** @see WP_Widget::form */
    function form($instance) {
		wp_enqueue_style( 'emailconnector', jc_qtlite::get_plugin_directory() . '/css/emailconnector.css');
		wp_enqueue_script( 'tooltip', jc_qtlite::get_plugin_directory() . '/js/tooltip.js');

		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$pretext = isset( $instance['pretext'] ) ? $instance['pretext'] : '';
		$posttext = isset( $instance['posttext'] ) ? $instance['posttext'] : '';
		$fullnamelabel = isset( $instance['fullnamelabel'] ) ? $instance['fullnamelabel'] : '';
		$emaillabel = isset( $instance['emaillabel'] ) ? $instance['emaillabel'] : '';
		$showbuttonimage = isset( $instance['showbuttonimage'] ) ? $instance['showbuttonimage'] : '';
		$subjectlabel = isset( $instance['subjectlabel'] ) ? $instance['subjectlabel'] : '';
		$descriptionlabel = isset( $instance['descriptionlabel'] ) ? $instance['descriptionlabel'] : '';
		$serviceboard = isset( $instance['serviceboard'] ) ? $instance['serviceboard'] : '';
		$imagepath = isset( $instance['imagepath'] ) ? $instance['imagepath'] : '';
		$buttontext = isset( $instance['buttontext'] ) ? $instance['buttontext'] : '';
		$successmessage = isset( $instance['successmessage'] ) ? $instance['successmessage'] : '';
		$textsize = isset( $instance['textsize'] ) ? $instance['textsize'] : '';
		$rowsfortextarea = isset( $instance['rowsfortextarea'] ) ? $instance['rowsfortextarea'] : '';
		$colsfortextarea = isset( $instance['colsfortextarea'] ) ? $instance['colsfortextarea'] : '';
		$fieldlayout = isset( $instance['fieldlayout'] ) ? $instance['fieldlayout'] : '';

		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );

		//Set tooltip strings
		$titletip = 'The widget title that will show on the frontend of your site.';
		$pretexttip = 'This text will appear above the form';
		$posttexttip = 'This text will appear below the form';
		$fullnamelabeltip = 'Label for the Name field on the form';
		$emaillabeltip = 'Label for the Email field on the form';
		$showbuttonimagetip = 'Select whether you would like to use a standard submit button or an image for your submit button';
		$subjectlabeltip = 'Label for the Subject field on the form';
		$descriptionlabeltip = 'Label for the Problem Description field on the form';
		$serviceboardtip = 'Service board name(s) and email(s). Enter one per line. Name and email should be separated by - only. Example: Support-support@domain.com';
		$imagepathtip = 'The full path to the image you wish to use as your form submit button';
		$buttontexttip = 'The text to display in the submit button';
		$successmessagetip = 'The text to display after the form is submitted';
		$textsizetip = 'Set the size of text box fields';
		$rowsfortextareatip = 'Set the rows/height of the text area field';
		$colsfortextareatip = 'Set the columns/width of the text area field';
		$fieldlayouttip = 'Select Full Form to better display this form inside a large content area. Select Slim Line for a better display on the sidebar.';
?>

<table>
	<tr><td>
		<label for="<?php echo $this->get_field_id('title'); ?>" onmouseover="tooltip.show('<?php echo $titletip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Title:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('pretext'); ?>" onmouseover="tooltip.show('<?php echo $pretexttip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Pre-text:') ?></label>
	</td><td>
		<textarea rows="3" cols="17" id="<?php echo $this->get_field_id('pretext'); ?>" name="<?php echo $this->get_field_name('pretext'); ?>"><?php echo $pretext; ?></textarea>
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('posttext'); ?>" onmouseover="tooltip.show('<?php echo $posttexttip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Post-text:') ?></label>
	</td><td>
		<textarea rows="3" cols="17" id="<?php echo $this->get_field_id('posttext'); ?>" name="<?php echo $this->get_field_name('posttext'); ?>"><?php echo $posttext; ?></textarea>
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('fullnamelabel'); ?>" onmouseover="tooltip.show('<?php echo $fullnamelabeltip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Full Name Label:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('fullnamelabel'); ?>" name="<?php echo $this->get_field_name('fullnamelabel'); ?>" value="<?php echo $fullnamelabel; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('emaillabel'); ?>" onmouseover="tooltip.show('<?php echo $emaillabeltip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Email Label:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('emaillabel'); ?>" name="<?php echo $this->get_field_name('emaillabel'); ?>" value="<?php echo $emaillabel; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('subjectlabel'); ?>" onmouseover="tooltip.show('<?php echo $subjectlabeltip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Subject Label:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('subjectlabel'); ?>" name="<?php echo $this->get_field_name('subjectlabel'); ?>" value="<?php echo $subjectlabel; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('descriptionlabel'); ?>" onmouseover="tooltip.show('<?php echo $descriptionlabeltip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Description Label:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('descriptionlabel'); ?>" name="<?php echo $this->get_field_name('descriptionlabel'); ?>" value="<?php echo $descriptionlabel; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('serviceboard'); ?>" onmouseover="tooltip.show('<?php echo $serviceboardtip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Service Board Name & Email Connector:') ?></label>
	</td><td>
		<textarea rows="3" cols="17" id="<?php echo $this->get_field_id('serviceboard'); ?>" name="<?php echo $this->get_field_name('serviceboard'); ?>"><?php echo $serviceboard; ?></textarea>
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('showbuttonimage'); ?>" onmouseover="tooltip.show('<?php echo $showbuttonimagetip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Show Button/Image:') ?></label>
	</td><td>
		<?php 
		$pos = strpos($showbuttonimage, 'Button');
		if($pos === false){ ?>
			<input type="radio" id="<?php echo $this->get_field_id('showbuttonimage'); ?>" name="<?php echo $this->get_field_name('showbuttonimage'); ?>" value="Button"> Button
			<input type="radio" id="<?php echo $this->get_field_id('showbuttonimage'); ?>" name="<?php echo $this->get_field_name('showbuttonimage'); ?>" value="Image" checked> Image
		<?php }else{ ?>
			<input type="radio" id="<?php echo $this->get_field_id('showbuttonimage'); ?>" name="<?php echo $this->get_field_name('showbuttonimage'); ?>" value="Button" checked> Button
			<input type="radio" id="<?php echo $this->get_field_id('showbuttonimage'); ?>" name="<?php echo $this->get_field_name('showbuttonimage'); ?>" value="Image"> Image		
		<?php } ?>
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('imagepath'); ?>" onmouseover="tooltip.show('<?php echo $imagepathtip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Image Path:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('imagepath'); ?>" name="<?php echo $this->get_field_name('imagepath'); ?>" value="<?php echo $imagepath; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('buttontext'); ?>" onmouseover="tooltip.show('<?php echo $buttontexttip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Button Text:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('buttontext'); ?>" name="<?php echo $this->get_field_name('buttontext'); ?>" value="<?php echo $buttontext; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('successmessage'); ?>" onmouseover="tooltip.show('<?php echo $successmessagetip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Success Message:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('successmessage'); ?>" name="<?php echo $this->get_field_name('successmessage'); ?>" value="<?php echo $successmessage; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('textsize'); ?>" onmouseover="tooltip.show('<?php echo $textsizetip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Text Field Size:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('textsize'); ?>" name="<?php echo $this->get_field_name('textsize'); ?>" value="<?php echo $textsize; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('rowsfortextarea'); ?>" onmouseover="tooltip.show('<?php echo $rowsfortextareatip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Rows for Text Area:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('rowsfortextarea'); ?>" name="<?php echo $this->get_field_name('rowsfortextarea'); ?>" value="<?php echo $rowsfortextarea; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('colsfortextarea'); ?>" onmouseover="tooltip.show('<?php echo $colsfortextareatip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Columns for Text Area:') ?></label>
	</td><td>
		<input type="text" id="<?php echo $this->get_field_id('colsfortextarea'); ?>" name="<?php echo $this->get_field_name('colsfortextarea'); ?>" value="<?php echo $colsfortextarea; ?>" />
	</td></tr>

	<tr><td>
		<label for="<?php echo $this->get_field_id('fieldlayout'); ?>" onmouseover="tooltip.show('<?php echo $fieldlayouttip; ?>', 230);" onmouseout="tooltip.hide();"><?php _e('Form Field Layout:') ?></label>
	</td><td>
		<?php //1 = full 	2 = slim
		if($fieldlayout == 2){ ?>
			<select id="<?php echo $this->get_field_id('fieldlayout'); ?>" name="<?php echo $this->get_field_name('fieldlayout'); ?>">
			  <option value="1"> Full Form </option>
			  <option value="2" selected>Slim Line </option>
			</select> 
		<?php }else{ ?>
			<select id="<?php echo $this->get_field_id('fieldlayout'); ?>" name="<?php echo $this->get_field_name('fieldlayout'); ?>">
			  <option value="1" selected>Full Form </option>
			  <option value="2">Slim Line </option>
			</select> 
		<?php } ?>
	</td></tr>
</table>
<?php
	}
} // class jc_qtlite_widget