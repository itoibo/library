<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/common/includes.php');

$formDataArray = [
    'username' => '',
    'password' => '',
];

$errorsArray = [];

$method = $_SERVER['REQUEST_METHOD'];
if($method === 'POST') {
    $formDataArray = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
    ];

    $userArray = findUserByUsername($formDataArray['username']);

    if (empty($userArray)) {
        $errorsArray[] = "There is no user with this username.";
    } else {
        if ($userArray['password'] !== sha1($formDataArray['password'])) {
            $errorsArray[] = "Wrong password.";
        }
    }


    if (empty($errorsArray)) {
        $_SESSION['userId'] = $userArray['id'];
		header("location: /");
    }
}

?>




<!DOCTYPE html>
<html lang='en'>
	<?php
		$title = "Login";
		include_once($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
	?>
	<body>
		<h1>Login</h1>
		<ul>
			<?php foreach ($errorsArray as $error) { ?>
				<li>
					<?php
					echo $error;
					?>
				</li>
			<?php } ?>
		</ul>
		<form action="" method="POST">
			<table>
				<tr>
					<td>
						<label for="username">Username</label>
					</td>
					<td>
						<input type="text" id="username" name="username" value="<?php escape($formDataArray['username']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="password">Password</label>
					</td>
					<td>
						<input type="password" id="password" name="password">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="submit">Submit</button>
					</td>
				</tr>
			</table>
		</form>
		<p>
			Not registered yet?
			<a href="/signup.php">Sinup!</a>
		</p>
	</body>
</html>