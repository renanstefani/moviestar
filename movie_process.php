<?php

    require_once("globals.php");
    require_once("db.php");

    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);

    // Resgatar tipo de formulário
    $type = filter_input(INPUT_POST, "type");

    // Resgatar dados do usuário
    $userData = $userDao->verifyToken();

    if($type === "create") {

        // Receber dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        // Validação mínima de dados
        if(!empty($title) && !empty($description) && !empty($category)) {

        } else {

            $message->setMessage("Preencha pelo menos os seguintes campos: título, descrição e categoria.", "error", "back");

        }

    } else {

        $message->setMessage("Informações inválidas", "error", "index.php");

    }