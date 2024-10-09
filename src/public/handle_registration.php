<?php

require_once './classes/Auth.php';

$user = new Auth();
$result = $user->registration();

require_once './get_registration.php';

?>




