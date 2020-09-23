<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* stores the form data (no params) */
function wptournreg_insert_data() {
	
	require_once WP_TOURNREG_DATABASE_PATH . 'escape.php';
	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
	
	global $wpdb;
	$data = [];
	$fields = [];
	$placeholder = [];
	
	foreach( $_POST as $field => $value ) {
		
		if ( $field == 'id' || $field == 'time' || $field == 'cc' || $field == 'touched'|| $field == 'ip' ) { continue; }
		
		/* no need for HTML in any field */
		$value = ( strip_tags( $value ) );
		
		if ( array_key_exists( $field, $scheme ) ) {
				
			if ( $field == 'email' ) {

				$data[] = wptournreg_escape( sanitize_email( $value ) );
				$placeholder[] = '%s';
			}
			else if ( $field == 'message' ) {
				
				$data[] = wptournreg_escape( sanitize_textarea_field( $value ) );
				$placeholder[] = '%s';
			}
			else if ( preg_match( '/char|string|text/i', $scheme[ $field ] ) ) {
				
				$data[] = wptournreg_escape( sanitize_text_field( $value ) );
				$placeholder[] = '%s';
			}
			else if ( preg_match( '/bool|int\(1\)/i', $scheme[ $field ] ) ) {
				
				$data[] = 1;
				$placeholder[] = '%d';
			}
			else if ( preg_match( '/int\(/i', $scheme[ $field ] ) ) {
				
				if ( preg_match( '/\d+/', $value ) ) {
					
					$data[] =  intval( sanitize_text_field( $value ) );
					$placeholder[] = '%d';
				}
				else { continue; } // NULL is default
			}
			else {
				
				$data[] = wptournreg_escape( sanitize_text_field( $value ) );
				$placeholder[] = '%s';
				trigger_error( 'Unknown field type ' . $scheme[ $field ] , E_USER_NOTICE );
			}
			
			$fields[] = $field;
		}
	}
	
	$fields[] = 'time';
	$data[] = time();
	$placeholder[] = '%d';
	$fields[] = 'ip';
	$data[] = "'" . $_SERVER[ 'REMOTE_ADDR' ] . "'";
	$placeholder[] = '%s';
	
	return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . WP_TOURNREG_DATA_TABLE . '(' . implode( ', ', $fields ) . ') VALUES (' . implode( ', ', $placeholder ) . ');', $data ) );
}