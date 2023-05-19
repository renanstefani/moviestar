<?php
    require_once("templates/header.php");

    require_once("dao/MovieDAO.php");

    // DAO dos filmes
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $latestMovies = $movieDao->getLatestMovies();

    $actionMovies = $movieDao->getMoviesByCategory("Ação");

    $dramaMovies = $movieDao->getMoviesByCategory("Drama");

    $comedyMovies = $movieDao->getMoviesByCategory("Comédia");

    $fantasyMovies = $movieDao->getMoviesByCategory("Fantasia");

    $fictionMovies = $movieDao->getMoviesByCategory("Ficção");
?>
    <div id="main-container" class="container-fluid">
        
        <h2 class="section-title">Recém adicionados</h2>
        <p class="section-description">Veja as críticas dos últimos filmes adicionados no MovieStar.</p>
            <div class="movies-container">

                <?php foreach($latestMovies as $movie): ?>
                    <?php require("templates/movie_card.php"); ?>
                <?php endforeach; ?>

                <?php if(count($latestMovies) === 0): ?>
                    <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
                <?php endif; ?>
        </div>
        
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação.</p>
            <?php foreach($actionMovies as $movie): ?>
                    <?php require("templates/movie_card.php"); ?>
            <?php endforeach; ?>

        <div class="movies-container">
            <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
            <?php endif; ?>
        </div>

        
        <h2 class="section-title">Drama</h2>
        <p class="section-description">Veja os melhores filmes de drama.</p>

        <div class="movies-container">
            <?php foreach($dramaMovies as $movie): ?>
                <?php require("templates/movie_card.php"); ?>
            <?php endforeach; ?>

            <?php if(count($dramaMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
            <?php endif; ?>
        </div>

        
        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Veja os melhores filmes de comédia.</p>

        <div class="movies-container">
            <?php foreach($comedyMovies as $movie): ?>
                <?php require("templates/movie_card.php"); ?>
            <?php endforeach; ?>

            <?php if(count($comedyMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
            <?php endif; ?>
        </div>

        
        <h2 class="section-title">Fantasia</h2>
        <p class="section-description">Veja os melhores filmes de fantasia.</p>

        <div class="movies-container">
            <?php foreach($fantasyMovies as $movie): ?>
                <?php require("templates/movie_card.php"); ?>
            <?php endforeach; ?>

            <?php if(count($fantasyMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
            <?php endif; ?>
        </div>

        
        <h2 class="section-title">Ficção</h2>
        <p class="section-description">Veja os melhores filmes de ficção.</p>
        
        <div class="movies-container">
            <?php foreach($fictionMovies as $movie): ?>
                <?php require("templates/movie_card.php"); ?>
            <?php endforeach; ?>

            <?php if(count($fictionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa categoria.</p>
            <?php endif; ?>
        </div>

    </div>

<?php
    require_once("templates/footer.php");
?>