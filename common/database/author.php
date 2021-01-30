<?php

function deleteAuthorById(int $id): void
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        DELETE FROM 
            author
        WHERE 
            id=:id
        ;
    ");

    $queryObject->execute([
        ':id' => $id
    ]);
}

function updateAuthor(int $idAuthor, string $firstName, string $lastName): void
{
    global $connexionObject;

    $queryObject = $connexionObject->prepare("
        UPDATE
            author
        SET 
            first_name = :firstName,
            last_name = :lastName
        WHERE
            id = :idAuthor;
    ");

    $queryObject->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':idAuthor' => $idAuthor,
    ]);
}

function findAllAuthors(): array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            *
        FROM
            author
        ;
    ");

    $queryObject->execute();

    return $queryObject->fetchAll(PDO::FETCH_ASSOC);
}

function saveAuthor(string $firstName, string $lastName): int
{
    global $connexionObject;

    $queryObject = $connexionObject->prepare("
        INSERT INTO
            author
            (first_name, last_name)
        VALUES
            (:firstName, :lastName)
        ;
    ");

    $queryObject->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
    ]);

    return $connexionObject->lastInsertId();
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

    $resultsArray = $queryObject->fetchAll(PDO::FETCH_ASSOC);

    if (empty($resultsArray)) {
        return null;
    }

    return $resultsArray[0];
}


function findAuthorByName(string $firstName, string $lastName): ?array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            *
        FROM
            author
		WHERE
			first_name = :firstName
			AND
			last_name = :lastName
    ");

    $queryObject->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName
    ]);

    $resultsArray = $queryObject->fetchAll();

    if (empty($resultsArray)) {
        return null;
    }

    return $resultsArray[0];
}
