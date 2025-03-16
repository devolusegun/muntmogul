<?php
$passwords = ['alice123', 'bob123', 'charlie123'];
foreach ($passwords as $password) {
    echo password_hash($password, PASSWORD_BCRYPT) . "<br>";
}
?>