<?php
$password = '987654'; // Reemplaza 'tu_password' con la contraseña que deseas hashear
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo $hashed_password;
?>