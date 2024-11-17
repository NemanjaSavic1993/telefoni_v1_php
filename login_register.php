<?php

require 'load.php';

if(isset($_SESSION['loggedUser'])){
    header("Location: index.php");
}

if(isset($_POST['btnRegister'])){
    $user->register();
}

if(isset($_POST['btnLogin'])){
    $user->login();
}

require 'views/login_register.html';