<?php
$hashed_password = '$2y$10$Z90KI.0zCrO1HPtlEZiFnOw9xbixAEg2HA4dQlVoSiPwW2jm2m/z2'; // Replace with your stored hash
$input_password = 'admin'; // Replace with the password you are testing

if (password_verify($input_password, $hashed_password)) {
    echo "Password is correct!";
} else {
    echo "Incorrect password!";
}
?>
