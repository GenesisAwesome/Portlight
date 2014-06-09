<?php
/**
 * GenesisAwesome Contact Page
 *
 * Template Name: Contact
 *
 * A Contact page with reCaptcha for GenesisAwesome Child themes
 *
 * @package    Genesis Child Theme
 * @subpackage Page Templates
 * @author     Harish Dasari
 * @version    1.0
 * @link       http://www.genesisawesome.com/
 */

/* Remove the Default Post Content */
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'genesisawesome_do_post_content' );
/**
 * GenesisAwesome Contact Form to Post Content
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_do_post_content() {

	/* Load reCpatcha library */
	require_once( CHILD_DIR . '/lib/recaptchalib.php' );

	/* Get Contact Form Options */
	$pub_key       = genesis_get_option( 'recaptcha_publickey', GA_CHILDTHEME_FIELD );
	$pvt_key       = genesis_get_option( 'recaptcha_privatekey', GA_CHILDTHEME_FIELD );
	$contact_email = genesis_get_option( 'contact_email', GA_CHILDTHEME_FIELD );
	$contact_email = $contact_email ? $contact_email : get_option( 'admin_email' );

	/* Helpers */
	$mail_status   = false;
	$reCaptcha     = ( $pub_key && $pvt_key ) ? true : false;
	$error         = array();
	$error_class   = ' class="ga-error"';

	/* Process Contact Form Submission */
	if ( isset( $_POST['ga-submit'] ) ) {

		if ( ! isset( $_POST['ga-name'] ) || empty( $_POST['ga-name'] ) )
			$error[] = 'name';

		if ( ! isset( $_POST['ga-subject'] ) || empty( $_POST['ga-subject'] ) )
			$error[] = 'subject';

		if ( ! isset( $_POST['ga-email'] ) || ! filter_var( $_POST['ga-email'], FILTER_VALIDATE_EMAIL ) )
			$error[] = 'email';

		if ( ! isset( $_POST['ga-message'] ) || empty( $_POST['ga-message'] ) )
			$error[] = 'message';

		if ( $reCaptcha ) {

			$responce = recaptcha_check_answer(
				$pvt_key,
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']
			);

			if ( ! $responce->is_valid )
				$error[] = 'recaptcha';

		}

		if ( count( $error ) === 0 ) {

			$ga_name    = isset( $_POST['ga-name'] ) || ! empty( $_POST['ga-name'] ) ? esc_html( stripslashes( $_POST['ga-name'] ) ) : __( 'NO NAME', 'genesisawesome' );
			$ga_subject = isset( $_POST['ga-subject'] ) || ! empty( $_POST['ga-subject'] ) ? esc_html( stripslashes( $_POST['ga-subject'] ) ) : __( 'NO SUBJECT', 'genesisawesome' );
			$ga_mail    = sanitize_email( stripslashes( $_POST['ga-email'] ) );
			$ga_message = isset( $_POST['ga-message'] ) || ! empty( $_POST['ga-message'] ) ? wpautop( esc_html( stripslashes( $_POST['ga-message'] ) ) ) : __( 'NO MESSAGE', 'genesisawesome' );

			$blog_name  = get_bloginfo( 'name' );
			$blog_url   = get_bloginfo( 'url' );
			$email_to   = "$blog_name <$contact_email> ";
			$ga_ip      = ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ? $_SERVER['HTTP_CLIENT_IP'] : ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );

			$headers    = array();
			$headers[]  = "From: $ga_name <$ga_mail> ";
			$headers[]  = 'MIME-Version: 1.0';
			$headers[]  = 'Content-type: text/html; charset=UTF-8';

			$message    = <<<GA_MSG

<table cellspacing="0" cellpadding="12" border="0">
  <tbody>
	<tr valign="top">
		<td style="background: #e7f8ff">Name</td>
		<td style="background: #e7f8ff">$ga_name &lt;$ga_mail&gt;</td>
	</tr>
	<tr valign="top">
		<td style="background: #ffffff">Subject</td>
		<td style="background: #ffffff">$ga_subject</td>
	</tr>
	<tr valign="top">
		<td style="background: #e7f8ff">Message</td>
		<td style="background: #e7f8ff">$ga_message</td>
	</tr>
	<tr valign="top">
		<td style="background: #ffffff">IP</td>
		<td style="background: #ffffff">$ga_ip</td>
	</tr>
	<tr valign="top">
		<td style="background: #e7f8ff" colspan="2">This mail is sent by Contact Form on $blog_name $blog_url</td>
	</tr>
  </tbody>
</table>

GA_MSG;

			$mail_status = wp_mail( $email_to, $ga_subject, $message, $headers );

			if ( $mail_status )
				echo '<div class="ga-contact-success">' . __( 'Success!. Your mail is Sent!', 'genesisawesome' ) . '</div>';
			else
				echo '<div class="ga-contact-failed">' . __( 'Sorry!. Failed to sent the Mail!', 'genesisawesome' ) . '</div>';

		}

	}

	/* Field Values if Contact Form has Error */
	$ga_field_name    = isset( $_POST['ga-name'] ) && ! $mail_status ? stripcslashes( $_POST['ga-name'] ) : '';
	$ga_field_subject = isset( $_POST['ga-subject'] ) && ! $mail_status ? stripcslashes( $_POST['ga-subject'] ) : '';
	$ga_field_email   = isset( $_POST['ga-email'] ) && ! $mail_status ? stripcslashes( $_POST['ga-email'] ) : '';
	$ga_field_message = isset( $_POST['ga-message'] ) && ! $mail_status ? stripcslashes( $_POST['ga-message'] ) : '';

	/* The Contact Form */
	?>
	<div id="ga-contact-form">
		<form method="POST">
			<p<?php if ( in_array( 'name', $error ) ) echo $error_class; ?>>
				<label for="ga-name"><?php _e( 'Name', 'genesisawesome' ); ?>  *</label><br />
				<input type="text" name="ga-name" id="ga-name" required="required" size="45" value="<?php echo esc_attr( $ga_field_name ); ?>"/>
			</p>
			<p<?php if ( in_array( 'subject', $error ) ) echo $error_class; ?>>
				<label for="ga-subject"><?php _e( 'Subject', 'genesisawesome' ); ?> *</label><br />
				<input type="text" name="ga-subject" id="ga-subject" required="required" size="45" value="<?php echo esc_attr( $ga_field_subject ); ?>"/>
			</p>
			<p<?php if ( in_array( 'email', $error ) ) echo $error_class; ?>>
				<label for="ga-email"><?php _e( 'Email', 'genesisawesome' ); ?> *</label><br />
				<input type="text" name="ga-email" id="ga-email" required="required" size="45" value="<?php echo esc_attr( $ga_field_email ); ?>"/>
			</p>
			<p<?php if ( in_array( 'message', $error ) ) echo $error_class; ?>>
				<label for="ga-message"><?php _e( 'Message', 'genesisawesome' ); ?> *</label><br />
				<textarea name="ga-message" id="ga-message" cols="60" rows="8" required="required"><?php echo esc_textarea( $ga_field_message ); ?></textarea>
			</p>
			<?php if ( $reCaptcha ) :
			$color_theme = genesis_get_option( 'recaptcha_colortheme', GA_CHILDTHEME_FIELD ) ? genesis_get_option( 'recaptcha_colortheme', GA_CHILDTHEME_FIELD ) : 'red';
			?>
			 <script type="text/javascript">
			 var RecaptchaOptions = {
			    theme : '<?php echo esc_js( $color_theme ); ?>'
			 };
			 </script>
 			<div<?php if ( in_array( 'recaptcha', $error ) ) echo $error_class; ?>>
				<label for=""><?php _e( 'Verification', 'genesisawesome' );?> *</label><br />
				<?php echo recaptcha_get_html( $pub_key ); ?>
			</div><br />
			<?php endif; ?>
			<p>
				<input type="submit" name="ga-submit" id="ga-submit" value="<?php esc_attr_e( 'Send', 'genesisawesome' );?>" />
			</p>
			<span style="font-size: small"><?php _e( '* indicates required', 'genesisawesome' );?></span>
		</form>
	</div>
	<?php

}

/* The Genesis */
genesis();