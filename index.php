<?php
/*
NeueResume 1.0
*/

require('neueresume/neueresume.php');

$neuegal = new NeueResume;

$neuegal->vars['version'] = '1.0';

$neuegal->startTimer();

$neuegal->loadSettings();
$neuegal->initialize();

?>