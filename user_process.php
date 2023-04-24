<?php

    require_once("globals.php");
    require_once("db.php");

    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    // Resgata tipo de formulário
    $type = filter_input(INPUT_POST, "type");

    // Atualizar usuário
    if($type === "update") {

        // Resgatar dados do usuário
        $userData = $userDao->verifyToken();

        // Receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        // Criar novo objeto de usuário
        $user = new User();

        // Preencher dados do usuário, utilizamos o userData por já conter o token verificado
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

        // Upload da imagem
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checar o tipo de imagem
            if(in_array($image["type"], $imageTypes)) {

                // Checar jpg
                if(in_array($image["type"], $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    
                // Caso seja png
                }else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }

                // Após criarmos a img acima, geramos o nome hex
                $imageName = $user->imageGenerateName();

                // Criamos o arquivo recebendo a img e o name
                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                // Declaramos a image do user
                $userData->image = $imageName;
                
                
            } else {

                $message->setMessage("Tipo de imagem inválido, insira jpg ou png!", "error", "back");

            }
        }

        $userDao->update($userData);

    // Atualizar senha do usuário
    } else if($type === "changepassword") {

        // Receber dados do post
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
        
        // Resgatar dados do usuário
        $userData = $userDao->verifyToken();
        $id = $userData->id;

        if($password == $confirmpassword) {

            // Criar um novo objeto de usuário
            $user = new User();

            $finalPassword = $user->generatePassword($password);

            $user->password = $finalPassword;
            $user->id = $id;

            $userDao->changePassword($user);

        } else {

            $message->setMessage("As senhas não são iguais.", "error", "back");
        }

    } else {
        $message->setMessage("Informações inválidas.", "error", "index.php");
    }