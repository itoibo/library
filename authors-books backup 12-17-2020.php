<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>My web site</title>
  </head>
  <body>
    <?php
		
		if (!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		//echo $page;
		
        $mysqlServer = "localhost";
        $database = "library";
        $mysqlUser = "libraryadmin";
        $mysqlPassword = "libraryadmin";
        
        $connexionObject = new PDO("mysql:host=$mysqlServer;dbname=$database", $mysqlUser, $mysqlPassword);
		
		$queryCountObject = $connexionObject->prepare("SELECT COUNT(*) FROM book;");
        $queryCountObject->execute();
        $countResultsArray = $queryCountObject->fetchAll();
        $total = $countResultsArray[0]['COUNT(*)'];
        //echo $total;
		$nbrPages = ceil($total / 10);
		
		$offset = ($page - 1) * 10;
		$queryObject = $connexionObject->prepare("
            SELECT
                book.id,
                book.title,
                book.description,
                author.first_name,
                author.last_name
            FROM
                book
            LEFT JOIN
                author ON author.id = book.author_id
			
			LIMIT 
				10
			OFFSET
				$offset
            ;
        ");//just contains a string now.
		
		$queryObject->execute();//now contains the string plus all the data we requested.
		
		$resultsArray = $queryObject->fetchAll();
		
		
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
                    <?php echo $resultArray['last_name']; ?>
                </td>
				<td>
                    <?php echo $resultArray['title']; ?>
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
        <a href = "authors-books.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php } ?>
	
	
	<pre>
		<?php /*print_r($resultsArray);*/ ?>
	</pre>
	
	
	
	
	
	
  </body>
</html>







