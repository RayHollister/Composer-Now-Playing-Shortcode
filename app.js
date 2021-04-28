// const newElement = document.createElement('div');
// document.body.appendChild(newElement);

document.getElementById('composer-now-playing');
let firstRun = true;
let minutes;

const URL = 'https://api.composer.nprstations.org/v1/widget/5187f37be1c838d5f207363f/now?format=json&limit=20';

const fetchComposerNowPlaying = async () => {
    try {
        const response = await fetch(URL); 
        const data = await response.json(); 
        const name = data.onNow.program.name; 
        const start = moment(data.onNow.start_time, 'HH:mm:ss').format('h:mm a');
        const end = moment(data.onNow.end_time, 'HH:mm:ss').format('h:mm a');
        //start and end time converted into preferred format using the moment js (https://momentjs.com/docs/)
        const program_url = data.onNow.program.program_link; 
        
        newElement.innerHTML = (`
            <div class="composer-now-playing">
                <h3 class="current-show"><a href="${program_url}">${name}</a></h3>
                <span class="cpw_program_time">${start} - ${end}</span>

            </div>
        `);
    } catch (error) {
        // console.error(error); 
        // throw error;
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
			minutes = 30 - minutes
		}
        firstRun = false;
		setInterval(fetchComposerNowPlaying, minutes * 60000);
	} else { 
        minutes = 30;
		setInterval(fetchComposerNowPlaying, minutes * 60000);
    }
};
fetchComposerNowPlaying(); 
AddShortcodeIntervalLogic();

// ?>
// 	<div class="composer-now-playing">
// 		<h3 class="current-show"><a href="<?php echo $program_url; ?>"><?php echo $name; ?></a></h3>
// 		<span class="cpw_program_time"><?php echo $start; ?> - <?php echo $end; ?></span>

// 	</div>
// 	<?php