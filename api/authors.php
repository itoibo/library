<?php
//GET /api/authors.php?id={id}

include_once($_SERVER['DOCUMENT_ROOT'].'/common/includes.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $authorArray = findAuthorById($id);
    if ($authorArray === null) {
        http_response_code(404);
        exit();
    }
	
	header('Content-Type: application/json');
	echo json_encode($authorArray);
}

// RETRIEVING ALL AUTHORS
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $authorsArray = findAllAuthors();
    header('Content-Type: application/json');
    echo json_encode($authorsArray);
}