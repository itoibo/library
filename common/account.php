<?php if (isset($_SESSION['userId'])) { ?>
    <?php $userArray = findUserById($_SESSION['userId']); ?>
    Hello <?php escape($userArray['username']); ?>
    | <a href="/logout.php">Logout</a>
<?php } else { ?>
    <a href="/login.php">Login</a>
<?php } ?>