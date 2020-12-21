<?php

function saveAuthor(string $firstName, string $lastName): int
{
	global $connexionObject;
    $queryObject = $connexionObject->prepare("
		INSERT INTO
			author
			(first_name, last_name)
		VALUES
			('$firstName', '$lastName')
		;
	");
    $queryObject->execute();
	
	return $connexionObject->lastInsertId();
}

function findBookById(int $id): ?array
{
	global $connexionObject;
    $queryObject = $connexionObject->prepare("
		SELECT
			book.id,
			book.title,
			book.description,
			book.author_id,
			author.first_name AS author_first_name,
			author.last_name AS author_last_name
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


function findAuthorById(int $id): ?array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            *
        FROM
            author
        WHERE
            id = $id
    ");
    
    $queryObject->execute();
    
    $resultsArray = $queryObject->fetchAll();
    
    if (empty($resultsArray)) {
        return null;
    }
    
    return $resultsArray[0];
}


function findBooksByAuthorId(int $id): array
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
            author.id = $id;
        ;
    ");
    
    $queryObject->execute();
    
    $resultsArray = $queryObject->fetchAll();
    
    //print_r($resultsArray);

    return $resultsArray;//Get all rows.
}




function countAllBooks(): string
{
	global $connexionObject;
	$queryCountObject = $connexionObject->prepare("SELECT COUNT(*) FROM book;");
    $queryCountObject->execute();
	$countResultsArray = $queryCountObject->fetchAll();
	return $countResultsArray[0]['COUNT(*)'];
}
	

function findNBooks(int $numBooks, int $offset): array
{
	global $connexionObject;
	$queryObject = $connexionObject->prepare("
		SELECT
			book.id,
			book.title,
			book.description,
			author.first_name AS author_first_name,
			author.last_name AS author_last_name,
			book.author_id
		FROM
			book
		LEFT JOIN
			author ON author.id = book.author_id
		
		LIMIT 
			$numBooks
		OFFSET
			$offset
		;
	");//just contains a string now.
	
	$queryObject->execute();//now contains the string plus all the data we requested.
	
	$resultsArray = $queryObject->fetchAll();
	
	//if(empty($resultsArray)) { return null; }
	
	return $resultsArray;
}




