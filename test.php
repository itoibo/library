<?php

$filename = 'blabla.bla.jpg';
$filename += 'yada';


//var_dump explode(".", [$filename]);
//var_dump explode(".", $filename);
//echo strrpos($filename, '.');
//echo strpos($filename, '.');
echo substr($filename, strrpos($filename, '.'));

