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
                echo "Missing book ID.";
                exit;
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
	
<?php
/*
3 things:
- you make a book.php page
this page will show the title, description, and author of a book
the url will be : book.php?id=15
so the id of the book will be in the url

then:
- you do the same with authors. you make a author.php file
url of a webpage will be: author.php?id=12
on this web page, you will show the first name, last name, and list of books of this author
and finally:

- you make links. On the authors-books.php, when , i click on an author last name, i should land on the author page of this autor. Same with books
that's it :_

*/
?>

	</body>
</html>
	