<?php

	include_once('common/includes.php');
	
	$authors = findAllAuthors();
	
	$formDataArray = [
		'title' => '',
		'description' => '',
	];
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//escape($method);
	if($method === 'POST') {
		$formDataArray = [
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		];
		
		//"$arrName[] =" is add to array.
		//$errorsArray[] = "test";
		//escape($formDataArray['firstName']);
		//escape($formDataArray['lastName']);
		//print_r(findAuthorByName($_POST['firstName'], $_POST['lastName']));
		
		
		if (empty($formDataArray['title'])) {
			$errorsArray[] = "Title should <strong>not</strong> be empty.";
		}
		
		/*
		if (empty($errorsArray)) {
			$id = saveBook($formDataArray['title'], $formDataArray['description']);
			$redirectUrl = "/book.php?id=$id";
			header("Location: $redirectUrl");
		}
		*/
	}
	
?>




<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <title>Create a Book</title>
</head>
	<body>
		<h1>Create a Book</h1>
		
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
						<label for="title">Title:</label>
					</td>
					<td>
						<input type="text" id="title" name="title" value="<?php escape($formDataArray['title']); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="description">Description:</label>
					</td>
					<td>
						<textarea rows="10" cols="100" id="description" name="description">
							<?php escape($formDataArray['description']); ?>
						</textarea>
					</td>
				</tr>
				
				<tr>
                    <td>
                        <label for="idAuthor">Author:</label>
                    </td>
                    <td>
                        <select id="idAuthor" name="idAuthor">
							<?php foreach ($authors as $author) { ?>
								<option value="<?php echo $author['id'] ?>">
									<?php echo $author['first_name'] ?> <?php echo $author['last_name'] ?>
								</option>
							<?php } ?>
						</select>
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
    