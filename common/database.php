<?php

function findBook(int $id): ?array
{
	global $connexionObject;
    $queryObject = $connexionObject->prepare("
                SELECT
                    book.id,
                    book.title,
                    book.description,
                    book.author_id,
                    author.first_name,
                    author.last_name
                FROM
                    book
                LEFT JOIN
                    author ON author.id = book.author_id
                WHERE
                    book.id = $id;
                ;
            ");

    $queryObject->execute();

    $resultsArray = $queryObject->fetchAll();
	
	//print_r($resultsArray);
	if (empty($resultsArray)) {
        return null;
    }
    

    return $resultsArray[0];//Get the first row.
}
  