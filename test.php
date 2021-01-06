<?php

$filename = 'blabla.bla.jpg';
$filename .= 'yada';
echo substr($filename, strrpos($filename, '.'));

echo $_SERVER['SCRIPT_FILENAME'];