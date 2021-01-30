<?php

function deleteBookById(int $id): void
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        DELETE FROM 
            book
        WHERE 
            id=:id
        ;
    ");

    $queryObject->execute([
        ':id' => $id
    ]);
}

function updateBook(int $idBook, string $title, string $description, int $idAuthor): void
{
    global $connexionObject;

    $queryObject = $connexionObject->prepare("
        UPDATE
            book
        SET 
            title = :title,
            description = :description,
            author_id = :idAuthor
        WHERE
            id = :idBook;
    ");

    $queryObject->execute([
        ':title' => $title,
        ':description' => $description,
        ':idAuthor' => $idAuthor,
        ':idBook' => $idBook,
    ]);
}

function saveBook(string $title, string $description, int $idAuthor): int
{
    global $connexionObject;

    $queryObject = $connexionObject->prepare("
        INSERT INTO
            book
            (title, description, author_id)
        VALUES
            (:title, :description, :idAuthor)
        ;
    ");

    $queryObject->execute([
        ':title' => $title,
        ':description' => $description,
        ':idAuthor' => $idAuthor,
    ]);

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
			book.id = :id;
		;
	");

    //Do we want the ; here: book.id = :id; ?

    $queryObject->execute([
        ':id' => $id
    ]);

    $resultsArray = $queryObject->fetchAll();

    //print_r($resultsArray);
    if (empty($resultsArray)) {
        return null;
    }


    return $resultsArray[0];//Get the first row.
}



/*
//Good example of a join.

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

    $resultsArray = $queryObject->fetchAll(PDO::FETCH_ASSOC);

    //print_r($resultsArray);

    return $resultsArray;//Get all rows.
}

*/

function findBooksByAuthorId(int $id): array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            book.id,
            book.title,
            book.description,
            book.author_id
        FROM
            book
        WHERE
            book.author_id = :id;
        ;
    ");

    $queryObject->execute([
        ':id' => $id
    ]);

    $resultsArray = $queryObject->fetchAll(PDO::FETCH_ASSOC);

    return $resultsArray;
}


function countAllBooks(): string
{
    global $connexionObject;
    $queryCountObject = $connexionObject->prepare("SELECT COUNT(*) FROM book;");
    $queryCountObject->execute();
    $countResultsArray = $queryCountObject->fetchAll();
    return $countResultsArray[0]['COUNT(*)'];
}

function findNBooksWithAuthors(int $numBooks, int $offset): array
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
