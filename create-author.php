<?php

	include_once('common/setup.php');
	include_once('common/database.php');
	
	$formDataArray = [
		'firstName' => '',
		'lastName' => '',
	];
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//echo $method;
	if($method === 'POST') {
		$formDataArray = [
		'firstName' => $_POST['firstName'],
		'lastName' => $_POST['lastName'],
		];
		
		if (empty($formDataArray['firstName'])) {
			$errorsArray[] = "First name should not be empty.";//"$arrName[] =" is add to array.
		}
		
		if (empty($formDataArray['lastName'])) {
			$errorsArray[] = "Last name should not be empty.";
		}
		
		if (empty($errorsArray)) {
			$id = saveAuthor($formDataArray['firstName'], $formDataArray['lastName']);
			$redirectUrl = "/author.php?id=$id";
			header("Location: $redirectUrl");
			//echo "The author has been successfully saved!";
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
					<?php echo $error; ?>
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
						<input type="text" id="firstName" name="firstName" value="<?php echo $formDataArray['firstName'] ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="lastName">Last name:</label>
					</td>
					<td>
						<input type="text" id="lastName" name="lastName" value="<?php echo $formDataArray['lastName'] ?>"/>
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
    