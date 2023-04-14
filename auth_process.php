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

            // Verificar se as senhas estão corretas
            if($password === $confirmpassword) {

                // Verificar se o e-mail já está cadastrado no sistema
                if($userDao->findByEmail($email) === false) {
                    
                    // Caso o email não conste no sistema iniciamos o cadastro
                    $user = new User();

                    // Criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    // Montando o objeto usuário com token e senha criados acima
                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;
                    
                    // Criando a conta e declarando autenticação (usuário criado e logado)
                    $auth = true;

                    $userDao->create($user, $auth);

                } else {

                    // Enviar mensagem de erro alertando que usuário já existe
                    $message->setMessage("Usuário já cadastrado, utilize outro e-mail.", "error", "back");

                }

            } else {

            // Enviar mensagem de erro alertando que as senhas digitadas são diferentes
            $message->setMessage("As senhas não são iguais.", "error", "back");

            }

        } else {

            // Enviar mensagem de erro alertando dados faltantes
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
            
        }

    } else if ($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        // Tentar autenticar o usuário
        if($userDao->authenticateUser($email, $password)) {

            $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

        // Redireciona o usuário caso não consiga autenticar
        } else {
            $message->setMessage("Usuário e/ou senha incorretos.", "error", "back");

        }

    } else {
        
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }