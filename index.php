<?php
//Bootstrap
// This is the barest implementation to get the package off the ground

require 'vendor/autoload.php'; //Don't try to make these paths absolute (begin with a /) unless you know what you're doing.

$publicFromRoot = realpath('.'); //Where is the directory that shows up when you go to the root of your site?
								 // http://example.com/  might be located at /home/public_html/ on the server.
									
$themePathFromRoot = realpath('themes/default'); //Where is your theme?
												 //Note that the theme MUST be in a publicly accesible directory!
												 //Otherwise your CSS won't load :(

$neueresume = new \Nickswalker\NeueResume\NeueResume($publicFromRoot, $themePathFromRoot);
$neueresume->resumePathFromRoot = realpath('resume.xml');

$neueresume->display();
