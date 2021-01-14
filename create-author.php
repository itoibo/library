<?php

	include_once('common/includes.php');
	
	$formDataArray = [
		'firstName' => '',
		'lastName' => '',
		'picture' => '',
	];
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//escape($method);
	if($method === 'POST') {
		$formDataArray = [
		'firstName' => $_POST['firstName'],
		'lastName' => $_POST['lastName'],
		'picture' => $_FILES['picture'],
		];
		
		//echo '<pre>';
        //var_dump($formDataArray);
        //exit;
		
		//"$arrName[] =" is add to array.
		
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
		
		$imageBytesMax = 1000000;
		$imageBytes = $formDataArray['picture']['size'];
		//echo $imageBytes;
		if($imageBytes > $imageBytesMax) {
			$errorsArray[] = "Image file size is ".($imageBytes/1000000)."Mb and is too large. Max size is ".($imageBytesMax/1000000)."Mb.";
		}
		
		if (empty($errorsArray)) {
			$id = saveAuthor($formDataArray['firstName'], $formDataArray['lastName']);
			processImage($formDataArray['picture'], $formDataArray['firstName'], $formDataArray['lastName'], $id);
			$redirectUrl = "/author.php?id=$id";
			header("Location: $redirectUrl");
		}
	}
	
?>




<!DOCTYPE html>
<html lang='en'>
	<?php 
        $title = "Add an Author";
        include_once('template/head.php'); 
    ?>
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
					<td>
						<label for="picture">Picture (1mb max):</label>
					</td>
					<td>
						<input type="file" id="picture" name="picture" accept="image/png, image/jpeg"/>
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
    