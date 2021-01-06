<?php

	include_once('common/includes.php');
	
	if(!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        http_response_code(400);
        exit("Missing author ID.");
    }

	
	$authorArray = findAuthorById($id);
	
    $formDataArray = [
        'firstName' => $authorArray['first_name'],
        'lastName' => $authorArray['last_name'],
        //'picture' => '',
    ];	
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//escape($method);
	if($method === 'POST') {
		$formDataArray = [
		'firstName' => $_POST['firstName'],
		'lastName' => $_POST['lastName'],
		//'picture' => $_FILES['picture'],
		];
		
		if (empty($formDataArray['firstName'])) {
			$errorsArray[] = "First name should <strong>not</strong> be empty.";
		}
		
		if (empty($formDataArray['lastName'])) {
			$errorsArray[] = "Last name should <strong>not</strong> be empty.";
		}
		
        if (empty($errorsArray)) {
            $authorArray = findAuthorByName($_POST['firstName'], $_POST['lastName']);
			if($authorArray['id'] != $id && !empty($authorArray)) {
				$errorsArray[] = "Author already exits.";
			}
        }
		
		if (empty($errorsArray)) {
			updateAuthor($id, $formDataArray['firstName'], $formDataArray['lastName']);
			$redirectUrl = "/author.php?id=$id";
			header("Location: $redirectUrl");
		}
	}
	
?>




<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <title>Update an Author</title>
</head>
	<body>
		<h1>Update an author</h1>
		
		<ul>
			<?php foreach ($errorsArray as $error) { ?>
				<li>
					<?php 
						echo $error;//Contains html. Do not escape. 
					?>
				</li>
			<?php } ?>
		</ul>
		
		<form action="" method="POST" enctype="multipart/form-data">
			<table>
				<tr>
					<td>
						<label for="firstName">First name:</label>
					</td>
					<td>
						<input type="text" id="firstName" name="firstName" value="<?php escape($formDataArray['firstName']); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="lastName">Last name:</label>
					</td>
					<td>
						<input type="text" id="lastName" name="lastName" value="<?php escape($formDataArray['lastName']); ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="submit">Save</button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
    