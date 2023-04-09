<?php
    // Nosso header possui o require de todos os arquivos que precisamos
    require_once("templates/header.php");
    
    if($userDao) {
        $userDao->destroyToken();
    }