<?php
//GET /api/authors.php?id={id}

include_once($_SERVER['DOCUMENT_ROOT'].'/common/includes.php');
header('Content-Type: application/json');

// CREATING AN AUTHOR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $firstName = $data['first_name'];
    $lastName = $data['last_name'];

    $errorsArray = [];

    if (empty($firstName)) {
        $errorsArray[] = "First name should not be empty.";
    }
	
	if (empty($lastName)) {
        $errorsArray[] = "Last name should not be empty.";
    }
	
	if (empty($errorsArray)) {
        if(!empty(findAuthorByName($firstName, $lastName))) {
            $errorsArray[] = "Author already exits.";
        }
    }
	
    if (empty($errorsArray)) {
        $id = saveAuthor($firstName, $lastName);
        http_response_code(201);
        $authorArray = findAuthorById($id);
        echo json_encode($authorArray);
    } else {
		http_response_code(400);
        echo json_encode($errorsArray);
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $authorArray = findAuthorById($id);
    if ($authorArray === null) {
        http_response_code(404);
        exit();
    }
	
	$authorArray['books'] = findBooksByAuthorId($authorArray['id']);
	echo json_encode($authorArray);
}

// RETRIEVING ALL AUTHORS
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $authorsArray = findAllAuthors();
    echo json_encode($authorsArray);
}