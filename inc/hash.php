<?php

// Password encryption
function password_encryption($password)
{
    $blowFish_hash_format = "$2y$13$";
    $salt = generatePasswordSalt(22);
    $formatting_blowfish_with_salt = $blowFish_hash_format . $salt;
    $hash = crypt($password, $formatting_blowfish_with_salt);
    return $hash;
}

function generatePasswordSalt($length)
{
    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '.', $base64_string);
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

function passwordCheck($password, $existing_hash)
{
    $hash = crypt($password, $existing_hash);
    return ($hash === $existing_hash);
}


function passwordCheckcliente($password, $existing_hash)
{
    return ($password === $existing_hash);
}
