<?php
/*
NeueResume 1.0
*/

require('neueresume/neueresume.php');

$neuegal = new NeueResume;

$neuegal->vars['version'] = '0.1';

$neuegal->startTimer();

$neuegal->loadSettings();
$neuegal->initialize();

?>