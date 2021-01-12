<?php

	include_once('common/includes.php');
	
	if(!empty($_GET['id'])) {
        $id = $_GET['id'];
	}
	if(!empty($_GET['type'])) {
        $type = $_GET['type'];
	}
	
	if (!isset($id) || !isset($type)) {
		http_response_code(400);
		exit("Please provide a type and an id.");
	}
	
	$acceptedTypes = ['book', 'author'];
	if (!in_array($type, $acceptedTypes)) {
		http_response_code(400);
		exit("Type should be either book or author.");
	}
	
	if ($type === 'book') {
		$book = findBookById($id);
		if (empty($book)) {
			http_response_code(404);
			exit("This book doesn't exist.");
		}
		deleteBookById($id);
		header("Location: /");
	}
	
	if ($type === 'author') {
    $author = findAuthorById($id);
    if (empty($author)) {
        http_response_code(404);
			exit("This author doesn't exist.");
		}
		deleteAuthorById($id);
		header("Location: /");
	}
	echo $type;
	echo $id;
	
?>