<?php
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/common/includes.php');
	
	if(!empty($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		http_response_code(400);
		exit("Missing book ID.");
	}
	
		$bookArray = findBookById($id);
	
	if ($bookArray === null) {
		http_response_code(404);
		escape("This book does not exist.");
		exit;
	}
	
	$authors = findAllAuthors();
	
    $formDataArray = [
        'title' => $bookArray['title'],
        'description' => $bookArray['description'],
        'idAuthor' => $bookArray['author_id'],
    ];
	
	$errorsArray = [];
	
	$method = $_SERVER['REQUEST_METHOD'];
	//escape($method);
	if($method === 'POST') {
		$formDataArray = [
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		'idAuthor' => $_POST['idAuthor'],
		];
		
		if (empty($formDataArray['title'])) {
			$errorsArray[] = "Title should <strong>not</strong> be empty.";
		}
		
		if (empty($formDataArray['idAuthor'])) {
			$errorsArray[] = "You must select an author.";
		}
		
        if (empty($errorsArray)) {
            updateBook($id, $formDataArray['title'], $formDataArray['description'], $formDataArray['idAuthor']);
            $redirectUrl = "/book.php?id=$id";
            header("Location: $redirectUrl");
        }
	}
	
?>




<!DOCTYPE html>
<html lang='en'>
	<?php 
        $title = "Update a Book";
        include_once($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
    ?>
	<body>
		<?php include_once($_SERVER['DOCUMENT_ROOT'].'/common/account.php'); ?>
		<h1>Update a Book</h1>
		
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
						<textarea rows="10" cols="100" id="description" name="description"><?php escape($formDataArray['description']); ?></textarea>
					</td>
				</tr>
				
				<tr>
                    <td>
                        <label for="idAuthor">Author:</label>
                    </td>
                    <td>
                        <select id="idAuthor" name="idAuthor">
							<option value="">Choose an author</option>
							<?php foreach ($authors as $author) { ?>
								<option value="<?php echo $author['id'] ?>" <?php if ($author['id'] === $formDataArray['idAuthor']) { echo "selected"; } ?>>
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
		
		<a href="/book.php?id=<?php echo $id; ?>">See this book</a>
        <br>
        <a href="/">See All Books</a>
		
	</body>
</html>