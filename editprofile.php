<?php
    require_once("templates/header.php");

    require_once("dao/UserDAO.php");

    require_once("models/User.php");

    $user = new User();
    $userData = new UserDao($conn, $BASE_URL);

    // Requerimos autenticação na página
    $userData = $userDao->verifyToken(true);

    $fullName = $user->getFullName($userData);

    if($userData->image == "") {
        $userData->image = "user.png";
    }
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><?= $fullName ?></h1>
                        
                        <p class="page-drescription"> Altere seus dados no formulário abaixo:</p>

                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite o seu nome" value="<?= $userData->lastname ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" readonly class="form-control disabled" id="email" name="email" value="<?= $userData->email ?>">
                        </div>

                        <input type="submit" class="btn form-btn" value="Alterar">
                    </div>

                    <div class="col-md-4">

                        <div id="profile-image-container" style="background-image:  url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>');"></div>
                        
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" class="form-control-file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="bio">Sobre você:</label>
                            <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte mais sobre você!"></textarea>
                        </div>

                    </div>

                </div>
            </form>

            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Alterar a senha:</h2>

                    <p class="page-description">Digite a nova senha e confirme para fazer a alteração:</p>
                    
                    <form action="<?= $BASE_URL ?>user_process.php" method="POST"></form>
                </div>
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>