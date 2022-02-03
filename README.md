
# WJCT Composer Now Playing Shortcode
A simple Wordpress plugin that pulls the Now Playing information from NPR Composer. 

The WJCT Composer Now Playing Shortcode pulls the currently playing episode and title from the NPR Composer API and displays it wherever the shortcode is entered on your station website.

## How to install:

Download the plugin. 

Change the UCSID to your station's USC ID.

 1. Log into Composer (https://composer.nprstations.org/)
 2. Go to the Calendar page for your stream
 3. Look at the URL, it should look something like this: 

 http://composer.nprstations.org/ **50d0e295e1c801749511ab5** /calendar
     
 4. The bold part of the above URL is the UCS. It will always be a string of numbers and letters right before /calendar.
 5. Open the file index.php, and find the line `const UCSID = "5187f37be1c838d5f207363f";`
 6. Replace the number in the quotation marks with your station's UCSID.

Upload to your plugin folder. 
Then, activate the plugin.

To show the Now Playing Information, just add the following shortcode anywhere in Wordpress: [composer_now_playing]

## Version History

1.1 Working PHP API call

1.2 Changed API call to JavaScript, and set to run every half hour AND fixed the time format to AP Style!

1.3 Cleaned up code and moved UCSID.

