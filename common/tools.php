<?php

function processImage(array $imageArray, int $id): void
{
    $sizeArray = getimagesize($imageArray['tmp_name']);
    $resource = imagecreatefromstring(file_get_contents($imageArray['tmp_name']));
	$newHeight = (100 * ($sizeArray[1] / $sizeArray[0]));//targetting 100w by aspect*h.
	
    $target = imagecreatetruecolor(100, $newHeight);
	imagecopyresampled($target, $resource,0,0,0,0, 100, $newHeight, $sizeArray[0], $sizeArray[1]);
	
	if ($imageArray['type'] === 'image/jpeg') {
		imagejpeg($target,"var/author/$id");
    } else {
        imagepng($target,"var/author/$id");
    }
}


function escape($data): void
{
    echo htmlentities($data);
}