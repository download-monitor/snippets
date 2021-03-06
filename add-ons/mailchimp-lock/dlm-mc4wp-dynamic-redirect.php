function mc4wp_dlm_dynamic_url( $url, $form ) {

	if ( isset( $_POST['mc4wp_dlm_download_id'] ) && ! empty( $_POST['mc4wp_dlm_download_id'] ) ) {
	
		try {
			/** @var DLM_Download $download */
			$download = download_monitor()->service( 'download_repository' )->retrieve_single( absint( $_POST['mc4wp_dlm_download_id'] ) );
			$url = $download->get_the_download_link();
		} catch ( Exception $exception ) {
			// no download with given ID found
		}
		
	}
	
	return $url;
}

add_filter( 'mc4wp_form_redirect_url', 'mc4wp_dlm_dynamic_url', 20, 2 );

function mc4wp_dlm_add_download_id( $content ) {
	global $wp;
	
	if ( isset( $wp->query_vars ) && isset( $wp->query_vars['download-id'] ) ) {
		$content .= "<input type='hidden' name='mc4wp_dlm_download_id' value='" . esc_attr( $wp->query_vars['download-id'] ) . "' />" . PHP_EOL;
	}
	
	return $content;
}

add_filter( 'mc4wp_form_content', 'mc4wp_dlm_add_download_id' );
