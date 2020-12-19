<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8' />
		<title>Author</title>
	</head>
	<body>
		<?php
			
			include_once('common/setup.php');
			
			if(!empty($_GET['id'])) {
				$id = $_GET['id'];
			} else {
				$id = 4;
			}
			
			$mysqlServer = "localhost";
			$database = "library";
			$mysqlUser = "libraryadmin";
			$mysqlPassword = "libraryadmin";
			
			$connexionObject = new PDO("mysql:host=$mysqlServer;dbname=$database", $mysqlUser, $mysqlPassword);
			
			$queryObject = $connexionObject->prepare("
				SELECT
					book.id,
					book.title,
					book.description,
					book.author_id,
					author.first_name,
					author.last_name
				FROM
					book
				LEFT JOIN
					author ON author.id = book.author_id
				WHERE
					author.id = $id;
				;
			");
			
			$queryObject->execute();
			
			$resultsArray = $queryObject->fetchAll();
			
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
		<a href="/" target="new">See All Authors</a>
	
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
	