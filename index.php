<?php
    require __DIR__ . "/vendor/autoload.php";
    
    use Source\Models\Session;
    use Source\Routes\Route;
    
    $session = new Session();
    $router = new Route();
