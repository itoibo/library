<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>My web site</title>
  </head>
  <body>
    <p>
		<a href="/">
            Home
        </a>
    </p>
	
    <?php
		
		include_once('common/setup.php');
		include_once('common/database.php');
		
		if (!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		//echo $page;
		
		$total = countAllBooks();
		
		$nbrPages = ceil($total / 10);
		
		$offset = ($page - 1) * 10;
		
		$numBooks = 10;
		
		$resultsArray = findNBooks($numBooks, $offset);
		
    ?>
    
    <h1>Authors and books</h1>
    
	<table border="1">
        <tr>
            <th>Author first name</th>
            <th>Author last name</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
		
		<?php foreach ($resultsArray as $resultArray) { ?>
            <tr>
                <td>
                    <?php echo $resultArray['first_name']; ?>
                </td>
				<td>
					<a href="/author.php?id=<?php echo $resultArray['author_id']; ?>">
						<?php echo $resultArray['last_name']; ?>
					</a>
                </td>
				<td>
					<a href="/book.php?id=<?php echo $resultArray['id']; ?>">
						<?php echo $resultArray['title']; ?>
					</a>
                </td>
				<td>
                    <?php echo $resultArray['description']; ?>
                </td>
				<td>
                    Coming soon
                </td>
            <tr>
        <?php } ?>
		
    </table>
	
	
	
	<?php for ($i = 1; $i <= $nbrPages; $i++) { ?>
        <a href = "/?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php } ?>
	
	
	<pre>
		<?php /*print_r($resultsArray);*/ ?>
	</pre>
	
  </body>
</html>







