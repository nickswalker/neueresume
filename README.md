NeueResume
==========

A simple PHP resume template. NeueResume makes it easy to seperate model and view when making HTML resumes.

View a demo at nickwalker.us/resume

Installation
------

Just unzip the download into any directory on a PHP 5.2 or above enabled server and you'll be up and running. See the sections below about configuring the `settings.php` file and writing your resume content. 

Usage
------
####Adding Resume Content

Section Tyes

Highlight List
Grouped List
List
Arbitrary


Settings
------

Within the `neueresume` directory, you'll find `settings.php`. Here you can configure a handful
of settings, which are listed below. Any setting can be set in either the root `settings.php` or a settings file at the
root of a theme (though some are more useful in one place than the other). All of these functions 
are part of the NeueResume class under the settings object and can be accessed in theme files with 
`$this->settings` as a prefix.


Theming
------


Issues
------

Found a bug? Please create an issue on GitHub at https://github.com/nickswalker/neueresume/issues