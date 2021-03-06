<?php
/**
 * Show the Shop Vendor's email for each download purchased
 * @link http://sumobi.com/show-shop-vendors-email-download-purchased/
 *
 * Example:
 * For more information about your order, please contact one of the following vendors:
 * {vendor_emails}
 */
 
/**
 * Add a {vendor_emails} tag
 */
function sumobi_edd_email_tags( $email_tags ) {
	$email_tags[] = array(
		'tag'         => 'vendor_emails',
		'description' => 'List each download purchased with the email address of the Shop vendor who added it',
		'function'    => 'sumobi_edd_vendor_emails'
	);
 
	return $email_tags;
}
add_filter( 'edd_email_tags', 'sumobi_edd_email_tags' );
 
/**
 * List each download with the email of the author (Shop Vendor who added it)
 */
function sumobi_edd_vendor_emails() {
	ob_start();
 
	$downloads = edd_get_purchase_session();
	$downloads = $downloads['downloads'];
 
	if ( $downloads ) {
		foreach ( $downloads as $key => $download ) {
			 $post = get_post( $download['id'] );
			 $author_id = $post->post_author;
 
			 // download title
			 echo get_the_title( $download['id'] ) . '<br/>';
			 // the email address of the author who added the download
			 echo get_the_author_meta( 'user_email', $author_id ) . '<br/><br/>';
		}
	}
 
	$html = ob_get_clean();
	return $html;
}