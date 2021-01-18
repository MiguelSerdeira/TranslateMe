<?php
session_start();
$loggedIn = false;
if (isset($_SESSION['loggedIn']) && isset($_SESSION['name']))
{
    $loggedIn = true;
}

$conn = new mysqli('localhost', 'root', '', 'translateme');
?>