<?php
    require_once("globals.php");
    require_once("db.php");

    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    // Resgata tipo de formulário
    $type = filter_input(INPUT_POST, "type");
    // (retorna o value do form com name "type" que criamos)

    // Verificação do tipo de formulário
    if($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // Verificação de dados mínimos
        if($name && $lastname && $email && $password) {

        } else {

            // Enviar mensagem de erro alertando dados faltantes
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");

        }

    } else if ($type === "login") {

    }