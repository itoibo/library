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
?>


<!DOCTYPE html>
<html lang='en'>
	<?php 
        $title = "Book";
        include_once($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
    ?>
	<body>
		<?php include_once($_SERVER['DOCUMENT_ROOT'].'/common/account.php'); ?>
		<h1>Book</h1>
		
		<table border='1'>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Author</th>
			</tr>
			
			<tr>
				<td>
					<?php escape($bookArray['title']); ?>
				</td>
				<td>
					<?php escape($bookArray['description']); ?>
				</td>
				<td>
					<a href="/author.php?id=<?php escape($bookArray['author_id']); ?>">
					<?php escape($bookArray['author_last_name']); ?>, <?php escape($bookArray['author_first_name']); ?>
					</a>
				</td>
			</tr>
		</table>
		<br>
        <a href="/update-book.php?id=<?php echo $id; ?>">Update this book</a>
        <br>
        <a class="delete" href="/delete.php?type=book&id=<?php echo $id; ?>">Delete this book</a>
        <br>
        <a href="/">See All Books</a>
	</body>
</html>
	