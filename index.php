<?php

/*

Plugin name: WJCT Composer Now Playing Shortcode
Author: Md. Sarwar-A-Kawsar, Ray Hollister
Version: 1.1

*/
wp_enqueue_style( "composer_now_playing",  plugins_url('style.css', __FILE__) );

defined('ABSPATH') or die('You cannot access to this page');

function get_program_data(){
	$response = wp_remote_get( 'https://api.composer.nprstations.org/v1/widget/5187f37be1c838d5f207363f/now?format=json&limit=20' );
	$http_code = json_decode(wp_remote_retrieve_body( $response ),true);
	return $http_code;
}

add_shortcode( 'composer_now_playing', 'composer_now_playing_shortcode_callback' );
function composer_now_playing_shortcode_callback(){
	ob_start();
	$http_code = get_program_data();
	$program_id = $http_code['onNow']['program_id'];
	$start = date('g:i a',strtotime($http_code['onNow']['start_utc']));
	$end = date('g:i a',strtotime($http_code['onNow']['end_utc']));
	$name = $http_code['onNow']['program']['name'];
	$program_url = $http_code['onNow']['program']['program_link'];
	if (is_null($program_url)){
		$program_url = "/listen";
	}
	?>
	<div class="composer-now-playing">
		<h3 class="current-show"><a href="<?php echo $program_url; ?>"><?php echo $name; ?></a></h3>
		<span class="cpw_program_time"><?php echo $start; ?> - <?php echo $end; ?></span>

	</div>
	<?php
	return ob_get_clean();
}
