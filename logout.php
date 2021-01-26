<?php

include_once('common/includes.php');

unset($_SESSION['userId']);
unset($_SESSION['username']);

header("Location: /");