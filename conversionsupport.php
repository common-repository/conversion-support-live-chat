<?php
/*
Plugin Name: Conversion Support Live Chat
Plugin URI: http://wordpress.org/extend/plugins/conversion-support-live-chat/
Description: Conversion Support Take chat and monitor visitor online
Version: 2.0
Author: Anusha of Conversion Support
Author URI: http://conversionsupport.com/
License: GPL
*/

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'cs_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'cs_remove' );

//inserts script in head of document

add_action( 'get_footer',   'insert_scriptcode' );

function insert_scriptcode()
{

$custom_vars = get_option('cs_chat_url');

 $scriptcode = "<script type='text/javascript'>
 (function() {var stag = document.createElement('script'); stag.type = 'text/javascript';
  stag.async = true; stag.src='$custom_vars';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(stag,s);})();</script>
 ";

echo $scriptcode;
}

/*===========================================
	Do the work, create a database field
 ===========================================*/

function cs_install() {
	/* Creates new database field */
	add_option("cs_chat_url", 'CS Chat Page URL', '', 'yes');
}

function cs_remove() {
	/* Deletes the database field */
	delete_option('cs_chat_url');
}

/*===========================================
	Create an admin menu to me loaded 
 ===========================================*/

if ( is_admin() ){
	/* Call the html code */
	add_action('admin_menu', 'cs_admin_menu');

	function cs_admin_menu() {
		add_options_page('Conversion Support Options', 'Conversion Support', 'administrator', 'ConversionSupport', 'cs_html_page');
	}
}

/*===========================================
	Conversionsupport HTML page
 ===========================================*/

function cs_html_page() { ?>
	<div>
		<h2>Conversion Support Options</h2>

		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>

			<table>
				<tr valign="top" align="left">
					<th width="190" scope="row">Your Conversion Support Chat URL</th>

					<td width="480">				
						<input 
							type="text"  
							id="cs_chat_url"
							name="cs_chat_url" 
							style="width: 310px;"
							value="<?php echo get_option('cs_chat_url'); ?>" />
					</td>
				</tr>
			</table>

			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="cs_chat_url" />

			<p class="submit" style="padding-top: 0;"><input type="submit" id="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
		</form>
		
		<br />
		
		<h3>Where can I find my Chat URL?</h3>

		<p>
			<a href="http://login.conversionsupport.com" target="_blank">Sign into Conversionsupport</a> and click the on the Settings tab.  You can get your wordpress chat url in wordpress section.
		</p>
		
		<br />
		
		<h3>Don't have a Conversion Support account? No problem!</h3>

		<p>
			Signing up with Conversion Support is simple and you can even 
			<a href="http://www.conversionsupport.com/sign-up.html" target="_blank">get started with a completely free account</a>.			
		</p>
	</div>
<?php } ?>