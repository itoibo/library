<?php

	include_once('common/includes.php');
	
	$formDataArray = [
		'firstName' => '',
		'lastName' => '',
	];
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//escape($method);
	if($method === 'POST') {
		$formDataArray = [
		'firstName' => $_POST['firstName'],
		'lastName' => $_POST['lastName'],
		];
		
		//"$arrName[] =" is add to array.
		//$errorsArray[] = "test";
		//escape($formDataArray['firstName']);
		//escape($formDataArray['lastName']);
		//print_r(findAuthorByName($_POST['firstName'], $_POST['lastName']));
		
		
		if (empty($formDataArray['firstName'])) {
			$errorsArray[] = "First name should <strong>not</strong> be empty.";
		}
		
		if (empty($formDataArray['lastName'])) {
			$errorsArray[] = "Last name should <strong>not</strong> be empty.";
		}
		
		if (empty($errorsArray)) {
			if(!empty(findAuthorByName($_POST['firstName'], $_POST['lastName']))) {
				$errorsArray[] = "Author already exits.";
			}
		}
		
		if (empty($errorsArray)) {
			$id = saveAuthor($formDataArray['firstName'], $formDataArray['lastName']);
			$redirectUrl = "/author.php?id=$id";
			header("Location: $redirectUrl");
		}
	}
	
?>




<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <title>Create an Author</title>
</head>
	<body>
		<h1>Create an author</h1>
		
		<ul>
			<?php foreach ($errorsArray as $error) { ?>
				<li>
					<?php 
						echo $error;//Contains html. Do not escape. 
					?>
				</li>
			<?php } ?>
		</ul>
		
		<form action="" method="POST">
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
    