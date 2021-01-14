<?php
	
	include_once('common/includes.php');
	
	if (!empty($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	//escape($page);
	
	$total = countAllBooks();
	
	$nbrPages = ceil($total / 10);
	
	$offset = ($page - 1) * 10;
	
	$numBooks = 10;
	
	$booksArray = findNBooks($numBooks, $offset);
	
?>


<!DOCTYPE html>
<html lang="en">
	<?php 
        $title = "Library Home";
        include_once('template/head.php'); 
    ?>
  <body>
    <p>
		<a href="/">
            Home
        </a>
    </p>
    
    <h1>Authors and books</h1>
    
	<table border="1">
        <tr>
            <th>Author first name</th>
            <th>Author last name</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
		
		<?php foreach ($booksArray as $bookArray) { ?>
            <tr>
                <td>
                    <?php escape($bookArray['author_first_name']); ?>
                </td>
				<td>
					<a href="/author.php?id=<?php escape($bookArray['author_id']); ?>">
						<?php escape($bookArray['author_last_name']); ?>
					</a>
                </td>
				<td>
					<a href="/book.php?id=<?php escape($bookArray['id']); ?>">
						<?php escape($bookArray['title']); ?>
					</a>
                </td>
				<td>
                    <?php escape($bookArray['description']); ?>
                </td>
				<td>
					<a class="delete" href="/delete.php?type=book&id=<?php escape($bookArray['id']); ?>">Delete book</a>
					-
					<a href="/update-book.php?id=<?php escape($bookArray['id']); ?>">Update this book</a>
				</td>
            <tr>
        <?php } ?>
		
    </table>
	
	
	
	<?php for ($i = 1; $i <= $nbrPages; $i++) { ?>
        <a href = "/?page=<?php escape($i); ?>"><?php escape($i); ?></a>
    <?php } ?>
	
	<br>
    <br>
    <a href="/create-book.php">Create a book</a>
    <br>
    <a href="/create-author.php">Create an author</a>
	
	<pre>
		<?php /*print_r($booksArray);*/ ?>
	</pre>
	
  </body>
</html>







