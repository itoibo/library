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
            
            $authorArray = findAuthorById($id);
            
            if ($authorArray === null) {
                http_response_code(404);
                exit("This author does not exist.");
            }
            
            
            $booksArray = findBooksByAuthorId($id);
            
        ?>
    
		
		<h1>Author</h1>
		
		<p>
            <strong>First name:</strong> <?php echo $authorArray['first_name']; ?>
            <br>
            <strong>Last name:</strong> <?php echo $authorArray['last_name']; ?>
        </p>
		
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
			</tr>
			<?php foreach ($booksArray as $bookArray) { ?>
				<tr>
					<td>
						<a href="/book.php?id=<?php echo $bookArray['id']; ?>">
						<?php echo $bookArray['title']; ?>
						</a>
					</td>
					<td>
						<?php echo $bookArray['description']; ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<br>
		<a href="/">See All Authors</a>

	</body>
</html>
	