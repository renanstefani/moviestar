<?php
    require_once("templates/header.php");

    require_once("dao/UserDAO.php");

    $userData = new UserDao($conn, $BASE_URL);

    // Requerimos autenticação na página
    $userData = $userDao->verifyToken(true);
?>
    <div id="main-container" class="container-fluid">
        <h1>Edição de Perfil</h1>
    </div>

<?php
    require_once("templates/footer.php");
?>