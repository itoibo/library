<?php

function getAuthorImage(int $authorId): ?string
{
    $filesArray = glob("var/author/$authorId-*");

    return empty($filesArray) ? null : $filesArray[0];
}


function sanitizeFileName(string $firstName, string $lastName): string
{
    $name = "$firstName-$lastName";
    $dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#");
    
    return str_replace($dangerous_characters, '-', $name.'-');
}


function processImage(array $imageArray, string $firstName, string $lastName, int $id): void
{
	$filename = $imageArray['name'];
    $extension = substr($filename, strrpos($filename, '.'));
    $sanitizedFilename = $id . '-' . sanitizeFileName($firstName, $lastName);
    $sanitizedFilename .= $extension;
	
    $sizeArray = getimagesize($imageArray['tmp_name']);
    $resource = imagecreatefromstring(file_get_contents($imageArray['tmp_name']));
	$newHeight = (100 * ($sizeArray[1] / $sizeArray[0]));//targetting 100w by aspect*h.
	
    $target = imagecreatetruecolor(100, $newHeight);
	imagecopyresampled($target, $resource,0,0,0,0, 100, $newHeight, $sizeArray[0], $sizeArray[1]);
	
	if ($imageArray['type'] === 'image/jpeg') {
        imagejpeg($target,"var/author/$sanitizedFilename");
    } else {
        imagepng($target,"var/author/$sanitizedFilename");
    }
}


function escape($data): void
{
    echo htmlentities($data);
}