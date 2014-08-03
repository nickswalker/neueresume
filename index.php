<?php
//Bootstrap - Move this code to wherever you want the resume to display on your server
// This is the barest implementation to get the package off the ground

require 'vendor/autoload.php'; //Don't try to make these paths absolute (begin with a /) unless you know what you're doing.

$resumePathFromRoot = realpath('resume.xml');
									
$themePathFromRoot = realpath('themes/default'); //Where is your theme?
												 //Note that the theme MUST be in a publicly accesible directory!
												 //Otherwise your CSS won't load :(

$neueresume = new \Nickswalker\NeueResume\NeueResume($resumePathFromRoot, $themePathFromRoot);

$neueresume->display();
