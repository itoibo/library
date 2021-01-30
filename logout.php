<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/common/includes.php');

unset($_SESSION['userId']);
unset($_SESSION['username']);

header("Location: /");