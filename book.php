<?php
	
	include_once('common/setup.php');
	include_once('common/database.php');
	
	if(!empty($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		http_response_code(400);
		//echo "Missing book ID.";
		exit("Missing book ID.");
	}
	
	$bookArray = findBookById($id);
	
	if ($bookArray === null) {
		http_response_code(404);
		echo "This book does not exist.";
		exit;
	}
?>


<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8' />
		<title>Book</title>
	</head>
	<body>
		<h1>Book</h1>
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Author</th>
			</tr>
			
			<tr>
				<td>
					<?php echo $bookArray['title']; ?>
				</td>
				<td>
					<?php echo $bookArray['description']; ?>
				</td>
				<td>
					<a href="/author.php?id=<?php echo $bookArray['author_id']; ?>">
					<?php echo $bookArray['author_last_name']; ?>, <?php echo $bookArray['author_first_name']; ?>
					</a>
				</td>
			</tr>
		</table>
		<br>
		<a href="/">See All Books</a>

	</body>
</html>
	