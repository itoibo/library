<?php

include_once('common/includes.php');

$formDataArray = [
    'username' => '',
    'password' => '',
    'passwordRepeat' => '',
];

$errorsArray = [];

$method = $_SERVER['REQUEST_METHOD'];
if($method === 'POST') {
    $formDataArray = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'passwordRepeat' => $_POST['passwordRepeat'],
    ];

    if (strlen($formDataArray['username']) < 3) {
        $errorsArray[] = "Username must be at least 3 characters";
    }
	
	$userArray = findUserByUsername($formDataArray['username']);
    if (!empty($userArray)) {
        $errorsArray[] = "This username is already in use.";
    }
	
	if (strlen($formDataArray['password']) < 5) {
        $errorsArray[] = "Password must be at least 5 characters";
    }
	
	if ($formDataArray['password'] !== $formDataArray['passwordRepeat']) {
        $errorsArray[] = "You haven't correctly repeated the password.";
    }
	
	if (empty($errorsArray)) {
        $userId = saveUser($formDataArray['username'], $formDataArray['password']);
        $userArray = findUserById($userId);
        $_SESSION['userId'] = $userArray['id'];
        header("Location: /");
    }
}

?>




<!DOCTYPE html>
<html lang='en'>
<?php
$title = "Signup";
include_once('template/head.php');
?>
<body>

</body>
<h1>Signup</h1>
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
            <td>
                <label for="passwordRepeat">Repeat</label>
            </td>
            <td>
                <input type="password" id="passwordRepeat" name="passwordRepeat">
            </td>
        </tr>
		<tr>
            <td colspan="2">
                <button type="submit">Submit</button>
            </td>
        </tr>
    </table>
</form>
</html>