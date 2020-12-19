<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8' />
		<title>Author</title>
	</head>
	<body>
		<?php
			
			include_once('common/setup.php');
			include_once('common/database.php');
			
			if(!empty($_GET['id'])) {
				$id = $_GET['id'];
			} else {
				http_response_code(400);
                //echo "Missing author ID.";
                exit("Missing author ID.");
			}
			
			$resultArray = findAuthorById($id);
			
			if ($resultArray === null) {
                http_response_code(404);
				//echo "This author does not exist.";
                exit("This author does not exist.");
            }
			
			
			$resultsArray = findBooksByAuthorId($id);
			
			if ($resultsArray === null) {
                http_response_code(404);
				//echo "This author does not exist.";
                exit("No books by this author.");
            }
		?>
		
		<h1>Author</h1>
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Author</th>
			</tr>
			<?php foreach ($resultsArray as $resultArray) { ?>
				<tr>
					<td>
						<a href="/book.php?id=<?php echo $resultArray['id']; ?>">
						<?php echo $resultArray['title']; ?>
						</a>
					</td>
					<td>
						<?php echo $resultArray['description']; ?>
					</td>
					<td>
						<?php echo $resultArray['last_name']; ?>, <?php echo $resultArray['first_name']; ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<br>
		<a href="/">See All Authors</a>

	</body>
</html>
	