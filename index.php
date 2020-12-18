<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>My web site</title>
  </head>
  <body>
    <?php

        $mysqlServer = "localhost";
        $database = "library";
        $mysqlUser = "libraryadmin";
        $mysqlPassword = "libraryadmin";
		
		$connexion = new PDO("mysql:host=$mysqlServer;dbname=$database", $mysqlUser, $mysqlPassword);
		
		$query = $connexion->prepare("SELECT * FROM book");
		
		$query->execute();//call the funtion "execute" of the object "$query"
		
		 foreach ($query->fetchAll() as $book) {
                echo $book['title'];
        }
		
    ?>
  </body>
</html>