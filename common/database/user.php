<?php

function findUserById(int $id): ?array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            *
        FROM
            user
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


function findUserByUsername(string $username): ?array
{
    global $connexionObject;
    $queryObject = $connexionObject->prepare("
        SELECT
            *
        FROM
            user
        WHERE
            username = :username
    ");

    $queryObject->execute([
        ':username' => $username,
    ]);

    $resultsArray = $queryObject->fetchAll(PDO::FETCH_ASSOC);

    if (empty($resultsArray)) {
        return null;
    }

    return $resultsArray[0];
}


function saveUser(string $username, string $password): int
{
    global $connexionObject;

    $queryObject = $connexionObject->prepare("
        INSERT INTO
            user
            (username, password)
        VALUES
            (:username, :password)
        ;
    ");

    $queryObject->execute([
        ':username' => $username,
        ':password' => sha1($password),
    ]);

    return $connexionObject->lastInsertId();
}
