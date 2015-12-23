<?php
	// trim filename
	function trimMP3String($fileName) {
		// check if file name starts with 0 or 1
		if($fileName[0] === '0' || $fileName[0] === '1') {
			
			/*
			 *	Chop numbers from mp3 file name
			 *  Ex. "01 Thunderstruck - AC-DC.mp3" --> "Thunderstruck - AC-DC.mp3"
			 *
			**/

			// check if second char is a number
			if(is_numeric($fileName[1])){
				// if so, chop it the two numbers
				$fileName = substr($fileName, 2);
			} else {
				// else, chop only the first number
				$fileName = substr($fileName, 1);
			}

			// check if there's a dot or a space in the first char, chop if there is
			if($fileName[0] === '.' || $fileName[0] === ' ') {
				$fileName = substr($fileName, 1);
			}

			/*
			 *	Chop mp3 extension
			 *  Ex. "Thunderstruck - AC-DC.mp3" --> "Thunderstruck - AC-DC"
			 *
			**/

			$fileName = substr($fileName, 0, -4);

			/*
			 *	Chop artist or album if divided by minus
			 *  Ex. "Thunderstruck - AC-DC" --> "Thunderstruck"
			 *
			**/

			if($pos = strpos($fileName, ' - ')) {
				$fileName = substr($fileName, 0, $pos);
			}

			// return the chopped filename
			return $fileName;
		}
	}


	// directory of PHP file (so 'muziekserver' in this case)
	$musicDir = 'Music';

	function recursiveDI($dir) {
		$myBaseDir = $dir;
		$di = new DirectoryIterator($myBaseDir);

		foreach ($di as $file) {
			if(!$file->isDot()) {	
				if($file->isFile() && $file->getExtension() === 'mp3') {
					echo '<li class="file"><a href="' . $dir . '\\' . $file->getFileName() . '">' . trimMP3String($file->getFileName()) . '</a></li>';
				}

				if($file->isDir() && $file->getFileName() !== 'iTunes') {
					echo '<li class="dir">' . $file->getFileName() . PHP_EOL;

					recursiveDI($dir . '\\' . $file);
					echo '</li>';
				}
			}
		}

	}	

?><!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Music Server</title>
</head>
<body>
	<!-- list of songs -->
	<main>
		<ul>
		<?php recursiveDI($musicDir); ?>
		</ul>
	</main>

	<!-- audio element -->
	<audio controls>
		<source src="audio/03 Time Is Now - Blues Pills.mp3" type="audio/mpeg">
	</audio>

	<!-- js scripts -->
	<script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
</body>
</html>