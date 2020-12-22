<?php

$numbers = [3, 5, 1, 8, 2, 7, 4];

function isAGreaterThanB(int $a, $b): bool
{
    return $a > $b;
}

usort($numbers, 'isAGreaterThanB');

echo '<pre>';
var_dump($numbers);