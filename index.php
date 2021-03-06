<?php

/*

Plugin name: WJCT Composer Now Playing Shortcode
Author: Matthew Forgette, Md. Sarwar-A-Kawsar, Ray Hollister
Version: 1.3

1.1 Working PHP API call
1.2 Changed API call to JavaScript, and set to run every half hour AND fixed the time format to AP Style!
1.3 Cleaned up code and moved UCSID

*/
wp_enqueue_style( "composer_now_playing",  plugins_url('style.css', __FILE__) );

defined('ABSPATH') or die('You cannot access to this page');

add_shortcode( 'composer_now_playing', 'composer_now_playing_shortcode_callback' );
function composer_now_playing_shortcode_callback(){
?>
	<div id="composer-now-playing" class="composer-now-playing">
	</div>

<script type='text/JavaScript'>

	let firstRun = true;
	let minutes;
	const element = document.getElementById(
	"composer-now-playing"
	);

	// Change this to your station's UCSID number. 	
	const UCSID = "5187f37be1c838d5f207363f";

	const URL =
	`https://api.composer.nprstations.org/v1/widget/${UCSID}/now?format=json&limit=20`;

	const fetchComposerNowPlaying = async () => {
	try {
		const response = await fetch(URL);
		const data = await response.json();
		const name = data.onNow.program.name;
		const start = data.onNow.start_utc;
		let newStart = new Date(start);
		newStart = newStart.toLocaleTimeString(('en-US'), {hour: 'numeric', minute:'2-digit'});
		newStart = newStart.replace("AM", "a.m.").replace("PM", "p.m.");
		const end = data.onNow.end_utc;
		let newEnd = new Date(end);
		newEnd = newEnd.toLocaleTimeString(('en-US'), {hour: 'numeric', minute:'2-digit'});
		newEnd = newEnd.replace("AM", "a.m.").replace("PM", "p.m.");
		const program_url = data.onNow.program.program_link;

		element.innerHTML = `
					<h3 class="current-show"><a href="${program_url}">${name}</a></h3>
					<span class="cpw_program_time">${newStart} - ${newEnd}</span>
			`;
	} catch (error) {
		console.error(error);
	}
	};

	function AddShortcodeIntervalLogic() {
	let d = new Date(); // initializes the exact time the the page loaded
	let minutes = d.getMinutes();
	let seconds = d.getSeconds();
	if (firstRun) {
		if (minutes > 30) {
		minutes = 60 - minutes;
		} else {
		minutes = 30 - minutes;
		}
		firstRun = false;
		setInterval(fetchComposerNowPlaying, minutes * 60000);
	} else {
		minutes = 30;
		setInterval(fetchComposerNowPlaying, minutes * 60000);
	}
	}
	fetchComposerNowPlaying();
	AddShortcodeIntervalLogic();

</script>

<?php

	return ob_get_clean();
}
	
// 	return ob_get_clean();
// }
