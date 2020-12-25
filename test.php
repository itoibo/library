<?php

$sentence = "I am :firstName and I am :age years old.";

$placeholders = [
    ':firstName' => 'Alice',
    ':age' => 23
];

foreach ($placeholders as $key => $value) {
    $sentence = str_replace($key, $value, $sentence);
}

echo $sentence;