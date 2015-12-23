/*
 * jQuery script for Music Server
 *
 * @author Michel Michels
 * @date 23/12/2015
 * @version 0.1
 * 
**/


// function to change the audio source 
var changeAudioSource = function(src) {
	console.log(src);

	// get audio in var
	var $audio = $('audio');

	// set src of source
	$('audio source').first().attr('src', src);

	// set audio to load a new src
	$audio[0].pause();
	$audio[0].load();

	$audio[0].oncanplaythrough = $audio[0].play();
}

// add eventhandler to links
$('li a').on('click', function(event) {
	// stop links from opening
	event.preventDefault();

	// get the path from the clicked item
	var path = $(this).attr('href');
	changeAudioSource(path);
});