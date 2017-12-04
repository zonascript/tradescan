<?php

if (! function_exists('obfuscate_email')) {

function obfuscate_email($email)
  {
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1), '@');
    $email = implode(array_slice($em, 1, count($em)-1), '@');
    $emailExtension = explode('.', $email, 4);
    $nameCutLength  = floor(strlen($name) - (strlen($name) - 2));
    $emailCutLength  = floor(strlen($name) - (strlen($name) - 1));
    $dottedName = substr($name,0, $nameCutLength) . str_repeat('*', (strlen($name) - 2));
    $dottedEmail= substr($email,0, $emailCutLength) . str_repeat('*', (strlen($name) - 4)) . '.' . $emailExtension[1];
    return $dottedName . "@" . $dottedEmail;
  }
}