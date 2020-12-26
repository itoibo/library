<?php
	
	include_once('common/includes.php');
	
	if(!empty($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		http_response_code(400);
		exit("Missing author ID.");
	}
	
	$authorArray = findAuthorById($id);
	
	if ($authorArray === null) {
		http_response_code(404);
		exit("This author does not exist.");
	}
	
	
	$booksArray = findBooksByAuthorId($id);
	
?>




<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8' />
		<title>Author</title>
	</head>
	<body>
		<h1>Author</h1>
		
		<p>
            <strong>First name:</strong> <?php escape($authorArray['first_name']); ?>
            <br>
            <strong>Last name:</strong> <?php escape($authorArray['last_name']); ?>
        </p>
		<p>
            <?php $authorImage = getAuthorImage($authorArray['id']); ?>
            <?php if (is_string($authorImage)) { ?>
                <img src="<?php echo $authorImage; ?>" alt="<?php escape($authorArray['last_name']); ?>">
            <?php } ?>
        </p>
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
			</tr>
			<?php foreach ($booksArray as $bookArray) { ?>
				<tr>
					<td>
						<a href="/book.php?id=<?php escape($bookArray['id']); ?>">
						<?php escape($bookArray['title']); ?>
						</a>
					</td>
					<td>
						<?php escape($bookArray['description']); ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<br>
		<a href="/">See All Authors</a>

	</body>
</html>