<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8' />
		<title>Book</title>
	</head>
	<body>
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
			
			$resultArray = findBook($id);
			
			if ($resultArray === null) {
                http_response_code(404);
				echo "This book does not exist.";
                exit;
            }
		?>
		
		<h1>Book</h1>
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Author</th>
			</tr>
			
			<tr>
				<td>
					<?php echo $resultArray['title']; ?>
				</td>
				<td>
					<?php echo $resultArray['description']; ?>
				</td>
				<td>
					<a href="/author.php?id=<?php echo $resultArray['author_id']; ?>">
					<?php echo $resultArray['last_name']; ?>, <?php echo $resultArray['first_name']; ?>
					</a>
				</td>
			</tr>
		</table>
		<br>
		<a href="/">See All Books</a>

	</body>
</html>
	