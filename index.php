<?php
/* NeueResume 1.1*/

require('neueresume/neueresume.php');

$neuegal = new NeueResume;

$neuegal->vars['version'] = '1.1';

$neuegal->startTimer();

$neuegal->loadSettings();
$neuegal->initialize();
